<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model\Method;

use Cryozonic\StripePayments\Helper\Logger;
use Cryozonic\StripePayments\Exception\WebhookException;

class ThreeDSecure
{
    public function __construct(
        \Cryozonic\StripePayments\Model\Config $config,
        \Cryozonic\StripePayments\Helper\Generic $helper,
        \Cryozonic\StripePayments\Helper\Api $api,
        \Cryozonic\StripePayments\Helper\Webhooks $webhooksHelper
    ) {
        $this->config = $config;
        $this->helper = $helper;
        $this->api = $api;
        $this->webhooksHelper = $webhooksHelper;
    }

    public function charge($order, $object)
    {
        $orderId = $order->getIncrementId();

        $payment = $order->getPayment();
        if (empty($payment))
            throw new WebhookException("Could not load payment method for order #$orderId", 202);

        $customerStripeId = $payment->getAdditionalInformation('customer_stripe_id');

        $orderSourceId = $payment->getAdditionalInformation('source_id');
        $webhookSourceId = $object['id'];
        if ($orderSourceId != $webhookSourceId)
            throw new WebhookException("Received source.chargeable webhook for order #$orderId but the source ID on the webhook $webhookSourceId was different than the one on the order $orderSourceId", 202);

        try
        {
            // Charge the card
            if ($this->config->getConfigData('payment_action') == \Magento\Payment\Model\Method\AbstractMethod::ACTION_AUTHORIZE_CAPTURE)
            {
                $this->helper->captureOrder($order);
                $comment = "Payment authorized and captured in Stripe";
                $transactionType = \Magento\Sales\Model\Order\Payment\Transaction::TYPE_CAPTURE;
            }
            else
            {
                $this->api->createCharge($payment, null, false);
                $comment = "Payment authorized in Stripe";
                $transactionType = \Magento\Sales\Model\Order\Payment\Transaction::TYPE_AUTH;
            }

            // Different to M1, no need to add a transaction, it is already added
            // when the invoice is created.
            // $payment->addTransaction($transactionType, null, false, $comment);

            $payment->setIsTransactionPending(false);
            $payment->save();

            if ($order->getState() != \Magento\Sales\Model\Order::STATE_PROCESSING)
                $order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING, \Magento\Sales\Model\Order::STATE_PROCESSING, "Transaction created in Stripe", false);

            $order->save();

            // Save the card
            if ($payment->getAdditionalInformation('save_card'))
            {
                $customer = \Stripe\Customer::retrieve($customerStripeId);
                $this->helper->addSavedCard($customer, $object['three_d_secure']['card']);
            }

            // Send the order email
            $this->webhooksHelper->sendNewOrderEmailFor($order);
        }
        catch (\Stripe\Error\Card $e)
        {
            $comment = "Order could not be charged because of a card error: " . $e->getMessage();
            $order->addStatusHistoryComment($comment);
            $order->save();
            throw new WebhookException($e->getMessage(), 202);
        }
        catch (\Stripe\Error $e)
        {
            $comment = "Order could not be charged because of a Stripe error.";
            $order->addStatusHistoryComment($comment);
            $order->save();
            throw new WebhookException($e->getMessage(), 202);
        }
        catch (\Exception $e)
        {
            $comment = "Order could not be charged because of server side error.";
            $order->addStatusHistoryComment($comment);
            $order->save();
            throw new WebhookException($e->getMessage(), 202);
        }
    }
}
