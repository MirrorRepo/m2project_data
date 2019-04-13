<?php

/**
 * Copyright © 2015 Bakeway . All rights reserved.
 */

namespace Bakeway\StoreCatalog\Helper;

use Webkul\Marketplace\Model\ProductFactory as ProductFactory;
use Webkul\Marketplace\Model\SellerFactory as SellerFactory;
use Bakeway\StoreCatalog\Model\StorecatalogFactory as StorecatalogFactory;
use Bakeway\StoreCatalog\Model\ResourceModel\Storecatalog\Collection as StorecatalogCollection;
use Bakeway\Partnerlocations\Model\ResourceModel\Partnerlocations\Collection as PartnerlocationsCollection;
use Bakeway\CatalogSync\Model\ResourceModel\CatalogSync\Collection as CatalogSyncCollection;
use Bakeway\CatalogSync\Model\CatalogSync as CatalogSync;
use Bakeway\Partnerlocations\Model\PartnerlocationsFactory as PartnerlocationsFactory;
use Magento\Catalog\Model\ProductRepository as ProductRepositoryInterface;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as EavAttribute;
use Magento\Framework\Exception\NotFoundException;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Bakeway\StoreCatalog\Model\StorecatalogcategoryFactory as StorecatalogcategoryFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    CONST Catalog_Entity_Product_Name_Attribute_Id = 73;
    CONST SELLER_ACTIVE = 1;
    const XML_PATH_EMAIL_STORE_PRODUCT_ENABLE_DISABLE_ALERT_EMAIL = 'vendor_app_settings/bakeway_product_inventory_setting/receiver_email';
    const XML_PATH_EMAIL_STORE_PRODUCT_ENABLE_DISABLE_ALERT_EMAIL_STATUS = 'vendor_app_settings/bakeway_product_inventory_setting/email_status';
    const XML_ORDERS_REPORT_EMAIL_TEMPLATE = 'order/status/order_report_email_list';

    /**
     * @var ProductFactory 
     */
    protected $productFactory;

    /**
     * @var SellerFactory 
     */
    protected $sellerFactory;

    /**
     * @var StorecatalogFactory 
     */
    protected $storecatalogFactory;

    /**
     * @var StorecatalogCollection 
     */
    protected $storecatalogCollection;

    /**
     * @var PartnerlocationsCollection 
     */
    protected $partnerlocations;

    /**
     * @var CatalogSyncCollection 
     */
    protected $catalogSyncCollection;

    /**
     * @var $catalogSync
     */
    protected $catalogSync;

    /*
     * @var PartnerlocationsFactory                   
     */
    protected $partnerlocationsFactory;

    /**
     * @var  \Magento\Framework\ObjectManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ProductRepositoryInterface 
     */
    protected $productRepositoryInterface;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;

    /**
     * @var EavAttribute
     */
    protected $eavAttribute;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepositoryInterface;
    
    /**
     * @var StorecatalogcategoryFactory
     */
    protected $storecatalogcategoryFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param ProductFactory $productFactory
     * @param SellerFactory $sellerFactory
     * @param StorecatalogFactory $storecatalogFactory
     * @param StorecatalogCollection $storecatalogCollection
     * @param PartnerlocationsCollection $partnerlocations
     * @param CatalogSyncCollection $catalogSyncCollection
     * @param CatalogSync $catalogSync
     * @param EavAttribute $eavAttribute
     * @param StorecatalogcategoryFactory $storecatalogcategoryFactory
     */
    public function __construct(
    \Magento\Framework\App\Helper\Context $context, ProductFactory $productFactory, SellerFactory $sellerFactory, StorecatalogFactory $storecatalogFactory, StorecatalogCollection $storecatalogCollection
    , PartnerlocationsCollection $partnerlocations, CatalogSyncCollection $catalogSyncCollection, CatalogSync $catalogSync, PartnerlocationsFactory $partnerlocationsFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, ProductRepositoryInterface $productRepositoryInterface, MarketplaceHelper $marketplaceHelper
    , EavAttribute $eavAttribute, CategoryFactory $categoryFactory, CategoryRepositoryInterface $categoryRepositoryInterface, StorecatalogcategoryFactory $storecatalogcategoryFactory) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->sellerFactory = $sellerFactory;
        $this->storecatalogFactory = $storecatalogFactory;
        $this->storecatalogCollection = $storecatalogCollection;
        $this->partnerlocations = $partnerlocations;
        $this->catalogSyncCollection = $catalogSyncCollection;
        $this->catalogSync = $catalogSync;
        $this->partnerlocationsFactory = $partnerlocationsFactory;
        $this->_storeManager = $storeManager;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->eavAttribute = $eavAttribute;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
        $this->storecatalogcategoryFactory = $storecatalogcategoryFactory;
    }

    /**
     * @return get base url
     */
    public function getBaseUrl() {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    /**
     * seller products
     * @param type $sellerId
     */
    public function getSellerProducts($sellerId) {
        /* $baseUrl = $this->getBaseUrl();
          $request = $baseUrl . "rest/V1/partners/" . $sellerId . "/products?storeName=flatproducts&searchCriteria[pageSize]=1000&searchCriteria[currentPage]=1&searchCriteria[filter_groups][0][filters][0][field]=category_id&searchCriteria[filter_groups][0][filters][0][value]=13&searchCriteria[filter_groups][0][filters][0][condition_type]=eq";
          $ch = curl_init($request);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

          $result = curl_exec($ch);
          $resultDecode = json_decode($result);

          if (isset($resultDecode->products)) {
          $apiProducts = $resultDecode->products;
          $productsData = [];
          foreach ($apiProducts as $products) {
          $productName = $products->name;
          $productId = $products->id;
          $productsData[$productId] = $productName;
          }

          return $productsData;
          } */

        $typeId = ["configurable", "simple"];

        $catalogVisibilityAttId = $this->getAttributeIdFromAttributeCode('visibility');

        $productsCollection = $this->productFactory->create()->getCollection();

        $productsCollection->getSelect()->joinLeft(array("cpe" => "catalog_product_entity")
                , 'main_table.mageproduct_id=cpe.entity_id', array("entity_id"));
        $productsCollection->getSelect()->joinLeft(array("cpev" => "catalog_product_entity_varchar")
                , 'main_table.mageproduct_id =cpev.entity_id', array("value as productname"));
        $productsCollection->getSelect()->joinLeft(array("cpei" => "catalog_product_entity_int")
                , 'main_table.mageproduct_id =cpei.entity_id', array("value"));

        $productsCollection->getSelect()->joinLeft(array("ccp" => "catalog_category_product")
                , 'cpev.entity_id =ccp.product_id', array("category_id"));
        $productsCollection->getSelect()->where("main_table.seller_id =?", $sellerId);
        $productsCollection->getSelect()->where("cpe.type_id in ('configurable', 'simple')");
        //$productsCollection->getSelect()->where("main_table.status =?", "1");
        $productsCollection->getSelect()->where("cpev.attribute_id =?", self::Catalog_Entity_Product_Name_Attribute_Id);
        $productsCollection->getSelect()->where("cpei.value in ('4')");
        $productsCollection->getSelect()->where("cpei.attribute_id =?", $catalogVisibilityAttId);

        $productsCollection->getSelect()->where("cpev.store_id =?", "0");
        $productsCollection->getSelect()->group("main_table.mageproduct_id");
        // $productsCollection->getSelect()->where("ccp.category_id =?",13);
        $prodCount = $productsCollection->count();
        $productsData = [];
        if ($prodCount > 0) {
            $productsData = [];
            foreach ($productsCollection as $products) {
                $productName = $products->getProductname();
                $productId = $products->getId();
                $productsData[$productId] = $productName;
            }
        }

        return $productsData;
    }

    /**
     * return seller data
     * @param type $sellerId
     * @return type
     */
    public function getSellerIdBySellerId($sellerId) {
        $model = $this->sellerFactory->create()
                ->getCollection()
                ->addFieldToFilter(
                        'seller_id', $sellerId
                )->addFieldToSelect("merchant_name")
                ->getFirstItem();
        return $model->getData('merchant_name');
    }

    /**
     * return if storeentry exist on catalog store table
     * @param type $storeId
     */
    public function checkDuplicateStoreData($proId, $localityId) {

        $collection = $this->storecatalogCollection
                ->addFieldToFilter("product_id", $proId)
                ->addFieldToFilter("store_id", $localityId);
        $getCount = count($collection);

        if ($getCount > 0) {
            return true;
        }
        return false;
    }

    /**
     * Seller products array 
     * @param type $storeId
     * @param type $sellerId
     * @param type $proCountFlag
     * @param type $inactiveFlag
     * @param type $allcakesProducts
     * @return boolean
     */
    public function getSellerStoreProduct($storeId, $sellerId, $proCountFlag = null, $inactiveFlag = null, $allcakesProducts = null) {

        $collection = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("status", 0)
                ->addFieldToFilter("store_id", $storeId);


        if (isset($allcakesProducts) && !empty($allcakesProducts)) {
            $collection->addFieldToSelect("entity_id");
            $collection->getSelect()->where("product_id = " . $allcakesProducts);
            return $collection->getFirstItem();
        }


        if ($proCountFlag == true) {
            if (count($collection) > 0) {
                return true;
            }
            return false;
        }


        if ($inactiveFlag === true) {
            if (count($collection) > 0) {
                return $collection->getData();
            }
        }


        $productsId = [];
        if (count($collection) > 0) {

            foreach ($collection as $collectionId) {
                $productsId[] = $collectionId->getProductId();
            }
            return $productsId;
        }


        return [];
    }

    /**
     * @param type $storeName
     * @param type $sellerId
     */
    public function getStoreIdFromStoreName($storeName, $sellerId) {
        $collection = $this->partnerlocations
                ->addFieldToFilter("seller_id", ["eq" => $sellerId])
                ->addFieldToFilter("store_unique_name", ["eq" => $storeName])
                ->getFirstItem();
        return $collection->getData('id');
    }

    /**
     * return sellers all disabled products array
     * @param type $sellerId
     * @return type
     */
    public function getSellerAllStoreProduct($sellerId) {
        $collection = $this->storecatalogCollection
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("status", 0);

        $productsId = [];
        if (count($collection) > 0) {

            foreach ($collection as $collectionId) {
                $productsId[] = $collectionId->getProductId();
            }
            return $productsId;
        }

        return [];
    }

    /**
     * 
     * @param type $sellerId
     * @return type
     */
    public function getSellerDisablesProducts($sellerId) {
        $collection = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToSelect(['product_id'])
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("status", 0);
        $collection->getSelect()->group('product_id');

        return $collection->getData();
    }

    /**
     * 
     * @param type $sellerId
     * @return type
     */
    public function getSellerDisablesProductsForFeed($sellerId, $productId) {
        $collection = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToSelect(['product_id', 'store_id'])
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("product_id", $productId)
                ->addFieldToFilter("status", 0);
        return $collection->getData();
    }

    /**
     * 
     * @param type $sellerId
     * @param type $productId
     * @return type
     */
    public function getStorefromproduct($sellerId, $productId) {

        $collection = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToSelect(['store_id', 'product_id'])
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("product_id", $productId);
        return $collection->getData();
    }

    /**
     * @param type $sellerId
     * @return boolean
     */
    public function getSellerStoresId($sellerId) {
        $collection = $this->partnerlocationsFactory->create()->getCollection()
                ->addFieldToSelect("id")
                ->addFieldToFilter("seller_id", ["eq" => $sellerId])
                ->addFieldToFilter('is_active', self::SELLER_ACTIVE);
        if (count($collection) > 0) {
            $storesId = [];
            foreach ($collection as $collectionId) {
                $storesId[] = $collectionId->getId();
            }
            return $storesId;
        } else {
            return false;
        }
    }

    /**
     * Function to check if product is available for the current seller in the selected store
     * @param type $sellerId
     * @param type $store
     * @param type $_productId
     * @return bool
     */
    public function checkProdAvailibilty($sellerId, $store, $_productId) {
        $partnerLocation = $this->partnerlocationsFactory->create()->getCollection()
                ->addFieldToSelect("id")
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter('store_unique_name', ['eq' => $store]);
        if (count($partnerLocation) > 0) {
            foreach ($partnerLocation as $location) {
                $storeId = $location->getId();
            }
        } else
            return true;

        $collection = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToSelect('entity_id')
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("store_id", $storeId)
                ->addFieldToFilter("product_id", ['in' => $_productId])
                ->getFirstItem();

        if ($collection->getData('entity_id')) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductDetails($id) {
        $productObj = $this->productRepositoryInterface->getById($id);
        return $productObj->getName();
    }

    /**
     * @param type $sellerId
     * @return []
     */
    public function getStandAloneSellerProduct($sellerId) {

        $collection = $this->storecatalogCollection
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("status", 0);

        $productsId = [];

        $sellerType = $this->marketplaceHelper->isConglomerate($sellerId);

        if ($sellerType === true) {
            return [];
        }

        if (count($collection) > 0) {

            foreach ($collection as $collectionId) {
                $productsId[] = $collectionId->getProductId();
            }
            return $productsId;
        }

        return [];
    }

    /**
     * return store count for product which are disbled in store
     * @param type $sellerId
     * @param type $productId
     * @return type
     */
    public function getStoreCountForProduct($sellerId, $productId) {

        $collection = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToSelect(['store_id', 'product_id'])
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("product_id", $productId);
        $count = $collection->count();
        if (!empty($count)) {
            return $count;
        } else {
            return;
        }
    }

    /**
     * return diasble product count if any store have this product
     * @param type $sellerId
     * @param type $productId
     */
    public function checkProductStatus($sellerId, $productId) {

        $collection = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToSelect(['product_id', 'store_id'])
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("product_id", $productId)
                ->addFieldToFilter("status", 0);
        $collection->getSelect()->group('product_id');
        if ($collection->count() > 0) {
            return true;
        }
    }

    /**
     * check stores on Pick up Store case 
     * @param type $sellerId
     * @param type $allStores
     */
    public function getPickupAvaiableStores($sellerId, $allStores, $productId) {

        $storesId = $storesIdDisablePro = [];

        if (count($allStores) > 0) {

            foreach ($allStores as $allStoresData) {
                $storesId[] = $allStoresData['id'];
            }

            $collection = $this->storecatalogFactory->create()->getCollection()
                    ->addFieldToSelect(['entity_id', 'store_id'])
                    ->addFieldToFilter("seller_id", $sellerId)
                    ->addFieldToFilter("product_id", $productId);

            foreach ($collection as $data) {
                $storesIdDisablePro[] = $data['store_id'];
            }

            return $storesIdDisablePro;
        }
    }

    /**
     * 
     * @param type $sellerid
     * @param type $storeId
     * @param type $producutId
     */
    public function checkProdStatusForAllPuneCase($sellerid, $storeId, $producutId) {
        $collection = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToSelect(['entity_id', 'store_id'])
                ->addFieldToFilter("seller_id", $sellerid)
                ->addFieldToFilter("store_id", $storeId)
                ->addFieldToFilter("product_id", $producutId)
                ->getFirstItem();

        if ($collection->getData('entity_id')) {
            return true;
        }
        return;
    }

    /**
     * return attribute id from attribute code
     * @param type $code
     * @return type
     */
    public function getAttributeIdFromAttributeCode($code) {
        $attributeId = $this->eavAttribute->getIdByCode('catalog_product', $code);
        return $attributeId;
    }

    /**
     * check product status in case of all-city names
     * @param type $sellerId
     * @param type $productId
     */
    public function checkAllCityProductCase($sellerId, $productId) {

        $getSellerStores = $this->getSellerStoresId($sellerId);


        if (count($getSellerStores) > 0) {

            $storesCount = count($getSellerStores);
            $collection = $this->storecatalogFactory->create()->getCollection()
                    ->addFieldToSelect(['product_id', 'store_id'])
                    ->addFieldToFilter("seller_id", $sellerId)
                    ->addFieldToFilter("product_id", $productId)
                    ->addFieldToFilter("store_id", ["in" => $getSellerStores])
                    ->addFieldToFilter("status", 0)
                    ->getSize();


            if ((int) $collection === (int) $storesCount) {

                return true;
            }

            return false;
        }
    }

    /**
     * Function to check if product is available for the current seller in the selected store
     * @param type $sellerId
     * @param type $store
     * @param type $_productId
     * @return bool
     */
    public function checkProdAvailibiltyShipping($sellerId, $store, $_productId) {
        $partnerLocation = $this->partnerlocationsFactory->create()->getCollection()
                ->addFieldToSelect("id")
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter('store_unique_name', ['eq' => $store])
                ->getFirstItem();

        if (empty($partnerLocation->getId())) {
            throw new NotFoundException(__("store Unique name is undefined"));
        }


        if (!empty($partnerLocation->getId())) {
            $storeId = $partnerLocation->getId();
        }

        $collection = $this->storecatalogFactory->create()->getCollection()
                ->addFieldToSelect('entity_id')
                ->addFieldToFilter("seller_id", $sellerId)
                ->addFieldToFilter("store_id", $storeId)
                ->addFieldToFilter("product_id", ['in' => $_productId]);

        if ($collection->getData('entity_id')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return Store Products Array
     * @return mixed
     */
    public function getStoreProductsStatusReceiverEmails() {
        return $this->scopeConfig->getValue(
                        self::XML_PATH_EMAIL_STORE_PRODUCT_ENABLE_DISABLE_ALERT_EMAIL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return Store Product enable or disable status
     * @return mixed
     */
    public function getStoreProductsStatus() {
        return $this->scopeConfig->getValue(
                        self::XML_PATH_EMAIL_STORE_PRODUCT_ENABLE_DISABLE_ALERT_EMAIL_STATUS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return category array
     */
    public function getCategoriesCollection($oldCatids) {
        
        $collection = $this->categoryFactory->create();
    
        if(!empty($oldCatids)){

            $collection->addFieldToFilter("entity_id",["in"=>[$oldCatids]]);
        }
        $collection->addAttributeToSelect('*');
        $collection->addFieldToFilter('level',["in"=>[0,1,2]]);
        $size = $collection->getSize();
        $catArray = [];
        if ($size > 0) {

            foreach ($collection as $catCollection) {
                $cateDetails = $this->categoryRepositoryInterface->get($catCollection->getId());
                if ($cateDetails->getName() != "Root Catalog" && $cateDetails->getName() != "Default") {
                    $catArray[] = ["id" => $catCollection->getId(), "level" => $catCollection->getLevel(), "name" => $cateDetails->getName()];
                }
            }
            
            return $catArray;
        }
        return;
    }
    
    /**
     * return store categories id
     * @param type $storeId
     * @param type $sellerId
     */
    public function getSellerStoreCategories($storeId, $sellerId) {
        $collection = $this->storecatalogcategoryFactory->create()->getCollection()
                ->addFieldToFilter("seller_id",$sellerId)
                ->addFieldToFilter("store_id",$storeId)
                ->getFirstItem();
        
        
        if(count($collection) > 0){
            
            return $collection['categories_id'];
            
        }
           
        return;
        
    }
    

    
    /**
     * return store categories id
     * @param type $storeId
     * @param type $sellerId
     */
    public function getSellerStoreActiveCategories($storeId, $sellerId) {
        $collection = $this->storecatalogcategoryFactory->create()->getCollection()
                ->addFieldToFilter("seller_id",$sellerId)
                ->addFieldToFilter("store_id",$storeId)
                ->getFirstItem();
        
        if(count($collection) > 0){
         
            return json_decode($collection['enable_categories_id'], true);
            
        }
           
        return;
        
    }
    
    
     /**
     * Return Store Products Array
     * @return mixed
     */
    public function getProductsReportStatusReceiverEmails() {
        return $this->scopeConfig->getValue(
                        self::XML_ORDERS_REPORT_EMAIL_TEMPLATE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    

    
    
}
