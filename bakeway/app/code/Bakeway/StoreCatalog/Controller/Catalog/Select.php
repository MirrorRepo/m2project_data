<?php

/**
 *
 * Copyright © 2015 Bakewaycommerce. All rights reserved.
 */

namespace Bakeway\StoreCatalog\Controller\Catalog;

use Bakeway\StoreCatalog\Model\StorecatalogFactory as StorecatalogFactory;
use Bakeway\StoreCatalog\Helper\Data as StorecatalogHelper;
use Magento\Framework\Controller\Result\JsonFactory as JsonFactory;
class Select extends \Magento\Framework\App\Action\Action {

    
    const STATUS_ENABLE = 1;
    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var \Magento\Framework\App\Cache\StateInterface
     */
    protected $_cacheState;

    /**
     * @var \Magento\Framework\App\Cache\Frontend\Pool
     */
    protected $_cacheFrontendPool;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $rangepriceFactory;

    /**
     * @var StorecatalogFactory 
     */
    protected $storecatalogFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    
    /**
     * @var StorecatalogHelper
     */
    protected $storecatalogHelper;

    /**
     * @var JsonFactory 
     */
    protected $resultJsonFactory;
    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\StateInterface $cacheState
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param StorecatalogFactory $storecatalogFactory
     */
    public function __construct(
    \Magento\Framework\App\Action\Context $context, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, \Magento\Framework\App\Cache\StateInterface $cacheState, \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory, \Magento\Framework\Registry $coreRegistry, StorecatalogFactory $storecatalogFactory
            ,StorecatalogHelper $storecatalogHelper,JsonFactory $resultJsonFactory 
    ) {
        parent::__construct($context);
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheState = $cacheState;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->resultPageFactory = $resultPageFactory;
        $this->rangepriceFactory = $rangepriceFactory;
        $this->coreRegistry = $coreRegistry;
        $this->storecatalogFactory = $storecatalogFactory;
        $this->storecatalogHelper = $storecatalogHelper;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Flush cache storage
     *
     */
    public function execute() {
        $this->resultPage = $this->resultPageFactory->create();
        $sellerId = $this->getRequest()->getParam('seller_id');
        $storeLocalityId = $this->getRequest()->getParam('locality_id');

        $result = $this->resultJsonFactory->create();
        
        if (isset($sellerId) && isset($storeLocalityId)) {
            $sellerid = $sellerId;
            $localityId = $storeLocalityId;
            return $result->setData(['success' => true,'seller_id'=>$sellerId,'store_id' => $storeLocalityId]);
        } else {
            return $result->setData(['success' => false]);
        }
    }

}
