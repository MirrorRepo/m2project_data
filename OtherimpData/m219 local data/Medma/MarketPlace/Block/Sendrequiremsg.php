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

namespace Medma\MarketPlace\Block;
 
class Sendrequiremsg extends \Magento\Framework\View\Element\Template
{
    protected $userfactory;
    protected $profilefactory;
    protected $messagefactory;
    protected $detailfactory;
    protected $customerSession;
    protected $adminSession;
    protected $messageFactory;
    protected $messagechainFactory;
    protected $productRepositoryInterface;


    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\User\Model\UserFactory $userfactory,
        \Medma\MarketPlace\Model\ProfileFactory $profilefactory,
        \Medma\MarketPlace\Model\MessageFactory $messagefactory,
        \Medma\MarketPlace\Model\DetailFactory $detailfactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\User\Model\UserFactory $adminSession,
        \Medma\MarketPlace\Model\EnquirymessageFactory $messageFactory,
        \Medma\MarketPlace\Model\EnquirymessagechainFactory $messagechainFactory,
       \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface

    ) {
        $this->userfactory = $userfactory;
        $this->profilefactory = $profilefactory;
        $this->messagefactory = $messagefactory;
        $this->detailfactory = $detailfactory;
        $this->customerSession = $customerSession;
        $this->adminSession = $adminSession;
        $this->messageFactory = $messageFactory;
        $this->messagechainFactory = $messagechainFactory;
        $this->productRepositoryInterface = $productRepositoryInterface;
        parent::__construct($context);
    }
    public function getUser($userid)
    {
        return $this->userfactory->create()->load($userid);
    }
    public function getProfile($userid)
    {
        return $this->profilefactory->create()->load($userid);
    }
    public function getCollection()
    {
        $customerid = $this->customerSession->getCustomer()->getId();
        if ($customerid) {
            $msgcollecition = $this->messageFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerid);

            return $msgcollecition;
        } else {

            return 'There are no messages';
        }
    }
    public function getVendorName($msg_id)
    {
    
        $vendorid = $this->detailfactory->create()->load($msg_id)->getVendorId();
        $user_id = $this->profilefactory->create()->load($vendorid)->getUserId();
        return $this->adminSession->create()->load($user_id)->getName();
    }

    public function getMessageRecord($id)
    {
        if ($id) {
            $msgcollecition = $this->messagechainFactory->create()->getCollection()->addFieldToFilter('msg_id', $id);

            return $msgcollecition;
        } else {

            return 'There are no messages';
        }
    }

    public function getMessageData($id)
    {

        $msgcollecition = $this->messageFactory->create()->getCollection()->addFieldToFilter('entity_id', $id)
                         ->getLastItem();

        return $msgcollecition;
    }

    public function getProductDetails($sku)
    {
        $productObj =  $this->productRepositoryInterface->get($sku);
       return $productObj;
    }

    public function getSellerMessageData($id)
    {

        $msgcollecition = $this->messageFactory->create()->getCollection()->addFieldToFilter('seller_id', $id)
            ->getLastItem();

        return $msgcollecition;
    }


    public function getQuoteData($id)
    {

        $msgcollecition = $this->messageFactory->create()->getCollection()->addFieldToFilter('entity_id', $id)
            ->getLastItem();

        return $msgcollecition;
    }
}
