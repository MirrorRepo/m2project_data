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


class Featuredproducts extends \Magento\Framework\View\Element\Template
{

  protected $customerSession;
 
   /**
   * Catalog product visibility
   *
   * @var \Magento\Catalog\Model\Product\Visibility
   */
  protected $catalogProductVisibility;

  /**
   * Product collection factory
   *
   * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
   */
  protected $productCollectionFactory;

 
  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
     \Magento\Customer\Model\Session $customerSession,
     \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
      \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
    )
    { 
       $this->customerSession = $customerSession;
       $this->productCollectionFactory = $productCollectionFactory;
       $this->catalogProductVisibility = $catalogProductVisibility;
       parent::__construct($context);
    }


    public function getFeaturedProductCollection(){

        $collection = $this->productCollectionFactory->create();
        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());
        $collection->addAttributeToFilter("featured_products","1");
        
        return $collection->getData();
    
    }

}
