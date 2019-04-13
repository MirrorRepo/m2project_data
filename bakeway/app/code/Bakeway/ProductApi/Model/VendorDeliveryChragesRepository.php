<?php

/**
 * Bakeway
 *
 * @category  Bakeway
 * @package   Bakeway_ProductApi
 * @author    Bakeway
 */

namespace Bakeway\ProductApi\Model;

use Bakeway\ProductApi\Api\VendorDeliveryChragesRepositoryInterface;
use \Magento\Framework\Exception\NotFoundException;
use Bakeway\HomeDeliveryshipping\Helper\Data as HomedeliveryHelper;
use Bakeway\GrabIntigration\Helper\Data as grabHelper;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Bakeway\Partnerlocations\Model\ResourceModel\Partnerlocations\CollectionFactory as LocationsCollection;
use Bakeway\Deliveryrangeprice\Helper\Data as  DeliveryrangepriceHelper;
use Bakeway\ProductApi\Helper\Data as  ProductapiHelper;
use Bakeway\ProductApi\Model\CatalogSeoRepository;

class VendorDeliveryChragesRepository implements VendorDeliveryChragesRepositoryInterface {
    CONST DELIVERYEXTRAKM = "0.5";
    CONST GRAB_START_DELIVERY_DISTANCE = "4"; //in km
    CONST WEIGHT_ATTRIBUTE_NAME = 'cake_weight';

    /*
     * @param \Bakeway\Deliveryrangeprice\Helper\Data 
     */

    protected $deliveryrangepricehelper;

    /**
     * @var HomedeliveryHelper
     */
    protected $homedeliveryHelper;

    /**
     * @var grabHelper
     */
    protected $grabHelper;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productobj;
    /**
     * @var DeliveryrangepriceHelper
     */
    protected $deliveryrangepriceHelper;
    /**
     * @var ProductapiHelper
     */
    protected $productapiHelper;

    /**
     *
     * @var Bakeway\Partnerlocations\Model\ResourceModel\Partnerlocations\CollectionFactory 
     */
    protected $locationsCollection;

    /**
     * VendorDeliveryChragesRepository constructor.
     * @param \Bakeway\Deliveryrangeprice\Helper\Data $deliveryrangepricehelper
     * @param HomedeliveryHelper $homedeliveryHelper
     * @param grabHelper $grabHelper
     * @param MarketplaceHelper $marketplaceHelper
     */
    public function __construct(
        \Bakeway\Deliveryrangeprice\Helper\Data $deliveryrangepricehelper,
        HomedeliveryHelper $homedeliveryHelper,
        grabHelper $grabHelper,
        MarketplaceHelper $marketplaceHelper,
        LocationsCollection $locationsCollection,
        \Magento\Catalog\Model\ProductFactory $productobj,
        ProductapiHelper $productapiHelper
    )
    {
        $this->deliveryrangepricehelper = $deliveryrangepricehelper;
        $this->homedeliveryHelper = $homedeliveryHelper;
        $this->grabHelper = $grabHelper;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->locationsCollection = $locationsCollection;
        $this->productobj = $productobj;
        $this->productapihelper = $productapiHelper;
    }

    /**
     * Get Vendor Delivery Charges Details
     * @param int $vendorId
     * @param string $storeName
     * @return array
     * @return empty []
     */
    public function getDeliverycharges($vendorId ,$storeName = null) 
    {
        $deliveryCharges = [];

        if(empty($vendorId))
        {
            throw new NotFoundException(__("Vendor id is missing."));
        }

        /**
         * check bakery type and global check
         */
        $homebakerGlobalStatus =  $this->homedeliveryHelper->getHomeBakersFreeShippingStatus();
        $bakeryType = $this->homedeliveryHelper->getBakeryType($vendorId);
        $grabGlobalStatus = $this->grabHelper->getGrabGlobalStatus();

        $grabSellerStatus = $this->grabHelper->getNonxonglomerateSellerGrabStatus($vendorId);
        $isConglomerate = $this->marketplaceHelper->isConglomerate($vendorId);

        if($isConglomerate && !is_null($storeName) && $storeName != "" && !in_array($storeName, CatalogSeoRepository::ALL_LOC_ARRAY)) :
            $sellerMaxShipPrice = $this->deliveryrangepricehelper->getSellerStoreMaxInPrice($vendorId,$storeName);
            $grabSellerStatus =$this->grabHelper->getSellerStoreGrabStatus($vendorId,$storeName);
            $_DeliveryStatus = $this->deliveryrangepricehelper->getSellerStoredelivery($vendorId,$storeName);
            $pickupStatus = $this->deliveryrangepricehelper->getSellerPickupStatus($vendorId,$storeName);
            $sellerFreeShippingFlag = $this->deliveryrangepricehelper->getSellerStoreFreeShippingFlag($vendorId,$storeName);
        else :
            if(is_null($storeName) || $storeName == "" || in_array($storeName, CatalogSeoRepository::ALL_LOC_ARRAY))
                return $deliveryCharges;
            else
            {
                $sellerMaxShipPrice = $this->deliveryrangepricehelper->getSellerStoreMaxInPrice($vendorId);
                $_DeliveryStatus = $this->deliveryrangepricehelper->getSellerStoredelivery($vendorId);
                $pickupStatus = $this->deliveryrangepricehelper->getSellerPickupStatus($vendorId);
                $sellerFreeShippingFlag = $this->deliveryrangepricehelper->getSellerStoreFreeShippingFlag($vendorId,$storeName);
            }
        endif;

        if(!empty($grabGlobalStatus) && !empty($grabSellerStatus))
        {
            $grabMaxDeliveryLimit = $this->grabHelper->getGrabUpperLimitinKms();
            $grabFinalweightForMultiplication = $this->grabHelper->getWeightForapplyMultiplication();
            $grabSurplusAmountWeight =  $this->grabHelper->getGrabSurplusAmoutForWeight();
            $grabshippingTax = $this->grabHelper->getGrabTax();
            $grabShippingAmount = $grabshippingTax;
            $delivery = array();
            $grabDeliveryNotes = "";

            /**
             * normal grab with homebakers
             */
           if(!empty($homebakerGlobalStatus) && !empty($bakeryType))
           {
               $grabDeliveryCharges = 0;
               $grabDeliveryNotes =  "Free Delivery";
           }
           else
           {
               $grabDeliveryCharges = $grabShippingAmount;
               if(!empty($grabSellerStatus))
                    $grabDeliveryNotes =  "Above ".$grabFinalweightForMultiplication." kg, ₹". $grabshippingTax * $grabSurplusAmountWeight;
           }

           $delivery['type'] = 3;
           $delivery['values'][] = [
              "from_kms" => 0,
              "to_kms" => $grabMaxDeliveryLimit,
              "charges" => $grabDeliveryCharges
           ];

           if (!empty($delivery))
             $deliveryCharges["delivery"][] = $delivery;
           if (!empty($grabDeliveryNotes))
               $deliveryCharges[ "notes" ] =  $grabDeliveryNotes;
        }
        else
        {
            if(!$_DeliveryStatus)
            {
                $deliveryCharges = array();
                return $deliveryCharges;
            }

            /**
             * seller has max price than apply threshhold delivery
             */

            $sellerFreeShippingGlobalStatus = $this->homedeliveryHelper->getSellersFreeShippingStatus();

            $deliveryChargescheck = "";
            if (!empty($sellerMaxShipPrice) && $sellerFreeShippingFlag == 1 && !empty($sellerFreeShippingGlobalStatus))
            {
                $deliveryChargescheck = "Above ₹" . $sellerMaxShipPrice . ",free delivery";
            }

            $sizeThreshold = "";
            if(!in_array($storeName, CatalogSeoRepository::ALL_LOC_ARRAY))
            {
                if($isConglomerate && !is_null($storeName) && $storeName != "")
                    $sizeThreshold = $this->deliveryrangepricehelper->getSellerSizeThreshold($vendorId,$storeName);
                else
                    $sizeThreshold = $this->deliveryrangepricehelper->getSellerSizeThreshold($vendorId);

                if(!empty($sizeThreshold) && $pickupStatus)
                    $sizeThreshold = "Above " . $sizeThreshold . " kg, Pickup Only";
            }

            if($isConglomerate && !is_null($storeName) && $storeName != "" && !in_array($storeName, CatalogSeoRepository::ALL_LOC_ARRAY)):
                $collection = $this->deliveryrangepricehelper->getSellerStoreRange($vendorId,$storeName);
                $delTimings = $this->deliveryrangepricehelper->getSellerMornMidDetails($vendorId,$storeName);
                $midnightMorningStatus = $this->deliveryrangepricehelper->isMidnightMorningActive($vendorId,$storeName);

            else:
                $collection = $this->deliveryrangepricehelper->getSellerStoreRange($vendorId);
                $delTimings = $this->deliveryrangepricehelper->getSellerMornMidDetails($vendorId);
                $midnightMorningStatus = $this->deliveryrangepricehelper->isMidnightMorningActive($vendorId);
            endif;

            if (!empty($collection)) 
            {
                $midnightArray = array();
                $earlyMorning = array();
                $delivery = array();

                foreach ($collection as $key => $value)
                {

                    if(isset($value['delivery_price']) && $value['delivery_price'] != "" && !is_null($value['delivery_price']))
                    {
                        $delivery['type'] = 3;
                        $delivery['values'][] = [
                            "from_kms" => $value['from_kms'],
                            "to_kms" => $value['to_kms'],
                            "charges" => $value['delivery_price']
                        ];                        
                    }

                    if(isset($value['midnight_price']) && $midnightMorningStatus["is_midnight_active"] && $value['midnight_price'] != "" && !is_null($value['midnight_price']))
                    {
                        $midnightArray['type'] = 1;
                        $midnightArray['values'][] = [
                            "from_kms" => $value['from_kms'],
                            "to_kms" => $value['to_kms'],
                            "charges" => $value['midnight_price'],
                            "start_time" => $delTimings['midnight_delivery_start_time'],
                            "end_time" => $delTimings['midnight_delivery_end_time'],
                        ];                        
                    }

                    if(isset($value['morning_price']) && $midnightMorningStatus["is_morning_active"] && $value['morning_price'] != "" && !is_null($value['morning_price']))
                    {
                        $earlyMorning['type'] = 2;
                        $earlyMorning['values'][] = [
                            "from_kms" => $value['from_kms'],
                            "to_kms" => $value['to_kms'],
                            "charges" => $value['morning_price'],
                            "start_time" => $delTimings['morning_delivery_start_time'],
                            "end_time" => $delTimings['morning_delivery_end_time'],
                        ];                        
                    }
                }

                if (!empty($delivery))
                    $deliveryCharges["delivery"][] = $delivery;
                if (!empty($midnightArray))
                    $deliveryCharges["delivery"][] = $midnightArray;
                if (!empty($earlyMorning))
                    $deliveryCharges["delivery"][] = $earlyMorning;

                if (!empty($deliveryChargescheck)) {
                    $deliveryCharges["notes"] = $deliveryChargescheck;
                }
                if(!empty($sizeThreshold) && $pickupStatus) {
                    $deliveryCharges["additional_notes"] = $sizeThreshold;
                }
            }
            else
            {
                $this->grabHelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
            }
        }
        return $deliveryCharges;
    }
}
