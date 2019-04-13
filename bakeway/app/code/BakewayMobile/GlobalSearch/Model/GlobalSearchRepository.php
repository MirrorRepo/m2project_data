<?php

namespace BakewayMobile\GlobalSearch\Model;

use BakewayMobile\GlobalSearch\Api\GlobalSearchRepositoryInterface;
use BakewayMobile\GlobalSearch\Helper\Globalsearch as GlobalSearchHelper;
use BakewayMobile\GlobalSearch\Model\GlobalsearchFactory as GlobalsearchFactory;
use \Magento\Framework\Exception\NotFoundException;
use Bakeway\ProductApi\Api\CategoryProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Webkul\Marketplace\Model\Product as VendorProduct;
use Magento\Framework\App\ResourceConnectionFactory;
use Magento\Catalog\Helper\ImageFactory as ProductImageHelper;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Store\Model\App\Emulation as AppEmulation;
use Magento\Catalog\Model\Product\Visibility as CatalogVisibility;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;
use Bakeway\HomeDeliveryshipping\Helper\Data as HomeDeliveryHelper;
use Bakeway\Cities\Helper\Data as BakewayCityHelper;
use \Bakeway\Partnerlocations\Model\ResourceModel\Partnerlocations\CollectionFactory as LocationCollection;
use Bakeway\ProductApi\Helper\Filter as ProductFilterHelper;
use \Bakeway\CatalogSync\Model\ResourceModel\CatalogSync\Collection as CatalogSyncCollection;
use \Bakeway\CatalogSync\Helper\Data as CatalogSyncHelper;
use Bakeway\StoreCatalog\Helper\Data as StorecatalogHelper;
use Bakeway\StoreCatalog\Model\StorecatalogFactory as StorecatalogFactory;
use Bakeway\ProductApi\Model\CategoryProductRepository;
use \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use \Webkul\Marketplace\Model\ResourceModel\Seller\Collection as SellerCollection;
use \Bakeway\ProductApi\Helper\Filter as ProductApiFilterHelper;

class GlobalSearchRepository implements GlobalSearchRepositoryInterface {

    CONST RETURN_PRODUCTS_COUNT = 10;
    CONST CATALOG_PRODUCTS_STATUS = 1;

    /**
     * @param GlobalSearchHelper
     */
    protected $globalSearchHelper;

    /*
     * @param GlobalsearchFactory;
     */
    protected $globalsearchFactory;

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
     */ /**
     * @var CategoryCollectionFactory
     */
    protected $categoryCollectionFactory;
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
     * @var BakewayCityHelper
     */
    protected $bakewayCityHelper;

    /**
     * @var LocationCollection
     */
    protected $locationsCollection;

    /**
     * ProductFilterHelper
     */
    protected $productFilterHelper;

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
     * @var int value for pickup enable filter
     */
    protected $pickupValue = 0;

    /**
     * @var int value for delivery enable filter
     */
    protected $deliveryValue = 0;

    /**
     * @var type StorecatalogFactory
     */
    protected $storecatalogFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * CategoryProductRepository
     */
    protected $categoryProductRepository;

    /**
     * @var SellerCollection
     */
    protected $sellerCollection;

    /**
     * @var ProductApiFilterHelper
     */
    protected $productApiFilterHelper;

    /**
     * VendorInformationRepository constructor.
     * @param SellerHelper $sellerHelper
     * @param ResourceConnectionFactory $_resourceConnection
     * @param ProductCollectionFactory $_productCollection
     * @param VendorProduct $_vendorProduct
     * @param \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param \Magento\Catalog\Helper\ImageFactory
     * @param \Magento\Store\Model\StoreManagerInterface
     * @param \Magento\Store\Model\App\Emulation
     * @param \Bakeway\ProductApi\Helper\Data
     * @param CatalogVisibility $catalogVisibility
     * @param MarketplaceHelper $marketplaceHelper
     * @param ObjectManagerInterface $objectManager
     * @param HomeDeliveryHelper $homeDeliveryHelper
     * @param BakewayCityHelper $bakewayCityHelper
     * @param LocationCollection $locationsCollection
     * @param CatalogSyncCollection $catalogSyncCollection
     * @param CatalogSyncHelper $catalogSyncHelper
     * @param StorecatalogHelper $storecatalogHelper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param StorecatalogFactory $storecatalogFactory
     * @param CategoryProductRepository $categoryProductRepository
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param SellerCollection $sellerCollection
     * @param ProductApiFilterHelper $productApiFilterHelper
     */
    public function __construct(
    GlobalSearchHelper $globalSearchHelper, GlobalsearchFactory $globalsearchFactory, ResourceConnectionFactory $_resourceConnection, ProductCollectionFactory $_productCollection, VendorProduct $_vendorProduct, \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface, \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor, ProductImageHelper $productImageHelper, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Store\Model\App\Emulation $appEmulation, CatalogVisibility $catalogVisibility, \Bakeway\ProductApi\Helper\Data $productapiHelper, MarketplaceHelper $marketplaceHelper, ObjectManagerInterface $objectManager, HomeDeliveryHelper $homeDeliveryHelper, BakewayCityHelper $bakewayCityHelper, LocationCollection $locationsCollection, CatalogSyncCollection $catalogSyncCollection, CatalogSyncHelper $catalogSyncHelper, StorecatalogHelper $storecatalogHelper, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, StorecatalogFactory $storecatalogFactory, CategoryProductRepository $categoryProductRepository
    , CategoryCollectionFactory $categoryCollectionFactory, SellerCollection $sellerCollection, ProductApiFilterHelper $productApiFilterHelper) {
        $this->globalsearchFactory = $globalsearchFactory;
        $this->globalSearchHelper = $globalSearchHelper;
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
        $this->bakewayCityHelper = $bakewayCityHelper;
        $this->locationsCollection = $locationsCollection;
        $this->catalogSyncCollection = $catalogSyncCollection;
        $this->catalogSyncHelper = $catalogSyncHelper;
        $this->storecatalogHelper = $storecatalogHelper;
        $this->scopeConfig = $scopeConfig;
        $this->storecatalogFactory = $storecatalogFactory;
        $this->categoryProductRepository = $categoryProductRepository;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->sellerCollection = $sellerCollection;
        $this->productApiFilterHelper = $productApiFilterHelper;
    }

    /**
     * Get search result of tag specfic for product
     * @api
     * @param string|null $city
     * @param string|null $lat
     * @param string|null $long
     * @param string $query
     * @return array
     * @throws NotFoundException
     */
    public function getSearchResult($city = null, $lat = null, $long = null, $query) {

        $cdnMediaPath = $proSearchLimit = "";
        $productSearch = $this->globalSearchHelper->getProductSearchStatus();
        $categorySearch = $this->globalSearchHelper->getCatsSearchStatus();
        $bakerySearch = $this->globalSearchHelper->getBakeriesSearchStatus();
        $flavoursSearch = $this->globalSearchHelper->getFlavoursSearchStatus();
        $proSearchLimit = $this->globalSearchHelper->getReturnProductLimit();


        $sellerIds = $businessName = $products = $responseArray = $searchProductId = $sellerVal = [];
        if (empty($query)) {
            throw new NotFoundException(__('search terms is not defined'));
        }

        if ($city === null) {
            throw new LocalizedException(__('Please select the city to see product list'));
        }

        if ($lat === null || $long === null) {
            throw new LocalizedException(__('Lat and Long is missing'));
        }




        $cityId = $this->bakewayCityHelper->getCityIdByName($city);

        $storeLocationCollection = $this->locationsCollection->create();
        $storeLocationCollection->addFieldToSelect(['seller_id', 'store_unique_name', 'store_locality_area']);

        if ($cityId !== false) {
            $storeLocationCollection->addFieldToFilter('main_table.city_id', $cityId);
        } else {
            $storeLocationCollection->addFieldToFilter('main_table.city_id', 0);
        }
        $storeLocationCollection->addFieldToFilter('main_table.is_active', 1);

        $storeLocationCollection->getSelect()->joinLeft(
                ['sub_loc' => $storeLocationCollection->getTable('bakeway_sub_locations')], 'main_table.sub_loc_id=sub_loc.id', ['area_name']
        );

        if ($lat != '' && $long != '') {
            $storeLocationCollection->getSelect()->columns(
                    [
                        'distance' => new \Zend_Db_Expr("ST_Distance_Sphere(POINT(" . $long . ", " . $lat . "), sub_loc_geo_point)/1000")
            ]);
            $storeLocationCollection->setOrder('distance', 'ASC');
            $storeLocationCollection->getSelect()->having('distance<=?', \Bakeway\ProductApi\Model\CategoryProductRepository::SEARCH_RADIUS);
        }
        $storeLocationCollection->getSelect()->joinLeft(
                ['mp_udata' => $storeLocationCollection->getTable('marketplace_userdata')], 'main_table.seller_id=mp_udata.seller_id', ['is_conglomerate', 'shop_title', 'business_name', 'userdata_brand']
        );

        $storeLocationCollection->getSelect()->columns(
                [
                    'unique_col_grp' => new \Zend_Db_Expr("IFNULL(mp_udata.userdata_brand,UUID())")
        ]);

        $storeLocationCollection->getSelect()->where('mp_udata.is_seller=?', 1);
        $storeLocationCollection->getSelect()->where('mp_udata.is_live_Ready=?', 1);
        $storeLocationCollection->getSelect()->where('mp_udata.userdata_shop_operatational_status=?', 0);


        if (!empty($proSearchLimit) && isset($proSearchLimit)) {
            $storeLocationCollection->getSelect()->limit($proSearchLimit);
        }



        foreach ($storeLocationCollection as $storeObj) {


            $vendorId = $storeObj->getData('seller_id');
            if (!isset($storeDetailsArr[$vendorId]['locality']) &&
                    !isset($storeDetailsArr[$vendorId]['unique_name'])
            ) {
                $storeDetailsArr[$vendorId]['locality'] = $storeObj->getData('store_locality_area');
                $storeDetailsArr[$vendorId]['unique_name'] = $storeObj->getData('store_unique_name');
                $storeDetailsArr[$vendorId]['store_id'] = $storeObj->getData('id');
            }

            $storeUniqueName[] = $storeObj->getData('store_unique_name');
            $storeIdsArray[] = $storeObj->getData('id');
            $sellerIdsUnique[] = $storeObj->getData('seller_id');
            $isConglomarateSeller[$storeObj->getData('seller_id')] = $storeObj->getData('is_conglomerate');
        }


        /**
         * find seller radious within 3.5 KM
         */
        $nearestSellerId = array_unique($sellerIdsUnique);


        /**
         * filter catalog sync table products for $nearestSellerId
         */
        $catalogSyncCollection = $this->catalogSyncCollection
                ->addFieldToFilter("is_configurable", ["neq" => 0])
                ->addFieldToFilter('seller_id', ['in' => $nearestSellerId]);


        if (!empty($proSearchLimit) && isset($proSearchLimit)) {
            // $catalogSyncCollection->getSelect()->limit($proSearchLimit);
        }
        foreach ($catalogSyncCollection as $catalogSync) {
            $productId1[] = $catalogSync->getData('product_id');
        }

        $syncedCatalog = $productId = $businessNamesArr = [];
        foreach ($catalogSyncCollection as $catalogSync) {
            $productId[] = $catalogSync->getData('product_id');
            $syncedCatalog[$catalogSync->getData('product_id')] = $catalogSync;
            $businessNamesArr[$catalogSync->getData('product_id')]['store_id'] = $storeDetailsArr[$catalogSync->getData('seller_id')]['store_id'];
            $businessNamesArr[$catalogSync->getData('product_id')]['is_conglomerate'] = $isConglomarateSeller[$catalogSync->getData('seller_id')];
            $businessNamesArr[$catalogSync->getData('product_id')]['seller_id'] = $catalogSync->getData('seller_id');
            $businessNamesArr[$catalogSync->getData('product_id')]['store_unique_name'] = $storeDetailsArr[$catalogSync->getData('seller_id')]['unique_name'];
        }

        $query = strtolower($query);

        if (!empty($query) && isset($query)) {
            $searchStringExplode = explode(" ", $query);

            $terms = [];
            if (is_array($searchStringExplode)) {
                foreach ($searchStringExplode as $searchTerms) {
                    $terms[] = $searchTerms;
                }
            }

            $collection = $this->globalsearchFactory->create()->getCollection()
                    ->addFieldToSelect(["product_id", "tags"]);

            /**
             * commenting these line
             * will remove comment in future
             */
            //$collection->getSelect()->join(["bcs" => $collection->getTable("bakeway_catalog_sync")], 'main_table.product_id=bcs.product_id', ["seller_id"]);
            //$collection->getSelect()->join(["mu" => $collection->getTable("marketplace_userdata")], 'bcs.seller_id=mu.seller_id', ["store_city"]);
            //$collection->getSelect()->join(["bc" => $collection->getTable("bakeway_cities")], 'mu.store_city=bc.id', ["name"]);


            foreach ($terms as $termsVal) {
                $collection->addFieldToFilter(["tags"], [["like" => '%' . $termsVal . '%']]);
            }

            $resultSize = $collection->getSize();

            if (isset($resultSize) && $resultSize != null) {

                foreach ($collection as $key => $value) {
                    $searchProductId[] = $value->getProductId();
                }
            }
        }

        $catalogSyncProductsId = $productId;

        /**
         * final list of product id's
         */
        $finalProductArray = array_intersect($productId1, $searchProductId);


        $coreProductCollection = $this->_productCollection->create()
                ->addAttributeToFilter("status", ["eq" => self::CATALOG_PRODUCTS_STATUS])
                ->addFieldToFilter("entity_id", ["in" => $finalProductArray])
                ->addAttributeToSelect('*')
                ->setPageSize(self::RETURN_PRODUCTS_COUNT);

        $coreProductCollection->setVisibility($this->catalogVisibility->getVisibleInSiteIds());
        //$coreProductCollection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $coreProductCollection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        $coreProductCollection = $this->categoryProductRepository->addBakewayUrlRewrite($coreProductCollection);
        $i = 0;


        foreach ($coreProductCollection as $product) {


            /**
             * getting seller business name to display
             */
            $businessName = "";
            $storeLocality = "";

            $sellerId = $businessNamesArr[$product->getEntityId()]['seller_id'];

            $storeId = $businessNamesArr[$product->getEntityId()]['store_id'];


            $isConglomerate = $businessNamesArr[$product->getEntityId()]['is_conglomerate'];


            if ($isConglomerate == 1) {
                $storeUniqueName = $businessNamesArr[$product->getEntityId()]['store_unique_name'];
            } else {
                $storeUniqueName = null;
            }


            $productStatus = $this->storecatalogHelper->checkProdStatusForAllPuneCase($sellerId, $storeId, $product->getEntityId());


            if ($productStatus != true) {
                $products[$i]['product_status'] = $product->getStatus();
                $products[$i]['name'] = $product->getName();
                $products[$i]['id'] = $product->getEntityId();
                $products[$i]['type_id'] = $product->getTypeId();
                $products[$i]['sku'] = $product->getSku();
                $products[$i]['price'] = $product->getPrice();

                /*
                 * for now giving attribute names is static
                  $flavourLabel = $this->categoryProductRepository->getAttributeLabel($product,'cake_flavour');
                  $ingredientLabel = $this->categoryProductRepository->getAttributeLabel($product,'cake_ingredients');
                  $weightLabel = $this->categoryProductRepository->getAttributeLabel($product,'cake_weight');
                 */
                $flavourLabel = "Flavour";
                $ingredientLabel = "Ingredients";
                $weightLabel = "Weight (kg)";

                if (isset($syncedCatalog[$product->getEntityId()]) &&
                        $syncedCatalog[$product->getEntityId()] != null
                ) {
                    $syncedProduct = $syncedCatalog[$product->getEntityId()];
                    $prodAttr = $this->catalogSyncHelper->getCatalogAttributes($syncedProduct, $product, $cityId);
                } else {
                    $prodAttr = $this->catalogSyncHelper->getCatalogAttributes(null, $product, $cityId);
                }


                $rulePrice = $prodAttr['rule_price'];
                $ruleTaxPrice = $prodAttr['rule_tax_price'];
                $discountRule = $prodAttr['discount_rule'];
                $flavour = $prodAttr['flavour'];
                $weight = $prodAttr['weight'];
                $ingredient = $prodAttr['ingredient'];


                if (is_numeric($prodAttr['intimation_time'])) {
                    $whole = floor($prodAttr['intimation_time']);
                    $fraction = $prodAttr['intimation_time'] - $whole;
                    if ($fraction == 0)
                        $intimationTime = (int) $prodAttr['intimation_time'];
                    else
                        $intimationTime = (float) $prodAttr['intimation_time'];
                } else
                    $intimationTime = $prodAttr['intimation_time'];


                $specialPrice = $prodAttr['special_price'];
                $priceInclTax = $prodAttr['price_incl_tax'];
                $priceExclTax = $prodAttr['price_excl_tax'];
                $advancedOrderIntimationunit = $prodAttr['advanced_order_intimation_unit'];
                $prodTypeId = $product->getTypeId();
                $ExtensionAttObject = $product->getExtensionAttributes();


                $_imageHelper = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Catalog\Helper\Image');

                $_ProductsmallImageUrl = $_imageHelper->init($product, 'image', ['type' => 'small_image'])->keepAspectRatio(true)->resize('135', '135')->getUrl();


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
                    "store_unique_name" => $storeUniqueName,
                    "seo_url" => $this->categoryProductRepository->getProductSeoUrl($product->getData('request_path'), $product->getId()),
                    'media' => [
                        'small' => $_ProductsmallImageUrl
                    ],
                    "seller_id" => $sellerId,
                    "advance_order_intimation" => $intimationTime,
                    "advanced_order_intimation_unit" => $advancedOrderIntimationunit
                ];

                $i++;
            }
        }
        $responseArray['products'] = $products;

        if ($flavoursSearch == 1) {
            /**
             * Flavours Search
             */
            $flavours = [];
            $flavours['attr_code'] = \Bakeway\PartnerWebapi\Model\GlobalSearchRepository::FLAVOUR_ATTR_CODE;
            $flavours['label'] = 'Flavours';
            $newFlavourVal = [];
            $flavoursArray = $this->productApiFilterHelper->getProductAttributeFilter([\Bakeway\PartnerWebapi\Model\GlobalSearchRepository::FLAVOUR_ATTR_CODE]);

            if (isset($flavoursArray[0]['value']) && !empty($flavoursArray[0]['value']) && is_array($flavoursArray[0]['value'])) {
                $i = 0;
                foreach ($flavoursArray[0]['value'] as $key => $value) {
                    if (strpos(strtolower($value['label']), $query) !== false) {
                        $newFlavourVal[$i]['value'] = $value['value'];
                        $newFlavourVal[$i]['label'] = $value['label'];
                        $i++;
                    }
                }
            }
            $flavours['value'] = array_slice($newFlavourVal, 0, 5);
            $responseArray['flavours'] = $flavours;
        }

        if ($categorySearch == 1) {
            /**
             * Category Search
             */
            $catArray['attr_code'] = 'category_id';
            $catArray['label'] = 'Categories';
            $catVal = [];
            $cake = $this->categoryCollectionFactory->create()
                    ->addFieldToFilter("name", ['eq' => "Cakes"])
                    ->getFirstItem();
            $cakeCatId = $cake->getId();

            $children = [];
            if (isset($cakeCatId)) {
                $childrenCategories = $cake->getChildrenCategories();
                foreach ($childrenCategories as $child) {
                    $children[] = $child->getData('entity_id');
                }
            }

            $catCollection = $this->categoryCollectionFactory->create()
                    ->addFieldToFilter("name", ['like' => "%$query%"])
                    ->addFieldToFilter("entity_id", ['in' => $children])
                    ->setPageSize(5);
            $i = 0;
            foreach ($catCollection as $category) {
                $catVal[$i]['value'] = $category->getEntityId();
                $catVal[$i]['label'] = $category->getName();
                $i++;
            }
            $catArray['value'] = $catVal;
            $responseArray['categories'] = $catArray;
        }

        if ($bakerySearch == 1) {


            /**
             * Seller Search
             */
            $sellers['attr_code'] = 'seller_id';
            $sellers['label'] = 'Brands';


            /**
             * these below code is writing twice will remove in future when do debugging
             * start
             */
            $cityId = $this->bakewayCityHelper->getCityIdByName($city);

            $storeLocationCollection = $this->locationsCollection->create();
            $storeLocationCollection->addFieldToSelect(['seller_id', 'store_unique_name', 'store_locality_area']);

            if ($cityId !== false) {
                $storeLocationCollection->addFieldToFilter('main_table.city_id', $cityId);
            } else {
                $storeLocationCollection->addFieldToFilter('main_table.city_id', 0);
            }
            $storeLocationCollection->addFieldToFilter('main_table.is_active', 1);

            $storeLocationCollection->getSelect()->joinLeft(
                    ['sub_loc' => $storeLocationCollection->getTable('bakeway_sub_locations')], 'main_table.sub_loc_id=sub_loc.id', ['area_name']
            );

            if ($lat != '' && $long != '') {
                $storeLocationCollection->getSelect()->columns(
                        [
                            'distance' => new \Zend_Db_Expr("ST_Distance_Sphere(POINT(" . $long . ", " . $lat . "), sub_loc_geo_point)/1000")
                ]);
                $storeLocationCollection->setOrder('distance', 'ASC');
                $storeLocationCollection->getSelect()->having('distance<=?', \Bakeway\ProductApi\Model\CategoryProductRepository::SEARCH_RADIUS);
            }
            $storeLocationCollection->getSelect()->joinLeft(
                    ['mp_udata' => $storeLocationCollection->getTable('marketplace_userdata')], 'main_table.seller_id=mp_udata.seller_id', ['is_conglomerate', 'shop_title', 'business_name', 'userdata_brand']
            );

            $storeLocationCollection->getSelect()->columns(
                    [
                        'unique_col_grp' => new \Zend_Db_Expr("IFNULL(mp_udata.userdata_brand,UUID())")
            ]);

            $storeLocationCollection->getSelect()->where('mp_udata.is_seller=?', 1);
            $storeLocationCollection->getSelect()->where('mp_udata.is_live_Ready=?', 1);
            $storeLocationCollection->getSelect()->where('mp_udata.userdata_shop_operatational_status=?', 0);
            /**
             * these below code is writing twice will remove in future when do debugging
             * end
             */
            $sellerCollection = $storeLocationCollection
                    ->addFieldToFilter("business_name", ['like' => "%$query%"]);
            $sellerCollection->getSelect()->group('mp_udata.seller_id');
            $sellerCollection->getSelect()->limit(5);

            $i = 0;
            foreach ($sellerCollection as $seller) {
                $sellerVal[$i]['value'] = $seller->getSellerId();
                $sellerVal[$i]['label'] = $seller->getData('business_name');
                $i++;
            }

            $sellers['value'] = $sellerVal;
            $responseArray['bakeries'] = $sellers;
        }


        return json_decode(json_encode($responseArray), true);
    }

}
