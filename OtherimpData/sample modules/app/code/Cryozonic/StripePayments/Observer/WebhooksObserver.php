<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Observer;

use Magento\Framework\Event\ObserverInterface;
use Cryozonic\StripePayments\Helper\Logger;
use Cryozonic\StripePayments\Exception\WebhookException;

class WebhooksObserver implements ObserverInterface
{
    public function __construct(
        \Cryozonic\StripePayments\Helper\Webhooks $webhooksHelper,
        \Cryozonic\StripePayments\Helper\Generic $paymentsHelper,
        \Cryozonic\StripePayments\Model\Config $config,
        \Cryozonic\StripePayments\Model\Method\ThreeDSecure $threeDSecure,
        \Magento\Sales\Model\Order\Email\Sender\OrderCommentSender $orderCommentSender
    )
    {
        $this->webhooksHelper = $webhooksHelper;
        $this->paymentsHelper = $paymentsHelper;
        $this->config = $config;
        $this->threeDSecure = $threeDSecure;
        $this->orderCommentSender = $orderCommentSender;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $eventName = $observer->getEvent()->getName();
        $arrEvent = $observer->getData('arrEvent');
        $stdEvent = $observer->getData('stdEvent');
        $object = $observer->getData('object');

        $order = $this->webhooksHelper->loadOrderFromEvent($arrEvent);

        switch ($eventName) {
            case 'cryozonic_stripe_webhook_source_chargeable_three_d_secure':

                $this->threeDSecure->charge($order, $arrEvent['data']['object']);
                break;

            case 'cryozonic_stripe_webhook_charge_failed_three_d_secure':

                $this->paymentsHelper->cancelOrCloseOrder($order);
                $this->addOrderCommentWithEmail($order, "Your order has been cancelled. The card 3D Secure authorization succeeded, however your bank declined the payment when a charge was attempted.");
                break;

            case 'cryozonic_stripe_webhook_source_canceled_three_d_secure':

                $cancelled = $this->paymentsHelper->cancelOrCloseOrder($order);

                // The order will not be cancelled if it has already been charged, only if it is still pending
                if ($cancelled)
                {
                    $this->addOrderCommentWithEmail($order, "Sorry, your order has been cancelled because a 3D Secure session was initiated, but we did not receive a successful or failed authorization message from your bank. Please place your order again.");
                }

                break;

            case 'cryozonic_stripe_webhook_source_failed_three_d_secure':

                $this->paymentsHelper->cancelOrCloseOrder($order);
                $this->addOrderCommentWithEmail($order, "Your order has been cancelled because the card 3D Secure authorization failed.");
                break;

            case 'cryozonic_stripe_webhook_charge_refunded_card':

                $this->webhooksHelper->refund($order, $object);
                break;

            default:
                # code...
                break;
        }
    }

    public function addOrderCommentWithEmail($order, $comment)
    {
        $order->addStatusToHistory($status = false, $comment, $isCustomerNotified = true);
        $this->orderCommentSender->send($order, $notify = true, $comment);
        $order->save();
    }
}
