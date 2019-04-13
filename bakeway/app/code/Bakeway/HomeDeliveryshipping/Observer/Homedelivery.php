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
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Bakeway\Partnerlocations\Model\ResourceModel\Partnerlocations\CollectionFactory as LocationsCollection;
use Bakeway\GrabIntigration\Helper\Data as Grabhelper;
use Magento\Checkout\Block\Cart\Item\Renderer as Renderer;
use Magento\Catalog\Api\ProductRepositoryInterface as ProductRepositoryInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Bakeway\Deliveryrangeprice\Helper\Data as DeliveryrangeHelper;
use Magento\Framework\Event\Manager as Eventmanager;
use Magento\Quote\Model\QuoteRepository as QuoteRepository;

class Homedelivery implements ObserverInterface
{
    CONST DELIVERYMETHOD = "bakewayhomedelivery_bakewayhomedelivery";
    CONST DELIVERYEXTRAKM = "1";
    CONST WEIGHT_ATTRIBUTE_NAME = 'cake_weight';
    CONST GRAB_START_DELIVERY_DISTANCE = "4"; //in km
    CONST ADD_ON_SCAT = "Add ons";
    CONST ADD_ON_SCAT_ID = "3";

    CONST FREE_SHIPPING_METHOD = "freeshipping";

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
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $webApiRequest;

    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * Homedelivery constructor.
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
     * @param \Magento\Framework\Webapi\Rest\Request $webApiRequest
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
        \Magento\Framework\Webapi\Rest\Request $webApiRequest,
        QuoteRepository $quoteRepository
    )
    {
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
        $this->webApiRequest = $webApiRequest;
        $this->quoteRepository = $quoteRepository;
    }
    
    /**
     * calculate product data
     * @param type $quoteItems
     * @param type $addOnsCat
     * @return type
     */    
    public function checkItemsTypes($quoteItems, $addOnsCat)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/shipping_log.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('---------------------------------------------------------------------------------');
        $logger->info('------------------- START : Calculation of Product Weight ---------------');
        $logger->info('---------------------------------------------------------------------------------');
        $weightAttributeValueofConfigurable = "";
        $prodsToCheck = $prodsSkus = [];
        $multiplier = 1;
        $parentItem["qty"] = 0;
        $parentItem["id"] = 0;

        foreach ($quoteItems as $quoteItem)
        {
            if ($quoteItem->getParentItem())
            {
               $parentProductSku = $quoteItem->getSku();
               $prodsSkus[] = $prodData->getSku();
                
                /**
                 * adding weight attribute value for configurable product
                 */  
                $logger->info('------------------- Parent Item Id "'.$quoteItem->getParentItemId().'" ---------------');
                $logger->info('------------------- Child Parent Item Id "'.$parentItem["id"].'" ---------------');
                $logger->info('------------------- Parent Item Qty "'.$parentItem["qty"].'" ---------------');
                $logger->info('------------------- Multiplier "'.$multiplier.'" ---------------');

                $simpleData = $this->productobj->create()->load($quoteItem->getProductId());
                if($parentItem["qty"] > 0 && $parentItem["id"] == $quoteItem->getParentItemId())
                    $multiplier = $parentItem["qty"];

                $logger->info('------------------- Qty of the Product/Multiplier "'.$multiplier.'" & Weight of the Simple of Config Product is "'.str_replace(" Kg","",$simpleData->getAttributeText(self::WEIGHT_ATTRIBUTE_NAME)).'" ---------------');

                $weightAttributeValueofConfigurable  += ($multiplier * str_replace(" Kg","",$simpleData->getAttributeText(self::WEIGHT_ATTRIBUTE_NAME)));

                $logger->info('------------------- Weight of the Simple of Config Product "'.$weightAttributeValueofConfigurable.'" ---------------');
                continue;
            }
            else
            {
                $configData =  $this->productobj->create()->load($quoteItem->getProductId());
                $prodData =  $configData;
                if($configData->getTypeId() === 'configurable')
                {
                    $prodsToCheck[] = $configData->getId();
                    $parentItem["qty"] = $quoteItem->getQty();
                    $parentItem["id"] = $quoteItem->getId();
                }
                if($prodData->getTypeId() === 'simple' && $configData->getVisibility() == 4)
                {
                    $parentProductSku = $prodData->getSku();
                    $prodsToCheck[] = $prodData->getId();
                    $prodsSkus[] = $prodData->getSku();
                    $prodCatId =  $prodData->getCategoryIds();
                    
                    if(!in_array(self::ADD_ON_SCAT_ID, $prodCatId))
                    {
                        $weightAttributeValueofConfigurable  += str_replace(" Kg","",$prodData->getAttributeText(self::WEIGHT_ATTRIBUTE_NAME));
                        $logger->info('------------------- Weight of the Simple Visible Product : "'.str_replace(" Kg","",$prodData->getAttributeText(self::WEIGHT_ATTRIBUTE_NAME)).'" ---------------');
                        continue;
                    }
                }
            }
        }

        $logger->info('------------------- Total Order Weight: "'.$weightAttributeValueofConfigurable.'" ---------------');
        $logger->info('---------------------------------------------------------------------------------');
        $logger->info('------------------- END : Calculation of Product Weight ---------------');
        $logger->info('---------------------------------------------------------------------------------');

        $returnProdData = ["weight"=>$weightAttributeValueofConfigurable,"prod_ids"=>array_unique($prodsToCheck), "prodsSkus"=>array_unique($prodsSkus)];
        return $returnProdData;                
    }

    /**
     * Function to return delivery fees calculation
     * @param type $address
     * @param type $quote
     * @param type $_setProductsku
     * @param type $_Custshipping
     * @param type $observer
     */
    public function setCustomShippingCharges($address,$quote,$_setProductsku,$_Custshipping,$observer)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/shipping_log.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        foreach ($address->getAllShippingRates() as $rate)
        {
            if ($rate->getCode() == self::DELIVERYMETHOD)
            {
                $store = $quote->getStore();
                /* function to return delivery fees calculation */
                $_checkProduct = $this->_homedeliveryhelper->getSelleridFSku($_setProductsku);
                if (!empty($_checkProduct))
                {
                    $rate->setPrice($_Custshipping);
                }
                $address->setPrice(10);
                $observer->getTotal()->setTotalAmount($rate->getCode(), $_Custshipping);
                $observer->getTotal()->setBaseTotalAmount($rate->getCode(), $_Custshipping);
                $shippingDescription = $rate->getCarrierTitle() . ' - ' . $rate->getMethodTitle();
                $address->setShippingDescription(trim($shippingDescription, ' -'));
                $observer->getTotal()->setBaseShippingAmount($_Custshipping);
                $observer->getTotal()->setShippingAmount($_Custshipping);
                $observer->getTotal()->setShippingDescription($address->getShippingDescription());
                /*
                 * set grand total and base grand total
                 */
                $_getSubTotal = $observer->getTotal()->getGrandTotal();
                $observer->getTotal()->setGrandTotal($_getSubTotal + $_Custshipping);
                $observer->getTotal()->setBaseGrandTotal($_getSubTotal + $_Custshipping);
                /* function to return delivery fees calculation */

                $logger->info($quote->getId() .' actual shipping val '.$_Custshipping.' for quote id .'.$quote->getId());
                break;
            }
        }        
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/shipping_log.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('---------------------------------------------------------------------------------');
        $logger->info('-------------------inside in shipping observer process get started---------------');
        $logger->info('---------------------------------------------------------------------------------');

        $bakeryType = false;
        $freeshippingFlag = false;
        $freeshippingFlagNear = false;
        $minDistance = "";

        $addOnsCat = $this->scopeConfig->getValue('otherproducts/otherproducts_setting/name',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if(empty($addOnsCat) || is_null($addOnsCat))
            $addOnsCat = array(self::ADD_ON_SCAT);
        else            
            $addOnsCat = explode(',', $addOnsCat);

        $corsOriginUrl = $this->scopeConfig->getValue('web/corsRequests/origin_url',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $shippingAssignment = $observer->getShippingAssignment();
        $address = $shippingAssignment->getShipping()->getAddress();
        $method = $shippingAssignment->getShipping()->getMethod();
        $quote = $observer->getQuote();

        $configData =  $this->productobj->create();

        $logger->info('---------quote '.$quote->getId().' assigned--------');
        $address = $shippingAssignment->getShipping()->getAddress();
        $errorMessage = [];
        $_QuoteDeliveryType = $quote->getDeliveryType();

        /* calling extension attributes start */
        $extensionAttributes = $address->getExtensionAttributes();
        $_setLatitude = $_setLongtitude = $_setProductsku = "";
        if (!empty($address->getExtensionAttributes()))
        {
            $extensionAttributes = $address->getExtensionAttributes();
            $_setLatitude = $extensionAttributes->getLatitude();
            $_setLongtitude = $extensionAttributes->getLongtitude();
            $_setProductsku = $extensionAttributes->getSku();
            $is_midnight = $extensionAttributes->getIsMidnight();
            $is_earlymorning = $extensionAttributes->getIsEarlyMorning();
            /*$is_midnight = 0;
            $is_earlymorning = 0;*/

            $logger->info($quote->getId().' latitude val '.$_setLatitude.' longitude val '.$_setLongtitude.'and product-sku '.$_setProductsku);
        }
        /* calling extension attributes end */

        if ($_QuoteDeliveryType == 'home')
        {
            $logger->info($quote->getId().' --inserted in home deleivery type--');

            /** @varw \Magento\Quote\Model\Quote\Address $address */
            foreach ($observer->getTotal() as $totel)
            {
                $addressTotal = $this->collectAddressTotals($quote, $address);
            }

            $address->collectShippingRates();

            $key = $this->getMapKey();
            $_sellerid = $this->_homedeliveryhelper->getSelleridFSku($_setProductsku);
            $logger->info($quote->getId(). '---------------seller-id '.$_sellerid);
            $_selleraddress = ['lat'=>'00.000000', 'long'=>'00.000000'];
            $isConglomerate = $this->marketplaceHelper->isConglomerate($_sellerid);

            /******************* Single Login Delivery Fee Calculation START *********************/
            if ($quote->getItems() && $_sellerid)
            {
                $isConglomerate = $this->marketplaceHelper->isConglomerate($_sellerid);
                $locationColl = $this->locationsCollection->create()
                    ->addFieldToFilter('seller_id', $_sellerid);
                if ($isConglomerate === true)
                {
                    $logger->info($quote->getId().' seller '.$_sellerid.' is conglomerate');
                    $storeUniqueName = $quote->getData('store_unique_name');
                    if($quote->getData('primary_store_unique_name'))
                    {
                        $storeUniqueName =  $quote->getData('primary_store_unique_name');
                    }
                    $logger->info($quote->getId().' store unique name  '.$storeUniqueName.' has fechted');
                    if (trim($storeUniqueName) != '' && $storeUniqueName != Null)
                    {
                        $locationColl->addFieldToFilter('store_unique_name', trim($storeUniqueName));
                        if ($locationColl->count() > 0)
                        {
                            $location = $locationColl->getFirstItem();
                            $_selleraddress['lat'] = $location->getData('store_latitude');
                            $_selleraddress['long'] = $location->getData('store_longitude');
                            $logger->info($quote->getId().' latitude '.$_selleraddress['lat'] .' and longitude is '.$_selleraddress['long']);
                        }
                        else
                        {
                            $this->grabhelper->getBadrequestExpection('No location found for this store unique name.','DELIVERY_NOT_AVAILABLE');
                        }
                    }
                    else
                    {
                        $logger->info($quote->getId().' Store unique name not present in quote store name is '.$storeUniqueName);
                        $this->grabhelper->getBadrequestExpection('Store unique name not present in quote.');
                    }
                }
                else
                {
                    if ($locationColl->count() > 0)
                    {
                        $location = $locationColl->getFirstItem();
                        $_selleraddress['lat'] = $location->getData('store_latitude');
                        $_selleraddress['long'] = $location->getData('store_longitude');
                        $logger->info($quote->getId().' single store seller is '. $_sellerid. "and store lat". $_selleraddress['lat']  .'and long'.$_selleraddress['long']);
                    }
                    else
                    {
                        $logger->info($quote->getId().' location is not found for single seller .'.$_sellerid);
                        $this->grabhelper->getBadrequestExpection('Location is not present for this seller.');
                    }
                    //$_selleraddress = $this->getSelleraddressData($_sellerid);
                }
            }

            /******************* Single Login Delivery Fee Calculation END *********************/

            $isConglomerate = $this->marketplaceHelper->isConglomerate($_sellerid);
            $storeUniqueName = $quote->getData('store_unique_name');
            if($quote->getData('primary_store_unique_name')){
                $storeUniqueName =  $quote->getData('primary_store_unique_name');
            }
            $_DeliveryStatus = $this->getSelleredeliveryStatus($_sellerid, $isConglomerate, $storeUniqueName);

            /** seller delivery status**/
            $sellerFreeShippingFlag = $this->deliveryrangeHelper->getSellerStoreFreeShippingFlag($_sellerid,$storeUniqueName);

            /** grab intigration start **/
            $grabGlobalStatus = $weightAttributeValue = $grabSellerStatus = $taxAmount = "";
            $grabGlobalStatus = $this->grabhelper->getGrabGlobalStatus();
            
            if(!empty($isConglomerate))
            {
                $grabSellerStatus =  $this->grabhelper->getSellerStoreGrabStatus($_sellerid,$storeUniqueName);
            }
            else
            {
                $grabSellerStatus =  $this->grabhelper->getNonxonglomerateSellerGrabStatus($_sellerid);
            }

            $logger->info('---------quote '.$quote->getId().' assigned--------');
            $logger->info($quote->getId().' seller grab global status '.$grabGlobalStatus);
            $logger->info($quote->getId().' seller grab status '.$grabSellerStatus);
            $logger->info($quote->getId().' Store unique name '.$storeUniqueName);
            
            /*
             * check bakery type and global check
             */
            $homebakerGlobalStatus =  $this->_homedeliveryhelper->getHomeBakersFreeShippingStatus();

            $bakeryType = $this->_homedeliveryhelper->getBakeryType($_sellerid);

            if(!empty($bakeryType))
            {
                $bakeryType = true;
                $logger->info($quote->getId() .' Bakery type '.$bakeryType.' for seller(homebakers) '.$_sellerid);
            }

            $logger->info('--------- Grab Max Weight : '.$this->grabhelper->getWeightForapplyMultiplication().' --------');

            if(!empty($grabGlobalStatus) && !empty($grabSellerStatus))
            {
                $logger->info('--inside grab calculation----');
                $grabBaseAmount =  $this->grabhelper->getGrabbaseDiscount();
                $grabSurplusAmountDistance = $this->grabhelper->getGrabSurplusAmoutForDistance();
                $grabFinalweightForMultiplication = $this->grabhelper->getWeightForapplyMultiplication();
                $grabSurplusAmountWeight =  $this->grabhelper->getGrabSurplusAmoutForWeight();
                $grabUpperKmLimit  = $this->grabhelper->getGrabUpperLimitinKms();
                $grabshippingTax = $this->grabhelper->getGrabTax();
                $parentProductSku = $weightAttributeValue = "";
                $quoteItems = $quote->getAllItems();
                $configProductId = 0;
                $prodsToCheck  = array();

                $quoteitemsData = $this->checkItemsTypes($quoteItems, $addOnsCat);
                
                if(!empty($quoteitemsData['weight'])){ 
                   $weightAttributeValue = $quoteitemsData['weight'];
                   
                }
                
                if(!empty($quoteitemsData['prod_ids'])){
                   $quoteitemsProId =   $quoteitemsData['prod_ids'];
                }
                
                if(!empty($quoteitemsData['prodsSkus'])){
                   $prodsToCheck =   $quoteitemsData['prodsSkus'];
                }
                
                /**
                 * first item sku from quote
                 */
                $parentProductSku = current($prodsToCheck);
                
                $logger->info('sku assigned '.$parentProductSku.' to quote id is '.$quote->getId());

                $logger->info('---------quote '.$quote->getId().' assigned--------');
                /**
                 * throw error when product sku dosent found
                 */
                if(empty($parentProductSku))
                {
                    $this->grabhelper->getBadrequestExpection('No Product Found.');
                }
               
                if(!empty($prodsToCheck))
                    $logger->info('Product Id assigned '.implode(",",$quoteitemsProId).' to quote id is '.$quote->getId());

                //$weightAttributeValue  = $productData->getAttributeText(self::WEIGHT_ATTRIBUTE_NAME);

                
                $logger->info($quote->getId().' weight attribute value is '.$weightAttributeValue. ' for product '.$parentProductSku);
                $logger->info($quote->getId(). ' start cal based on lat and long');
                $logger->info($quote->getId().' lat '.$_setLatitude.' and long' .$_setLongtitude.' seller lat '.$_selleraddress['lat'].' and long val is '.$_selleraddress['long']);

                if(!empty($_setLatitude) && !empty($_setLongtitude) && !empty($_selleraddress['lat']) && !empty($_selleraddress['long']))
                {
                    $logger->info($quote->getId() .' insided cal based on lat and long');

                    $areaDistance = $this->_homedeliveryhelper->getDistance($_setLatitude, $_setLongtitude, $_selleraddress['lat'],  $_selleraddress['long'], $key);
                    $logger->info($quote->getId() .' area distance is '.$areaDistance);

                    $grabMaxDeliveryLimit = $this->grabhelper->getGrabUpperLimitinKms();

                    if($areaDistance <= $grabMaxDeliveryLimit)
                    {
                        $grabShippingAmount = $grabshippingTax;

                        if($weightAttributeValue > $grabFinalweightForMultiplication)
                        {
                            $grabShippingAmount  = $grabShippingAmount * $grabSurplusAmountWeight;
                        }


                        $logger->info($quote->getId() .' grab shiiping amount for '.$grabShippingAmount. ' for quote id '.$quote->getId() );

                        if($bakeryType === true && !empty($homebakerGlobalStatus)){
                            $grabShippingAmount = 0;
                            $logger->info($quote->getId() .' grab shipping amount zero when is home bakers '.$grabShippingAmount);
                        }

                        $logger->info('---------quote '.$quote->getId().' assigned--------');
                        if (!empty($areaDistance))
                        {
                            $this->setCustomShippingCharges($address,$quote,$_setProductsku,$grabShippingAmount,$observer);
                        }
                    }

                    else
                    {
                        /*
                         * check sub store in case of grab
                         */                        
                        if($isConglomerate === true)
                        {
                            $logger->info($quote->getId(). "-------------check sub store in case of grab start------------------");

                            /* Adding Product Id check for each store after Storewise Catalouge */
                            $storeShippingArray = ["sellerid"=>$_sellerid,"customerlat"=>$_setLatitude,"customerlong"=>$_setLongtitude,"savedStorename"=>$storeUniqueName,"quote"=>$quote->getEntityId(),"grab"=>true,"prdId"=>$quoteitemsProId];

                            $this->eventmanager->dispatch("store_check_for_shipping",["store-shipping"=> $storeShippingArray]);
                            if(($this->_registry->registry('min_location_distance') >= 0 && $quote->getData('store_unique_name') != '')) {

                                $areaDistance = $this->_registry->registry("min_location_distance");
                                $logger->info($quote->getId(). "-------------check sub store in case of grab  area distnace is ".$areaDistance);


                                if($areaDistance <= $grabMaxDeliveryLimit) {
                                    $grabShippingAmount = $grabshippingTax;

                                    if ($weightAttributeValue > $grabFinalweightForMultiplication) {
                                        $grabShippingAmount = $grabShippingAmount * $grabSurplusAmountWeight;
                                    }


                                    $logger->info($quote->getId().' case : grab event in case of other store - grab shiiping amount for ' . $grabShippingAmount . ' for quote id ' . $quote->getId());

                                    if ($bakeryType === true && !empty($homebakerGlobalStatus)) {
                                        $grabShippingAmount = 0;
                                        $logger->info($quote->getId().' case : grab event in case of other store - grab shipping amount zero when is home bakers ' . $grabShippingAmount);
                                    }
                                }
                                else {
                                    $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
                                }
                                $logger->info($quote->getId(). " -------------check sub store in case of grab  area distnace is ".$areaDistance." and shiiping amout is ".$grabShippingAmount);

                                if (!empty($areaDistance))
                                {
                                    $logger->info($quote->getId(). " -------------check sub store in case of grab  area distnace is ".$areaDistance." and come inside condition of delivery calculation");

                                    $this->setCustomShippingCharges($address,$quote,$_setProductsku,$grabShippingAmount,$observer);
                                    return;
                                }
                                else
                                {
                                    $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
                                }

                            }else{
                                $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
                            }
                        }
                        $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
                    }

                }
            }
            elseif(!empty($_DeliveryStatus))
            {
                /*
                 * Check if size of the cake is under limit of Size Threshold from the Seller Store
                 */
                $sizeThreshold = $this->deliveryrangeHelper->getSellerSizeThreshold($_sellerid,$storeUniqueName);

                $parentProductSku = "";
                $quoteItems = $quote->getAllItems();
                $configProductId = 0;
                $prodsToCheck = array();

                $quoteitemsData = $this->checkItemsTypes($quoteItems, $addOnsCat);
                
                if(!empty($quoteitemsData['weight'])){ 
                   $weightAttributeValue = $quoteitemsData['weight'];
                   
                }
                
                if(!empty($quoteitemsData['prod_ids'])){
                   $quoteitemsProId =   $quoteitemsData['prod_ids'];
                }
                
                if(!empty($quoteitemsData['prodsSkus'])){
                   $prodsToCheck =   $quoteitemsData['prodsSkus'];
                }
                
                  /**
                 * first item sku from quote
                 */
                $parentProductSku = current($prodsToCheck);
              
                
                $logger->info('sku assigned '.$parentProductSku.' to quote id is '.$quote->getId());
                $logger->info('---------quote '.$quote->getId().' assigned--------');

                /**
                 * throw error when product sku dosent found
                 */
                if(empty($parentProductSku))
                    $this->grabhelper->getBadrequestExpection('No Product Found.');

                if(!empty($prodsToCheck))
                    $logger->info('Product Id assigned '.implode(",", $quoteitemsProId).' to quote id is '.$quote->getId());

                if(!empty($sizeThreshold))
                {
                    $logger->info('-------------------- Inside weight check condition --------------------');
                    $weightAttributeValue  = str_replace(" Kg","",$weightAttributeValue);
                    $weightAttributeValue  = (float)$weightAttributeValue;
                    $logger->info($quote->getId().' weight attribute value is '.$weightAttributeValue. ' for product '.$parentProductSku);

                    if($weightAttributeValue > $sizeThreshold)
                        $this->grabhelper->getBadrequestExpection('Does not deliver orders above '.$sizeThreshold.' Kg','DELIVERY_NOT_AVAILABLE');
                }

                $logger->info($quote->getId(). ' --inside delivery  calculation when grab disabled ----');
                $logger->info($quote->getId().' --lat and long value fetched----');
                $logger->info($quote->getId().' lat '.$_selleraddress['lat'].'and long' .$_selleraddress['long']);

                if (!empty($_selleraddress['lat'] && !empty($_selleraddress['long']) && !empty($_DeliveryStatus))) 
                {
                    //tmp code
                    $latitudeCust = $_setLatitude; //visitor lat
                    $longitudeCust = $_setLongtitude; //visitor long
                    $latitudeSeller = $_selleraddress['lat']; // seller lat
                    $longitudeSeller = $_selleraddress['long']; //seller long
                    //tmp code end

                    $logger->info($quote->getId().' lat '.$latitudeCust.'and long' .$longitudeCust.' and for seller lat '.$latitudeSeller.' and long val is '.$longitudeSeller);
                    $logger->info('---------quote '.$quote->getId().' assigned--------');

                    $logger->info('--------- Is Seller conglomerate? '.$isConglomerate.' --------');
                    $logger->info('--------- Store Unique Name : '.$storeUniqueName.' --------');

                    /**
                     * new feature @17-03-2018
                     * apply free shipping for seller if seller set max price value for product
                     */
                    $sellerFreeShippingGlobalStatus = $this->_homedeliveryhelper->getSellersFreeShippingStatus();
                    $subTotal = round($quote->getSubtotal());
                    $quotetaxAmout = round($subTotal * 18/ 100);
                    $subtotalInclTax = $subTotal + $quotetaxAmout;
                    if($isConglomerate && !is_null($storeUniqueName))
                        $sellerMaxShipPrice = $this->deliveryrangeHelper->getSellerStoreMaxInPrice($_sellerid,$storeUniqueName);
                    else
                        $sellerMaxShipPrice = $this->deliveryrangeHelper->getSellerStoreMaxInPrice($_sellerid);

                    $logger->info('--------- Free Shipping Global Status '.$sellerFreeShippingGlobalStatus.' --------');
                    $logger->info('--------- Free Shipping Seller Status '.$sellerFreeShippingFlag.' --------');
                    $logger->info('--------- Free Delivery Threshold '.$sellerMaxShipPrice.' --------');
                    $logger->info('--------- Order subtotal '.$subtotalInclTax.' --------');

                    /* Free Shipping for Normal Delivery, Free Delivery is not applicable for Midnight & Early Morning Deliveries */
                    if(!empty($sellerMaxShipPrice) && $sellerFreeShippingFlag == 1 && !$is_midnight && !$is_earlymorning)
                    {
                        if ($subtotalInclTax > $sellerMaxShipPrice)
                        {
                            $freeshippingFlag = true;
                            $logger->info($quote->getId(). ' free shipping check if inside seller max price ' . $freeshippingFlag);
                        }
                    }
                    $_AddressDistance = $this->_homedeliveryhelper->getDistance($latitudeCust, $longitudeCust, $latitudeSeller, $longitudeSeller, $key);
                    $logger->info($quote->getId().' address distance is '.$_AddressDistance);

                    if($isConglomerate && !is_null($storeUniqueName))
                        $_checkMaxFees = $this->checkMaxSellerStoreRange($_sellerid,$_AddressDistance,$storeUniqueName);
                    else
                        $_checkMaxFees = $this->checkMaxSellerStoreRange($_sellerid,$_AddressDistance);

                    $logger->info('Does Seller have range to accomodate: '.$_AddressDistance.'kms? '. $_checkMaxFees);

                    if ($_checkMaxFees === true)
                    {
                        if($freeshippingFlag === true && !empty($sellerFreeShippingGlobalStatus))
                        {
                            $_Custshipping = 0;
                        }
                        else 
                        {
                            if($is_midnight || $is_earlymorning)
                            {
                                $midnightMorningStatus = $this->deliveryrangeHelper->isMidnightMorningActive($_sellerid,$storeUniqueName);
                                $logger->info('--------- Midnight Delivery for Seller '.$_sellerid.' for Store '.$storeUniqueName.' is '.$midnightMorningStatus["is_midnight_active"].' where delivery is in range of Primary Store --------');
                                $logger->info('--------- Early Morning Delivery for Seller '.$_sellerid.' for Store '.$storeUniqueName.' is '.$midnightMorningStatus["is_morning_active"].' where delivery is in range of Primary Store --------');
                            }
                            if ($is_midnight == 1 && $midnightMorningStatus["is_midnight_active"])
                            {
                                $_Custshipping = $this->getSellerRange($_sellerid, $_AddressDistance, $quote->getData('entity_id'), true, false, $storeUniqueName);
                            }                             
                            if ($is_earlymorning == 1 && $midnightMorningStatus["is_morning_active"])
                            {
                                $_Custshipping = $this->getSellerRange($_sellerid, $_AddressDistance, $quote->getData('entity_id'), false, true, $storeUniqueName);
                            }
                            if ($is_midnight != 1 && $is_earlymorning != 1)
                            {
                                $_Custshipping = $this->getSellerRange($_sellerid, $_AddressDistance, $quote->getData('entity_id'),false, false, $storeUniqueName);
                            }                          
                        }
                        if (isset($_Custshipping) && $_Custshipping !== "nan"):
                            $logger->info('Shipping Price is: '. $_Custshipping);
                            $logger->info('Condition is True');
                            $this->setCustomShippingCharges($address,$quote,$_setProductsku,$_Custshipping,$observer);
                        else:
                            /*
                             * applying zero shipping when user select pick up option
                             */
                            $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');

                        endif;
                    }
                    else
                    {                     
                        /**
                         * created new observer as per new requirement
                         * @17-07-2018
                         */
                        if($isConglomerate === true)
                        {
                            $logger->info($quote->getId()." inside store delivery cal for conglomerate seller ".$_sellerid);
                            $logger->info($quote->getId()." ---------------------------------------------------------------");

                            /* Adding Product Id check for each store after Storewise Catalouge */
                            $storeShippingArray = ["sellerid"=>$_sellerid,"customerlat"=>$latitudeCust,"customerlong"=>$longitudeCust,"savedStorename"=>$storeUniqueName,"quote"=>$quote->getEntityId(),"grab"=>false, "prdId"=>$quoteitemsProId];

                            $this->eventmanager->dispatch("store_check_for_shipping",["store-shipping"=> $storeShippingArray]);
                            /**
                             * set mindistance to shipping rate
                             */
                            
                            if($this->_registry->registry('min_location_distance') >= 0 && $quote->getData('store_unique_name') != '') 
                            {
                                $logger->info($quote->getId(). " min location distance has set in registry for seller id ".$_sellerid." quote id is ".$quote->getData('entity_id'));

                                $minDistance = $this->_registry->registry('min_location_distance');
                                $logger->info($quote->getId() ." min distnace return from event for quote id ".$quote->getData('entity_id')." is ".$minDistance);
                                $minDistanceStore = "";

                                if($this->_registry->registry('min_location_store'))
                                {
                                    $minDistanceStore = $this->_registry->registry('min_location_store');
                                    $logger->info($quote->getId() ." mindistnace store return from event for quote id ".$quote->getData('entity_id')." is ".$minDistanceStore. '------------');
                                }

                                /*
                                 * Check if size of the cake is under limit of Size Threshold from the Seller Store
                                 */
                                $sizeThresholdNear = $this->deliveryrangeHelper->getSellerSizeThreshold($_sellerid,$minDistanceStore);
                                if(!empty($sizeThresholdNear))
                                {
                                    $logger->info('-------------------- Inside weight check condition after nearest store selection --------------------');
                                    $logger->info($quote->getId().' Weight attribute value after nearest store selection is '.$weightAttributeValue);

                                    if($weightAttributeValue > $sizeThresholdNear)
                                        $this->grabhelper->getBadrequestExpection('Does not deliver orders above '.$sizeThresholdNear.' Kg','DELIVERY_NOT_AVAILABLE');
                                }

                                $sellerFreeShippingFlagNear = $this->deliveryrangeHelper->getSellerStoreFreeShippingFlag($_sellerid,$minDistanceStore);
                                $logger->info('--------- Free Shipping Seller Status after nearest store selection '.$sellerFreeShippingFlagNear.' --------');
                                $sellerMaxShipPriceNear = $this->deliveryrangeHelper->getSellerStoreMaxInPrice($_sellerid,$minDistanceStore);
                                $logger->info('--------- Free Delivery Threshold after nearest store selection '.$sellerMaxShipPriceNear.' --------');

                                if(!empty($sellerMaxShipPriceNear) && $sellerFreeShippingFlagNear == 1 && !$is_midnight && !$is_earlymorning)
                                {
                                    if ($subtotalInclTax > $sellerMaxShipPriceNear)
                                    {
                                        $freeshippingFlagNear = true;
                                        $logger->info($quote->getId(). ' free shipping check inside seller max price After nearest store selection ' . $freeshippingFlagNear);
                                    }
                                }

                                if($freeshippingFlagNear === true && !empty($sellerFreeShippingGlobalStatus))
                                {
                                    $custshippingValue = 0;
                                    $logger->info($quote->getId(). ' Free Shipping Applied After nearest store '.$minDistanceStore.' was selected  ');
                                }
                                else
                                {
                                    if($is_midnight || $is_earlymorning)
                                    {
                                        $midnightMorningStatus = $this->deliveryrangeHelper->isMidnightMorningActive($_sellerid,$minDistanceStore);
                                        $logger->info('--------- Midnight Delivery for Seller '.$_sellerid.' for Store '.$minDistanceStore.' is '.$midnightMorningStatus["is_midnight_active"].' where delivery is not in range of Primary Store --------');
                                        $logger->info('--------- Early Morning Delivery for Seller '.$_sellerid.' for Store '.$minDistanceStore.' is '.$midnightMorningStatus["is_morning_active"].' where delivery is not in range of Primary Store --------');
                                    }
                                    if ($is_midnight == 1 && $midnightMorningStatus["is_midnight_active"])
                                    {
                                        $custshippingValue = $this->getSellerRange($_sellerid, $minDistance, $quote->getData('entity_id'), true, false, $minDistanceStore);
                                    }
                                    if ($is_earlymorning == 1 && $midnightMorningStatus["is_morning_active"])
                                    {
                                        $custshippingValue = $this->getSellerRange($_sellerid, $minDistance, $quote->getData('entity_id'), false, true, $minDistanceStore);
                                    }
                                    if ($is_midnight != 1 && $is_earlymorning != 1)
                                    {
                                        $custshippingValue = $this->getSellerRange($_sellerid, $minDistance, $quote->getData('entity_id'),false, false, $minDistanceStore);
                                    }
                                }

                                if (isset($custshippingValue) && $custshippingValue !== "nan") {
                                    $logger->info($quote->getId() ." delivery rate for quote id ".$quote->getData('entity_id')."is ".$custshippingValue);
                                    $logger->info($quote->getId() ." inside delivery rate for quote id ".$quote->getData('entity_id')." is INR".$custshippingValue);

                                    $logger->info($quote->getId() .' store inside condtion for quote id .' . $quote->getId());
                                    $this->setCustomShippingCharges($address,$quote,$_setProductsku,$custshippingValue,$observer);

                                    $quoteObj = $this->quoteRepository->getActive($quote->getId());
                                    $quoteObj->setData("store_unique_name",$minDistanceStore);
                                    $quoteObj->save();
                                    $this->_registry->unregister('min_location_distance');
                                    
                                } else {
                                    $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.', 'DELIVERY_NOT_AVAILABLE');

                                }
                            }else{
                                $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');
                            }

                        }
                        else
                        {
                            $this->grabhelper->getBadrequestExpection('Delivery is not available for this area.','DELIVERY_NOT_AVAILABLE');

                        }
                    }
                }
                else
                {
                    //$this->grabhelper->getBadrequestExpection('Shipping is not available for this area', 'DELIVERY_NOT_AVAILABLE');
                }

            }
            else
            {
                if (!empty($address->getExtensionAttributes()))
                {
                    $logger->info('---------------------------------------------------------------------------------');
                    $logger->info('----- Delivery not available when both Grab & Delivery are disabled for the store ----');
                    $logger->info('---------------------------------------------------------------------------------');
                    $this->grabhelper->getBadrequestExpection('Delivery is not available for this location please try Pickup.', 'DELIVERY_NOT_AVAILABLE');
                }
            }


        }
        else
        {
            /*
             * Disallow Pickup for Midnight && Early Morning Delivery
             */
            if(isset($is_midnight) && isset($is_earlymorning))
            {
                if($is_midnight || $is_earlymorning)
                {
                    $this->grabhelper->getBadrequestExpection('Pickup Option is not available for special deliveries like Midnight or Early Morning Delivery.','DELIVERY_NOT_AVAILABLE');                
                }                
            }
            /*
             * applying zero shipping when user select pick up option
             */
            foreach ($address->getAllShippingRates() as $rate) 
            {
                if ($rate->getCode() == $method) 
                {
                    $store = $quote->getStore();
                    /* function to return delivery fees calculation */
                    $_price = 0;
                    $amountPrice = $this->priceCurrency->convert(
                        $_price, $store
                    );
                    $observer->getTotal()->setTotalAmount($rate->getCode(), $amountPrice);
                    $observer->getTotal()->setBaseTotalAmount($rate->getCode(), $amountPrice);
                    $shippingDescription = $rate->getCarrierTitle() . ' - ' . $rate->getMethodTitle();
                    $address->setShippingDescription(trim($shippingDescription, ' -'));
                    $observer->getTotal()->setBaseShippingAmount($amountPrice);
                    $observer->getTotal()->setShippingAmount($amountPrice);
                    $observer->getTotal()->setShippingDescription($address->getShippingDescription());
                    /* function to return delivery fees calculation */
                    break;
                }
            }
        }
        $logger->info('---------------------------------------------------------------------------------');
        $logger->info($quote->getId() . '-------------------inside in shipping observer process ended---------------------');
        $logger->info('---------------------------------------------------------------------------------');
        return;
    }

    /*
     * get matrix key
     */
    public function getMapKey()
    {
        return $this->_homedeliveryhelper->getKey('delivery_fee/delivery_fee/google_api_key');
    }

    /*
     * return seller lat and long value
     */
    public function getSelleraddressData($id)
    {
        $customerAddress = array();

        $customerObj = $this->_homedeliveryhelper->getSelleraddress($id);
        if (!empty($customerObj->getStoreLatitude())) 
        {
            return array("lat" => $customerObj->getStoreLatitude(), "long" => $customerObj->getStoreLongitude());
        }
    }

    /**
     * @return $_finalFess
     */
    public function getSellerRange($id, $_distance, $quoteId = null, $is_midnight = false, $is_earlymorning = false, $storeUqName = null)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/shipping_log.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $logger->info('---------------------------------------------------------------------------------');
        $logger->info('-------------------inside Seller range to calculate shipping price ---------------------');
        $logger->info('---------------------------------------------------------------------------------');

        $_finalFess = "";
        $_collection = $this->rangepriceFactory->create()->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('delivery_deleted', 0)
            ->addFieldToFilter('seller_id', $id);

        if (!is_null($storeUqName))
        {
            $logger->info('---- Added Store Filter Check to find Delivery Price -----');
            $storeId = $this->deliveryrangeHelper->getStoreIdFromStoreUniqueName($id, $storeUqName);
            $_collection->addFieldToFilter('store_id', $storeId);
            $logger->info('---- Inside Storewise Collection Check, Collection Count Check: '.count($_collection));
        }

        if(count($_collection) > 0)
        {
            $i = 1;
            foreach ($_collection as $_rangedata) 
            {
                if ($_rangedata['from_kms'] == 0)
                    $_rangedata['from_kms'] = -1;

                $maxSellerDeliveryKms = $_rangedata['to_kms'];
                $toDistance = $maxSellerDeliveryKms + self::DELIVERYEXTRAKM;
                if ($_distance > $_rangedata['from_kms'] && $_distance <= $toDistance)
                {
                    if($is_midnight)
                        $price = $_rangedata['midnight_price'];
                    if($is_earlymorning)
                        $price = $_rangedata['morning_price'];
                    if(!$is_earlymorning && !$is_midnight)
                        $price = $_rangedata['delivery_price'];

                    if(is_null($price) || $price == ""){
                        $logger->info('Seller given range shipping val is '.$price.' considered as null or empty');
                        return  $_finalFess = "nan";
                    }
                    $logger->info('Seller given range shipping val is '.$price);
                    return  $_finalFess = $price;

                    break;
                }
                if($i == count($_collection))
                    return  $_finalFess = "nan";
                $i++;
                continue;
            }            
        }
        else
            return  $_finalFess = "nan";
    }

    /**
     * @check distance
     * return true when seller max delivery range is below than customer address range
     */
    public function checkMaxSellerRange($id, $_distance)
    {
        $_Maxdistance = array();
        $_collection = $this->rangepriceFactory->create()->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('delivery_deleted', 0)
            ->addFieldToFilter('seller_id', $id);

        foreach ($_collection as $_rangedata) {
            $_Maxdistance[] = $_rangedata['to_kms'];
        }
        if (!empty($_Maxdistance)) :
            $maxFromArray = max($_Maxdistance);
            $maxDeliveryKms = $maxFromArray + self::DELIVERYEXTRAKM;
            if ($maxDeliveryKms >= $_distance) {
                return true;
            } else {
                return false;
            }
        else:
            return false;
        endif;
    }

    /**
     * Function to check if the seller delivers to the range of the destination
     * @param type $sellerId
     * @param type $storeUqName
     * @param type $_distance
     * @return bool
     */
    public function checkMaxSellerStoreRange($_sellerid, $_distance, $storeUniqueName = null) 
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/shipping_log.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $_Maxdistance = array();
        $_collection = $this->rangepriceFactory->create()->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('delivery_deleted', 0)
            ->addFieldToFilter('seller_id', $_sellerid);

        if (!is_null($storeUniqueName) || $storeUniqueName != "")
        {
            $logger->info('---- Added Store Filter Check to check Max Seller Store Range -----');
            $storeId = $this->deliveryrangeHelper->getStoreIdFromStoreUniqueName($_sellerid, $storeUniqueName);
            $_collection->addFieldToFilter('store_id', $storeId);
            $logger->info('---- Inside Storewise Collection Check, Collection Count Check: '.count($_collection));
        }

        if($_collection->count() <= 0)
        {
            return false;
        }
        else
        {
            foreach ($_collection as $_rangedata) {
                $_Maxdistance[] = $_rangedata['to_kms'];
            }
            if (!empty($_Maxdistance)) :
                $maxFromArray = max($_Maxdistance);
                $maxDeliveryKms = $maxFromArray + self::DELIVERYEXTRAKM;
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

    /*
     * check delivery is on or off for seller
     */
    public function getSelleredeliveryStatus($id, $isConglomerate, $storeUniqueName = null) 
    {
        return $this->deliveryrangeHelper->getSellerStoredelivery($id, $storeUniqueName);
    }
}