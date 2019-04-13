<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Observer;

use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Cryozonic\StripePayments\Helper\Logger;

class OrderObserver extends AbstractDataAssignObserver
{
    public function __construct(\Cryozonic\StripePayments\Model\Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $method = $order->getPayment()->getMethod();

        if ($method != 'cryozonic_stripe')
            return;

        // Set the order status according to the configuration
        $newOrderStatus = $this->config->getNewOrderStatus();
        if ($newOrderStatus)
            $order->addStatusToHistory($newOrderStatus, __('Changing order status as per New Order Status configuration'));

        $this->updateOrderState($observer);

        // Different to M1, this is unnecessary
        // $this->updateStripeCustomer()
    }

    public function updateOrderState($observer)
    {
        $order = $observer->getEvent()->getOrder();
        $payment = $order->getPayment();

        if ($payment->getAdditionalInformation('three_d_secure_pending'))
        {
            $order->setState(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
            $order->addStatusToHistory(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT, "3D Secure authorization is pending", false);
            $order->save();
        }
    }
}
