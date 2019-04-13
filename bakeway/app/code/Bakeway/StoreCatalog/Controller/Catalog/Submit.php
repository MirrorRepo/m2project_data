<?php

/**
 *
 * Copyright © 2015 Bakewaycommerce. All rights reserved.
 */

namespace Bakeway\StoreCatalog\Controller\Catalog;

use Bakeway\StoreCatalog\Model\StorecatalogFactory as StorecatalogFactory;
use Bakeway\StoreCatalog\Helper\Data as StorecatalogHelper;
use Magento\Framework\Controller\Result\JsonFactory as JsonFactory;
use Bakeway\OrderstatusEmail\Model\Email as OrderstatusEmail;
use Bakeway\StoreCatalog\Model\StorecatalogcategoryFactory as StorecatalogcategoryFactory;

class Submit extends \Magento\Framework\App\Action\Action {

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

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
     * @var OrderstatusEmail
     */
    protected $orderstatusEmail;

    /**
     * @var StorecatalogcategoryFactory
     */
    protected $storecatalogcategoryFactory;

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
     * @param StorecatalogcategoryFactory $storecatalogcategoryFactory
     */
    public function __construct(
    \Magento\Framework\App\Action\Context $context, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, \Magento\Framework\App\Cache\StateInterface $cacheState, \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory, \Magento\Framework\Registry $coreRegistry, StorecatalogFactory $storecatalogFactory
    , StorecatalogHelper $storecatalogHelper, JsonFactory $resultJsonFactory, OrderstatusEmail $orderstatusEmail, StorecatalogcategoryFactory $storecatalogcategoryFactory
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
        $this->orderstatusEmail = $orderstatusEmail;
        $this->storecatalogcategoryFactory = $storecatalogcategoryFactory;
    }

    /**
     * Flush cache storage
     *
     */
    public function execute() {
        $this->resultPage = $this->resultPageFactory->create();
        $this->resultPage->getConfig()->getTitle()->set('Delivery Range & Price');
        $sellerId = $this->getRequest()->getParam('seller_id');
        $sellerName = $this->getRequest()->getParam('seller_name');
        $produts = $this->getRequest()->getParam('productsId');
        $storeLocalityId = $this->getRequest()->getParam('locality_id');

        $categoryIds = $this->getRequest()->getParam('categoryIds');
        $activeCatids = $this->getRequest()->getParam('activeCatsId');


        $result = $this->resultJsonFactory->create();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/storelog.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        /**
         * STORE WISE CATEGORIES MANAGEMENT STARTS
         */
        if (isset($sellerId) && isset($categoryIds) && isset($storeLocalityId)) {

            $checkExistvalue = $this->checkDuplicateEntry($categoryIds, $storeLocalityId, "store_category", $sellerId);
            $categoriesidEmail = "";
            if (empty($checkExistvalue)) {
                $categoriesid = rtrim($categoryIds, ",");
                $storeCatalogModel = $this->storecatalogcategoryFactory->create();
                $storeCatalogModel->setSellerId($sellerId);
                $storeCatalogModel->setStoreId($storeLocalityId);
                $categoriesidEmail = $categoriesid;
                $storeCatalogModel->setCategoriesId($categoriesid);
                $storeCatalogModel->setCreatedBy($sellerName);
                $storeCatalogModel->setStatus(self::STATUS_DISABLE);


                $activeCatids = explode(",", $activeCatids);
                $activeCatData = $this->storecatalogHelper->getCategoriesCollection($activeCatids);
                $categoriesid = json_encode($activeCatData);
                $storeCatalogModel->setEnableCategoriesId($categoriesid);

                try {
                    $storeCatalogModel->save();
                } catch (Exception $e) {
                    
                }
            } else {
                $postCategoriesid = rtrim($categoryIds, ",");

                $storeCatalogUpdateModel = $this->storecatalogcategoryFactory->create()->load($checkExistvalue);
                $saveCategoriesid = $storeCatalogUpdateModel['categories_id'];
                $postCategoriesid = explode(",", $postCategoriesid);

                $saveCategoriesid = explode(",", $saveCategoriesid);



                $editCatids = array_intersect($postCategoriesid, $saveCategoriesid);
                $diffCatids = array_diff($postCategoriesid, $saveCategoriesid);


                if (!empty($diffCatids) && isset($diffCatids)) {
                    $diffCatids = implode(",", $diffCatids);
                } else {
                    $diffCatids = "";
                }


                if (!empty($editCatids) && isset($editCatids)) {
                    $editCategoriesid = implode(",", $editCatids);
                } else {
                    $editCategoriesid = "";
                }

                $categoriesidEmail = $diffCatids;


                $storeCatalogUpdateModel->setCategoriesId($editCategoriesid . "," . $diffCatids);

                if (!empty($activeCatids)) {
                    $activeCatids = $activeCatids;
                } else {
                    $activeCatids = "";
                }

                $activeCatids = explode(",", $activeCatids);
                $activeCatData = $this->storecatalogHelper->getCategoriesCollection($activeCatids);

                $activeCatids = json_encode($activeCatData);

                $storeCatalogUpdateModel->setEnableCategoriesId($activeCatids);

                try {

                    $storeCatalogUpdateModel->save();
                } catch (Exception $e) {
                    
                }
            }
        }

        if (isset($sellerId) && isset($produts) && isset($storeLocalityId)) {
            $sellerid = $sellerId;
            $localityId = $storeLocalityId;
            $productsId = $produts;
            $productsid = rtrim($productsId, ",");

            $proIDs = explode(",", $productsid);

            $returnproId = $this->checkDuplicateEntry($proIDs, $localityId);

            $requestId = [];

            $requestedProductArray = $proIDs;

            $sellerStoreProducts = $this->storecatalogHelper->getSellerStoreProduct($localityId, $sellerid);

            $diffIds = "";


            if (count($requestedProductArray) > 0) {

                $diffStoredIds = array_diff($sellerStoreProducts, $requestedProductArray);
            }



            if (count($diffStoredIds) > 0) {

                $diffStoredIds = array_filter($diffStoredIds);
                if (count($diffStoredIds) > 0) {
                    $this->sendEmails($localityId, $sellerid, $diffStoredIds, "Active");
                }

                foreach ($diffStoredIds as $proId) {
                    $returnproId = $this->checkDuplicateEntry($proId, $localityId);
                    $storeCatalogModel = $this->storecatalogFactory->create()->load($returnproId);
                    $storeCatalogModel->setStoreId($localityId);
                    $storeCatalogModel->setStatus(self::STATUS_ENABLE);
                    try {
                        $storeCatalogModel->delete();
                    } catch (Exception $e) {
                        
                    }
                }
            } else {

                if (count($proIDs) > 0) {
                    $productDiff = [];
                    foreach ($proIDs as $proId) {

                        if (!in_array($proId, $sellerStoreProducts)) {
                            $productDiff[] = $proId;
                        }
                    }

                    //  if (count($productDiff) > 0) {
                    foreach ($productDiff as $proId) {
                        $logger->info($proId);
                        $storeCatalogModel = $this->storecatalogFactory->create();
                        $storeCatalogModel->setSellerId($sellerid);
                        $storeCatalogModel->setStoreId($localityId);
                        $storeCatalogModel->setProductId($proId);
                        $storeCatalogModel->setCreatedBy($sellerName);
                        $storeCatalogModel->setStatus(self::STATUS_DISABLE);
                        try {
                            if (!empty($proId)) {
                                $storeCatalogModel->save();
                            }
                        } catch (Exception $e) {
                            
                        }
                    }

                    $productDiff = array_filter($productDiff);

                    if (count($productDiff) > 0) {
                        $this->sendEmails($localityId, $sellerid, $productDiff, "Inactive");
                    }
                }
            }
        }

        $this->messageManager->addSuccess(
                __('Store catalogue has completed !!!')
        );
        return $result->setData(['success' => true, 'store_id' => $storeLocalityId]);
    }

    /**
     * 
     * @param type $productId
     * @param type $storeId
     * @param string $type
     * @param int $sellerId
     */
    public function checkDuplicateEntry($productId, $storeId, $type = null, $sellerId = null) {

        if ($type == "store_category") {

            $storeCatalogCatModelUpdate = $this->storecatalogcategoryFactory->create()->getCollection()
                    ->addFieldToFilter("seller_id", ["eq" => $sellerId])
                    ->addFieldToFilter("store_id", ["eq" => $storeId])
                    ->getFirstItem();
            return $storeCatalogCatModelUpdate->getData('entity_id');
        }

        $storeCatalogModelUpdate = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToFilter("product_id", $productId)
                ->addFieldToFilter("store_id", $storeId)
                ->getFirstItem();
        return $storeCatalogModelUpdate->getData('entity_id');
    }

    /**
     * call emails function which is defind in order status email module model class
     * @param int $storeId
     * @param array $productsArray
     * @param int $sellerId
     * @param string $status
     */
    public function sendEmails($storeId, $sellerid, $productsArray, $status) {
        $this->orderstatusEmail->sendStoreProductStatusAlertEmails($storeId, $sellerid, $productsArray, $status);
    }

}
