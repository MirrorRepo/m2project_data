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

use Magento\Authorization\Model\Acl\Role\User as RoleGroup;
use Magento\Customer\Model\CustomerFactory as  CustomerFactory;
 
class Searchrequirement extends \Magento\Framework\View\Element\Template
{
    protected $profilefactory;
    protected $userfactory;
    protected $marketHelper;
    protected $rolesFactory;
    protected $bulletinFactory;
    protected $customerFactory;
   
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Medma\MarketPlace\Model\Profilefactory $profilefactory,
        \Magento\User\Model\UserFactory $userfactory,
        \Medma\MarketPlace\Helper\Data $marketHelper,
        \Magento\Authorization\Model\RoleFactory $rolesFactory,
        \Medma\MarketPlace\Model\BulletinFactory  $bulletinFactory,
        CustomerFactory $customerFactory

    ) {
        $this->profilefactory = $profilefactory;
        $this->userfactory = $userfactory;
        $this->marketHelper = $marketHelper;
        $this->rolesFactory = $rolesFactory;
        $this->bulletinFactory = $bulletinFactory;
        $this->customerFactory = $customerFactory;
        parent::__construct($context);
    }
    public function getBulletinCollection()
    {

      $searchtext = $this->getRequest()->getParams();
      
      $bulletinCollection = $this->bulletinFactory->create()->                   getCollection()
                                  ->addFieldToFilter('approve', ['eq'=>'1']); 


            



 $customerCollection = $this->customerFactory->create()->getCollection();

if (
            isset($searchtext['scorecard_level']) || 
            isset($searchtext['location']) || 
            isset($searchtext['name']) || 
            isset($searchtext['industry'])

            ){

$locationVal =  $searchtext['location'];

$scorecard_level = $searchtext['scorecard_level'];

$industryVal = $searchtext['industry'];

$titleVal = $searchtext['name'];

                  $customerCollection->addFieldToFilter('location', ['like'=>'%'.$locationVal.'%'])
                  ->addFieldToFilter('scorecard_level', ['like'=>'%'.$scorecard_level.'%'])
                  ->addFieldToFilter('industry', ['like'=>'%'.$industryVal.'%']);

$customerCollection->getSelect()->where("cbb.title LIKE ?", "%".$titleVal."%");

}


 $customerCollection->getSelect()->joinLeft(
                        ['cbb' => $customerCollection->getTable('smj_bulletin_board')], 'e.entity_id=cbb.customer_id', ['title','product_cat','ldos', 'customer_id']
                ); 

 $getSize = $customerCollection->getSize();
 if(!empty( $getSize)){
     return   $customerCollection->getData();
 }else{
    return false;
 }
  
        
    }

     public function getBulletinDetails($id)
    {
           $bulletinCollection = $this->bulletinFactory->create()->                   getCollection()
                                  ->addFieldToFilter('customer_id', ['eq'=>$id])
                                  ->getFirstItem();
             return $bulletinCollection->getData();

    }
}
