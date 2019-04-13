<?php

namespace Bakeway\Deliveryrangeprice\Helper;

use Bakeway\Partnerlocations\Model\Partnerlocations as Partnerlocations;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Bakeway\Deliveryrangeprice\Model\RangepriceFactory
     */
    protected $rangepriceFactory;

    /**
     * @var  \Magento\Customer\Model\CustomerFactory
     */
    protected $_sellerFactory;
    protected $vendorFactory;

    /**
     * @var  \Magento\Customer\Block\Account\Dashboard\Info
     */
    protected $customerdash;

    /*
   * @var  Partnerlocations
   */
    protected $partnerlocations;

    /**
     * Locale Date/Timezone
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_timezone;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory
     * @param \Magento\Customer\Model\CustomerFactory $sellerFactory
     * @param \Webkul\Marketplace\Model\SellerFactory $vendorFactory
     * @param \Magento\Customer\Block\Account\Dashboard\Info $customerdash
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $_timezone
     * @param Partnerlocations $partnerlocations
     */
    public function __construct(
    \Magento\Framework\App\Helper\Context $context,
    \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory,
    \Magento\Customer\Model\CustomerFactory $sellerFactory,
    \Webkul\Marketplace\Model\SellerFactory $vendorFactory,
    \Magento\Customer\Block\Account\Dashboard\Info $customerdash,
    \Magento\Framework\Stdlib\DateTime\DateTime $_timezone,
    Partnerlocations $partnerlocations
    ) {
        parent::__construct($context);
        $this->rangepriceFactory = $rangepriceFactory;
        $this->_sellerFactory = $sellerFactory;
        $this->vendorFactory = $vendorFactory;
        $this->customerdash = $customerdash;
        $this->_timezone = $_timezone;
        $this->partnerlocations = $partnerlocations;
    }

    /**
     * seller email collection
     * @return array
     */
    public function getSellercollection() {

        $_Collection = $this->_sellerFactory->create()->getCollection()
                ->addAttributeToSelect('email');
        $_SellerArray = [];
        foreach ($_Collection as $_CollectionData) {

            $_SellerArray[$_CollectionData['entity_id']] = $_CollectionData['email'];
        }

        return $_SellerArray;
    }

    public function getCurrentSellerData() {
        return $this->rangepriceFactory->create()->getCollection();
    }

    public function checkCollectionforid($id,$storeId = null) {

        $_Collection = $this->rangepriceFactory->create()->getCollection()
                ->addFieldToFilter('delivery_deleted', 0)
                ->addFieldToFilter('seller_id', $id);

        if(!is_null($storeId) && $storeId != "")
            $_Collection->addFieldToFilter('store_id', $storeId);

        return count($_Collection);
    }

    public function getEmail($id) {
        $_Email = [];
        $_Collection = $this->_sellerFactory->create()->getCollection()
                ->addAttributeToFilter('entity_id', $id);
        foreach ($_Collection as $_Collection1) {
            $_Email[] = $_Collection1['email'];
        }

        return $_Email[0];
    }

    public function getidFromEmail($email) {
        $_Email = $_EntityId = [];

        $_Collection = $this->_sellerFactory->create()->getCollection()
                ->addAttributeToFilter('email', array("like" => '%' . $email . '%'));
        if (count($_Collection) > 0) {
            foreach ($_Collection as $_Collection1) {
                $_EntityId[] = $_Collection1['entity_id'];
            }

            return $_EntityId[0];
        } else {
            return "";
        }
    }

    public function getSelleredelivery($id) {
        $_Seller = $this->vendorFactory->create()->getCollection()
                ->addFieldToFilter("seller_id", $id);
        return $_Seller->getFirstItem()->getData('delivery');
    }

    public function getSellerEntityid($id) {
        $_Seller = $this->vendorFactory->create()->getCollection()
                ->addFieldToFilter("seller_id", $id);
        return $_Seller->getFirstItem()->getData('entity_id');
    }

    public function getPasswordurl() {
        return $this->customerdash->getChangePasswordUrl();
    }

    public function getSellerDeliverychargesdetails($vendorId) {
        $_Collection = $this->getCurrentSellerData()
                ->addFieldToFilter('delivery_deleted', 0)
                ->addFieldToFilter('seller_id', $vendorId);
        if (count($_Collection) > 0) {
            return $_Collection->getData();
        } else {
            return false;
        }
    }

    /*
     * @param int $vendorId
     * return bool
     */

    public function autoDeliveryChage($vendorId) {
        $_Collection = $this->getCurrentSellerData()
                ->addFieldToFilter('delivery_deleted', 0)
                ->addFieldToFilter('seller_id', $vendorId);
        if (count($_Collection) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSellerGrabValue($id) {
        $_Seller = $this->partnerlocations->getCollection()
            ->addFieldToFilter("seller_id", $id);
        return $_Seller->getFirstItem()->getData('is_grab_active');
    }

    /**
     * @param $sellerId
     * @return mixed
     */
    public function getGrabdelivery($sellerId) {
        $_Seller = $this->partnerlocations->getCollection()
            ->addFieldToFilter("seller_id", $sellerId);
        return $_Seller->getFirstItem()->getData('is_grab_active');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSellerMaxInPrice($id) {
        $_Seller = $this->vendorFactory->create()->getCollection()
            ->addFieldToFilter("seller_id", $id);
        return $_Seller->getFirstItem()->getData('is_deivery_max_price');
    }

    /**
     * return seller delivery range count
     * @param $vendorId
     * @return bool
     */
    public function getSellerDeliveryRangeCount($vendorId) {
        $_Collection = $this->getCurrentSellerData()
            ->addFieldToFilter('delivery_deleted', 0)
            ->addFieldToFilter('seller_id', $vendorId);
        if (count($_Collection) > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getSellerFreeShippingFlag($id) {

        $_Seller = $this->vendorFactory->create()->getCollection()
            ->addFieldToSelect("is_free_delivery")
            ->addFieldToFilter("seller_id", $id);
        return $_Seller->getFirstItem()->getData('is_free_delivery');
    }

    /**
     * Get seller information
     * @return array
     */
    public function getSellerData()
    {
        $collection = $this->vendorFactory->create()->getCollection()->addFieldToFilter('is_live_ready',
                1);
        $options = [['label' => '', 'value' => '']];

        foreach ($collection as $seller) {
            $options[] = [
                'label' => __('%1', $seller->getShopTitle()),
                'value' => $seller->getSellerId()
            ];
        }

        return $options;
    }

    /**
     * Get seller information
     * @return array
     */
    public function getStoreData($sellerId)
    {
        $collection = $this->partnerlocations->getCollection()
                ->addFieldToSelect('store_headline')
                ->addFieldToSelect('store_locality_area')
                ->addFieldToSelect('id')
                ->addFieldToFilter('seller_id', $sellerId);
        $options = [['label' => '', 'value' => '']];

        foreach ($collection as $store) {
            $options[] = [
                'label' => __('%1', $store->getStoreHeadline()."-".ucfirst(strtolower($store->getStoreLocalityArea()))),
                'value' => $store->getId()
            ];
        }

        return $options;
    }

    /**
     * Function to get delivery types
     * @return array
     */
    public function getDeliveryTypes()
    {
        $options = [];
        $options[] = ['label' => __('Early Morning'), 'value' => 2];
        $options[] = ['label' => __('Regular'), 'value' => 3];
        $options[] = ['label' => __('Midnight'), 'value' => 1];

        return $options;       
    }

    /**
     * @param $sellerId
     * @param $storeUniqueName
     * @return mixed
     */
    public function getSellerStoreFreeShippingFlag($sellerId,$storeUqName = null) 
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('is_free_delivery_active'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId]);

        if(!is_null($storeUqName) && $storeUqName != "")
            $partnerLocation->addFieldToFilter('store_unique_name',['eq' => $storeUqName]);

        $partnerLocation = $partnerLocation->getFirstItem();

        return (int)$partnerLocation->getData('is_free_delivery_active');
    }

    /**
     * @param $sellerId
     * @param $storeUniqueName
     * @return mixed
     */
    public function getStoreIdFromStoreUniqueName($sellerId,$storeUqName = null)
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('id'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId]);

        if(!is_null($storeUqName) && $storeUqName != "")
            $partnerLocation->addFieldToFilter('store_unique_name',['eq' => $storeUqName]);

        $partnerLocation = $partnerLocation->getFirstItem();
        
        return $partnerLocation->getId();
    }

    /**
     * Function to get delivery status per store
     * @param type $sellerId
     * @param type $storeUqName
     * @return array
     */
    public function getSellerStoredelivery($sellerId,$storeUqName = null)
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('is_delivery_active'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId]);

        if(!is_null($storeUqName) && $storeUqName != "")
            $partnerLocation->addFieldToFilter('store_unique_name',['eq' => $storeUqName]);

        $partnerLocation = $partnerLocation->getFirstItem();

        return (int)$partnerLocation->getData('is_delivery_active');
    }

    /**
     * Function to get pickup status per store
     * @param type $sellerId
     * @param type $storeUqName
     * @return array
     */
    public function getSellerPickupStatus($sellerId,$storeUqName = null)
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('is_pickup_active'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId]);

        if(!is_null($storeUqName) && $storeUqName != "")
            $partnerLocation->addFieldToFilter('store_unique_name',['eq' => $storeUqName]);

        $partnerLocation = $partnerLocation->getFirstItem();

        return (int)$partnerLocation->getData('is_pickup_active');
    }

    /**
     * Function to get seller size threshold if any
     * @param type $sellerId
     * @param type $storeUqName
     * @return array
     */
    public function getSellerSizeThreshold($sellerId,$storeUqName = null)
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('size_threshold'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId]);

        if(!is_null($storeUqName) && $storeUqName != "")
            $partnerLocation->addFieldToFilter('store_unique_name',['eq' => $storeUqName]);

        $partnerLocation = $partnerLocation->getFirstItem();

        return $partnerLocation->getData('size_threshold');
    }

    /**
     * Function to get delivery status per store
     * @param type $sellerId
     * @param type $storeUqName
     * @return array
     */
    public function getSellerStoreMaxInPrice($sellerId,$storeUqName = null)
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('free_delivery_threshold'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId]);

        if(!is_null($storeUqName) && $storeUqName != "")
            $partnerLocation->addFieldToFilter('store_unique_name',['eq' => $storeUqName]);

        $partnerLocation = $partnerLocation->getFirstItem();
        $freeDeliveryThreshold = $partnerLocation->getData('free_delivery_threshold');

        if(is_null($freeDeliveryThreshold) or $freeDeliveryThreshold == "")
            return false;
        else
            return $freeDeliveryThreshold;
    }

    /**
     * Function to get delivery status per store
     * @param type $sellerId
     * @param type $storeUqName
     * @return array
     */
    public function getSellerDeliveryDetails($sellerId,$storeUqName = null)
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('regular_delivery_start_time','regular_delivery_end_time','free_delivery_threshold','is_delivery_active','is_pickup_active','shop_open_timing','shop_open_AMPM','shop_close_timing','shop_close_AMPM'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId]);

        if(!is_null($storeUqName) && $storeUqName != "")
            $partnerLocation->addFieldToFilter('store_unique_name',['eq' => $storeUqName]);

        $partnerLocation = $partnerLocation->getFirstItem();
        $data = array();
        $data['delivery']                   = $partnerLocation->getData('is_delivery_active');
        $data['shop_delivery_open_time']    = $partnerLocation->getData('regular_delivery_start_time');
        $data['shop_delivery_close_time']   = $partnerLocation->getData('regular_delivery_end_time');
        $data['is_deivery_max_price']       = $partnerLocation->getData('free_delivery_threshold');
        $data['is_pickup_active']           = $partnerLocation->getData('is_pickup_active');
        $data['shop_open_timing']           = $partnerLocation->getData('shop_open_timing');
        $data['shop_open_AMPM']             = $partnerLocation->getData('shop_open_AMPM');
        $data['shop_close_timing']          = $partnerLocation->getData('shop_close_timing');
        $data['shop_close_AMPM']            = $partnerLocation->getData('shop_close_AMPM');

        return $data;
    }

    /**
     * Function to get delivery details for store
     * @param type $sellerId
     * @param type $storeId
     * @return array
     */
    public function getDeliveryDetails($sellerId,$storeId)
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('size_threshold','free_delivery_threshold','is_delivery_active','is_midnight_active','is_morning_active','is_free_delivery_active'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId])
                                ->addFieldToFilter('id',['eq' => $storeId]);


        $partnerLocation = $partnerLocation->getFirstItem();
        $data = array();
        $data = $partnerLocation->getData();

        return $data;
    }

    public function getDateTime()
    {
        return $todayDate = $date = $this->_timezone->gmtDate('Y-m-d H:i:s');        
    }
    
    /**
     * Function to get delivery status per store
     * @param type $sellerId
     * @param type $storeUqName
     * @return array
     */
    public function getSellerMornMidDetails($sellerId,$storeUqName = null)
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('midnight_delivery_start_time','midnight_delivery_end_time','morning_delivery_start_time','morning_delivery_end_time'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId]);

        if(!is_null($storeUqName) && $storeUqName != "")
            $partnerLocation->addFieldToFilter('store_unique_name',['eq' => $storeUqName]);

        $partnerLocation = $partnerLocation->getFirstItem();
        $data = array();
        $data['morning_delivery_start_time']    = $partnerLocation->getData('morning_delivery_start_time');
        $data['morning_delivery_end_time']      = $partnerLocation->getData('morning_delivery_end_time');
        $data['midnight_delivery_start_time']   = $partnerLocation->getData('midnight_delivery_start_time');
        $data['midnight_delivery_end_time']     = $partnerLocation->getData('midnight_delivery_end_time');

        return $data;
    }

    /**
     * Function to get delivery status per store
     * @param type $sellerId
     * @param type $storeUqName
     * @return bool
     */
    public function isMidnightMorningActive($sellerId,$storeUqName = null)
    {
        $partnerLocation = $this->partnerlocations->getCollection()
                                ->addFieldToSelect(array('is_midnight_active','is_morning_active'))
                                ->addFieldToFilter('seller_id',['eq' => $sellerId]);

        if(!is_null($storeUqName) && $storeUqName != "")
            $partnerLocation->addFieldToFilter('store_unique_name',['eq' => $storeUqName]);
        $partnerLocation = $partnerLocation->getFirstItem();

        $data = array();
        $data['is_midnight_active'] = $partnerLocation->getData('is_midnight_active');
        $data['is_morning_active']  = $partnerLocation->getData('is_morning_active');
        return $data;
    }

    /**
     * Function to check if the seller delivers to the range of the destination
     * @param type $sellerId
     * @param type $storeUqName
     * @param type $_distance
     * @return mixed
     */
    public function checkMaxSellerStoreRange($sellerId,$storeUqName,$_distance = null)
    {
        $_Maxdistance = array();

        $storeId = $this->getStoreIdFromStoreUniqueName($sellerId,$storeUqName);

        $_collection = $this->rangepriceFactory->create()->getCollection()
                ->addFieldToFilter('is_active', 1)
                ->addFieldToFilter('delivery_deleted', 0)
                ->addFieldToFilter('seller_id', $sellerId)
                ->addFieldToFilter('store_id', $storeId);

        return $_collection;
    }

    /**
     * Function to check if the seller delivers to the range of the destination
     * @param type $sellerId
     * @param type $storeUqName
     * @param type $typeId
     * @param type $_distance
     * @return mixed
     */
    public function getSellerStoreRange($sellerId,$storeUqName = null)
    {
        $_collection = $this->rangepriceFactory->create()->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('delivery_deleted', 0)
            ->addFieldToFilter('seller_id', $sellerId);

        //if (!is_null($storeUqName) || $storeUqName != "")
        //{
            $storeId = $this->getStoreIdFromStoreUniqueName($sellerId,$storeUqName);
            $_collection->addFieldToFilter('store_id', $storeId);
        //}

        return $_collection;
    }

    /**
     * Function to get delivery price
     * @param type $sellerId
     * @param type $storeUqName
     * @param type $typeId
     * @param type $distance
     * @return int
     */
    public function getStoreDeliveryPrice($sellerId,
            $storeUqName,
            $typeId,
            $distance)
    {
        $storeId = $this->getStoreIdFromStoreUniqueName($sellerId,$storeUqName);        

        $collection = $this->rangepriceFactory->create()->getCollection()
                ->addFieldToFilter('is_active', 1)
                ->addFieldToFilter('delivery_deleted', 0)
                ->addFieldToFilter('seller_id', $sellerId)
                ->addFieldToFilter('store_id', $storeId)
                ->addFieldToFilter('from_kms', ['lteq' => $distance])
                ->addFieldToFilter('to_kms', ['gteq' => $distance])
                ->getFirstItem();

        if($typeId == 1)
            $price = $collection->getMidnightPrice();
        if($typeId == 2)
            $price = $collection->getMorningPrice();
        if($typeId == 3)
            $price = $collection->getDeliveryPrice();
        if (isset($price) && !empty($price)) {
            return $price;
        }
        
        return 0;
    }

    /**
     * @param type $sellerId
     * @param type $storeId
     * @return mixed
     */
    public function getStoreName($sellerId,$storeId)
    {
        $collection = $this->partnerlocations->getCollection()
                ->addFieldToSelect('store_headline')
                ->addFieldToSelect('store_locality_area')
                ->addFieldToFilter('id',$storeId)
                ->addFieldToFilter('seller_id', $sellerId);
        if (count($collection) > 0) :
            $partnerLocation = $collection->getFirstItem();
            return $partnerLocation->getData();
        else :
            return false;
        endif;
    }
}