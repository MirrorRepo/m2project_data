<?php

/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bakeway\EventsListing\Observer;

use Magento\Framework\Event\ObserverInterface;
use Webkul\Marketplace\Model\Product as Marketplaceproduct;
class ProductAction implements ObserverInterface
{    
    
    const product_enable = 1;
    const product_disable = 2;
    
    /**
     * @var Marketplaceproduct
     */
    
    protected $marketplaceproduct;

    /**
     * @param Marketplaceproduct $marketplaceproduct
     */
    public function __construct(
            Marketplaceproduct $marketplaceproduct
            ){
    $this->marketplaceproduct =$marketplaceproduct;
    }
              
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/product_eventslog.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        $_product = $observer->getProduct();  //product object
        $_sku= $_product->getSku(); // for sku
        $status = $_product->getStatus();
        $id = $_product->getId();
        
        $sellerProduct = $this->marketplaceproduct->getCollection()
        ->addFieldToFilter('mageproduct_id', $id)
        ->getFirstItem();
        $approvedFlag = "";
        
        if(!empty($sellerProduct->getStatus())){
             
            if($status == self::product_enable){ 
               $approvedFlag = self::product_enable;   
            }else if($status == self::product_disable){
               $approvedFlag = self::product_disable;    
            }
            
            if(!empty($sellerProduct->getEntityId()) && $sellerProduct->getEntityId() != null){
                $productObj = $this->marketplaceproduct->load($sellerProduct->getEntityId());
                $productObj->setStatus($approvedFlag);
                try{
                   $productObj->save();
                }catch(Exception $e){
                   echo $e->getMessage();
                }
            }
            
        }
    }   
    
}
