<?php

/**
 * Bakeway
 *
 * @category  Bakeway
 * @package   Bakeway_PartnerWebapi
 * @author    Bakeway
 */

namespace Bakeway\PartnerWebapi\Model;

use \Bakeway\PartnerWebapi\Api\SearchPartnerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use \Webkul\Marketplace\Model\ResourceModel\Seller\CollectionFactory as SellerCollection;
use \Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use \Bakeway\PartnerWebapi\Helper\Data as WebapiHelper;
use Magento\Framework\App\ResourceConnection;
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
use Bakeway\Deliveryrangeprice\Helper\Data as DeliveryrangeHelper;
use Bakeway\StoreCatalog\Helper\Data as StoreCatalogHelper;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface as TimezoneInterface;

class SearchPartnerRepository implements SearchPartnerInterface
{
    const SEARCH_RADIUS = 3.5;
    const SPECIAL_DELIVERY_SEARCH_RADIUS = 3.5;
    const HOME_BAKER_SEARCH_RADIUS = 30;
    const MAX_PAGE_SIZE = 20;
    const MAX_PAGE_NUMBER = 5;
    const PRODUCT_ATTR = ['cake_ingredients'];
    const PRODUCT_ATTR_PRODUCT_LISTING_FILTER = ['cake_flavour', 'cake_ingredients'];
    const MIN_PAGE_SIZE = 20;
    const MIN_PAGE_NUMBER = 1;

    /**
     * @var BakewayCityHelper
     */
    protected $bakewayCityHelper;

    /**
     * @var SellerCollection
     */
    protected $sellerCollection;

    /**
     * @var MarketplaceHelper;
     */
    protected $marketplaceHelper;

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
     * @var ResourceConnection
     */
    protected $resourceConnection;

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
     * Delivery Range Price Helper
     * @var DeliveryrangeHelper
     */
    protected $deliveryrangeHelper;
    
    /**
     * StoreCatalogHelper
     */
    protected $storeCatalogHelper;

    /* 
     * TimezoneInterface
     * @var TimezoneInterface
     */
    protected $timezoneInterface;

    /**
     * SearchPartnerRepository constructor.
     * @param SellerCollection $sellerCollection
     * @param MarketplaceHelper $marketplaceHelper
     * @param WebapiHelper $webapiHelper
     * @param BakewayCityHelper $bakewayCityHelper
     * @param ProductCollectionFactory $productCollection
     * @param BakewayProductapiHelper $productapihelper
     * @param LocationCollection $locationsCollection
     * @param ResourceConnection $resourceConnection
     * @param CatalogVisibility $catalogVisibility
     * @param ProductApiFilterHelper $prodApiFilterHelper
     * @param Grabhelper $grabhelper
     * @param DeliveryrangeHelper $deliveryrangeHelper
     * @param StoreCatalogHelper $storeCatalogHelper
     * @param TimezoneInterface $timezoneInterface
     */
    public function __construct(
            SellerCollection $sellerCollection,
            MarketplaceHelper $marketplaceHelper,
            WebapiHelper $webapiHelper,
            BakewayCityHelper $bakewayCityHelper,
            ProductCollectionFactory $productCollection,
            BakewayProductapiHelper $productapihelper,
            LocationCollection $locationsCollection,
            ResourceConnection $resourceConnection,
            CatalogVisibility $catalogVisibility,
            ProductApiFilterHelper $prodApiFilterHelper,
            Grabhelper $grabhelper,
            \Magento\Framework\Event\ManagerInterface $eventManager,
            ReviewratingHelper $reviewratingHelper,
            DeliveryrangeHelper $deliveryrangeHelper,
            StoreCatalogHelper $storeCatalogHelper,
            TimezoneInterface $timezoneInterface
    )
    {
        $this->sellerCollection = $sellerCollection;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->webapiHelper = $webapiHelper;
        $this->bakewayCityHelper = $bakewayCityHelper;
        $this->productCollection = $productCollection;
        $this->productapihelper = $productapihelper;
        $this->locationsCollection = $locationsCollection;
        $this->resourceConnection = $resourceConnection;
        $this->catalogVisibility = $catalogVisibility;
        $this->prodApiFilterHelper = $prodApiFilterHelper;
        $this->grabhelper = $grabhelper;
        $this->_eventManager = $eventManager;
        $this->reviewratingHelper = $reviewratingHelper;
        $this->deliveryrangeHelper = $deliveryrangeHelper;
        $this->storeCatalogHelper = $storeCatalogHelper;
        $this->timezoneInterface = $timezoneInterface;
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
    public function getSearchList($city = null, $lat = null, $long = null, $deliverydate = null, $searchterm = null, \Magento\Framework\Api\SearchCriteria $searchCriteria = null) {
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
            $result['current_page'] = $locationsResult['current_page'];
            $result['page_size'] = $locationsResult['page_size'];
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

        //$collection->addFieldToSelect(['seller_id','store_unique_name','store_locality_area','store_latitude','store_longitude','store_street_address','is_grab_active']);
        $collection->addFieldToSelect(['seller_id','store_unique_name','store_locality_area','store_latitude','store_longitude','is_grab_active', 'number_of_orders','is_pickup_active','regular_delivery_start_time','regular_delivery_end_time','free_delivery_threshold','is_delivery_active','shop_open_timing','shop_open_AMPM','shop_close_timing','shop_close_AMPM']);

        if ($cityId !== false) {
            $collection->addFieldToFilter('store_city', $cityId);
        } else {
            $collection->addFieldToFilter('store_city', 0);
        }
        $collection->addFieldToFilter('main_table.is_active', 1);

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
                'store_city','average_ratings', 'advanced_order_intimation_time', 'delivery_time',
                'merchant_name', 'business_name', 'banner_pic', 'logo_pic', 'delivery',
                'userdata_shop_temporarily_u_from', 'userdata_shop_temporarily_u_to',
                'meta_keyword', 'meta_description',  'is_pickup','is_conglomerate','categories_available','is_deivery_max_price']
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
        if ($searchterm != '' && $searchterm !== null) {
            $collection->addFieldToFilter([
                'mp_udata.business_name', 'mp_udata.merchant_name', 'main_table.store_locality_area'],
                [['like' => "%$searchterm%"], ['like' => "%$searchterm%"],
                    ['like' => "%$searchterm%"]]);
        }

        if ($searchCriteria != null) {
            $catFilterId = null;
            $catSellerIds = null;
            $prodFields = [];
            $prodFilterGroup = 0;
            foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
                $prodFilterGroupCount = 0;
                foreach ($filterGroup->getFilters() as $filter) {
                    $filterField = $filter->getField();
                    $filterValue = $filter->getValue();
                    $filterCondition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                    if ($filterField == 'bakery_type' && !$isLateNight && !$isEarlyMorning) {
                        $collection->getSelect()->where('mp_udata.bakery_type=?',
                                $filterValue);
                    }
                    if ($filterField == 'business_name') {
                        $collection->getSelect()->where('mp_udata.business_name LIKE "%'.$filterValue.'%"');
                    }
                    /**
                     * applying delivery filter
                     */
                    if ($filterField == WebapiHelper::FILTER_DELIVERY_CODE) {
                        switch ($filterValue) {
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
                    if ($filterField == WebapiHelper::CATEGORY_FILTER_CODE) {
                        $catFilterId = $filterValue;
                        $catSellerIds = $this->applyCategoryFilterOnBakery($catFilterId);
                        $collection->addFieldToFilter('mp_udata.seller_id', ['in' => $catSellerIds]);
                    }

                    /**
                     * check for late night delivery filter
                     */
                    if ($filterField == WebapiHelper::LATE_NIGHT_DEL_FILTER_CODE) {
                        $timeArr = explode("-", $filterValue);
                        if (isset($timeArr[0]) && isset($timeArr[1])) {
                            $collection->addFieldToFilter('main_table.shop_close_timing', ['eq' => (int)$timeArr[0]]);
                            $collection->addFieldToFilter('main_table.shop_close_AMPM', ['eq' => (int)$timeArr[1]]);
                        }
                    }

                    /**
                     * Check for advance order intimation time filter
                     */
                    if ($filterField == WebapiHelper::ADV_ORDER_INT_TIME_FILTER_CODE) {
                        $prodFields[$prodFilterGroup][$prodFilterGroupCount] = ['attribute' => $filter->getField(), $filterCondition => (int)$filter->getValue()];
                        $prodFilterGroupCount++;
                    }

                    /**
                     * applying offers filter
                     */
                    if ($filterField == WebapiHelper::OFFERS_FILTER)
                    {
                        $todayDate = $this->timezoneInterface->date()->format('Y-m-d');
                        $collection->getSelect()->joinLeft(
                            ['bkw_catalogrule' => $collection->getTable('catalogrule')],
                            'bkw_part_rule.rule_id=bkw_catalogrule.rule_id',
                            ['bkw_catalogrule.from_date as rule_from_date','bkw_catalogrule.to_date as rule_to_date','bkw_catalogrule.is_active as rule_active']
                        );
                        if ($filterValue == 1)
                        {
                            $collection->getSelect()->where('bkw_part_rule.rule_id != ?', null);
                            $collection->getSelect()->where('bkw_catalogrule.is_active = ?', 1);
                            $collection->getSelect()->where('bkw_catalogrule.from_date <= ?', $todayDate);
                            $collection->getSelect()->where('bkw_catalogrule.to_date >= ?', $todayDate);
                        }
                    }
                }
                if (!empty($prodFields)) {
                    $prodFilterGroup++;
                }
            }
            if (!empty($prodFields) && is_array($prodFields)) {
                $sellerIds = $this->applyProductFiltersOnBakery($prodFields);
                if ($catSellerIds !== null) {
                    $sellerIds = array_intersect($sellerIds, $catSellerIds);
                }
                $collection->addFieldToFilter('mp_udata.seller_id', ['in' => $sellerIds]);
            }
        }
        $collection->getSelect()->order('main_table.is_featured DESC');
        $collection->getSelect()->order('distance ASC');
        $collection->getSelect()->order('main_table.number_of_orders DESC');

        $result['page_size'] = $searchCriteria->getPageSize();
        $result['current_page'] = $searchCriteria->getCurrentPage();
        $offset = (($result['current_page']-1)*$result['page_size']);

        $partners = [];
        $i = 0;
        $rulesArr = $this->webapiHelper->getCatalogRuleNames();
        $sellerIdsArray = $collection->getColumnValues('seller_id');
        $sellerUrlArray = $this->productapihelper->getSellerUrlListArray($sellerIdsArray, $cityId);

        $currentDateTime = new \DateTime('now', new \DateTimezone("Asia/Kolkata"));
        $cDate = $currentDateTime->format('Y-m-d');
        $nextDate = date('Y-m-d', strtotime('+1 day', strtotime($cDate)));
        $existingSellerIdsArray = [];

        foreach ($collection as $seller) 
        {
            /*
             * BKWYADMIN-1281 Remove bakery from listing if disabled.
             */
            $temporarilyFrom = date('Y-m-d', strtotime($seller->getData('userdata_shop_temporarily_u_from')));
            $temporarilyTo = date('Y-m-d', strtotime($seller->getData('userdata_shop_temporarily_u_to')));
            if (($temporarilyFrom <= $cDate) && ($cDate <= $temporarilyTo)) 
            {
                continue;
            }
            if (!in_array($seller->getData('seller_id'), $existingSellerIdsArray)) {
                array_push($existingSellerIdsArray, $seller->getData('seller_id'));

                $partners[$i] = $seller->getData();

                if (isset($partners[$i]['average_ratings'])) {
                    if ($partners[$i]['average_ratings'] <= 0) {
                        $partners[$i]['average_ratings'] = null;
                    }
                } else {
                    $partners[$i]['average_ratings'] = null;
                }

                $logo = $seller->getLogoPic() != '' ? $seller->getLogoPic() : "noimage.png";
                $banner = $seller->getBannerPic() != '' ? $seller->getBannerPic() : "banner-image.png";

                /** Adding SEO URL */
                if (isset($sellerUrlArray[$seller->getSellerId()])) {
                    $url = $sellerUrlArray[$seller->getSellerId()];
                } else {
                    $url = null;
                }
                $isConglomerate = $seller->getData('is_conglomerate');
                if ($isConglomerate == 1) {
                    $partners[$i]['seo_url'] = $url . '?store=' . $seller->getData('store_unique_name');
                } else {
                    $partners[$i]['seo_url'] = $url;
                }

                $media = [];
                $media['logo_pic'] = $this->getImageArray($logo);
                //$media['banner_pic'] = $this->getImageArray($banner);
                $partners[$i]['media'] = $media;

                /** adding city value */
                $partners[$i]['store_city'] = $this->bakewayCityHelper->getCityNameById($seller->getStoreCity());
                
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
                $sellerRuleId = $seller->getData('rule_id');
                if (isset($rulesArr[$sellerRuleId])) {
                    $partners[$i]['discount_rule'] = $rulesArr[$sellerRuleId];
                } else {
                    $partners[$i]['discount_rule'] = null;
                }
                /**
                 * return rating
                 */
                /*$sellerAvgRating = $this->reviewratingHelper->getSellerRating($seller->getSellerId());
                $partners[$i]['average_ratings']= $sellerAvgRating;*/

                /**
                 * Adding bakery availability
                 */
                $closedToday = 0;
                $closedTomorrow = 0;
                if (($temporarilyFrom <= $nextDate) && ($nextDate <= $temporarilyTo)) {
                    $closedTomorrow = 1;
                }
                $partners[$i]['closed_today'] = $closedToday;
                $partners[$i]['closed_tomorrow'] = $closedTomorrow;
                $i++;
            }
        }
        $result['total_count'] = count($partners);
        $output = array_slice($partners, $offset, $result['page_size'] );
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
     * Get Autocomplete List.
     *
     * @api
     * @param string|null $city
     * @param string|null $lat
     * @param string|null $long
     * @param string|null $deliverydate
     * @param string|null $searchterm
     * @return array
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function getSearchAutoCompleteList($city = null, $lat = null, $long = null, $deliverydate = null, $searchterm = null) {
        return $this->partnerSearch(
            $city, $lat, $long, $deliverydate, $searchterm, null, true
        );
    }

    /**
     * Get Partner Details.
     * @param int $vendorId
     * @param string|null $store
     * @return array
     */
    public function getPartnerDetails($vendorId, $store=null) {
        $partners = [];
        $grabCount = $grabSellerFlag = $locationId = "";
        $collection = $this->sellerCollection->create()
            ->addFieldToSelect(['entity_id', 'seller_id', 'shop_title', 'bakery_type', 'store_manager_mobile_no', 'store_street_address',
                'shop_url', 'company_description', 'business_name', 'store_city', 'store_locality_area', 'average_ratings', 
                'shop_open_timing', 'shop_open_AMPM','shop_close_timing', 'shop_close_AMPM', 'advanced_order_intimation_time', 'delivery_time', 'known_for',
                'store_highlights', 'is_pickup', 'merchant_name', 'business_name', 'banner_pic', 'logo_pic',
                'meta_keyword', 'meta_description',
                'is_conglomerate', 'categories_available', 
                'userdata_shop_temporarily_u_from', 'userdata_shop_temporarily_u_to',
                'shop_delivery_open_time','shop_delivery_close_time','is_deivery_max_price','delivery','marketing'
            ])
            ->addFieldToFilter('main_table.seller_id', $vendorId);

        $collection->getSelect()->joinLeft(
            ['bkw_part_rule' => $collection->getTable('bakeway_partner_catalogrule')],
            'main_table.seller_id=bkw_part_rule.seller_id',
            ['rule_id']
        );

        /**
         * grab status set enable when its enable for single store
         */
        $grabCount =  $this->grabhelper->getGrabForSellerforAnySingleStore($vendorId);
        if($grabCount > 0){
             $grabSellerFlag = "1";
        }

        /**
         * return rating
         */
        //$sellerAvgRating = $this->reviewratingHelper->getSellerRating($vendorId);
        /**
         * grab global status
         */
        $grabGlobalStatus = $this->grabhelper->getGrabGlobalStatus();
        $currentDateTime = new \DateTime('now', new \DateTimezone("Asia/Kolkata"));
        $cDate = $currentDateTime->format('Y-m-d');
        if (count($collection) > 0) {
            $rulesArr = $this->webapiHelper->getCatalogRuleNames();
            $deliveryTimeInterval = $this->webapiHelper->getDeliveryTimeInterval();
            foreach ($collection as $seller) {
                $partners[0] = $seller->getData();
                $deliveryStatus = $partners[0]["delivery"];
                $isConglomerate = $seller->getData('is_conglomerate');

                /* 
                 * Condition to check 
                 */
                if($isConglomerate && !is_null($store) && trim($store) != '' && !in_array($store,CatalogSeoRepository::ALL_LOC_ARRAY)) : 
                    $deliveryDetails = $this->deliveryrangeHelper->getSellerDeliveryDetails($vendorId, $store);
                else :
                    $deliveryDetails = $this->deliveryrangeHelper->getSellerDeliveryDetails($vendorId);
                endif;

                if(!empty($deliveryDetails))
                {
                    $partners[0]['delivery']                 = $deliveryDetails['delivery'];
                    $deliveryStatus                          = $partners[0]['delivery'];
                    $partners[0]['shop_open_timing']         = $deliveryDetails['shop_open_timing'];
                    $partners[0]['shop_open_AMPM']           = $deliveryDetails['shop_open_AMPM'];
                    $partners[0]['shop_close_timing']        = $deliveryDetails['shop_close_timing'];
                    $partners[0]['shop_close_AMPM']          = $deliveryDetails['shop_close_AMPM'];
                    $partners[0]['shop_delivery_open_time']  = $deliveryDetails['shop_delivery_open_time'];
                    $partners[0]['shop_delivery_close_time'] = $deliveryDetails['shop_delivery_close_time'];
                    $partners[0]['is_deivery_max_price']     = $deliveryDetails['is_deivery_max_price'];
                    
                    /** Setting PickUp Status at Store Level */
                    $partners[0]['is_pickup']                = $deliveryDetails['is_pickup_active'];
                }

                $isConglomerate = $seller->getData('is_conglomerate');
                /** Adding SEO URL */
                $url = $this->productapihelper->getSellerSeoUrl($seller->getSellerId());

                $locationsColl = $this->locationsCollection->create()
                        ->addFieldToSelect(['seller_id', 'store_unique_name', 'store_locality_area', 'store_street_address', 'is_grab_active', 'store_locality_meta_description','is_midnight_active','is_morning_active','midnight_delivery_start_time','midnight_delivery_end_time','morning_delivery_start_time','morning_delivery_end_time', 'store_latitude', 'store_longitude','is_featured'])
                        ->addFieldToFilter('seller_id', $vendorId)
                        ->addFieldToFilter('is_active', 1);
                if ($isConglomerate == 1) 
                {
                    if ($store === null || trim($store) == '') {
                        return [];
                    }
                    else
                    {
                        if (!in_array($store,
                                        CatalogSeoRepository::ALL_LOC_ARRAY)) {
                            $locationsColl->addFieldToFilter('store_unique_name',
                                    $store);
                        }
                        if ($locationsColl->count() > 0) 
                        {
                            $location = $locationsColl->getFirstItem();
                            $locationId = $location->getData('id');
                            $partners[0]['is_midnight_delivery'] = $location->getData('is_midnight_active');
                            $partners[0]['is_earlymorning_delivery'] = $location->getData('is_morning_active');
                            $partners[0]['earlymorning_timings'] = array('start_time' => $location->getData('morning_delivery_start_time'), 'end_time' => $location->getData('morning_delivery_end_time'));
                            $partners[0]['latenight_timings'] = array('start_time' => $location->getData('midnight_delivery_start_time'), 'end_time' => $location->getData('midnight_delivery_end_time'));
                            $partners[0]['store_locality_area'] = $location->getData('store_locality_area');
                            $partners[0]['store_unique_name'] = $location->getData('store_unique_name');
                            $partners[0]['store_street_address'] = $location->getData('store_street_address');
                            $partners[0]['seo_url'] = $url.'?store='.$location->getData('store_unique_name');
                            $partners[0]['is_grab_global']  = $grabGlobalStatus;
                            $partners[0]['is_grab_active'] = $location->getData('is_grab_active');
                            $partners[0]['store_meta_description'] = $location->getData('store_locality_meta_description');
                            $partners[0]['store_latitude'] = $location->getData('store_latitude');
                            $partners[0]['store_longitude'] = $location->getData('store_longitude');
                        } else {
                            return [];
                        }
                    }
                }
                else 
                {
                    if ($store !== null || trim($store) != '') {
                        return [];
                    }
                    if ($locationsColl->count() > 0) 
                    {
                        $location = $locationsColl->getFirstItem();
                        $locationId = $location->getData('id');
                        $partners[0]['is_midnight_delivery'] = $location->getData('is_midnight_active');
                        $partners[0]['is_earlymorning_delivery'] = $location->getData('is_morning_active');
                        $partners[0]['earlymorning_timings'] = array('start_time' => $location->getData('morning_delivery_start_time'), 'end_time' => $location->getData('morning_delivery_end_time'));
                        $partners[0]['latenight_timings'] = array('start_time' => $location->getData('midnight_delivery_start_time'), 'end_time' => $location->getData('midnight_delivery_end_time'));
                        $partners[0]['store_locality_area'] = $location->getData('store_locality_area');
                        $partners[0]['store_unique_name'] = $location->getData('store_unique_name');
                        $partners[0]['store_street_address'] = $location->getData('store_street_address');
                        $partners[0]['is_grab_global']  = $grabGlobalStatus;
                        $partners[0]['is_grab_active'] = $location->getData('is_grab_active');
                        $partners[0]['store_meta_description'] = $location->getData('store_locality_meta_description');
                        $partners[0]['store_latitude'] = $location->getData('store_latitude');
                        $partners[0]['store_longitude'] = $location->getData('store_longitude');
                    }
                    $partners[0]['seo_url'] = $url;
                }

                 //==BKWYADMIN-1206 : setting is_feature status =========//
                    $partners[0]['is_featured'] = $location->getData('is_featured');

                if(!$partners[0]['is_grab_active'] && !$deliveryStatus)
                    $partners[0]["delivery"] = 0;

                if(isset($grabSellerFlag)){
                    $partners[0]['is_grab_status']= $grabSellerFlag;
                }

                if (isset($partners[0]['average_ratings'])) {
                    if ($partners[0]['average_ratings'] <= 0) {
                        $partners[0]['average_ratings'] = null;
                    }
                } else {
                    $partners[0]['average_ratings'] = null;
                }
                $partners[0]['categories'] = $this->productapihelper->getMainandAddoncategory();
                $logo = $seller->getLogoPic() != '' ? $seller->getLogoPic() : "noimage.png";
                $banner = $seller->getBannerPic() != '' ? $seller->getBannerPic() : "banner-image.png";
                $media = [];
                $media['logo_pic'] = $this->getImageArray($logo);
                $media['banner_pic'] = $this->getImageArray($banner);
                $partners[0]['media'] = $media;
                
                /**
                 * store enable categories
                 */
                $partners[0]['active_categories'] = $this->getSellerStoreCategories($locationId, $vendorId);
                /** adding city value */
                $partners[0]['store_city'] = $this->bakewayCityHelper->getCityNameById($seller->getStoreCity());

                /** Adding delivery time interval */
                $partners[0]['delivery_time_interval'] = $deliveryTimeInterval;

                /** Adding discount name */
                $sellerRuleId = $seller->getData('rule_id');
                if (isset($rulesArr[$sellerRuleId])) {
                    $partners[0]['discount_rule'] = $rulesArr[$sellerRuleId];
                } else {
                    $partners[0]['discount_rule'] = null;
                }

                /**
                 * Adding closed dates range for bakery
                 */
                $temporarilyFrom = date('Y-m-d', strtotime($seller->getData('userdata_shop_temporarily_u_from')));
                $temporarilyTo = date('Y-m-d', strtotime($seller->getData('userdata_shop_temporarily_u_to')));
                if ((($cDate <= $temporarilyFrom) || ($cDate <= $temporarilyTo)) &&
                    ($temporarilyFrom <= $temporarilyTo)) {
                    $partners[0]['closed_from'] = $temporarilyFrom;
                    $partners[0]['closed_to'] = $temporarilyTo;
                } else {
                    $partners[0]['closed_from'] = null;
                    $partners[0]['closed_to'] = null;
                }

            }
            return json_decode(json_encode($partners[0], false));
        } else {

            $partners = array("error" => 'no data found');
            return $partners;
        }
    }

    /**
     * Get Partner Filters
     * @return array
     */
    public function getPartnerFilters() {
        $result = $this->webapiHelper->getProductAttributeFilters(self::PRODUCT_ATTR);
        $deliveryFilter = $this->webapiHelper->getBakeryDeliveryFilter();
        $bakeryTypeFilter = $this->webapiHelper->getBakeryTypeFilter();
        $bakeryCategoryFilter = $this->webapiHelper->getBakeryCategoryFilter();
        $intimationTimeFilter = $this->prodApiFilterHelper->getAdvanceOrderIntimationFilter();
        $lateNightDeliveryFilter = $this->webapiHelper->getLateNightDeliveryFilter();
        array_push($result, $deliveryFilter);
        array_push($result, $bakeryTypeFilter);
        array_push($result, $bakeryCategoryFilter);
        array_push($result, $intimationTimeFilter);
        array_push($result, $lateNightDeliveryFilter);
        $this->_eventManager->dispatch('partner_filter_load_after',['filters'=>$result]);
        return json_decode(json_encode($result, false));
    }

    /**
     * Get Product Filters
     * @return array
     */
    public function getProductFilters() {
        $result = $this->webapiHelper->getProductAttributeFilters(self::PRODUCT_ATTR_PRODUCT_LISTING_FILTER);
        return json_decode(json_encode($result, false));
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
       
    /**
     * enable store categories of seller
     * @param type $sellerId
     * @param type $storeId
     */
    public function getSellerStoreCategories($storeId, $sellerId)
    {
         $catCatcollection = $this->storeCatalogHelper->getSellerStoreActiveCategories($storeId, $sellerId);

         if(count($catCatcollection) > 0 ){
           return $catCatcollection;    
         }
         else{
          return null;
         }
       
    }
}