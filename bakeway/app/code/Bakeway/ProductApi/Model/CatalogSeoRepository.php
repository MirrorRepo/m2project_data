<?php
/**
 * Bakeway
 *
 * @category  Bakeway
 * @package   Bakeway_ProductApi
 * @author    Bakeway
 */
namespace Bakeway\ProductApi\Model;

use Bakeway\ProductApi\Api\CatalogSeoRepositoryInterface;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\Catalog\Model\ProductFactory;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Bakeway\Cities\Helper\Data as CitiesHelper;
use Bakeway\PartnerWebapi\Model\SearchPartnerRepository as PartnerListModel;
use \Magento\Framework\Exception\NotFoundException;
use \Magento\Framework\Exception\NoSuchEntityException;
use \Magento\Framework\Exception\LocalizedException;
use Bakeway\Partnerlocations\Model\ResourceModel\Partnerlocations\CollectionFactory as PartnerLocationsFactory;
use Bakeway\HomeDeliveryshipping\Observer\StoreDelivery;
use Bakeway\GrabIntigration\Helper\Data as Grabhelper;
use Bakeway\StoreCatalog\Helper\Data as StoreCatalogHelper;


class CatalogSeoRepository implements CatalogSeoRepositoryInterface
{
    const ALL_LOC_ARRAY = ['all-pune', 'all-bangalore', 'all-hyderabad'];

    /**
     * @var UrlRewriteFactory
     */
    protected $urlRewrite;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;

    /**
     * @var ProductFactory
     */
    protected $catalogProductModel;

    /**
     * @var PartnerLocationsFactory
     */
    protected $partnerLocations;

    protected $citiesHelper;

    /**
     * @var Grabhelper
     */
    protected $grabhelper;
    
    /**
     * @var StoreCatalogHelper 
     */
    protected $storeCatalogHelper;

    /**
     * CatalogSeoRepository constructor.
     * @param UrlRewriteFactory $urlRewrite
     * @param MarketplaceHelper $marketplaceHelper
     * @param ProductFactory $catalogProductModel
     * @param PartnerLocationsFactory $partnerLocations
     * @param CitiesHelper $citiesHelper
     * @param Grabhelper $grabhelper
     */
    public function __construct(
        UrlRewriteFactory $urlRewrite,
        MarketplaceHelper $marketplaceHelper,
        ProductFactory $catalogProductModel,
        PartnerLocationsFactory $partnerLocations,
        CitiesHelper $citiesHelper,
        Grabhelper $grabhelper,
        StoreCatalogHelper $storeCatalogHelper
    ) {
        $this->urlRewrite = $urlRewrite;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->catalogProductModel = $catalogProductModel;
        $this->partnerLocations = $partnerLocations;
        $this->citiesHelper = $citiesHelper;
        $this->grabhelper = $grabhelper;
        $this->storeCatalogHelper = $storeCatalogHelper;
    }

    /**
     * Get Url Details
     * @param string $url
     * @param string|null $store
     * @return array
     * @throws NotFoundException
     * @throws NoSuchEntityException
     */
    public function getUrlDetails($url, $store = null) {
        $result = [];
        $collection = $this->urlRewrite->create()
            ->getCollection()
            ->addFieldToFilter('request_path', strtolower($url))
            ->addFieldToFilter('target_path', strtolower($url));
        foreach ($collection as $entity) {
            if ($entity->getEntityType() == 'bakeway-product') {
                $details = $this->getSellerProductDetails($entity->getEntityId());
                if (isset($details['partner_id'])) {
                    $result['partner_id'] = $details['partner_id'];
                }
                if (isset($details['product_id'])) {
                    $result['product_id'] = $details['product_id'];
                }
                if (isset($details['sku'])) {
                    $result['sku'] = $details['sku'];
                }
            } elseif ($entity->getEntityType() == 'customer') {
                $details = $this->getSellerDetails($entity->getEntityId());
                if (isset($details['partner_id'])) {
                    $result['partner_id'] = $details['partner_id'];
                }
            }
        }
        if (isset($result['partner_id'])) {
            $isConglomerate = $this->marketplaceHelper->isConglomerate($result['partner_id']);
            if ($isConglomerate === true) {
                if ($store == null || trim($store) == '') {
                    throw new NoSuchEntityException(__('Requested url does not match any route.'));
                }
                $locations = $this->partnerLocations->create()
                    ->addFieldToFilter('seller_id', $result['partner_id']);

                if (in_array($store, self::ALL_LOC_ARRAY)) {
                    $storeArr = explode("-", $store);
                    if (isset($storeArr[1])) {
                        $cityId = $this->citiesHelper->getCityIdByName($storeArr[1]);
                        $locations->addFieldToFilter('city_id', $cityId);
                    }
                } else {
                    $locations->addFieldToFilter('store_unique_name', $store);
                }

                if ($locations->count() <= 0) {
                    throw new NoSuchEntityException(__('Requested url does not match any route.'));
                }
            } else {
                if ($store !== null || trim($store) != '') {
                    throw new NoSuchEntityException(__('Requested url does not match any route.'));
                }
            }

        } else {
            throw new NoSuchEntityException(__('Requested url does not match any route.'));
        }
        if (empty($result)) {
            throw new NoSuchEntityException(__('Requested url does not match any route.'));
        }
        return json_decode(json_encode($result, false));
        //return $result;
    }

    /**
     * @param int $sellerId
     * @return mixed
     */
    public function getSellerDetails($sellerId) {
        $result = [];
        $seller = $this->marketplaceHelper->getSellerDataBySellerId($sellerId)->getFirstItem();
        $sellerId = $seller->getData('seller_id');
        if (isset($sellerId)) {
            $result['partner_id'] = $sellerId;
        }
        return $result;
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function getSellerProductDetails($productId) {
        $result = [];
        $marketplaceProduct = $this->marketplaceHelper->getSellerProductDataByProductId($productId)->getFirstItem();
        $mageProductId = $marketplaceProduct->getData('mageproduct_id');
        if (isset($mageProductId)) {
            $product = $this->catalogProductModel->create()
                ->load($mageProductId);
            $result['sku'] = $product->getData('sku');
            $result['partner_id'] = $marketplaceProduct->getData('seller_id');
            $result['product_id'] = $mageProductId;
        }
        return $result;
    }

    /**
     * Get Seller Store Details
     * @param int $vendorId
     * @param string $city
     * @param string $lat
     * @param string $long
     * @param string|null $sku
     * @param bool|false $single
     * @param int|null $deliveryStoreradious
     * @param int|null $includePickup
     * @return array
     * @throws NotFoundException
     * @throws LocalizedException
     */
    public function getStoreDetails($vendorId, $city, $lat, $long, $sku = null, $single = false ,$deliveryStoreradious = null, $includePickup = null)
    {
        /*
         * BKWYADMIN-1232
         * Commented code as we need this API for all bakeries, standalone as well as conglomerate

            $isConglomerate = $this->marketplaceHelper->isConglomerate($vendorId);
            if ($isConglomerate === false) {
                throw new NotFoundException(__('Requested seller not found in conglomerate database'));
            }
        */
        $cityId = $this->citiesHelper->getCityIdByName($city);

        if ($cityId === false) 
        {
            throw new NotFoundException(__('Requested city not found in database'));
        }

        $locations = $this->partnerLocations->create();
        $locations->addFieldToSelect(['seller_id','store_unique_name','store_locality_area','store_street_address']);
        $locations->addFieldToFilter('store_city', $cityId);
        $locations->addFieldToFilter('main_table.seller_id', $vendorId);
        $locations->addFieldToFilter('is_active', 1);
        if (!$single && is_null($includePickup))
            $locations->addFieldToFilter('is_pickup_active', 1);
        
        /**
         * Joining bakeway_sub_locations Table (SUB-HUB)
         */
        $locations->getSelect()->joinLeft(
            ['sub_loc' => $locations->getTable('bakeway_sub_locations')],
            'main_table.sub_loc_id=sub_loc.id',
            ['area_name']
        );

        /**
         * Joining bakeway_sub_locations Table (SUB-HUB)
         */
        $locations->getSelect()->joinLeft(
            ['mp_udata' => $locations->getTable('marketplace_userdata')],
            'main_table.seller_id=mp_udata.seller_id',
            ['business_name']
        );

        $searchRadiousValue = PartnerListModel::SEARCH_RADIUS;
        if(isset($deliveryStoreradious) && !empty($deliveryStoreradious))
        {
            $searchRadiousValue = StoreDelivery::DELIVERY_STORE_RADIOUS;
        }

        if ($lat != '' && $long != '')
        {
            $locations->getSelect()->columns(
                [
                    'distance' => new \Zend_Db_Expr("ST_Distance_Sphere(POINT(" . $long . ", " . $lat . "), sub_loc_geo_point)/1000")
                ]);
            $locations->setOrder('distance', 'ASC');
            $locations->getSelect()->having('distance<=?', $searchRadiousValue);

        }

        if(isset($deliveryStoreradious) && !empty($deliveryStoreradious))
        {
            if ($locations->count() <= 0)
            {
                $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
            }
        }

        if ($locations->count() <= 0) 
        {
            $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
        }

        if ($single === true)
        {
            $productId = "";
            $firstStore = $locations->getFirstItem()->getData('id');

            if(isset($sku) && !empty($sku))
            {
                if($this->catalogProductModel->create()->loadByAttribute("sku",$sku))
                {
                  $product = $this->catalogProductModel->create()->loadByAttribute("sku",$sku);
                  $productId = $product->getData('entity_id');
                }
                else
                {
                    $this->grabhelper->getFourNotFoundExpection("Requested product sku is not available in system.","PRODUCT_SKU_IS_NOT_FIND");
                }
                $storeCatalougeStatus = $this->storeCatalogHelper->getSellerStoreProduct($firstStore, $vendorId, false, false, $productId);

                if (!empty($storeCatalougeStatus->getData('entity_id')))
                {
                    $this->grabhelper->getFourNotFoundExpection("Requested product is disabled in system.","PRODUCT_IS_DISABLED");
                }
            }
            return [$locations->getFirstItem()->getData()];
        }
       
        if(isset($sku) && !empty($sku))
        {
            $productId = "";
            if($this->catalogProductModel->create()->loadByAttribute("sku",$sku))
            {
              $product = $this->catalogProductModel->create()->loadByAttribute("sku",$sku);
              $productId = $product->getData('entity_id');
            }
            else
            {
               throw new LocalizedException(__('Requested product sku is not available in system.'));
            }

            $storeCatalougeStatus = $this->storeCatalogHelper->getPickupAvaiableStores($vendorId, $locations->getData(), $productId);
             
            if(count($storeCatalougeStatus) > 0)
            {
                if(count($locations->getData()) > 0)
                {
                    $locations->addFieldToFilter("main_table.id",["nin" => $storeCatalougeStatus])
                              ->addFieldToSelect('*')
                              ->load();
                    $storesdata = [];
                    $i = 0;
                    foreach($locations as $data)
                    {
                        if(!in_array($data['id'],$storeCatalougeStatus))
                        {
                            $storesdata[$i]['id'] = $data['id'];
                            $storesdata[$i]['seller_id'] = $data['seller_id'];
                            $storesdata[$i]['store_unique_name'] = $data['store_unique_name'];
                            $storesdata[$i]['store_locality_area'] = $data['store_locality_area'];
                            $storesdata[$i]['store_street_address'] = $data['store_street_address'];
                            $storesdata[$i]['area_name'] = $data['area_name'];
                            $storesdata[$i]['business_name'] = $data['business_name'];
                            $i++;
                        }
                    }
                    return json_decode(json_encode($storesdata),false);
                }
            }
        }
        
        if(isset($deliveryStoreradious) && !empty($deliveryStoreradious))
        {
           $locations->getSelect()->limit(3);
           return $locations->getData();
        }
        return $locations->getData();
    }
}