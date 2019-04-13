<?php
namespace BakewayMobile\PartnerMobileApi\Model;

use \BakewayMobile\PartnerMobileApi\Api\MobilePartnerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use \Bakeway\PartnerWebapi\Helper\Data as WebapiHelper;
use Magento\Framework\App\ResourceConnectionFactory;
use \Bakeway\Cities\Helper\Data as BakewayCityHelper;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use \Bakeway\ProductApi\Helper\Data as BakewayProductapiHelper;
use Magento\Catalog\Model\Product\Visibility as CatalogVisibility;
use \Magento\Framework\Exception\NotFoundException;
use \Bakeway\Partnerlocations\Model\ResourceModel\Partnerlocations\CollectionFactory as LocationCollection;
use Bakeway\ProductApi\Helper\Filter as ProductApiFilterHelper;
use Bakeway\GrabIntigration\Helper\Data as Grabhelper;
use Bakeway\ProductApi\Model\CatalogSeoRepository;
use Bakeway\ReviewRating\Helper\Data as ReviewratingHelper;
use Magento\Catalog\Helper\ImageFactory as ProductImageHelper;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Store\Model\App\Emulation as AppEmulation;
use Magento\Framework\ObjectManagerInterface;
use Bakeway\HomeDeliveryshipping\Helper\Data as HomeDeliveryHelper;
use \Bakeway\CatalogSync\Model\ResourceModel\CatalogSync\Collection as CatalogSyncCollection;
use \Bakeway\CatalogSync\Helper\Data as CatalogSyncHelper;
use BakewayMobile\PartnerMobileApi\Helper\data as helper;

class MobilePartnerRepository implements MobilePartnerInterface
{
    const SEARCH_RADIUS = 3.5;
    const SPECIAL_DELIVERY_SEARCH_RADIUS = 3.5;
    const HOME_BAKER_SEARCH_RADIUS = 30;

    protected $helper;

     /**
     * @var ResourceConnectionFactory
     */
    protected $_resourceConnection;

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
     * @var CatalogSyncCollection
     */
    protected $catalogSyncCollection;

    /**
     * @var CatalogSyncHelper
     */
    protected $catalogSyncHelper;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var HomeDeliveryHelper
     */
    protected $homeDeliveryHelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Store\Model\App\Emulation
     */
    protected $appEmulation;

    /**
     * @var BakewayCityHelper
     */
    protected $bakewayCityHelper;

    /**
     * @var WebapiHelper;
     */
    protected $webapiHelper;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollection;

    /**
     * @var BakewayProductapiHelper
     */
    protected $productapihelper;

    /**
     * @var LocationCollection
     */
    protected $locationsCollection;

    /**
     * @var CatalogVisibility
     */
    protected $catalogVisibility;

    /**
     * @var ProductApiFilterHelper
     */
    protected $prodApiFilterHelper;

    /**
     * @var Grabhelper
     */
    protected $grabhelper;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager = null;

    /**
     * @var ReviewratingHelper
     */
    protected $reviewratingHelper;

    /**
     * SearchPartnerRepository constructor.
     * @param WebapiHelper $webapiHelper
     * @param BakewayCityHelper $bakewayCityHelper
     * @param ProductCollectionFactory $productCollection
     * @param BakewayProductapiHelper $productapihelper
     * @param LocationCollection $locationsCollection
     * @param CatalogVisibility $catalogVisibility
     * @param ProductApiFilterHelper $prodApiFilterHelper
     * @param Grabhelper $grabhelper
     */
    public function __construct(
            ResourceConnectionFactory $_resourceConnection,
            WebapiHelper $webapiHelper,
            BakewayCityHelper $bakewayCityHelper,
            ProductCollectionFactory $productCollection,
            BakewayProductapiHelper $productapihelper,
            LocationCollection $locationsCollection,
            CatalogVisibility $catalogVisibility,
            ProductApiFilterHelper $prodApiFilterHelper,
            Grabhelper $grabhelper,
            \Magento\Framework\Event\ManagerInterface $eventManager,
            ReviewratingHelper $reviewratingHelper,
            \Magento\Store\Model\StoreManagerInterface $storeManager, 
            \Magento\Store\Model\App\Emulation $appEmulation,
            ObjectManagerInterface $objectManager, HomeDeliveryHelper $homeDeliveryHelper,
            CatalogSyncCollection $catalogSyncCollection, CatalogSyncHelper $catalogSyncHelper,
            \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor,
            \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface,
            \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
            helper $helper
    )
    {
        $this->_resourceConnection = $_resourceConnection;
        $this->webapiHelper = $webapiHelper;
        $this->bakewayCityHelper = $bakewayCityHelper;
        $this->productCollection = $productCollection;
        $this->productapihelper = $productapihelper;
        $this->locationsCollection = $locationsCollection;
        $this->catalogVisibility = $catalogVisibility;
        $this->prodApiFilterHelper = $prodApiFilterHelper;
        $this->grabhelper = $grabhelper;
        $this->_eventManager = $eventManager;
        $this->reviewratingHelper = $reviewratingHelper;
        $this->storeManager = $storeManager;
        $this->appEmulation = $appEmulation;
        $this->objectManager = $objectManager;
        $this->homeDeliveryHelper = $homeDeliveryHelper;
        $this->catalogSyncCollection = $catalogSyncCollection;
        $this->catalogSyncHelper = $catalogSyncHelper;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->metadataService = $metadataServiceInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->helper = $helper;
    }

    /**
     * Get Partner List.
     *
     * @api
     * @param string|null $city
     * @param string|null $lat
     * @param string|null $long
     * @param string|null $deliverydate
     * @param string|null $searchterm
     * @param \Magento\Framework\Api\SearchCriteria|null $searchCriteria The search criteria.
     * @return array
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function getMobilePartnerList($city = null, $lat = null, $long = null, $deliverydate = null, $searchterm = null, \Magento\Framework\Api\SearchCriteria $searchCriteria = null) {
        return $this->partnerSearch(
            $city, $lat, $long, $deliverydate, $searchterm, $searchCriteria
        );
    }

    /**
     * @param string|null $city
     * @param string|null $lat
     * @param string|null $long
     * @param string|null $deliverydate
     * @param string|null $searchterm
     * @param \Magento\Framework\Api\SearchCriteria|null $searchCriteria The search criteria.
     * @param bool $autocomplete
     * @return array
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function partnerSearch($city = null, $lat = null, $long = null, $deliverydate = null, $searchterm = null, \Magento\Framework\Api\SearchCriteria $searchCriteria = null, $autocomplete = false) {
        $result = [];

        /*$deliveryDate = date('Y-m-d', strtotime($deliverydate));
        $today = date('Y-m-d', strtotime('today'));*/

        try{
            /*if ($deliverydate === null || $today > $deliveryDate) {
                return $result;
            }*/

            $cityId = $this->bakewayCityHelper->getCityIdByName($city);

            $locationsResult = $this->multipleLocationSearch(
                $cityId,
                $lat,
                $long,
                $deliverydate,
                $searchterm,
                $searchCriteria
            );

            $result['total_count'] = $locationsResult['total_count'];
            $result['current_page'] =  $searchCriteria->getCurrentPage();
            $result['page_size'] = $searchCriteria->getPageSize();
            $partners = [];
            $partners = array_merge($partners, $locationsResult['partners']);

            if ($autocomplete === false) {
                $result['partners'] = $partners;
                return json_decode(json_encode($result, false));
            } else {
                return json_decode(json_encode($partners, false));
            }
        } catch (Exception $e) {
            throw new NotFoundException(__('Something went wrong please try again later.'));
        }

    }

    public function multipleLocationSearch(
        $cityId = null,
        $lat = null,
        $long = null,
        $deliverydate = null,
        $searchterm = null,
        \Magento\Framework\Api\SearchCriteria $searchCriteria = null
    ) {
        $result = [];
        $collection = $this->locationsCollection->create();
        $collection->addFieldToSelect(['seller_id','store_unique_name','store_locality_area','store_latitude','store_longitude','is_grab_active', 'number_of_orders','is_pickup_active','regular_delivery_start_time','regular_delivery_end_time','free_delivery_threshold','store_locality_meta_description','is_delivery_active','shop_open_timing','shop_open_AMPM','shop_close_timing','shop_close_AMPM']);

        if ($cityId !== false) {
            $collection->addFieldToFilter('store_city', $cityId);
        } else {
            $collection->addFieldToFilter('store_city', 0);
        }
        $collection->addFieldToFilter('is_active', 1);

        /**
         * Joining bakeway_sub_locations Table (SUB-HUB)
         */
        $collection->getSelect()->joinLeft(
            ['sub_loc' => $collection->getTable('bakeway_sub_locations')],
            'main_table.sub_loc_id=sub_loc.id',
            ['area_name']
        );

        /**
         * Code to calculate the distance between store and the delivery area
         * Sorted the stores in ASC order of distance
         */
        if ($lat != '' && $long != '') {
            $collection->getSelect()->columns(
                [
                    'distance' => new \Zend_Db_Expr("ST_Distance_Sphere(POINT(" . $long . ", " . $lat . "), sub_loc_geo_point)/1000")
                ]);
            //$collection->setOrder('distance', 'ASC');
            $isHomeBaker = false;
            $isLateNight = false;
            $isEarlyMorning = false;
            $deliveryType = 0;
            if ($searchCriteria != null) {
                foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
                    foreach ($filterGroup->getFilters() as $filter) {
                        $filterField = $filter->getField();
                        $filterValue = $filter->getValue();
                        if ($filterField == 'bakery_type' && $filterValue == 3) {
                            $isHomeBaker = true;
                        }
                        if ($filterField == 'late_night_delivery' && $filterValue == 1) {
                            $isLateNight = true;
                            $deliveryType = 1;
                        }
                        if ($filterField == 'early_morning_delivery' && $filterValue == 1) {
                            $isEarlyMorning = true;
                            $deliveryType = 2;
                        }
                    }
                }
            }
            if (!$isLateNight && !$isEarlyMorning)
            {
                if ($isHomeBaker === true) 
                {
                    $collection->getSelect()->having('distance<=?',self::HOME_BAKER_SEARCH_RADIUS);
                }
                else
                {
                    $collection->getSelect()->having('distance<=?', self::SEARCH_RADIUS);
                }
            }
            else
            {
                $collection->getSelect()->having('distance<=?', self::SPECIAL_DELIVERY_SEARCH_RADIUS);

            }

            /* Code for late night and early mornign delivery starts */
            if ($isLateNight) {
                $collection->getSelect()->where('main_table.is_midnight_active = 1');
            }

            if ($isEarlyMorning) {
                $collection->getSelect()->where('main_table.is_morning_active = 1');
            }
            if($isLateNight || $isEarlyMorning)
            {
                $collection->getSelect()->where('main_table.is_grab_active = 0');
                $collection->getSelect()->where('main_table.is_delivery_active = 1');
            }
            /* Code for late night and early mornign delivery ends */

            $collection->getSelect()->group(['main_table.seller_id', 'main_table.sub_loc_id']);
            //$collection->getSelect()->group('distance');
        }

        /**
         * grab gloabal status
         */
        $grabGlobalStatus = $this->grabhelper->getGrabGlobalStatus();

        $collection->getSelect()->joinLeft(
            ['mp_udata' => $collection->getTable('marketplace_userdata')],
            'main_table.seller_id=mp_udata.seller_id',
            ['bakery_type', 'company_description', 'business_name',
                'store_city','average_ratings', 'advanced_order_intimation_time', 'delivery_time','logo_pic', 'delivery',
                'userdata_shop_temporarily_u_from', 'userdata_shop_temporarily_u_to','is_pickup','is_conglomerate']
        );

        $collection->getSelect()->joinLeft(
            ['bkw_part_rule' => $collection->getTable('bakeway_partner_catalogrule')],
            'main_table.seller_id=bkw_part_rule.seller_id',
            ['rule_id']
        );

        $collection->getSelect()->where('mp_udata.is_seller=?', 1);
        $collection->getSelect()->where('mp_udata.is_live_Ready=?', 1);
        $collection->getSelect()->where('mp_udata.userdata_shop_operatational_status=?', 0);


        /**
         * Added condition to search on searchterm
         * shop_url, shop_title, business_name, merchant_name considered
         */
        if ($searchterm != '' && $searchterm !== null) 
        {
            $collection->addFieldToFilter([
                'mp_udata.business_name', 'mp_udata.merchant_name', 'main_table.store_locality_area'],
                [['like' => "%$searchterm%"], ['like' => "%$searchterm%"],
                    ['like' => "%$searchterm%"]]);
        }

        if ($searchCriteria != null)
        {
            $catFilterId = null;
            $catSellerIds = null;
            $prodFields = [];
            $prodFilterGroup = 0;
            foreach ($searchCriteria->getFilterGroups() as $filterGroup)
            {
                $prodFilterGroupCount = 0;
                foreach ($filterGroup->getFilters() as $filter)
                {
                    $filterField = $filter->getField();
                    $filterValue = $filter->getValue();
                    $filterCondition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                    if ($filterField == 'bakery_type' && !$isLateNight && !$isEarlyMorning)
                    {
                        $collection->getSelect()->where('mp_udata.bakery_type=?',
                                $filterValue);
                    }
                    if ($filterField == 'business_name')
                    {
                        $collection->getSelect()->where('mp_udata.business_name LIKE "%'.$filterValue.'%"');
                    }
                    /**
                     * applying delivery filter
                     */
                    if ($filterField == WebapiHelper::FILTER_DELIVERY_CODE)
                    {
                        switch ($filterValue)
                        {
                            case WebapiHelper::DELIVERY_OPTION_PICKUP :
                                $collection->getSelect()->where('main_table.is_pickup_active=?', 1);
                                break;
                            case WebapiHelper::DELIVERY_OPTION_DELIVERY :
                             $collection->addFieldToFilter(
                                    array('main_table.is_delivery_active', 'main_table.is_grab_active'),
                                         array(
                                               array('eq'=>'1'), 
                                               array('eq'=>'1')
                                               )
                                         );                            
                                break;
                            case WebapiHelper::DELIVERY_OPTION_BOTH :
                                $collection->getSelect()->where('main_table.is_delivery_active=?', 1);
                                $collection->getSelect()->where('main_table.is_pickup_active=?', 1);
                                $collection->getSelect()->orWhere('main_table.is_grab_active=?', 1);
                                break;
                        }
                    }
                    /**
                     * check for category filter
                     */
                    if ($filterField == WebapiHelper::CATEGORY_FILTER_CODE)
                    {
                        $catFilterId = $filterValue;
                        $catSellerIds = $this->applyCategoryFilterOnBakery($catFilterId);
                        $collection->addFieldToFilter('mp_udata.seller_id', ['in' => $catSellerIds]);
                    }

                    /**
                     * check for late night delivery filter
                     */
                    if ($filterField == WebapiHelper::LATE_NIGHT_DEL_FILTER_CODE)
                    {
                        $timeArr = explode("-", $filterValue);
                        if (isset($timeArr[0]) && isset($timeArr[1]))
                        {
                            $collection->addFieldToFilter('main_table.shop_close_timing', ['eq' => (int)$timeArr[0]]);
                            $collection->addFieldToFilter('main_table.shop_close_AMPM', ['eq' => (int)$timeArr[1]]);
                        }
                    }

                    /**
                     * Check for advance order intimation time filter
                     */
                    if ($filterField == WebapiHelper::ADV_ORDER_INT_TIME_FILTER_CODE)
                    {
                        $prodFields[$prodFilterGroup][$prodFilterGroupCount] = ['attribute' => $filter->getField(), $filterCondition => (int)$filter->getValue()];
                        $prodFilterGroupCount++;
                    }

                    /**
                     * applying offers filter
                     */
                    if ($filterField == WebapiHelper::OFFERS_FILTER)
                    {
                        if ($filterValue == 1)
                        {
                            $collection->getSelect()->where('bkw_part_rule.rule_id != ?', null);
                        }
                    }
                }
                if (!empty($prodFields))
                {
                    $prodFilterGroup++;
                }
            }
            if (!empty($prodFields) && is_array($prodFields))
            {
                $sellerIds = $this->applyProductFiltersOnBakery($prodFields);
                if ($catSellerIds !== null)
                {
                    $sellerIds = array_intersect($sellerIds, $catSellerIds);
                }
                $collection->addFieldToFilter('mp_udata.seller_id', ['in' => $sellerIds]);
            }
        }
        $collection->getSelect()->order('main_table.is_featured DESC');
        $collection->getSelect()->order('distance ASC');
        $collection->getSelect()->order('main_table.number_of_orders DESC');

        $limit = $result['page_size'] = $searchCriteria->getPageSize();
        if(is_null($limit) || $limit == "")
        {
            $limit = $this->helper->getFetchLimit();
        }
        $result['current_page'] = $searchCriteria->getCurrentPage();
        $offset = (($result['current_page']-1)*$result['page_size']);
        $collection->getSelect()->limit($limit, $offset);

        $partners = [];
        $i = 0;
        $rulesArr = $this->webapiHelper->getCatalogRuleNames();
        $sellerIdsArray = $collection->getColumnValues('seller_id');
        $sellerUrlArray = $this->productapihelper->getSellerUrlListArray($sellerIdsArray, $cityId);

        $currentDateTime = new \DateTime('now', new \DateTimezone("Asia/Kolkata"));
        $cDate = $currentDateTime->format('Y-m-d');
        $nextDate = date('Y-m-d', strtotime('+1 day', strtotime($cDate)));
        $existingSellerIdsArray = [];
      
        $conn = $this->_resourceConnection->create()->getConnection();
        $select = $collection->getSelect();
        $select = str_replace("SELECT ", "SELECT SQL_CALC_FOUND_ROWS ", $select);
        $data = $conn->fetchAll($select);
        $countQuery = $conn->fetchAll("SELECT FOUND_ROWS();");
        $flavourLabel    = "Flavour";
        $ingredientLabel = "Ingredients";
        $weightLabel     = "Weight (kg)";
        $escapedBakery = 0;
        foreach ($data as $seller) 
        {
            /*
             * BKWYADMIN-1281 Remove bakery from listing if disabled.
             */
            $temporarilyFrom = date('Y-m-d', strtotime($seller['userdata_shop_temporarily_u_from']));
            $temporarilyTo = date('Y-m-d', strtotime($seller['userdata_shop_temporarily_u_to']));
            if (($temporarilyFrom <= $cDate) && ($cDate <= $temporarilyTo)) 
            {
                $escapedBakery++;
                continue;
            }

            array_push($existingSellerIdsArray, $seller['seller_id']);
            $partners[$i] = $seller;

            if (isset($partners[$i]['average_ratings'])) {
                if ($partners[$i]['average_ratings'] <= 0) {
                    $partners[$i]['average_ratings'] = null;
                }
            } else {
                $partners[$i]['average_ratings'] = null;
            }

            $logo = $seller['logo_pic'] != '' ? $seller['logo_pic'] : "noimage.png";

            /** Adding SEO URL */
            if (isset($sellerUrlArray[$seller['seller_id']])) {
                $url = $sellerUrlArray[$seller['seller_id']];
            } else {
                $url = null;
            }
            $isConglomerate = $seller['is_conglomerate'];
            if ($isConglomerate == 1) {
                $partners[$i]['seo_url'] = $url . '?store=' . $seller['store_unique_name'];
            } else {
                $partners[$i]['seo_url'] = $url;
            }

            $media = [];
            $media['logo_pic'] = $this->getImageArray($logo);
            $partners[$i]['media'] = $media;
            $partners[$i]['store_description'] = $seller['store_locality_meta_description'];

            /** adding city value */
            $partners[$i]['store_city'] = $this->bakewayCityHelper->getCityNameById($seller['store_city']);
            
            /** Setting PickUp Status at Store Level */
            if(isset($partners[$i]['is_pickup_active']))
            {
                $partners[$i]['is_pickup'] = $partners[$i]['is_pickup_active'];
                unset($partners[$i]['is_pickup_active']);
            }
            if(isset($partners[$i]['is_delivery_active']))
            {
                $partners[$i]['delivery'] = $partners[$i]['is_delivery_active'];
                unset($partners[$i]['is_delivery_active']);
            }
            if(isset($partners[$i]['regular_delivery_start_time']))
            {
                $partners[$i]['shop_delivery_open_time'] = $partners[$i]['regular_delivery_start_time'];
                unset($partners[$i]['regular_delivery_start_time']);
            }
            if(isset($partners[$i]['regular_delivery_end_time']))
            {
                $partners[$i]['shop_delivery_close_time'] = $partners[$i]['regular_delivery_end_time'];
                unset($partners[$i]['regular_delivery_end_time']);
            }

            /** set grab global value */
            $partners[$i]['is_grab_global'] = $grabGlobalStatus;

            /** Adding discount name */
            $sellerRuleId = $seller['rule_id'];
            if (isset($rulesArr[$sellerRuleId])) {
                $partners[$i]['discount_rule'] = $rulesArr[$sellerRuleId];
            } else {
                $partners[$i]['discount_rule'] = null;
            }
           
            $closedToday = 0;
            $closedTomorrow = 0;
            if (($temporarilyFrom <= $nextDate) && ($nextDate <= $temporarilyTo)) {
                $closedTomorrow = 1;
            }
            $partners[$i]['closed_today'] = $closedToday;
            $partners[$i]['closed_tomorrow'] = $closedTomorrow;

            /* ============================================= Product Collection Start =============================================== */ 
            if(isset($seller['seller_id']) && isset($seller['store_unique_name']) && $seller['seller_id'] > 0 && $seller['store_unique_name'] != "")
            {
                $vendorId = $seller['seller_id'];
                $storeName = $seller['store_unique_name'];
                $category = (empty($this->helper->getProductCategory()) ? $this->helper->getProductCategory() : array('13'));
             
                $prodCollection = $this->productCollection->create()->addAttributeToSelect('*');

                $disProId = "SELECT bsc.`product_id` FROM `bakeway_store_catalog` AS bsc INNER JOIN `bakeway_partner_locations` AS bpl
                                            ON bsc.`store_id` = bpl.`id` WHERE bsc.`seller_id` = ".$vendorId." AND bpl.`store_unique_name` = '".$storeName."'";
                $disProdIdArr = $conn->fetchCol($disProId);

                if(count($disProdIdArr) && count($disProdIdArr) > 0)
                    $prodCollection->addFieldToFilter('entity_id', ['nin' => $disProdIdArr]);

                $prodCollection->getSelect()->joinInner(['magepro' => $prodCollection->getTable('marketplace_product')],
                    'e.entity_id=magepro.mageproduct_id',
                    ['mageproduct_id']
                );
                $prodCollection->getSelect()->where('magepro.seller_id=?',$vendorId);
                $prodCollection->setVisibility($this->catalogVisibility->getVisibleInSiteIds());
                $prodCollection->addAttributeToSort('price', 'ASC');
                $prodCollection->addCategoriesFilter(['in' => $category]);
                
                $this->extensionAttributesJoinProcessor->process($prodCollection);

                foreach ($this->metadataService->getList($this->searchCriteriaBuilder->create())->getItems() as $metadata)
                {
                    $prodCollection->addAttributeToSelect($metadata->getAttributeCode());
                }
                $prodCollection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
                $prodCollection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
                $prodCollection->getSelect()->limit(5);
                $prodCollection->load();
                $prodCollection = $this->helper->addBakewayUrlRewrite($prodCollection);

                $filteredProdIds = $prodCollection->getColumnValues('entity_id');
                $filteredProdIdString = implode(",", $filteredProdIds);

                $products = array();
                $result = array();
                $j = 0;
                $vendorDetails = $this->homeDeliveryHelper->getSellerDetails($vendorId);
                $cityId = $vendorDetails->getData('store_city');
                $syncedCatalog = $catSyncProdsArr = [];
                
                if(count($filteredProdIds) && count($filteredProdIds) > 0 && $filteredProdIdString != '')
                {
                    $catSyncProds = "SELECT `product_id`,`id`, `special_price`, `price_incl_tax`, `catalog_discount_price`, `catalog_discount_price_incl_tax`, `catalog_rule_name`, `cake_flavour`, `cake_ingredients`, `cake_weight`,`fixed_discount_start_date`, `fixed_discount_end_date` FROM `bakeway_catalog_sync` WHERE `product_id` IN (".$filteredProdIdString.") AND `seller_id` = ".$vendorId;
                    
                    $catSyncProdsArr = $conn->fetchAssoc($catSyncProds);
                }

                if(count($catSyncProdsArr) && count($catSyncProdsArr) > 0)
                {
                    $syncedCatalog = $catSyncProdsArr;
                }
                $storeId = $this->storeManager->getStore()->getId();
                $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);

                foreach ($prodCollection as $product)
                {   
                    if (isset($syncedCatalog[$product->getEntityId()]) && $syncedCatalog[$product->getEntityId()] != null) 
                    {
                        $products[$j]['name'] = $product->getName();
                        $products[$j]['id'] = $product->getEntityId();
                        $products[$j]['type_id'] = $product->getTypeId();
                        $products[$j]['sku'] = $product->getSku();
                        $products[$j]['price'] = $product->getPrice();
                        $prodAttr = $syncedCatalog[$product->getEntityId()];
                        $ruleTaxPrice       = $prodAttr['catalog_discount_price_incl_tax'];
                        $discountRule       = $prodAttr['catalog_rule_name'];
                        $discountStartOn    = $prodAttr['fixed_discount_start_date'];
                        $discountEndsOn     = $prodAttr['fixed_discount_end_date'];
                        $flavour            = $prodAttr['cake_flavour'];
                        $weight             = $prodAttr['cake_weight'];
                        $ingredient         = $prodAttr['cake_ingredients'];
                        $priceInclTax       = $prodAttr['price_incl_tax'];

                        $productPickUpValue = "null";

                        $products[$j]['extension_attributes'] =
                        [
                            "product_attributes" => 
                            [
                                ["attr_code" => "cake_flavour", "label" => $flavourLabel, "values" => [$flavour]],
                                ["attr_code" => "cake_ingredients", "label" => $ingredientLabel, "values" => [$ingredient]],
                                ["attr_code" => "cake_weight", "label" => $weightLabel, "values" => [$weight]],
                            ],
                            "price_incl_tax" => number_format($priceInclTax, 2),
                            "catalog_discount_price_incl_tax" => $ruleTaxPrice,
                            "discount_rule" => $discountRule,
                            "discount_rule_start_date" => $discountStartOn,
                            "discount_rule_end_date" => $discountEndsOn,
                            "seo_url" => $this->helper->getProductSeoUrl($product->getData('request_path'), $product->getId()),
                            'media' => 
                            [
                                'small' => $this->helper->getImageUrl($product, 'product_small_image'),
                                'large' => $this->helper->getImageUrl($product, 'product_page_image_large'),    
                            ],
                        ];
                    } 
                    /*else
                    {
                        $prodAttr = $this->catalogSyncHelper->getCatalogAttributes(null, $product, $cityId);
                    }*/

                      
                    $j++; 
                }
                $partners[$i]['productList'] = $products;
            }
            else
            {
                $partners[$i]['productList'] = array();
                continue;
            }
            $i++;
        }
        $output = $partners;
        $total_count = $countQuery[0]['FOUND_ROWS()'];
        $result['total_count'] = (int)($total_count - $escapedBakery);
        $result['partners'] = $output;

        return $result;
    }

    /**
     * @param string $image
     * @return array
     */
    public function getImageArray($image) {
        $result = [];
        $result["small"] = $this->webapiHelper->resize($image, 25, 25);
        $result["thumb"] = $this->webapiHelper->resize($image, 150, 150);
        $result["large"] = $this->webapiHelper->resize($image);
        return $result;
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function applyProductFiltersOnBakery($fields) {
        $collection = $this->productCollection->create()
            ->addFieldToSelect('entity_id');
        foreach ($fields as $field) {
            $collection->addFieldToFilter($field);
        }
        $collection->addCategoriesFilter(['in'=>(13)]);
        $collection->setVisibility($this->catalogVisibility->getVisibleInSiteIds());
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        $collection->getSelect()->joinInner(['mark_prod' => $collection->getTable('marketplace_product')], 'e.entity_id=mark_prod.mageproduct_id', ['seller_id']);
        $collection->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $collection->getSelect()->where('mark_prod.status=?', 1);
        $collection->getSelect()->group('seller_id');
        return $collection->getColumnValues('seller_id');
    }

    /**
     * @param $catId
     * @return bool|array
     */
    public function applyCategoryFilterOnBakery($catId) {
        $collection = $this->productCollection->create()
            ->addFieldToSelect('entity_id');
        $collection->setVisibility($this->catalogVisibility->getVisibleInSiteIds());
        $collection->addCategoriesFilter(['in' => [$catId]]);
        $collection->getSelect()->joinInner(['mark_prod' => $collection->getTable('marketplace_product')], 'e.entity_id=mark_prod.mageproduct_id', ['seller_id']);
        $collection->getSelect()->where('mark_prod.status=?', 1);
        $sellerIds = $collection->getColumnValues('seller_id');
        if (is_array($sellerIds) && !empty($sellerIds)) {
            return array_unique($sellerIds);
        }
        return false;
    }

}
