<?php

/**
 * Bakeway
 *
 * @category  Bakeway
 * @package   Bakeway_Crons
 * @author    Bakeway
 */

namespace Bakeway\Crons\Model;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use \Magento\Framework\ObjectManagerInterface as ObjectManagerInterface;
use Bakeway\Partnerlocations\Model\ResourceModel\Partnerlocations\CollectionFactory as PartnerLocationFactory;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Store\Model\StoreManagerInterface;
use Bakeway\OrderstatusEmail\Model\Email as OrderstatusEmail;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Checkout\Model\Cart as Checkoutcart;
use Bakeway\HomeDeliveryshipping\Helper\Data as Homedeliveryhelper;
use Bakeway\Cities\Model\ResourceModel\Cities\CollectionFactory as CitiesFactory;

class OrderPaymentStatusEmail {

    const BAKEWAY_PENDING_PAYMENT_STATUS = "bakeway_payment_pending";
    const XML_PATH_ORDER_STATUS_EMAIL_STATUS = 'order/status/payment_email_status';
    const XML_PATH_ORDER_STATUS_EMAIL_ADDRESS = 'order/status/payment_status_email_list';
    const XML_PATH_ORDER_STATUS_REPORT_EMAIL_STATUS = 'order/status/report_email';

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ObjectManagerInterface 
     */
    protected $_objectManager;

    /*
     * @var PartnerLocationFactory
     */
    protected $partnerLocationfactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfigInterface;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManagerInterface;

    /**
     * @var OrderstatusEmail
     */
    protected $orderstatusEmail;

    /**
     * @var TimezoneInterface
     */
    protected $timezoneInterface;

    /**
     * @var Checkoutcart 
     */
    protected $checkoutcart;

    /**
     * @var Homedeliveryhelper
     */
    protected $homedeliveryhelper;
    protected $timezone;
    protected $citiesfactory;

    /**
     * @param CollectionFactory $collectionFactory
     * @param ObjectManagerInterface $objectManager
     * @param PartnerLocationFactory $partnerLocationCollectionFactory
     * @param ScopeConfigInterface $scopeConfigInterface
     * @param StoreManagerInterface $storeManagerInterface
     * @param OrderstatusEmail $orderstatusEmail
     * @param TimezoneInterface $timezoneInterface
     * @param Checkoutcart $checkoutcart
     * @param Homedeliveryhelper $homedeliveryhelper
     */
    public function __construct(
    CollectionFactory $collectionFactory, ObjectManagerInterface $objectManager, PartnerLocationFactory $partnerLocationfactory, ScopeConfigInterface $scopeConfigInterface
    , StoreManagerInterface $storeManagerInterface, OrderstatusEmail $orderstatusEmail, TimezoneInterface $timezoneInterface, Checkoutcart $checkoutcart, Homedeliveryhelper $homedeliveryhelper, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone, CitiesFactory $CitiesFactory) {
        $this->collectionFactory = $collectionFactory;
        $this->_objectManager = $collectionFactory;
        $this->partnerLocationfactory = $partnerLocationfactory;
        $this->scopeConfigInterface = $scopeConfigInterface;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->orderstatusEmail = $orderstatusEmail;
        $this->timezoneInterface = $timezoneInterface;
        $this->checkoutcart = $checkoutcart;
        $this->homedeliveryhelper = $homedeliveryhelper;
        $this->timezone = $timezone;
        $this->citiesfactory = $CitiesFactory;
    }

    /**
     * get incomplete payment orders
     */
    public function getIncompletepaymentOrders() {
        if (empty($this->getOrderStatusCron())) {
            return;
        }
        /*
         * defined start and end time
         */
        $startTime = date('Y-m-d 00:00:01');
        $endTime = date('Y-m-d 23:59:00');
        $orderCollection = $this->collectionFactory->create()
                ->addFieldToSelect(["entity_id", "created_at", "customer_email", "customer_firstname", "customer_lastname", "base_grand_total", "delivery_type", "increment_id", "status", "store_unique_name"])
                ->addFieldToFilter("created_at", ["from" => $startTime, "to" => $endTime])
                ->addFieldToFilter("status", ["in" => [\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT, self::BAKEWAY_PENDING_PAYMENT_STATUS]]);

        $collectionSize = $orderCollection->getSize();
        $ordersData = [];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $objDate = $objectManager->create('Magento\Framework\Stdlib\DateTime\Timezone');
        $currentTimestamp = $objDate->formatDatetime(date("Y-m-d H:i:s")); //timestamp
        $start = strtotime('0min', strtotime($currentTimestamp));
        $startTime = date('Y-m-d H:i:s', $start);
        $to = strtotime('- 15min', strtotime($currentTimestamp));
        $endTime = date('Y-m-d H:i:s', $to);


        if ($collectionSize > 0) {




            foreach ($orderCollection as $order) {
                $dateTimeZone = $this->timezone->date(new \DateTime($order['created_at']))->format('Y-m-d H:i:s');

                if (($dateTimeZone >= $endTime) && ($dateTimeZone <= $startTime)) {

                    $billingAddress = "";
                    $billingAddress = $order->getBillingAddress();


                    if ($billingAddress->getTelephone()):
                        $billingAddress = $billingAddress->getTelephone();
                    endif;


                    $items = $order->getAllVisibleItems();

                    $firstItem = [];
                    $firstItemSku = "";

                    foreach ($items as $item) {
                        $firstItem[] = $item->getSku();
                    }

                    $firstItemSku = current($firstItem);

                    if (empty($firstItemSku) || $firstItemSku == null) {
                        return;
                    }


                    $_sellerid = $this->homedeliveryhelper->getSelleridFSku($firstItemSku);

                    if (empty($_sellerid) || $_sellerid == null) {
                        return;
                    }

                    $orderDate = $this->timezoneInterface->date()->format('Y-m-d H:i:s');
                    $getBakeryname = $this->getBakeryinformation($order->getStoreUniqueName(), $_sellerid);
                    $bakeryInformation = $getBakeryname['bakery_name'] . " ," . $getBakeryname['store_name'];
                    $ordersData[] = "<table id=pendingorderEmail border=1><tr>
                <td padding:9px>" . $order->getIncrementId() . "</td>
                <td padding:9px>" . $bakeryInformation . "</td>
                <td padding:9px>" . $order->getCustomerEmail() . "</td>
                <td padding:9px>" . $billingAddress . "</td>  
              </tr></table>";
                }
            }
        }


        $receiverEmails = $this->getOrderStatusCronEmailReceiver();
        if (empty($receiverEmails)) {
            return;
        }


        if (count($ordersData) > 0) {

            $this->orderstatusEmail->sendPendingPaymentOrderstoSales($ordersData, $receiverEmails);
        }
    }

    /**
     * Return Order pending order and bakeway pending order cron status
     *
     * @return mixed
     */
    public function getOrderStatusCron() {
        return $this->scopeConfigInterface->getValue(
                        self::XML_PATH_ORDER_STATUS_EMAIL_STATUS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $this->storeManagerInterface->getStore()->getStoreId()
        );
    }

    /**
     * Return product report cron status
     * @return mixed
     */
    public function getReportStatusCron() {
        return $this->scopeConfigInterface->getValue(
                        self::XML_PATH_ORDER_STATUS_REPORT_EMAIL_STATUS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $this->storeManagerInterface->getStore()->getStoreId()
        );
    }

    /**
     * Return Order pending order and bakeway pending order receiver
     *
     * @return mixed
     */
    public function getOrderStatusCronEmailReceiver() {

        return $this->scopeConfigInterface->getValue(
                        self::XML_PATH_ORDER_STATUS_EMAIL_ADDRESS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $this->storeManagerInterface->getStore()->getStoreId()
        );
    }

    /**
     * Bakery information on the basis of storeUnquie Code
     * @param string $storeCode
     * @param int $_sellerid
     */
    public function getBakeryinformation($storeCode, $_sellerid) {
        $suname = $storeCode;
        $getBakeryData = $this->partnerLocationfactory->create()
                ->addFieldToFilter("store_unique_name", $suname);
        $getBakeryData->getSelect()->joinLeft(['mu' => 'marketplace_userdata'], 'main_table.seller_id =
                mu.seller_id', ['business_name']);
        $getBakeryData->getSelect()->where("main_table.seller_id=?", $_sellerid);

        $getBakeryBusName = $getBakeryStoreName = "";
        if ($getBakeryData->getSize()) {

            $getBakeryData = $getBakeryData->getFirstItem();
            $getBakeryBusName = $getBakeryData->getBusinessName();
            $getBakeryStoreName = $getBakeryData->getStoreLocalityArea();

            return ["bakery_name" => $getBakeryBusName, "store_name" => $getBakeryStoreName];
        }
    }

    /**
     * 
     * get active inventory and no. of products
     */
    public function getReportsdata() {

        if (empty($this->getReportStatusCron())) {
            return;
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $cityTable = $resource->getTableName('bakeway_cities');
        $partnerTable = $resource->getTableName('bakeway_partner_locations');
        $userdataTable = $resource->getTableName('marketplace_userdata');
        $syncTable = $resource->getTableName('bakeway_catalog_sync');
        $catalogTable = $resource->getTableName('bakeway_store_catalog');
        $ordersReportData = [];

        $sql = " SELECT  bc.name as city ,COUNT(bcs.product_id) as 'product count' ,(SELECT COUNT(*) FROM " . $partnerTable . " WHERE city_id=bc.id) as 'store count'
                    FROM " . $syncTable . " AS bcs 
                 join 
                ( 
                     SELECT id, 
                     seller_id, city_id , store_locality_area,is_active
                     FROM " . $partnerTable . " )AS bpl 
                JOIN 
                ( 
                     SELECT id, 
                     NAME 
                    FROM " . $cityTable . ")AS bc 
                JOIN 
                ( 
                     SELECT seller_id,is_live_ready, 
                     store_city 
                     FROM " . $userdataTable . " )AS mu 
                ON    ( 
              bc.id = mu.store_city AND mu.seller_id = bpl.seller_id AND bcs.seller_id = mu.seller_id )
             
               WHERE  bcs.product_id NOT IN 
                   ( 
                     SELECT product_id  
                    FROM " . $catalogTable . " ) AND mu.is_live_ready = 1 AND bpl.is_active=1
                    GROUP BY bc.name";

        $result = $connection->fetchAll($sql);

        foreach ($result as $r) {
            $ordersReportData[] = "<table id=productreportEmail border=1 width=300><tr>
                            <td width=100 padding:9px>" . $r['city'] . "</td>
                            <td width=100 padding:9px>" . $r['store count'] . "</td
                            <td width=100 padding:9px>" . $r['product count'] . "</td>
                               
                            </tr></table>";
        }




        $this->orderstatusEmail->sendOrderReports($ordersReportData);
    }

}