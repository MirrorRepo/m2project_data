<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model;

use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Payment\Gateway\Command\CommandPoolInterface;
use Magento\Payment\Gateway\Config\ValueHandlerPoolInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectFactory;
use Magento\Payment\Gateway\Validator\ValidatorPoolInterface;
use Magento\Payment\Model\InfoInterface;
use Magento\Payment\Model\MethodInterface;
use Magento\Quote\Api\Data\CartInterface;
use Cryozonic\StripePayments\Helper;
use Psr\Log\LoggerInterface;
use Magento\Framework\Validator\Exception;
use Cryozonic\StripePayments\Helper\Logger;
use Magento\Payment\Observer\AbstractDataAssignObserver;

class PaymentMethod extends \Magento\Payment\Model\Method\Adapter
{
    public static $code                 = "cryozonic_stripe";

    protected $_isInitializeNeeded      = false;
    protected $_canUseForMultishipping  = true;

    /**
     * @param ManagerInterface $eventManager
     * @param ValueHandlerPoolInterface $valueHandlerPool
     * @param PaymentDataObjectFactory $paymentDataObjectFactory
     * @param string $code
     * @param string $formBlockType
     * @param string $infoBlockType
     * @param Cryozonic\StripePayments\Model\Config $config
     * @param CommandPoolInterface $commandPool
     * @param ValidatorPoolInterface $validatorPool
     */
    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager,
        ValueHandlerPoolInterface $valueHandlerPool,
        PaymentDataObjectFactory $paymentDataObjectFactory,
        $code,
        $formBlockType,
        $infoBlockType,
        \Cryozonic\StripePayments\Model\Config $config,
        \Cryozonic\StripePayments\Helper\Generic $helper,
        \Cryozonic\StripePayments\Helper\Api $api,
        \Cryozonic\StripePayments\Model\StripeCustomer $customer,
        \Magento\Checkout\Helper\Data $checkoutHelper,
        LoggerInterface $logger,
        CommandPoolInterface $commandPool = null,
        ValidatorPoolInterface $validatorPool = null
    ) {
        $this->config = $config;
        $this->logger = $logger;
        $this->helper = $helper;
        $this->api = $api;
        $this->customer = $customer;
        $this->checkoutHelper = $checkoutHelper;
        $this->saveCards = $config->getSaveCards();
        $this->eventManager = $eventManager;

        parent::__construct(
            $eventManager,
            $valueHandlerPool,
            $paymentDataObjectFactory,
            $code,
            $formBlockType,
            $infoBlockType,
            $commandPool,
            $validatorPool
        );
    }

    protected function resetPaymentData()
    {
        $info = $this->getInfoInstance();
        $session = $this->checkoutHelper->getCheckout();

        // Reset a previously initialized 3D Secure session
        $session->setStripePaymentsRedirectUrl(null);
        $info->setAdditionalInformation('three_d_secure_pending', false)
             ->setAdditionalInformation('stripejs_token', null)
             ->setAdditionalInformation('switch_subscription', null)
             ->setCcType(null)
             ->setCcLast4(null)
             ->setAdditionalInformation('save_card', false);
    }

    public function create3DSecureSource($data, $card)
    {
        $info = $this->getInfoInstance();
        $session = $this->checkoutHelper->getCheckout();
        $params3DS = $this->config->get3DSecureParams(false);

        $quote = $this->helper->getSessionQuote();
        $quote->reserveOrderId();

        $returnUrl = $this->helper->urlBuilder->getUrl('cryozonic-stripe/payment', ['_secure' => $this->helper->isSecure()]);

        $source = \Stripe\Source::create(array(
            "amount" => $params3DS['amount'],
            "currency" => $params3DS['currency'],
            "type" => "three_d_secure",
            "three_d_secure" => array(
                "card" => $card[0],
            ),
            "metadata" => array(
                "Order #" => $quote->getReservedOrderId()
            ),
            "redirect" => array(
                "return_url" => $returnUrl
            ),
        ));

        if (empty($source) || !isset($source->id))
            $this->helper->dieWithError("Sorry, we could not initiate a card authentication with your bank.");

        // We only want to redirect the customer if 3D Secure is necessary
        if ($source->status == 'pending')
        {
            $session->setStripePaymentsRedirectUrl($source->redirect->url);
            $session->setStripePaymentsClientSecret($source->client_secret);
            $session->setQuoteId($quote->getId());

            // If its a guest customer, there will be no Stripe customer object
            if (empty($this->customer->getStripeId()))
            {
                $quote = $this->helper->getSessionQuote();
                $firstname = $quote->getFirstname();
                $lastname = $quote->getLastname();
                $email = $quote->getEmail();
                $this->customer->createNewStripeCustomer($firstname, $lastname, $email, 0);
            }

            $info->setAdditionalInformation('three_d_secure_pending', true)
                ->setAdditionalInformation('source_id', $source->id)
                ->setAdditionalInformation('customer_stripe_id', $this->customer->getStripeId())
                ->setAdditionalInformation('customer_email', $this->customer->getCustomerEmail())
                ->setAdditionalInformation('save_card', $this->saveCards && $data['cc_save']);
        }

        return $source;
    }

    public function assignData(\Magento\Framework\DataObject $data)
    {
        parent::assignData($data);

        if ($this->config->getIsStripeAPIKeyError())
            $this->helper->dieWithError("Invalid API key provided");

        // From Magento 2.0.7 onwards, the data is passed in a different property
        $additionalData = $data->getAdditionalData();
        if (is_array($additionalData))
            $data->setData(array_merge($data->getData(), $additionalData));

        $info = $this->getInfoInstance();
        $session = $this->checkoutHelper->getCheckout();

        $this->eventManager->dispatch(
            'cryozonic_stripepayments_assigndata',
            array(
                'method' => $this,
                'info' => $info,
                'data' => $data
            )
        );

        // If using a saved card
        if (!empty($data['cc_saved']) && $data['cc_saved'] != 'new_card' && empty($data['cc_stripejs_token']))
        {
            $card = explode(':', $data['cc_saved']);

            $this->resetPaymentData();

            if ($this->config->shouldUse3DSecure($card[0], $card[1]))
            {
                if ($this->helper->isAdmin())
                    $this->helper->dieWithError("This card cannot be used because a 3D Secure Verification is required by the customer.");

                $source = $this->create3DSecureSource($data, $card);
                $info->setAdditionalInformation('token', $source->id);
            }
            else
                $info->setAdditionalInformation('token', $card[0]);

            $info->setAdditionalInformation('save_card', false)
                ->setCcType($card[1])
                ->setCcLast4($card[2]);

            return $this;
        }

        // Other scenarios by OSC modules trying to prematurely save payment details
        if (empty($data['cc_stripejs_token']) && empty($data['cc_number']))
            return $this;

        // Stripe Elements OR Stripe.js v2
        if ($this->config->getSecurityMethod())
        {
            if (empty($data['cc_stripejs_token']))
                $this->helper->dieWithError("Sorry, we could not perform a card security check. Please contact us to complete your purchase.");

            $card = explode(':', $data['cc_stripejs_token']);
            $data['cc_stripejs_token'] = $card[0]; // To be used by Stripe Subscriptions

            // Security check: If Stripe Elements is enabled, only accept source tokens and saved cards
            if ($this->config->isStripeElementsEnabled())
            {
                if (strpos($card[0], 'src_') !== 0 && strpos($card[0], 'card_') !== 0 && strpos($card[0], 'tok_') !== 0)
                    $this->helper->dieWithError("Sorry, we could not perform a card security check. Please contact us to complete your purchase.");
            }

            // This is called both at the card filling step and also at the final step, so add some safety measures
            $usedToken = $info->getAdditionalInformation('stripejs_token');

            if (!empty($usedToken) && $usedToken == $card[0])
                return $this;
            else
            {
                $this->resetPaymentData();

                $info->setAdditionalInformation('stripejs_token', $card[0])
                    ->setCcType($card[1])
                    ->setCcLast4($card[2]);
            }

            // What to do at the Payment Information step
            if ($this->config->shouldUse3DSecure($card[0]))
            {
                if ($this->helper->isAdmin())
                    $this->helper->dieWithError("This card cannot be used because a 3D Secure Verification is required by the customer.");

                // Stripe Elements with 3D Secure enabled
                try
                {
                    $source = $this->create3DSecureSource($data, $card);

                    $params = array(
                        "card" => $source->id
                    );
                }
                catch (\Stripe\Error\Card $e)
                {
                    $this->resetPaymentData();
                    $this->helper->dieWithError($e->getMessage());
                }
                catch (\Stripe\Error $e)
                {
                    $this->resetPaymentData();
                    $this->helper->dieWithError($e->getMessage(), $e);
                }
                catch (\Exception $e)
                {
                    $this->resetPaymentData();
                    $this->helper->dieWithError($e->getMessage(), $e);
                }
            }
            else
            {
                // Stripe Elements or Stripe.js v2 enabled
                $params = array(
                    "card" => $card[0]
                );
            }
        }
        else
        {
            $this->resetPaymentData();

            if (empty($data['cc_owner']))
                $this->helper->dieWithError("Please specify the cardholder name.");
            if (empty($data['cc_number']))
                $this->helper->dieWithError("Please specify a card number.");
            if (empty($data['cc_cid']))
                $this->helper->dieWithError("Please specify the card CVC number.");
            if (empty($data['cc_exp_month']))
                $this->helper->dieWithError("Please specify the card expiration month.");
            if (empty($data['cc_exp_year']))
                $this->helper->dieWithError("Please specify the card expiration year.");

            $params = array(
                "card" => array(
                    "name" => $data['cc_owner'],
                    "number" => $data['cc_number'],
                    "cvc" => $data['cc_cid'],
                    "exp_month" => $data['cc_exp_month'],
                    "exp_year" => $data['cc_exp_year']
                )
            );
        }

        $isSourceToken = (is_string($params['card']) && strpos($params['card'], 'src_') !== false);

        // Add the card to the customer
        if (($data['cc_save'] && !$session->getStripePaymentsRedirectUrl()) || $data['is_multishipping'])
        {
            try
            {
                $card = $this->customer->addSavedCard($params['card']);
                $token = $card->id;
            }
            catch (\Stripe\Error\Card $e)
            {
                $this->helper->dieWithError($e->getMessage());
            }
            catch (\Stripe\Error $e)
            {
                $this->helper->dieWithError($e->getMessage(), $e);
            }
            catch (\Exception $e)
            {
                $this->helper->dieWithError("An error has occured. Please contact us to complete your order.", $e);
            }
        }
        else if (!$isSourceToken)
        {
            $token = $this->api->createToken($params);
        }
        else // is source token
        {
            $token = $params['card'];
        }

        $info->setAdditionalInformation('token', $token);

        if (isset($this->customer->customerCard))
        {
            $info->setCcType($this->customer->customerCard['brand'])
                ->setCcLast4($this->customer->customerCard['last4']);
        }

        return $this;
    }

    public function authorize(InfoInterface $payment, $amount)
    {
        if ($amount > 0 && !$this->is3DSecurePending())
        {
            $this->api->createCharge($payment, $amount, false);
        }

        return $this;
    }

    public function capture(InfoInterface $payment, $amount)
    {
        if ($amount > 0)
        {
            // We get in here when the store is configured in Authorize Only mode and we are capturing a payment from the admin
            $token = $payment->getTransactionId();
            if (empty($token))
                $token = $payment->getLastTransId(); // In case where the transaction was not created during the checkout, i.e. with a Stripe Webhook redirect

            if ($this->helper->isAdmin() && $token)
            {
                if ($payment->getAdditionalInformation('three_d_secure_pending') && !$payment->getAdditionalInformation('stripe_authorized'))
                    throw new \Exception("The customer has not yet authorized the payment using 3D Secure.");

                $token = $this->helper->cleanToken($token);
                try
                {
                    $ch = \Stripe\Charge::retrieve($token);

                    if ($this->config->useStoreCurrency())
                        $finalAmount = $this->helper->getMultiCurrencyAmount($payment, $amount);
                    else
                        $finalAmount = $amount;

                    $currency = $payment->getOrder()->getOrderCurrencyCode();
                    $cents = 100;
                    if ($this->helper->isZeroDecimal($currency))
                        $cents = 1;

                    if ($ch->captured)
                    {
                        // In theory this condition should never evaluate, but is added for safety
                        if ($ch->currency != strtolower($currency))
                            $this->helper->dieWithError("This invoice has already been captured in Stripe using a different currency ({$ch->currency}).");

                        $capturedAmount = $ch->amount - $ch->amount_refunded;

                        if ($capturedAmount != round($finalAmount * $cents))
                        {
                            $humanReadableAmount = strtoupper($ch->currency) . " " . round($capturedAmount / $cents, 2);
                            $this->helper->dieWithError("This invoice has already been captured in Stripe for a different amount ($humanReadableAmount). Please cancel and create a new offline invoice for the correct amount.");
                        }

                        // We return instead of trying to capture the payment to simulate an Offline capture
                        return $this;
                    }

                    $ch->capture(array('amount' => round($finalAmount * $cents)));
                }
                catch (\Exception $e)
                {
                    $this->logger->critical($e->getMessage());

                    if ($this->helper->isAuthorizationExpired($e->getMessage()) && $this->config->retryWithSavedCard())
                        $this->api->createCharge($payment, $amount, true, true);
                    else
                        $this->helper->dieWithError($e->getMessage(), $e);
                }
            }
            else
            {
                // Normal checkout payments in Authorize & Capture mode
                $this->api->createCharge($payment, $amount, true);
            }
        }

        return $this;
    }

    public function canCapture()
    {
        return parent::canCapture() && !$this->is3DSecurePending();
    }

    public function cancel(InfoInterface $payment, $amount = null)
    {
        if ($this->config->useStoreCurrency())
        {
            // Captured
            $creditmemo = $payment->getCreditmemo();
            if (!empty($creditmemo))
            {
                $rate = $creditmemo->getBaseToOrderRate();
                if (!empty($rate) && is_numeric($rate) && $rate > 0)
                    $amount *= $rate;
            }
            // Authorized
            $amount = (empty($amount)) ? $payment->getOrder()->getTotalDue() : $amount;

            $currency = $payment->getOrder()->getOrderCurrencyCode();
        }
        else
        {
            // Authorized
            $amount = (empty($amount)) ? $payment->getOrder()->getBaseTotalDue() : $amount;

            $currency = $payment->getOrder()->getBaseCurrencyCode();
        }

        $transactionId = $payment->getParentTransactionId();

        // With asynchronous payment methods, the parent transaction may be empty
        if (empty($transactionId))
            $transactionId = $payment->getLastTransId();

        // Case where an invoice is in Pending status, with no transaction ID, receiving a source.failed event which cancels the invoice.
        if (empty($transactionId))
            return $this;

        $transactionId = preg_replace('/-.*$/', '', $transactionId);

        try {
            $cents = 100;
            if ($this->helper->isZeroDecimal($currency))
                $cents = 1;

            $params = array();
            if ($amount > 0)
                $params["amount"] = round($amount * $cents);

            $charge = \Stripe\Charge::retrieve($transactionId);

            // This is true when an authorization has expired or when there was a refund through the Stripe account
            if (!$charge->refunded)
            {
                $charge->refund($params);
                // \Stripe\Refund::create($params);

                $refundId = $this->helper->getRefundIdFrom($charge);
                $payment->setAdditionalInformation('last_refund_id', $refundId);
            }
            else
            {
                $msg = __('This order has already been refunded in Stripe. To refund from Magento, please refund it offline.');
                $this->helper->addError($msg);
                throw new LocalizedException($msg);
            }
        }
        catch (\Exception $e)
        {
            $this->logger->addError('Could not refund payment: '.$e->getMessage());
            throw new \Exception(__($e->getMessage()));
        }

        return $this;
    }

    public function refund(InfoInterface $payment, $amount)
    {
        $this->cancel($payment, $amount);

        return $this;
    }

    public function void(InfoInterface $payment)
    {
        $this->cancel($payment);

        return $this;
    }

    public function acceptPayment(InfoInterface $payment)
    {
        return parent::acceptPayment($payment);
    }

    public function denyPayment(InfoInterface $payment)
    {
        return parent::denyPayment($payment);
    }

    // Fixes https://github.com/magento/magento2/issues/5413 in Magento 2.1
    public function setId($code) { }
    public function getId() { return $this::$code; }

    public function is3DSecurePending()
    {
        if (!$this->config->is3DSecureEnabled())
            return false;

        $info = $this->getInfoInstance();
        $token = $info->getAdditionalInformation('token');
        if (strpos($token, 'src_') !== 0)
            return false;

        try
        {
            $source = $this->helper->retrieveSource($token);

            if ($source->type !== 'three_d_secure')
                return false;

            $isAdminCapture = ($this->helper->isAdmin() && $source->status == 'chargeable');

            // A source is Pending authorization, and is then Chargeable until charged after a webhook event. It then becomes Consumed.
            return ($source->status == 'pending' || $isAdminCapture);
        }
        catch (\Stripe\Error\Card $e)
        {
            $this->helper->dieWithError($e->getMessage());
        }
        catch (\Stripe\Error $e)
        {
            $this->helper->dieWithError($e->getMessage(), $e);
        }
        catch (\Exception $e)
        {
            if (stripos($e->getMessage(), "a similar object exists in test mode, but a live mode key was used") !== false)
                return false;
            else if (stripos($e->getMessage(), "No such ") === 0)
            {
                $this->helper->dieWithError("Payment details for this order could not be found in your Stripe account (" . $e->getMessage() . ")");
            }
            $this->helper->dieWithError($e->getMessage(), $e);
        }
    }
}
