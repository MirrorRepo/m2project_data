<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Backend\Model\Session;
use Cryozonic\StripePayments\Model;
use Psr\Log\LoggerInterface;
use Magento\Framework\Validator\Exception;
use Cryozonic\StripePayments\Helper\Logger;
use Cryozonic\StripePayments\Model\PaymentMethod;
use Cryozonic\StripePayments\Model\Config;
use Magento\Framework\Exception\CouldNotSaveException;

class Generic
{
    public $magentoCustomerId = null;
    public $urlBuilder = null;
    protected $cards = array();

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Backend\Model\Session\Quote $backendSessionQuote,
        \Magento\Framework\App\Request\Http $request,
        LoggerInterface $logger,
        \Magento\Framework\App\State $appState,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Sales\Model\Order $order,
        \Magento\Sales\Model\Order\Invoice $invoice,
        \Magento\Sales\Model\Service\InvoiceService $invoiceService,
        \Magento\Sales\Model\Order\Creditmemo $creditmemo,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Sales\Block\Adminhtml\Order\Create\Form\Address $adminOrderAddressForm,
        \Magento\Customer\Model\CustomerRegistry $customerRegistry,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Catalog\Model\Product $productModel,
        \Magento\Sales\Model\Order $orderModel,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Sales\Model\Order\Invoice\CommentFactory $invoiceCommentFactory,
        \Magento\Customer\Model\Address $customerAddress,
        \Magento\Framework\Webapi\Response $apiResponse,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Framework\App\RequestInterface $requestInterface,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->backendSessionQuote = $backendSessionQuote;
        $this->request = $request;
        $this->logger = $logger;
        $this->appState = $appState;
        $this->storeManager = $storeManager;
        $this->order = $order;
        $this->invoice = $invoice;
        $this->invoiceService = $invoiceService;
        $this->creditmemo = $creditmemo;
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->resource = $resource;
        $this->coreRegistry = $coreRegistry;
        $this->adminOrderAddressForm = $adminOrderAddressForm;
        $this->customerRegistry = $customerRegistry;
        $this->messageManager = $messageManager;
        $this->productModel = $productModel;
        $this->orderModel = $orderModel;
        $this->cart = $cart;
        $this->invoiceCommentFactory = $invoiceCommentFactory;
        $this->customerAddress = $customerAddress;
        $this->apiResponse = $apiResponse;
        $this->transactionFactory = $transactionFactory;
        $this->requestInterface = $requestInterface;
        $this->urlBuilder = $urlBuilder;
        $this->pricingHelper = $pricingHelper;
    }

    public function getBackendSessionQuote()
    {
        return $this->backendSessionQuote;
    }

    public function isSecure()
    {
        return $this->request->isSecure();
    }

    public function getSessionQuote()
    {
        return $this->checkoutSession->getQuote();
    }

    public function getStoreId()
    {
        if ($this->isAdmin())
        {
            if ($this->request->getParam('order_id', null))
            {
                // Viewing an order
                $order = $this->order->load($this->request->getParam('order_id', null));
                return $order->getStoreId();
            }
            if ($this->request->getParam('invoice_id', null))
            {
                // Viewing an invoice
                $invoice = $this->invoice->load($this->request->getParam('invoice_id', null));
                return $invoice->getStoreId();
            }
            else if ($this->request->getParam('creditmemo_id', null))
            {
                // Viewing a credit memo
                $creditmemo = $this->creditmemo->load($this->request->getParam('creditmemo_id', null));
                return $creditmemo->getStoreId();
            }
            else
            {
                // Creating a new order
                $quote = $this->getBackendSessionQuote();
                return $quote->getStoreId();
            }
        }
        else
        {
            return $this->storeManager->getStore()->getId();
        }
    }

    public function loadProductById($productId)
    {
        $this->productModel->clearInstance();
        return $this->productModel->load($productId);
    }

    public function loadOrderByIncrementId($incrementId)
    {
        $this->orderModel->clearInstance();
        return $this->orderModel->loadByIncrementId($incrementId);
    }

    public function createInvoiceComment($msg, $notify = false, $visibleOnFront = false)
    {
        return $this->invoiceCommentFactory->create()
            ->setComment($msg)
            ->setIsCustomerNotified($notify)
            ->setIsVisibleOnFront($visibleOnFront);
    }

    public function isAdmin()
    {
        $areaCode = $this->appState->getAreaCode();

        return $areaCode == \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE;
    }

    public function isCustomerLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    public function getCustomerId()
    {
        // If we are in the back office
        if ($this->isAdmin())
        {
            // About to refund/invoice an order
            if ($order = $this->coreRegistry->registry('current_order'))
                return $order->getCustomerId();

            // About to capture an invoice
            if ($invoice = $this->coreRegistry->registry('current_invoice'))
                return $invoice->getCustomerId();

            // Creating a new order from admin
            if ($this->adminOrderAddressForm && $this->adminOrderAddressForm->getCustomerId())
                return $this->adminOrderAddressForm->getCustomerId();
        }
        // If we are on the checkout page
        else if ($this->customerSession->isLoggedIn())
        {
            return $this->customerSession->getCustomerId();
        }
        // A webhook has instantiated this object
        else if (!empty($this->magentoCustomerId))
        {
            return $this->magentoCustomerId;
        }

        return null;
    }

    public function getMagentoCustomer()
    {
        if ($this->customerSession->getCustomer()->getEntityId())
            return $this->customerSession->getCustomer();

        $customerId = $this->getCustomerId();
        if (!$customerId) return;

        $customer = $this->customerRegistry->retrieve($customerId);

        if ($customer->getEntityId())
            return $customer;

        return null;
    }

    // Should return the email address of guest customers
    public function getCustomerEmail()
    {
        $customer = $this->getMagentoCustomer();

        if (!$customer)
            $customer = $this->getGuestCustomer();

        if (!$customer)
            return null;

        return trim(strtolower($customer->getEmail()));
    }

    public function getGuestCustomer($order = null)
    {
        if ($order)
        {
            return $this->getAddressFrom($order, 'billing');
        }
        else if (isset($this->_order))
        {
            return $this->getAddressFrom($this->_order, 'billing');
        }
        else
            return null;
    }

    public function getCustomerDefaultBillingAddress()
    {
        $customer = $this->getMagentoCustomer();
        if (!$customer) return null;

        $addressId = $customer->getDefaultBilling();
        if (!$addressId) return null;

        $this->customerAddress->clearInstance();
        $address = $this->customerAddress->load($addressId);
        return $address;
    }

    public function getCustomerBillingAddress()
    {
        $quote = $this->getSessionQuote();
        if (empty($quote))
            return null;

        return $quote->getBillingAddress();
    }

    public function getStripeFormattedDefaultBillingAddress()
    {
        $address = $this->getCustomerDefaultBillingAddress();

        if (empty($address))
            return null;

        return [
            "address_line1" => $address->getStreetLine(1),
            "address_line2" => $address->getStreetLine(2),
            "address_city" => $address->getCity(),
            "address_state" => $address->getRegion(),
            "address_zip" => $address->getPostcode(),
            "address_country" => $address->getCountryId()
        ];
    }

    public function getStripeFormattedBillingAddress()
    {
        $address = $this->getCustomerBillingAddress();

        if (empty($address))
            return null;

        return [
            "address_line1" => $address->getStreetLine(1),
            "address_line2" => $address->getStreetLine(2),
            "address_city" => $address->getCity(),
            "address_state" => $address->getRegion(),
            "address_zip" => $address->getPostcode(),
            "address_country" => $address->getCountryId()
        ];
    }

    public function getCustomerLastRetrieved()
    {
        if (isset($this->customerLastRetrieved))
            return $this->customerLastRetrieved;

        // Get the magento customer id
        if (empty($customerId))
            $customerId = $this->getCustomerId();

        if (!empty($customerId) && $customerId < 1)
            $customerId = null;

        $connection = $this->resource->getConnection('core_read');
        $query = $connection->select()
            ->from('cryozonic_stripe_customers', ['*'])
            ->where('customer_id=?', $customerId);

        $result = $connection->fetchRow($query);
        if (empty($result)) return false;
        $this->customerStripeId = $result['stripe_id'];
        return $this->customerLastRetrieved = $result['last_retrieved'];
    }

    public function getAvsFields($card)
    {
        // If the card is a token then AVS should have already been taken care of during token creation
        if (!is_array($card))
            return $card;

        $address = $this->getStripeFormattedBillingAddress();

        // Union the arrays, existing keys from $card are preserved
        if (is_array($address))
            return $card + $address;

        return $card;
    }

    protected function updateLastRetrieved($stripeCustomerId)
    {
        try
        {
            $connection = $this->resource->getConnection('core_write');
            $fields = array();
            $fields['last_retrieved'] = time();
            $condition = array($connection->quoteInto('stripe_id=?', $stripeCustomerId));
            $result = $connection->update('cryozonic_stripe_customers', $fields, $condition);
        }
        catch (\Exception $e)
        {
            $this->logger->addError('Could not update Stripe customers table: '.$e->getMessage());
        }
    }

    public function getMultiCurrencyAmount($payment, $baseAmount)
    {
        $order = $payment->getOrder();
        $grandTotal = $order->getGrandTotal();
        $baseGrandTotal = $order->getBaseGrandTotal();

        $rate = $order->getBaseToOrderRate();
        if ($rate == 0) $rate = 1;

        // Full capture, ignore currency rate in case it changed
        if ($baseAmount == $baseGrandTotal)
            return $grandTotal;
        // Partial capture, consider currency rate but don't capture more than the original amount
        else if (is_numeric($rate))
            return min($baseAmount * $rate, $grandTotal);
        // Not a multicurrency capture
        else
            return $baseAmount;
    }

    public function getAddressFrom($order, $addressType = 'shipping')
    {
        if (!$order) return null;

        $addresses = $order->getAddresses();
        foreach ($addresses as $address)
        {
            if ($address["address_type"] == $addressType)
                return $address;
        }

        return null;
    }

    public function hasSubscriptions()
    {
        if (isset($this->_hasSubscriptions))
            return true;

        $items = $this->cart->getQuote()->getAllItems();
        foreach ($items as $item)
        {
            $product = $this->loadProductById($item->getProduct()->getEntityId());
            if ($product->getCryozonicSubEnabled())
                return $this->_hasSubscriptions = true;
        }
    }

    public function isZeroDecimal($currency)
    {
        return in_array(strtolower($currency), array(
            'bif', 'djf', 'jpy', 'krw', 'pyg', 'vnd', 'xaf',
            'xpf', 'clp', 'gnf', 'kmf', 'mga', 'rwf', 'vuv', 'xof'));
    }

    public function isAuthorizationExpired($errorMessage)
    {
        return (strstr($errorMessage, "cannot be captured because the charge has expired") !== false);
    }

    public function addError($msg)
    {
        $this->messageManager->addError( __($msg) );
    }

    public function addSuccess($msg)
    {
        $this->messageManager->addSuccess( __($msg) );
    }

    public function logError($msg)
    {
        $this->logger->addError(Config::module() . ": " . $msg);
    }

    public function isAjaxRequest()
    {
        return $this->requestInterface->isXmlHttpRequest();
    }

    public function isStripeAPIKeyError($msg)
    {
        $pos1 = stripos($msg, "Invalid API key provided");
        $pos2 = stripos($msg, "No API key provided");
        if ($pos1 !== false || $pos2 !== false)
            return true;

        return false;
    }

    public function cleanError($msg)
    {
        if ($this->isStripeAPIKeyError($msg))
            return "Invalid Stripe API key provided.";

        return $msg;
    }

    public function isMultiShipping()
    {
        $quote = $this->getSessionQuote();
        if (empty($quote))
            return false;

        return $quote->getIsMultiShipping();
    }

    public function dieWithError($msg, $e = null)
    {
        $this->logError($msg);

        if ($e)
        {
            if ($e->getMessage() != $msg)
                $this->logError($e->getMessage());

            $this->logError($e->getTraceAsString());
        }

        if ($this->isAdmin())
        {
            $this->addError($this->cleanError($msg));
            throw new \Exception($msg);
        }
        else if ($this->isAjaxRequest())
            throw new CouldNotSaveException(__($this->cleanError($msg)), $e);
        else if ($this->isMultiShipping())
            throw new \Magento\Framework\Exception\LocalizedException(__($msg), $e);
        else
            $this->addError($this->cleanError($msg));
    }

    public function captureOrder($order)
    {
        foreach($order->getInvoiceCollection() as $invoice)
        {
            $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);
            $invoice->capture();
            $invoice->save();
        }
    }

    public function invoiceOrder($order, $transactionId = null)
    {
        $dbTransaction = $this->transactionFactory->create();

        // This will kick in with "Authorize Only" mode, but not with "Authorize & Capture"
        if ($order->canInvoice())
        {
            $invoice = $this->invoiceService->prepareInvoice($order);
            $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);

            if ($transactionId)
                $invoice->setTransactionId($transactionId);

            $invoice->register();

            $dbTransaction->addObject($invoice)
                        ->addObject($order)
                        ->save();
        }
        // Invoices have already been generated with Authorize & Capture, but have not actually been captured because
        // the source is not chargeable yet. These should have a pending status.
        else
        {
            foreach($order->getInvoiceCollection() as $invoice)
            {
                $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);
                $invoice->register();
                $dbTransaction->addObject($invoice);
            }

            $dbTransaction->addObject($order)->save();
        }

        return $invoice;
    }

    // Pending orders are the ones that were placed with an asynchronous payment method, such as SOFORT or SEPA Direct Debit,
    // which may finalize the charge after several days or weeks
    public function invoicePendingOrder($order, $captureCase = \Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE, $transactionId = null)
    {
        if (!$order->canInvoice())
            throw new \Exception("Order #" . $order->getIncrementId() . " cannot be invoiced.");

        $invoice = $this->invoiceService->prepareInvoice($order);

        $invoice->setRequestedCaptureCase($captureCase);

        if ($transactionId)
            $invoice->setTransactionId($transactionId);

        $invoice->register();

        $dbTransaction = $this->transactionFactory->create();

        $dbTransaction
            ->addObject($invoice)
            ->addObject($order)
            ->save();

        return $invoice;
    }

    public function cancelOrCloseOrder($order)
    {
        $cancelled = false;

        $dbTransaction = $this->transactionFactory->create();

        // When in Authorize & Capture, uncaptured invoices exist, so we should cancel them first
        foreach($order->getInvoiceCollection() as $invoice)
        {
            if ($invoice->canCancel())
            {
                $invoice->cancel();
                $dbTransaction->addObject($invoice);
                $cancelled = true;
            }
        }

        // When all invoices have been canceled, the order can be canceled
        if ($order->canCancel())
        {
            $order->cancel();
            $dbTransaction->addObject($order);
            $cancelled = true;
        }

        $dbTransaction->save();

        return $cancelled;
    }

    public function getSanitizedBillingInfo()
    {
        // This method is unnecessary in M2, the checkout passes the correct billing details
    }

    public function retrieveSource($token)
    {
        if (isset($this->sources[$token]))
            return $this->sources[$token];

        $this->sources[$token] = \Stripe\Source::retrieve($token);

        return $this->sources[$token];
    }

    public function maskError($msg)
    {
        if (stripos($msg, "You must verify a phone number on your Stripe account") === 0)
            return $msg;

        return false;
    }

    // Removes decorative strings that Magento adds to the transaction ID
    public function cleanToken($token)
    {
        return preg_replace('/-.*$/', '', $token);
    }

    public function retrieveToken($token)
    {
        if (isset($this->sources[$token]))
            return $this->sources[$token];

        $this->sources[$token] = \Stripe\Token::retrieve($token);

        return $this->sources[$token];
    }

    public function retrieveCard($customer, $token)
    {
        if (isset($this->cards[$token]))
            return $this->cards[$token];

        $card = $customer->sources->retrieve($token);
        $this->cards[$token] = $card;

        return $card;
    }

    public function convertSourceToCard($source)
    {
        if (!$source || empty($source->card))
            return null;

        $card = json_decode(json_encode($source->card));
        $card->id = $source->id;
        return $card;
    }

    public function listCards($customer, $params = array())
    {
        try
        {
            $sources = $customer->sources;
            if (!empty($sources))
            {
                // Cards created through the Sources API
                $data = $sources->all(array('type' => 'card'))->data;
                $cards = array();
                foreach ($data as $source)
                    $cards[] = $this->convertSourceToCard($source);

                // Normal cards
                $data = $sources->all(array('object' => 'card'))->data;
                foreach ($data as $card)
                    $cards[] = $card;

                return $cards;
            }
            else
                return null;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    public function findCard($customer, $last4, $expMonth, $expYear)
    {
        $cards = $this->listCards($customer);
        foreach ($cards as $card)
        {
            if ($last4 == $card->last4 &&
                $expMonth == $card->exp_month &&
                $expYear == $card->exp_year)
            {
                return $card;
            }
        }

        return false;
    }

    public function addSavedCard($customer, $newcard)
    {
        if (!$customer)
            return;

        // The Stripe API is used
        if (is_array($newcard) && !empty($newcard['number']))
        {
            // Check if the customer already has this card and set it as the default if so
            $last4 = substr($newcard['number'], -4);
            $month = $newcard['exp_month'];
            $year = $newcard['exp_year'];
            $card = $this->findCard($customer, $last4, $month, $year);
            if ($card)
            {
                $customer->default_source = $card->id;
                $customer->save();
                return $card;
            }
            $newcard = $this->getAvsFields($newcard);
            $newcard["object"] = "card";
            $card = $customer->sources->create(array('source' => $newcard));
            $customer->default_source = $card->id;
            $customer->save();
            return $card;
        }
        // If we are adding a source
        else if (is_string($newcard) && strpos($newcard, 'src_') === 0)
        {
            $source = $this->retrieveSource($newcard);
            if ($source->type == 'card')
            {
                $card = $this->convertSourceToCard($source);
            }
            else if ($source->type == 'three_d_secure')
            {
                // We can get here when:
                // 1. 3D Secure is configured as "Required or optional" and
                // 2. The card is optional and __chargeable__ at the same time, thus we are not redirecting the customer and
                // 3. The customer is trying to save this card at the checkout
                $card = $customer->sources->create(array('source' => $source->three_d_secure->card));
                $customer->default_source = $card->id;
                $customer->save();
                return $card;
            }
            else if ($source->usage == 'reusable' && !isset($source->amount))
            {
                // SEPA Direct Debit with no amount set, no deduplication here
                $card = $customer->sources->create(array('source' => $source->id));
                $customer->default_source = $card->id;
                $customer->save();
                return $card;
            }
            else
            {
                // Bancontact, iDEAL etc
                return null;
            }

            if (isset($card->last4))
            {
                $last4 = $card->last4;
                $month = $card->exp_month;
                $year = $card->exp_year;
                $exists = $this->findCard($customer, $last4, $month, $year);
                if ($exists)
                {
                    $customer->default_source = $exists->id;
                    $customer->save();
                    return $exists;
                }
                else
                {
                    $card2 = $customer->sources->create(array('source' => $card->id));
                    $customer->default_source = $card2->id;
                    $customer->save();
                    return $card2;
                }
            }
        }
        // This should never hit, but if it does, assume it is already saved and set the card as the default
        else if (is_string($newcard) && strpos($newcard, 'card_') === 0)
        {
            $card = $this->retrieveCard($customer, $newcard);
            $customer->default_source = $card->id;
            $customer->save();
            return $card;
        }
        // Stripe.js v2
        else if (is_string($newcard) && strpos($newcard, 'tok_') === 0)
        {
            $token = $this->retrieveToken($newcard);
            $card = $token->card;
            $last4 = $card->last4;
            $month = $card->exp_month;
            $year = $card->exp_year;
            $card = $this->findCard($customer, $last4, $month, $year);
            if ($card)
            {
                $customer->default_source = $card->id;
                $customer->save();
                return $card;
            }
            $card = $customer->sources->create(array('source' => $newcard));
            $customer->default_source = $card->id;
            $customer->save();
            return $card;
        }

        return null;
    }

    public function formatPrice($price)
    {
        return $this->pricingHelper->currency($price, true, false);
    }

    public function getRefundIdFrom($charge)
    {
        $lastRefundDate = 0;
        $refundId = null;

        foreach ($charge->refunds->data as $refund)
        {
            // There might be multiple refunds, and we are looking for the most recent one
            if ($refund->created > $lastRefundDate)
            {
                $lastRefundDate = $refund->created;
                $refundId = $refund->id;
            }
        }

        return $refundId;
    }
}
