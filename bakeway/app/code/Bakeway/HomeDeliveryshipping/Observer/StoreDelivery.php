<?php

/**
 * Copyright © 2015 Bakeway. All rights reserved.
 */

namespace Bakeway\HomeDeliveryshipping\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Bakeway\Partnerlocations\Model\ResourceModel\Partnerlocations\CollectionFactory as LocationsCollection;
use Bakeway\GrabIntigration\Helper\Data as Grabhelper;
use Magento\Checkout\Block\Cart\Item\Renderer as Renderer;
use Magento\Catalog\Api\ProductRepositoryInterface as ProductRepositoryInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Bakeway\Deliveryrangeprice\Helper\Data as DeliveryrangeHelper;
use Magento\Framework\Event\Manager as Eventmanager;
use Magento\Quote\Model\QuoteRepository as QuoteRepository;
use \Bakeway\HomeDeliveryshipping\Observer\Homedelivery;
use \Bakeway\ProductApi\Model\CatalogSeoRepository as CatalogSeoRepository;
use \Bakeway\StoreCatalog\Helper\Data as StoreCatalogHelper;

class StoreDelivery implements ObserverInterface {

    CONST DELIVERY_STORE_RADIOUS = 10;
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var registry
     */
    protected $_registry;

    /**
     * @var \Magento\Quote\Model\Quote\Address\TotalFactory
     */
    protected $totalFactory;

    /**
     * @param   \Bakeway\HomeDeliveryshipping\Model\Carrier
     */
    protected $carrier;

    /**
     * @param   \Magento\Quote\Model\Quote\Address\RateResult
     */
    protected $MethodFactory;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var \Bakeway\HomeDeliveryshipping\Helper\Data
     */
    protected $_homedeliveryhelper;

    /**
     * @var \Bakeway\Deliveryrangeprice\Model\RangepriceFactory
     */
    protected $rangepriceFactory;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;

    /**
     * @var LocationsCollection
     */
    protected $locationsCollection;
    /**
     * @var Grabhelper
     */
    protected $grabhelper;
    /**
     * @var Renderer
     */
    protected $rendererhelper;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepositoryInterface;
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productobj;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepositoryInterface;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var CatalogSeoRepository
     */
    protected $catalogSeoRepository;

    /**
     * Delivery Type helper
     * @var \Bakeway\StoreCatalog\Helper\Data 
     */
    protected $storeCatalogHelper;

    /**
     * StoreDelivery constructor.
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Quote\Model\Quote\Address\TotalFactory $totalFactory
     * @param \Bakeway\HomeDeliveryshipping\Model\Carrier $carrier
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $method
     * @param PriceCurrencyInterface $priceCurrency
     * @param \Bakeway\HomeDeliveryshipping\Helper\Data $datahelper
     * @param \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory
     * @param MarketplaceHelper $marketplaceHelper
     * @param LocationsCollection $locationsCollection
     * @param Grabhelper $grabhelper
     * @param Renderer $rendererhelper
     * @param ProductRepositoryInterface $productRepositoryInterface
     * @param \Magento\Catalog\Model\ProductFactory $productobj
     * @param CategoryRepositoryInterface $categoryRepositoryInterface
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param DeliveryrangeHelper $deliveryrangeHelper
     * @param Eventmanager $eventmanager
     * @param QuoteRepository $quoteRepository
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Registry $registry,
        \Magento\Quote\Model\Quote\Address\TotalFactory $totalFactory,
        \Bakeway\HomeDeliveryshipping\Model\Carrier $carrier,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $method,
        PriceCurrencyInterface $priceCurrency,
        \Bakeway\HomeDeliveryshipping\Helper\Data $datahelper,
        \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory,
        MarketplaceHelper $marketplaceHelper,
        LocationsCollection $locationsCollection,
        Grabhelper $grabhelper,
        Renderer $rendererhelper,
        ProductRepositoryInterface $productRepositoryInterface,
        \Magento\Catalog\Model\ProductFactory $productobj,
        CategoryRepositoryInterface $categoryRepositoryInterface,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        DeliveryrangeHelper $deliveryrangeHelper,
        Eventmanager $eventmanager,
        QuoteRepository $quoteRepository,
        CatalogSeoRepository $catalogSeoRepository,
        StoreCatalogHelper $storeCatalogHelper
    ) {
        $this->_objectManager = $objectManager;
        $this->_registry = $registry;
        $this->totalFactory = $totalFactory;
        $this->carrier = $carrier;
        $this->MethodFactory = $method;
        $this->priceCurrency = $priceCurrency;
        $this->_homedeliveryhelper = $datahelper;
        $this->rangepriceFactory = $rangepriceFactory;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->locationsCollection = $locationsCollection;
        $this->grabhelper = $grabhelper;
        $this->rendererhelper = $rendererhelper;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->productobj = $productobj;
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
        $this->scopeConfig = $scopeConfig;
        $this->deliveryrangeHelper = $deliveryrangeHelper;
        $this->eventmanager = $eventmanager;
        $this->quoteRepository = $quoteRepository;
        $this->catalogSeoRepository =$catalogSeoRepository;
        $this->storeCatalogHelper = $storeCatalogHelper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @throws LocalizedException
     */
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/shipping_log.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('------------------shipping store observer process get started---------------');
        $storeShippiingEventData = $observer->getData("store-shipping");

        $grabDelivery = $storeShippiingEventData['grab'];

        if(isset($storeShippiingEventData['sellerid']) && !empty($storeShippiingEventData['sellerid'])
            && isset($storeShippiingEventData['customerlat']) && !empty($storeShippiingEventData['customerlat'])
        && isset($storeShippiingEventData['customerlong']) && !empty($storeShippiingEventData['customerlong'])
        && isset($storeShippiingEventData['savedStorename']) && !empty($storeShippiingEventData['savedStorename']))
        {
            $latitudeCust = $storeShippiingEventData['customerlat'];
            $longitudeCust = $storeShippiingEventData['customerlong'];
            $sellerId = $storeShippiingEventData['sellerid'];
            $savedStorename = $storeShippiingEventData['savedStorename'];
            $prodsToCheck = $storeShippiingEventData['prdId'];
            $logger->info('----------old saved store name for quote id '.$storeShippiingEventData['quote']." is ".$savedStorename);
            $logger->info('----------Product Id for the quote '.$storeShippiingEventData['quote'].' is '.implode(",",$prodsToCheck));
            $matrixApikey =   $this->_homedeliveryhelper->getKey('delivery_fee/delivery_fee/google_api_key');
            if(empty($matrixApikey)){
                $this->grabhelper->getBadrequestExpection('Matrix Api key is undefinded.','API_KEY_NOT_AVAILABLE');
            }

            /**
             * filter condition in case of grab enabled stores
             * todo this may be change
             */
            $sellercityName = "";
            $sellercityName = $this->_homedeliveryhelper->getSellerCityNameFromCityId($sellerId);
            
            /*
             * BKWYADMIN-1265
             * Commented condition which checks if the store
             */
            $storeDistance = $this->catalogSeoRepository->getStoreDetails($sellerId, $sellercityName, $latitudeCust, $longitudeCust, null,false, self::DELIVERY_STORE_RADIOUS,1);
            $sortedStorenameArray= [];
            foreach($storeDistance as $storeDistanceItem){
                $sortedStorenameArray[] = $storeDistanceItem['store_unique_name'];
            }
            if($grabDelivery === true)
            {
                $sellerLocationCollection = $this->locationsCollection->create()
                    ->addFieldToFilter("seller_id",["eq"=>$sellerId])
                    ->addFieldToFilter("is_active",["eq"=>"1"])
                    ->addFieldToFilter("store_unique_name",["neq"=>$savedStorename])
                    ->addFieldToSelect(["store_latitude","store_longitude","store_unique_name"])
                    ->addFieldToFilter("is_grab_active",["eq"=>"1"]);
            }
            else
            {
                $sellerLocationCollection = $this->locationsCollection->create()
                    ->addFieldToSelect(["store_latitude","store_longitude","store_unique_name"])
                    ->addFieldToFilter("seller_id",["eq"=>$sellerId])
                    ->addFieldToFilter("is_active",["eq"=>"1"])
                    ->addFieldToFilter("store_unique_name",["neq"=>$savedStorename])
                    ->addFieldToFilter("is_delivery_active",["eq"=>"1"])
                    ->addFieldToFilter("is_grab_active",["eq"=>"0"]);
            }
            
            /**
             * check if seller has only one store enable but which is not applicable
             */
            if(count($sellerLocationCollection) < 1){
                $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
            }


            $locationDistanceArray = [];
            foreach($sellerLocationCollection as $key=>$sellerLocationData){

            if (in_array($sellerLocationData['store_unique_name'], $sortedStorenameArray)) {
                $latitudeSeller = $sellerLocationData['store_latitude'];
                $longitudeSeller = $sellerLocationData['store_longitude'];
                $nearStoredistance = $this->_homedeliveryhelper->getDistance($latitudeCust, $longitudeCust, $latitudeSeller, $longitudeSeller, $matrixApikey);
                $locationDistanceArray[$sellerLocationData['store_unique_name']] = $nearStoredistance;
                $logger->info($storeShippiingEventData['quote'] ." and distance is ".$nearStoredistance." ".$sellerLocationData['store_unique_name']." lat ".$latitudeSeller ." and longi ".$longitudeSeller);

             }
            }
            
         
            $isPrdAvailable = "";
            $minDistance = $minDistanceStore = "";
            $allNearestStores = $locationDistanceArray;
            asort($allNearestStores);
            $rangeExist = false;
            
            foreach ($allNearestStores as $minDistanceStore => $minDistance) 
            { 
                $logger->info($storeShippiingEventData['quote']." --min distance is ".$minDistance." related store name is ".$minDistanceStore);
                if(empty($minDistanceStore)){
                    $this->grabhelper->getBadrequestExpection('Store Unique Name is undefinded.','STORE_UNIQUE_NAME_NOT_AVAILABLE');
                }
                
                $isPrdAvailable = $this->storeCatalogHelper->checkProdAvailibiltyShipping($sellerId,$minDistanceStore,$prodsToCheck);
                if($isPrdAvailable === true){
                    $logger->info('---------- Product is disable for '.$minDistanceStore.' & distance is: '.$minDistance.' kms ----------');
                }
                
                if($isPrdAvailable === false)
                {
                    $logger->info('---------- Product is enable for '.$minDistanceStore.' & distance is: '.$minDistance.' kms ----------');
                    if($grabDelivery !== true)
                    {
                        if(!is_null($minDistanceStore) && !in_array($minDistanceStore,CatalogSeoRepository::ALL_LOC_ARRAY))
                            $rangeExist = $this->checkMaxSellerStoreRange($sellerId, $minDistance, $minDistanceStore);
                        else
                            $rangeExist = $this->checkMaxSellerStoreRange($sellerId, $minDistance);

                        $logger->info('---- Does Range exists for '.$minDistanceStore.'? '.(bool)$rangeExist.' ----');
                        if(isset($rangeExist) && !empty($rangeExist) && $rangeExist !== "nan")
                        {
                            $rangeExist = true;
                            break;
                        }
                    }
                    else
                        break;
                }
            
                continue;   
             }
            
            if($isPrdAvailable === true)
            {
                $this->grabhelper->getBadrequestExpection('Product is not avalaible for the selected Address','PRODUCT_NOT_AVAILABLE');                
            }
            if($grabDelivery !== true && $rangeExist !== true)
            {
                $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
            }

            
            $this->_registry->unregister('min_location_distance');
            $this->_registry->unregister('min_location_store');


            /*
             * Commented Older function as it was calculating the price instead of the Max Range
             */
            /*if(!is_null($minDistanceStore) && !in_array($minDistanceStore,CatalogSeoRepository::ALL_LOC_ARRAY))
                $rangeExist = $this->getSellerRange($sellerId, $minDistance, $storeShippiingEventData['quote'], $minDistanceStore);
            else
                $rangeExist = $this->getSellerRange($sellerId, $minDistance, $storeShippiingEventData['quote']);*/


            if($grabDelivery === true){
                $rangeExist = false;
            }

            /**
             * get upper delivery limit of grab
             */
            $grabUpperKmLimit  = $this->grabhelper->getGrabUpperLimitinKms();
            $grabIn = false;

            if(isset($minDistanceStore))
            {
                $quoteId = $storeShippiingEventData['quote'];
                $quoteObj = $this->quoteRepository->getActive($quoteId);
                $quoteObj->setData("store_unique_name",$minDistanceStore);

                try{
                    if($grabDelivery === true)
                    {
                      if($minDistance <= $grabUpperKmLimit)
                      {
                            $grabIn = true;
                      }
                    }
                    if($grabIn === true)
                    {
                        $quoteObj->save();
                        if(!empty($this->_registry->register('min_location_distance',  $minDistance)))
                        {
                            $this->_registry->register('min_location_distance', $minDistance);
                            $logger->info($storeShippiingEventData['quote'].' ----------grab : store distance for quote id '.$storeShippiingEventData['quote']." is assigned to registry");
                        }
                        $logger->info($storeShippiingEventData['quote'].' ----------grab : new store has assgined to quote id '.$storeShippiingEventData['quote']." is ".$minDistanceStore);
                    }

                    if($rangeExist === true){
                        //$quoteObj->save();
                        if(isset($minDistance) && $minDistance !== 'nan'){
                            $this->_registry->register('min_location_distance', $minDistance);
                            $this->_registry->register('min_location_store', $minDistanceStore);
                            $logger->info($storeShippiingEventData['quote']. ' ----------normal deliery: store distance for quote id '.$storeShippiingEventData['quote']." is assigned to registry");
                          }
                        $logger->info($storeShippiingEventData['quote'] .' ----------normal deliery : new store has assgined to quote id '.$storeShippiingEventData['quote']." is ".$minDistanceStore);
                    }




                }catch (Exception $e){
                    $this->grabhelper->getBadrequestExpection($e->getMessage(),'PARAMETERS_NOT_AVAILABLE');
                }
            }
            return;

        }else{
            $this->grabhelper->getBadrequestExpection('Parameters are not avalaible.','PARAMETERS_NOT_AVAILABLE');

        }


        $logger->info($storeShippiingEventData['quote']. '-------------------shipping store observer process get completed---------------------');
    }

    /**
     * Function to check if the seller delivers to the range of the destination
     * @param type $sellerId
     * @param type $storeUqName
     * @param type $_distance
     * @return bool
     */
    public function checkMaxSellerStoreRange($_sellerid,$_distance,$storeUniqueName = null) 
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/shipping_log.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $logger->info('---------------------------------------------------------------------------------');
        $logger->info('StoreDelivery File: Inside Congolmerate Observer to check the range of the seller for storewise seller rule');
        $logger->info('---------------------------------------------------------------------------------');

        $_Maxdistance = array();
        $_collection = $this->rangepriceFactory->create()->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('delivery_deleted', 0)
            ->addFieldToFilter('seller_id', $_sellerid);

        if (!is_null($storeUniqueName) || $storeUniqueName != "")
        {
            $logger->info('---- StoreDelivery File: Added Store Filter Check to check Max Seller Store Range -----');
            $storeId = $this->deliveryrangeHelper->getStoreIdFromStoreUniqueName($_sellerid, $storeUniqueName);
            $_collection->addFieldToFilter('store_id', $storeId);
            $logger->info('---- StoreDelivery File: Inside Storewise Collection Check, Collection Count Check: '.count($_collection));
        }

        if($_collection->count() <= 0)
        {
            $logger->info('---- StoreDelivery File: Use Default Collection Per Seller when Per Store isnt available ----');
            return false;
        }
        else
        {
            foreach ($_collection as $_rangedata) {
                $_Maxdistance[] = $_rangedata['to_kms'];
            }
            if (!empty($_Maxdistance)) :
                $maxFromArray = max($_Maxdistance);
                $maxDeliveryKms = $maxFromArray + Homedelivery::DELIVERYEXTRAKM;
                if ($maxDeliveryKms >= $_distance) {
                    return true;
                } else {
                    return false;
                }
            else:
                return false;
            endif;            
        }
    }


}
