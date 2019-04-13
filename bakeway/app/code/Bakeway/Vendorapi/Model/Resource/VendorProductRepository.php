<?php

/**
 * Bakeway
 *
 * @category  Bakeway
 * @package   Bakeway_Vendorapi
 * @author    Bakeway
 */

namespace Bakeway\Vendorapi\Model\Resource;

use Bakeway\Vendorapi\Api\VendorProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Webkul\Marketplace\Model\Product as VendorProduct;
use Magento\Framework\App\ResourceConnectionFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Catalog\Helper\ImageFactory as ProductImageHelper;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Store\Model\App\Emulation as AppEmulation;
use Magento\Catalog\Model\Product\Visibility as CatalogVisibility;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;
use Bakeway\HomeDeliveryshipping\Helper\Data as HomeDeliveryHelper;
use \Bakeway\CatalogSync\Model\ResourceModel\CatalogSync\Collection as CatalogSyncCollection;
use \Bakeway\CatalogSync\Helper\Data as CatalogSyncHelper;
use \Bakeway\ReviewRating\Helper\Data as ReviewRatingHleper;
use Bakeway\StoreCatalog\Helper\Data as StorecatalogHelper;
use Bakeway\StoreCatalog\Model\ResourceModel\Storecatalog\Collection as StorecatalogCollection;

/**
 * Class VendorProductRepository
 * @package Bakeway\Vendorapi\Model
 */
class VendorProductRepository implements VendorProductRepositoryInterface {

    const PROD_FILTER_ATTR = ['cake_weight', 'cake_flavour', 'cake_ingredients'];
    const ALL_CITY_NAME_FOR_FILTER = ["all-pune", "all-bangalore", "all-hyderabad"];
    const SORT_BY_PRICE_CAT = array('3');

    /**
     * @var ResourceConnectionFactory
     */
    protected $_resourceConnection;

    /**
     * @var ProductCollectionFactory
     */
    protected $_productCollection;

    /**
     * @var VendorProduct
     */
    protected $_vendorProduct;

    /**
     * @var \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Catalog\Api\ProductAttributeRepositoryInterface
     */
    protected $metadataService;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var \Magento\Catalog\Helper\ImageFactory
     */
    protected $productImageHelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Store\Model\App\Emulation
     */
    protected $appEmulation;

    /**
     * @var CatalogVisibility
     */
    protected $catalogVisibility;

    /**
     * @var \Bakeway\ProductApi\Helper\Data
     */
    protected $productapihelper;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var HomeDeliveryHelper
     */
    protected $homeDeliveryHelper;

    /**
     * @var
     */
    protected $priceFilter;

    /**
     * @var
     */
    protected $priceFilterValue;

    /**
     * @var
     */
    protected $offerFilter;

    /**
     * @var
     */
    protected $offerFilterValue;

    /**
     * @var
     */
    protected $prodFilterArr = [];

    /**
     * @var CatalogSyncCollection
     */
    protected $catalogSyncCollection;

    /**
     * @var CatalogSyncHelper
     */
    protected $catalogSyncHelper;

    /**
     * @var ReviewRatingHleper
     */
    protected $reviewRatingHleper;

    /**
     * @var StorecatalogHelper 
     */
    protected $storecatalogHelper;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StorecatalogCollection 
     */
    protected $storecatalogCollection;

    /**
     * VendorProductRepository constructor.
     * @param ResourceConnectionFactory $_resourceConnection
     * @param ProductCollectionFactory $_productCollection
     * @param VendorProduct $_vendorProduct
     * @param \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ProductImageHelper $productImageHelper
     * @param StoreManager $storeManager
     * @param AppEmulation $appEmulation
     * @param CatalogVisibility $catalogVisibility
     * @param \Bakeway\ProductApi\Helper\Data $productapiHelper
     * @param MarketplaceHelper $marketplaceHelper
     * @param ObjectManagerInterface $objectManager
     * @param HomeDeliveryHelper $homeDeliveryHelper
     * @param CatalogSyncCollection $catalogSyncCollection
     * @param CatalogSyncHelper $catalogSyncHelper
     * @param ReviewRatingHleper $reviewRatingHleper
     * @param StorecatalogHelper $storecatalogHelper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param StorecatalogCollection $storecatalogCollection
     */
    public function __construct(
    ResourceConnectionFactory $_resourceConnection, ProductCollectionFactory $_productCollection, VendorProduct $_vendorProduct, \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface, \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor, ProductImageHelper $productImageHelper, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Store\Model\App\Emulation $appEmulation, CatalogVisibility $catalogVisibility, \Bakeway\ProductApi\Helper\Data $productapiHelper, MarketplaceHelper $marketplaceHelper, ObjectManagerInterface $objectManager, HomeDeliveryHelper $homeDeliveryHelper, CatalogSyncCollection $catalogSyncCollection, CatalogSyncHelper $catalogSyncHelper, ReviewRatingHleper $reviewRatingHleper, StorecatalogHelper $storecatalogHelper, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, StorecatalogCollection $storecatalogCollection
    ) {
        $this->_resourceConnection = $_resourceConnection;
        $this->_productCollection = $_productCollection;
        $this->_vendorProduct = $_vendorProduct;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->metadataService = $metadataServiceInterface;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->productImageHelper = $productImageHelper;
        $this->storeManager = $storeManager;
        $this->appEmulation = $appEmulation;
        $this->catalogVisibility = $catalogVisibility;
        $this->productapihelper = $productapiHelper;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->objectManager = $objectManager;
        $this->homeDeliveryHelper = $homeDeliveryHelper;
        $this->catalogSyncCollection = $catalogSyncCollection;
        $this->catalogSyncHelper = $catalogSyncHelper;
        $this->reviewRatingHleper = $reviewRatingHleper;
        $this->storecatalogHelper = $storecatalogHelper;
        $this->scopeConfig = $scopeConfig;
        $this->storecatalogCollection = $storecatalogCollection;
    }

    /**
     * Helper function that provides full cache image url
     * @param \Magento\Catalog\Model\Product
     * @return string
     */
    protected function getImageUrl($product, string $imageType = '') {
        if ($imageType == 'product_page_image_large') {
            $imageUrl = $this->productImageHelper->create()->init($product, $imageType)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(225, 225)->getUrl();
        } else {
            $imageUrl = $imageUrl = $this->productImageHelper->create()->init($product, $imageType)->getUrl();
        }
        //$this->appEmulation->stopEnvironmentEmulation();
        return $imageUrl;
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param \Magento\Framework\Api\Search\FilterGroup $filterGroup
     * @param Collection $collection
     * @return void
     */
    protected function addFilterGroupToCollection(
    \Magento\Framework\Api\Search\FilterGroup $filterGroup, Collection $collection
    ) {
        $fields = [];
        $categoryFilter = [];
        $prodAttrFields = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $conditionType = $filter->getConditionType() ? $filter->getConditionType() : 'eq';

            if ($filter->getField() == 'category_id') {
                $catsId = explode(",", $filter->getValue());
                $categoryFilter[$conditionType][] = $catsId;
                continue;
            }

            if ($filter->getField() == 'advance_order_intimation') {
                $fields[] = ['attribute' => $filter->getField(), $conditionType => (int) $filter->getValue()];
                continue;
            }

            if ($filter->getField() == 'price') {
                $this->priceFilter = true;
                $this->priceFilterValue = $filter->getValue();
                continue;
            }

            if ($filter->getField() == 'offer') {
                $this->offerFilter = true;
                $this->offerFilterValue = $filter->getValue();
                continue;
            }

            if (in_array($filter->getField(), self::PROD_FILTER_ATTR)) {
                $prodAttrFields[] = ['attribute' => $filter->getField(), $conditionType => $filter->getValue()];
                continue;
            }

            $fields[] = ['attribute' => $filter->getField(), $conditionType => $filter->getValue()];
        }

        if ($prodAttrFields) {
            $this->prodFilterArr[] = $prodAttrFields;
        }

        if ($categoryFilter) {
            $collection->addCategoriesFilter($categoryFilter);
        }

        if ($fields) {
            $collection->addFieldToFilter($fields);
        }
    }

    /**
     * @param int $vendorId
     * @param string $storeName
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return object|array
     * @throws \Magento\Framework\Exception\NotFoundException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProducts($vendorId, $storeName = null, \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null) {
        $isLiveReady = $this->marketplaceHelper->getIsLiveReady($vendorId);

        if ($isLiveReady === false) {
            throw new LocalizedException(__('Bakery is not live ready'));
        }

        $disabledProductId = [];


        if (isset($storeName) && !empty($storeName)) {
            $sellerStoreId = $this->storecatalogHelper->getStoreIdFromStoreName($storeName, $vendorId);

            /**
             * handling all-city(name) case
             * start
             */
            /*  if (!in_array($storeName, self::ALL_CITY_NAME_FOR_FILTER)) {
              throw new LocalizedException(__("Requested Store City Name is wrong"));
              }
             */

            $disabledProdId = [];
            if (in_array($storeName, self::ALL_CITY_NAME_FOR_FILTER)) {

                $alldisableProIds = $this->storecatalogHelper->getSellerDisablesProducts($vendorId);

                foreach ($alldisableProIds as $productId) {
                    $disabledProductId[] = $productId['product_id'];
                }
            }
        }
        

        $storeCollection = $this->_vendorProduct->getCollection()
                // ->addFieldToFilter('seller_id', $vendorId)
                // ->addFieldToFilter('status', 1)
                ->addFieldToSelect(['mageproduct_id']);
        $storeCollection->getSelect()->group('mageproduct_id');

        /**
         * custom code for store wise products
         * start
         */
        $storeCollection->getSelect()->where("main_table.seller_id=?", $vendorId);
        $storeCollection->getSelect()->where("main_table.status=?", 1);

        $storeProductIDs = $storeCollection->getAllIds();

        $storeDisableProIds = [];
        if (isset($storeName) && !empty($storeName)) {
            if (in_array($storeName, self::ALL_CITY_NAME_FOR_FILTER)) {
                $storeDisableProIds = $disabledProductId;
            } else {
                if($storeName = "flatproducts"){
                  $storeDisableProIds = "";  
                }
                $storeDisableProIds = $this->storecatalogHelper->getSellerStoreProduct($sellerStoreId, $vendorId);
            }
        }else{
            
                $storeDisableProIds = $this->storecatalogHelper->getStandAloneSellerProduct($vendorId);
        }
        
        $storeProductIDColl = [];

        /**
         * end
         * custom code for store wise products
         */
        foreach ($storeProductIDs as $storeProductID) {

            if (!in_array($storeProductID, $storeDisableProIds)) {
                $storeProductIDColl[] = $storeProductID;
            }
        }

        $collection = $this->_productCollection->create()
                ->addFieldToFilter('entity_id', ['in' => $storeProductIDColl])
                ->addAttributeToSelect('*');

        $collection->setVisibility($this->catalogVisibility->getVisibleInSiteIds());

        /**
         * Setting sort order according to BKWYADMIN-155
         */
        //$collection->addAttributeToSort('likely_available', 'DESC');
        //$collection->addAttributeToSort('listing_position', 'ASC');
        //$collection->addAttributeToSort('updated_at', 'DESC');

        /**
         * BKWYADMIN-1223
         * Sort Products by AOIT instead of Price
         */
        $products_sorting = $this->scopeConfig->getValue('products_sorting/settings/option',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if($products_sorting && $products_sorting == 2)
        {
            $categoryId = 0;
            if ($searchCriteria !== null) 
            {
                foreach ($searchCriteria->getFilterGroups() as $group)
                {
                    foreach ($group->getFilters() as $filter) 
                    {
                        if($filter->getField() == "category_id" && !is_null($filter->getValue()))
                        {
                            $categoryId = $filter->getValue();
                            break;
                        }
                    }

                }
            }

            if($categoryId && !in_array($categoryId,self::SORT_BY_PRICE_CAT))
            {
                /**
                 * BKWYADMIN-1223
                 * Sort Products by AOIT instead of Price
                 * Changed AOIT column from varchar to decimal in datasbe as sort was not working, sorting by catalog_sync table instead of attribute from default db
                 */

                //$collection->addAttributeToSort('advance_order_intimation', 'ASC');
                $collection->getSelect()->joinLeft(['cat_sync' => $collection->getTable('bakeway_catalog_sync')], 'e.entity_id=cat_sync.product_id', ['advance_order_intimation']
                );
                $collection->getSelect()->order("cat_sync.advance_order_intimation", "ASC");     
            }
            else
            {
                $collection->addAttributeToSort('price', 'ASC');
            }            
        }
        elseif($products_sorting && $products_sorting == 1)
        {
            $collection->addAttributeToSort('price', 'ASC');
        }
        else
        {
            $collection->addAttributeToSort('price', 'ASC');
        }

        $collection->getSelect()->order("e.entity_id", "ASC");
        $this->extensionAttributesJoinProcessor->process($collection);

        foreach ($this->metadataService->getList($this->searchCriteriaBuilder->create())->getItems() as $metadata) {
            $collection->addAttributeToSelect($metadata->getAttributeCode());
        }
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');

        if ($searchCriteria !== null) {
            //Add filters from root filter group to the collection
            foreach ($searchCriteria->getFilterGroups() as $group)
            {
                $this->addFilterGroupToCollection($group, $collection);
            }
            /** @var SortOrder $sortOrder */

            foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                        $field, ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
            $collection->setCurPage($searchCriteria->getCurrentPage());
            $collection->setPageSize($searchCriteria->getPageSize());

            /**
             * adding custom price filter
             */
            if ($this->priceFilter === true && $this->priceFilterValue != '') {
                $collection->getSelect()->joinLeft(
                        ['price_index' => $collection->getTable('catalog_product_index_price')], 'e.entity_id=price_index.entity_id', ['min_price', 'max_price']
                );
                $priceArr = explode("-", $this->priceFilterValue);
                if (isset($priceArr[0]) && isset($priceArr[1])) {
                    $collection->getSelect()->where('price_index.min_price >= ' . $priceArr[0]);
                    $collection->getSelect()->where('price_index.max_price <= ' . $priceArr[1]);
                    $collection->getSelect()->group('e.entity_id');
                }
            }

            /**
             * adding custom offer filter
             */
            if ($this->offerFilter === true && $this->offerFilterValue == 1) {
                $collection->getSelect()->joinLeft(
                        ['bkw_cat_sync' => $collection->getTable('bakeway_catalog_sync')], 'e.entity_id=bkw_cat_sync.product_id', ['catalog_discount_price_incl_tax', 'catalog_rule_name']
                );

                $collection->getSelect()->where('bkw_cat_sync.catalog_discount_price_incl_tax >= 0');
                $collection->getSelect()->where('bkw_cat_sync.catalog_rule_name IS NOT NULL');
                $collection->getSelect()->group('e.entity_id');
            }


            /**
             * Adding the prod attribute filter
             */
            if (isset($this->prodFilterArr) && is_array($this->prodFilterArr) && !empty($this->prodFilterArr)) {
                $filteredProdColl = $this->_productCollection->create();
                foreach ($this->prodFilterArr as $filter) {
                    $filteredProdColl->addFieldToFilter($filter);
                }

                $filteredProdColl->getSelect()->joinLeft(['link_table' => 'catalog_product_super_link'], 'link_table.product_id = e.entity_id', ['product_id', 'parent_id']
                );
                $filteredProdColl->getSelect()->where('link_table.parent_id IS NOT NULL');

                $filteredProdColl->getSelect()->group('link_table.parent_id');
                $sqlQuery = $filteredProdColl->getSelect();
                $connection = $this->_resourceConnection->create()->getConnection();
                $prods = $connection->fetchAll($sqlQuery);
                $simpleProds = [];
                $confProds = [];
                if (is_array($prods) && !empty($prods)) {
                    $simpleProds = array_column($prods, 'product_id');
                    $simpleProds = array_unique($simpleProds);
                    $confProds = array_column($prods, 'parent_id');
                    $confProds = array_unique($confProds);
                }
                $simpleProds = array_intersect($simpleProds, $storeProductIDs);
                $confProds = array_intersect($confProds, $storeProductIDs);
                $prodIds = array_merge($simpleProds, $confProds);
                $collection->addFieldToFilter('entity_id', ['in' => $prodIds]);
            }
        }

        $collection->load();
        $collection = $this->addBakewayUrlRewrite($collection);

        $filteredProdIds = $collection->getColumnValues('entity_id');

        /* Refining the result */
        $products = array();
        $result = array();
        $i = 0;
        $vendorDetails = $this->homeDeliveryHelper->getSellerDetails($vendorId);
        $cityId = $vendorDetails->getData('store_city');

        $catalogSyncCollection = $this->catalogSyncCollection
                ->addFieldToFilter('seller_id', ['eq' => $vendorId])
                ->addFieldToFilter('product_id', ['in' => $filteredProdIds]);
        $syncedCatalog = [];
        foreach ($catalogSyncCollection as $catalogSync) {
            $productId = $catalogSync->getData('product_id');
            $syncedCatalog[$productId] = $catalogSync;
        }

        $storeId = $this->storeManager->getStore()->getId();
        $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
        $productsId = [];
        
        foreach ($collection as $product) {
            $productsId[] = $product->getEntityId();
            $products[$i]['name'] = $product->getName();
            $products[$i]['id'] = $product->getEntityId();
            $products[$i]['type_id'] = $product->getTypeId();
            $products[$i]['sku'] = $product->getSku();
            $products[$i]['price'] = $product->getPrice();
            $flavourLabel = $this->getAttributeLabel($product, 'cake_flavour');
            $ingredientLabel = $this->getAttributeLabel($product, 'cake_ingredients');
            $weightLabel = $this->getAttributeLabel($product, 'cake_weight');
            if (isset($syncedCatalog[$product->getEntityId()]) &&
                    $syncedCatalog[$product->getEntityId()] != null
            ) {
                $syncedProduct = $syncedCatalog[$product->getEntityId()];
                $prodAttr = $this->catalogSyncHelper->getCatalogAttributes($syncedProduct, $product, $cityId);
            } else {
                $prodAttr = $this->catalogSyncHelper->getCatalogAttributes(null, $product, $cityId);
            }

            $catJson = $prodAttr['category_json'];
            $categoryJson = "";
            if (!empty($catJson)) {
                $categoryJson = $catJson;
            } else {
                $categoryJson = 'null';
            }
            $rulePrice = $prodAttr['rule_price'];
            $ruleTaxPrice = $prodAttr['rule_tax_price'];
            $discountRule = $prodAttr['discount_rule'];
            $discountStartOn = $prodAttr['discount_rule_start_date'];
            $discountEndsOn = $prodAttr['discount_rule_end_date'];
            $flavour = $prodAttr['flavour'];
            $weight = $prodAttr['weight'];
            $ingredient = $prodAttr['ingredient'];
            
            /**
             * BKWYADMIN-1223
             * Sort Products by AOIT instead of Price
             * Changed AOIT column from varchar to decimal in datasbe as sort was not working, changing response to integer for frontend
             */
            if(is_numeric($prodAttr['intimation_time']))
            {
                $whole = floor($prodAttr['intimation_time']);
                $fraction = $prodAttr['intimation_time'] - $whole;
                if($fraction == 0)
                    $intimationTime = (int)$prodAttr['intimation_time'];
                else
                    $intimationTime = (float)$prodAttr['intimation_time'];
            }
            else
                $intimationTime = $prodAttr['intimation_time'];

            $specialPrice = $prodAttr['special_price'];
            $priceInclTax = $prodAttr['price_incl_tax'];
            $priceExclTax = $prodAttr['price_excl_tax'];
            $advancedOrderIntimationunit = $prodAttr['advanced_order_intimation_unit'];

            /**
             * BKWYADMIN-1024
             */
            $productPickUpValue = "null";

            if (!empty($prodAttr['pick_up_status'])) {
                $productPickUpValue = $prodAttr['pick_up_status'];
            }

            $prodTypeId = $product->getTypeId();
            $ExtensionAttObject = $product->getExtensionAttributes();
            $products[$i]['extension_attributes'] = [
                "product_attributes" => [
                    ["attr_code" => "cake_flavour", "label" => $flavourLabel, "values" => [$flavour]],
                    ["attr_code" => "cake_ingredients", "label" => $ingredientLabel, "values" => [$ingredient]],
                    ["attr_code" => "cake_weight", "label" => $weightLabel, "values" => [$weight]],
                ],
                "special_price" => number_format($specialPrice, 2),
                "price_excl_tax" => number_format($priceExclTax, 2),
                "price_incl_tax" => number_format($priceInclTax, 2),
                "catalog_discount_price" => $rulePrice,
                "catalog_discount_price_incl_tax" => $ruleTaxPrice,
                "discount_rule" => $discountRule,
                "discount_rule_start_date" => $discountStartOn,
                "discount_rule_end_date" => $discountEndsOn,
                "description" => $product->getDescription(),
                "short_description" => $product->getShortDescription(),
                "seo_url" => $this->getProductSeoUrl($product->getData('request_path'), $product->getId()),
                "categories" => [$categoryJson],
                'media' => [
                    'small' => $this->getImageUrl($product, 'product_small_image'),
                    'large' => $this->getImageUrl($product, 'product_page_image_large'),
                //'thumb' => $this->getImageUrl($product, 'product_thumbnail_image'),
                ],
                "advance_order_intimation" => $intimationTime,
                "advanced_order_intimation_unit" => $advancedOrderIntimationunit,
                "pickup_status" => $productPickUpValue,
                "product_ratings" => $this->catalogSyncHelper->getProductRatings($product->getEntityId())
            ];

            /**
             * return rating and review
             *
             */
            /*
             * BKWYADMIN-1186 Commented previous code as it was calling to get fetch reviews & was unnecessary increasing load & added product_ratings above
            $productRating = $this->reviewRatingHleper->getSellerProductRating($product->getEntityId(), $vendorId);
            $products[$i]['average_ratings'] = $productRating;*/
            $i++;
        }


        $this->appEmulation->stopEnvironmentEmulation();
        $result['products'] = $products;
        $result['current_page'] = $collection->getCurPage();
        $result['total_count'] = $collection->getSize();

        return json_decode(json_encode($result, false));
    }

    /*
     * return attribute label name from attribute code
     */

    public function getAttributeLabel($product, $code) {
        $_AttData = $product->getResource()->getAttribute($code)->getStoreLabel();
        return $_AttData;
    }

    public function getProductSeoUrl($url, $productId) {
        if ($url !== null) {
            $sellerCity = $this->productapihelper->getSellerCity($productId);
            if ($sellerCity !== null) {
                $cityString = preg_replace('#[^0-9a-z]+#i', '-', strtolower($sellerCity));

                $pos = strpos($url, $cityString . "-");
                if ($pos !== false) {
                    $url = substr_replace($url, $cityString . "/", $pos, strlen($cityString . "-"));
                } else {
                    $url = str_replace($cityString . "-", $cityString . "/", $url);
                }
            }
        }
        return $url;
    }

    protected function addBakewayUrlRewrite($collection) {
        $productIds = [];
        foreach ($collection as $item) {
            $productIds[] = $item->getEntityId();
        }
        if (!$productIds) {
            return $collection;
        }

        $urlCollectionData = $this->objectManager
                ->create('Magento\UrlRewrite\Model\UrlRewrite')
                ->getCollection()
                ->addFieldToFilter('entity_type', 'bakeway-product')
                ->addFieldToFilter('entity_id', ['in' => $productIds]);

        // more priority is data with category id
        $urlRewrites = [];

        foreach ($urlCollectionData as $row) {
            if (!isset($urlRewrites[$row['entity_id']])) {
                $urlRewrites[$row['entity_id']] = $row['request_path'];
            }
        }

        foreach ($collection as $item) {
            if (isset($urlRewrites[$item->getEntityId()])) {
                $item->setData('request_path', $urlRewrites[$item->getEntityId()]);
            } else {
                $item->setData('request_path', false);
            }
        }

        return $collection;
    }

}
