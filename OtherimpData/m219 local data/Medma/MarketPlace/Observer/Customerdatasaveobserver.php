<?php
/**
 *
 * Copyright © 2016 Medma. All rights reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 */
 
namespace Medma\MarketPlace\Observer;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;

class Customerdatasaveobserver implements ObserverInterface
{

    protected $_customerRepositoryInterface;
    protected $_request;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_request = $request;
    }
 

    public function execute(Observer $observer)
    {
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/user.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $id = $observer->getEvent()->getCustomer()->getId();
        $customer = $this->_customerRepositoryInterface->getById($id);

        $group_id = $this->_request->getParam('group_id');
        $customer->setGroupId($group_id);
        $this->_customerRepositoryInterface->save($customer);;

         $logger->info($group_id);
         $logger->info('---------------------');
    }
}
