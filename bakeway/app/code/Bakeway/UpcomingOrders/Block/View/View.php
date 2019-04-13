<?php

namespace Bakeway\UpcomingOrders\Block\View;

/*
 * Bakeway UpcomingOrders View Block
 */
use Magento\Sales\Model\Order;
use Magento\Customer\Model\Customer;
use Webkul\Marketplace\Model\ResourceModel\Saleslist\CollectionFactory;
use Bakeway\Partnerlocations\Model\Partnerlocations as Partnerlocations;

class View extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Customer\Model\Customer
     */
    public $customer;

    /**
     * @var \Magento\Sales\Model\Order
     */
    public $order;

    /**
     * @var ObjectManagerInterface
     */
    public $_objectManager;

    /**
     * @var Session
     */
    public $_customerSession;

    /**
     * @var CollectionFactory
     */
    public $_orderCollectionFactory;

    /** @var \Magento\Catalog\Model\Product */
    public $salesOrderLists;

    /** @var \Magento\Sales\Model\OrderRepository */
    public $orderRepository;

    /** @var \Magento\Catalog\Model\ProductRepository */
    public $productRepository;

    protected $partnerlocations;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\ObjectManagerInterface        $objectManager
     * @param Order                                            $order
     * @param Customer                                         $customer
     * @param \Magento\Customer\Model\Session                  $customerSession
     * @param CollectionFactory                                $orderCollectionFactory
     * @param \Magento\Sales\Model\OrderRepository             $orderRepository
     * @param \Magento\Catalog\Model\ProductRepository         $productRepository
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        Order $order,
        Customer $customer,
        \Magento\Customer\Model\Session $customerSession,
        CollectionFactory $orderCollectionFactory,
        \Magento\Sales\Model\OrderRepository $orderRepository,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = [],
        Partnerlocations $partnerlocations
    ) {
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->Customer = $customer;
        $this->Order = $order;
        $this->_objectManager = $objectManager;
        $this->_customerSession = $customerSession;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->partnerlocations = $partnerlocations;
        parent::__construct($context, $data);

    }

    /**
     */
    public function _construct()
    {
        parent::_construct();
        $this->pageConfig->getTitle()->set(__('My Orders'));
    }

    public function getCustomerId()
    {
        
        return $this->_customerSession->getCustomerId();
    }

    /**
     * @return bool|\Webkul\Marketplace\Model\ResourceModel\Saleslist\Collection
     */
    public function getAllSalesOrder()
    {

     
        if (!($customerId = $this->getCustomerId())) {
            return false;
        }
        if (!$this->salesOrderLists) {


            
           

            $paramData = $this->getRequest()->getParams();
            $filterOrderid = '';
           
            $from =date('Y-m-d');
            $to = date("Y-m-d 23:59:59", strtotime($from ." + 5 day") );
            $filterStoreLocation = '';
            $filterIsDelivery = '';


           
           

            $orderids = $this->getOrderIdsArray($customerId);

            

            $ids = $this->getEntityIdsArray($orderids);


            $collection = $this->_orderCollectionFactory->create()->addFieldToSelect('*');
          
            $collection->getSelect()->joinInner(array('so' => 'sales_order'),'main_table.order_id = so.entity_id', array('main_table.order_id','so.status','so.base_subtotal','main_table.magerealorder_id','so.delivery_time','so.store_unique_name','so.delivery_type'));



                $collection->addFieldToFilter(
                    'entity_id',
                    ['in' => $ids]
                );


               

                $collection->addFieldToFilter(
                'delivery_time',
                ['datetime' => true, 'from' => $from, 'to' => $to]
            );


            $collection->addFieldToFilter(
                    'status',
                    ['st' => [\Bakeway\Vendorapi\Model\OrderStatus::STATUS_PARTNER_ACCEPTED]]
                );



             if(isset($paramData['storelocation']) && ($paramData['storelocation'] != "0")){

            
               
             $filterStoreLocation = $paramData['storelocation'] != ""?$paramData['storelocation']:"";
            
             $collection->addFieldToFilter(
                    'store_unique_name',
                    ['name' => $filterStoreLocation]
                );
         }


            if(isset($paramData['is_delivery']) && isset($paramData['is_pickup'])){

                

                }elseif(isset($paramData['is_delivery'])){

                     $filterIsDelivery = $paramData['is_delivery'] != ""?$paramData['is_delivery']:"";
                  $collection->addFieldToFilter(
                    'delivery_type',
                    ['type' => $filterIsDelivery]
                );
               }elseif (isset($paramData['is_pickup'])) {
                   $filterIsPickup = $paramData['is_pickup'] != ""?$paramData['is_pickup']:"";
                  $collection->addFieldToFilter(
                    'delivery_type',
                    ['type' => $filterIsPickup]
                );
               }





            $collection->setOrder(
                'delivery_time',
                'asc'
            );
            
$orders = [];
 foreach ($collection->getData() as  $value) {

            $orders[$value['delivery_time']]=  $value;
            # code...
        }

        //echo $collection->getSelect(); exit;
        return $orders;

          //  $this->salesOrderLists = $collection;
        }

       

       

    }




    public function getOrderIdsArray($customerId = '')
    {
        $orderids = [];

       

        $collectionOrders = $this->_objectManager->create(
            'Webkul\Marketplace\Model\Saleslist'
        )->getCollection()
            ->addFieldToFilter(
                'seller_id',
                ['eq' => $customerId]
            )
            ->addFieldToSelect('order_id');
           

        return $collectionOrders->getAllOrderIds();
    }

    public function getEntityIdsArray($orderids = [])
    {
        $ids = [];
        foreach ($orderids as $orderid) {
            $collectionIds = $this->_objectManager->create(
                'Webkul\Marketplace\Model\Saleslist'
            )->getCollection()
                ->addFieldToFilter(
                    'order_id',
                    ['eq' => $orderid]
                )

                ->setOrder('entity_id', 'DESC')
                ->setPageSize(1);


            foreach ($collectionIds as $collectionId) {
                $autoid = $collectionId->getId();
                array_push($ids, $autoid);
            }
        }

        return $ids;
    }

  
    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getCurrentUrl()
    {
        return $this->_urlBuilder->getCurrentUrl(); // Give the current url of recently viewed page
    }

    public function getpronamebyorder($orderId)
    {
        $sellerId = $this->getCustomerId();
        $collection = $this->_objectManager->create(
            'Webkul\Marketplace\Model\Saleslist'
        )->getCollection()
            ->addFieldToFilter(
                'seller_id',
                ['eq' => $sellerId]
            )
            ->addFieldToFilter(
                'order_id',
                ['eq' => $orderId]
            );
        $name = '';
        foreach ($collection as $res) {
            $products = $this->_objectManager->create(
                'Webkul\Marketplace\Model\Saleslist'
            )->load($res['mageproduct_id']);
            $name .= "<p style='float:left;'>".
                $res['magepro_name'].' X '.(int) $res['magequantity'].'&nbsp;</p>';
        }

        return $name;
    }

    public function getPricebyorder($orderId)
    {
        $sellerId = $this->getCustomerId();
        $collection = $this->_objectManager->create(
            'Webkul\Marketplace\Model\Saleslist'
        )->getCollection()
            ->addFieldToFilter(
                'seller_id',
                $sellerId
            )->getPricebyorderData();
        $name = '';
        foreach ($collection as $coll) {
            if ($coll->getOrderId() == $orderId) {
                return $coll->getTotal();
            }
        }
    }

    public function getOrderedPricebyorder($order, $basePrice)
    {
        $helper = $this->_objectManager->create(
            'Webkul\Marketplace\Helper\Data'
        );
        /*
        * Get Current Store Currency Rate
        */
        $currentCurrencyCode = $order->getOrderCurrencyCode();
        $baseCurrencyCode = $order->getBaseCurrencyCode();
        $allowedCurrencies = $helper->getConfigAllowCurrencies();
        $rates = $helper->getCurrencyRates(
            $baseCurrencyCode,
            array_values($allowedCurrencies)
        );
        if (empty($rates[$currentCurrencyCode])) {
            $rates[$currentCurrencyCode] = 1;
        }
        return $basePrice * $rates[$currentCurrencyCode];
    }

    public function getMainOrder($orderId)
    {
        $sellerId = $this->getCustomerId();
        $collection = $this->_objectManager->create(
            'Magento\Sales\Model\Order'
        )->getCollection()
            ->addFieldToFilter(
                'entity_id',
                ['eq' => $orderId]
            );
        foreach ($collection as $res) {
            return $res;
        }

        return [];
    }

    public function getStoreLocations($sellerId)
    {

        
        $partnerLocations = $this->partnerlocations->getCollection()
                               ->addFieldToSelect(array('store_unique_name','store_locality_area'))
                               ->addFieldToFilter('seller_id',['eq' => $sellerId]);


           return  $partnerLocations;                   

    }







}
