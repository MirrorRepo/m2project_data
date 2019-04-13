<?php

/**
 *
 * Copyright © 2015 Bakewaycommerce. All rights reserved.
 */

namespace Bakeway\StoreCatalog\Controller\Catalog;

class Index extends \Magento\Framework\App\Action\Action {

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
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    protected $_orderCollectionFactory;
    protected $_itemCollectionFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\StateInterface $cacheState
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
    \Magento\Framework\App\Action\Context $context, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, \Magento\Framework\App\Cache\StateInterface $cacheState, \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory, \Magento\Framework\Registry $coreRegistry, \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory, \Magento\Sales\Model\Order\ItemFactory $itemCollectionFactory
    ) {
        parent::__construct($context);
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheState = $cacheState;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->resultPageFactory = $resultPageFactory;
        $this->rangepriceFactory = $rangepriceFactory;
        $this->coreRegistry = $coreRegistry;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_itemCollectionFactory = $itemCollectionFactory;
    }

    /**
     * Flush cache storage
     *
     */

    public function execute() {
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
      $objectManager->create('Bakeway\Crons\Model\OccasionwiseOrders')->getOrderCollectionByOccasion();

      die;

        $this->resultPage = $this->resultPageFactory->create();
        $this->resultPage->getConfig()->getTitle()->set('Manage Store Catalogue');
        $_id = $this->getRequest()->getParam('id');

        $this->coreRegistry->register('sellerid', $_id);
        return $this->resultPage;
    }

}
