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
use  \Medma\MarketPlace\Model\BulletinFactory  as  BulletinFactory;
 
class Requirements extends \Magento\Framework\View\Element\Template
{

   /**
    * @var \Medma\Productsearch\Helper\Data $marketHelper
    */
    protected $Helper;
   
   /**
    * @var \Magento\Framework\Registry $registry
    */
    protected $registry;
    protected $collectionfactory;
    protected $userfactory;
    protected $profilefactory;
    protected $bulletinFactory;
     protected  $customerFactory;
    
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ProductFactory $collectionfactory,
        \Magento\User\Model\UserFactory $userfactory,
        \Medma\MarketPlace\Model\ProfileFactory $profilefactory,
        \Medma\MarketPlace\Helper\Data $Helper,
         BulletinFactory $bulletinFactory,
          \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
        $this->registry = $context->getRegistry();
        $this->userfactory = $userfactory;
        $this->profilefactory = $profilefactory;
        $this->Helper = $Helper;
        $this->collectionfactory = $collectionfactory;
        $this->bulletinFactory = $bulletinFactory;
        $this->_customerFactory = $customerFactory;
        parent::__construct($context);
    }
    public function getRequirementsCollection()
    {
        $collection = $this->bulletinFactory->create()->getCollection()
                         ->addFieldToFilter('approve', 1);
        return $collection;
    }

    public function getCustomerDetails($id)
    {
       $customerDetails =  $this->_customerFactory->create()->load($id);

       return $customerDetails;

    }


    public function getRequirementView($id)
    {
         $collection = $this->bulletinFactory->create()->getCollection()
                         ->addFieldToFilter('customer_id', $id)
                        ->getFirstItem();
        return $collection->getData();
    }

   
}
