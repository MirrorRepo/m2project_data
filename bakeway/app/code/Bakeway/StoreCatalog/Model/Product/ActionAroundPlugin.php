<?php

namespace Bakeway\StoreCatalog\Model\Product;

use Magento\Catalog\Model\Product\Action\Interceptor;
use Webkul\Marketplace\Model\Product as Marketplaceproduct;
use Magento\Catalog\Api\ProductRepositoryInterface as ProductRepositoryInterface;


class ActionAroundPlugin
{
    
    /**
     * @var Marketplaceproduct
     */
    
    protected $marketplaceproduct;
    
    /**
     *
     * @var type ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    /**
     * 
     * @param Marketplaceproduct $marketplaceproduct
     * @param ProductRepositoryInterface $productRepositoryInterface
     */
    public function __construct(
            Marketplaceproduct $marketplaceproduct,
            ProductRepositoryInterface $productRepositoryInterface
            ){
    $this->marketplaceproduct =$marketplaceproduct;
    $this->productRepositoryInterface = $productRepositoryInterface;
    }
    
    /**
     * @param Interceptor $interceptor
     * @param \Closure $closure
     * @param $productIds
     * @param $attrData
     * @param $storeId
     * @return Interceptor
     */
    public function aroundUpdateAttributes(
        Interceptor $interceptor,
        \Closure $closure,
        $productIds,
        $attrData,
        $storeId
    ) {
        $result = $closure($productIds, $attrData, $storeId);
        if(count($productIds) > 0 ){
            
            foreach($productIds as $productId){
             $productDetailsObj =   $this->productRepositoryInterface->getById($productId);
              
             $updateProStatus = $productDetailsObj->getData('status');
             $sellerProduct = $this->marketplaceproduct->getCollection()
            ->addFieldToFilter('mageproduct_id', $productId)
            ->getFirstItem();
            $approvedFlag = "";
            $status = $updateProStatus;
            if(!empty($sellerProduct->getStatus())){

                if($status == \Bakeway\EventsListing\Observer\ProductAction::product_enable){ 
                   $approvedFlag = \Bakeway\EventsListing\Observer\ProductAction::product_enable;   
                }else if($status == \Bakeway\EventsListing\Observer\ProductAction::product_disable){
                   $approvedFlag = \Bakeway\EventsListing\Observer\ProductAction::product_disable;    
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
        
           
        return $result;
    }
}
