<?php

namespace Magenest\ZohocrmIntegration\Observer;

use Magento\Framework\Event\ObserverInterface;

class OrderSyncObserver implements ObserverInterface {

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager) {
        $this->objectManager = $objectManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {

        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getIncrementId();
        $email = $order->getCustomerEmail();
        $createdAt = $order->getCreatedAt();
        $dob = $order->getCustomerDob();
        
        $_shippingAddress = $order->getShippingAddress();
        $sender_fname = $_shippingAddress->getFirstname();
        $sende_lname = $_shippingAddress->getLastname();
        

        $_billingAddress = $order->getBillingAddress();
        $reciever_fname = $_billingAddress->getFirstname();
        $reciever_lname = $_billingAddress->getLastname();
        $phone = $_billingAddress->getTelephone();

        

        foreach ($order->getAllItems() as $item) {

            if ($item->getParentItem()) continue;
            $message = $item->getCustomMessage();
            $syncOrderFactory = $this->objectManager->create('Magenest\ZohocrmIntegration\Model\OrderSync');
            $syncOrderFactory->setData('order_id', $orderId);
            $syncOrderFactory->setData('customer_email', $email);
            $syncOrderFactory->setData('created_at', $createdAt);
            $syncOrderFactory->setData('telephone', $phone);
            $syncOrderFactory->setData('custom_message', $message);
            $syncOrderFactory->setData('sender_firstname', $sender_fname);
            $syncOrderFactory->setData('sender_lastname', $sende_lname);
            $syncOrderFactory->setData('reciever_firstname', $reciever_fname);
            $syncOrderFactory->setData('reciever_lastname', $reciever_lname);
            $syncOrderFactory->setData('dob', $dob);

            try {
                $syncOrderFactory->save();
            } catch (\Exception $e) {
                
            }
        }
    }

}
