<?php
/**
 * Copyright © 2015 Bakeway . All rights reserved.
 */
namespace Bakeway\ExportCsv\Helper;
use Magento\Sales\Api\OrderRepositoryInterface as OrderRepositoryInterface;
use Magento\Sales\Model\Order\Status\History as OrderStatushistory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface As TimezoneInterface;

use  Bakeway\OrderstatusEmail\Block\Order\Email\Items as Itemsblock;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	/**
	 * @var Itemsblock
	 */
	protected $itemsblock;

	/**
     * Order Collection Factory
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory 
     */
    protected $orderModel;

	/**
	 * @var \Magento\Catalog\Model\CategoryFactory
	 */
	protected $orderRepositoryInterface;

	/**
	 * @var OrderStatushistory
	 */
	protected $orderStatushistory;

	/**
	 * @var TimezoneInterface
	 */
	protected $timezoneInterface;

    /** @var \Webkul\Marketplace\Block\Order\View */
    protected $block;

    /** @var \Magento\Sales\Model\Order */
    protected $order;

    /** @var \Webkul\Marketplace\Helper\Data */
    protected $helper;

    /** @var \Bakeway\PayoutsCalculation\Helper\Data */
    protected $payoutHelper;

    /** @var \Webkul\Marketplace\Model\Orders */
    protected $marketplaceOrder;

    /** @var \Webkul\Marketplace\Model\ResourceModel\Orders\Collection */
    protected $marketplaceOrderCollection;

    /** @var \Webkul\Marketplace\Model\Saleslist */
    protected $saleslist;

    /**
     * constructor.
     * @param \Magento\Framework\App\Helper\Context $context 
     * @param Itemsblock $itemsblock
     * @param OrderRepositoryInterface $orderRepositoryInterface
     * @param OrderStatushistory $orderStatushistory
     * @param TimezoneInterface $timezoneInterface
     * @param \Magento\Sales\Model\Order $orderModel
     */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		Itemsblock $itemsblock,
        OrderRepositoryInterface $orderRepositoryInterface,
        OrderStatushistory $orderStatushistory,
        TimezoneInterface $timezoneInterface,
        \Magento\Sales\Model\Order $orderModel,
        \Webkul\Marketplace\Block\Order\View $block,
        \Magento\Sales\Model\Order $order,
        \Webkul\Marketplace\Helper\Data $helper,
        \Bakeway\PayoutsCalculation\Helper\Data $payoutHelper,
        \Webkul\Marketplace\Model\Orders $marketplaceOrder,
        \Webkul\Marketplace\Model\ResourceModel\Orders\Collection $marketplaceOrderCollection,
        \Webkul\Marketplace\Model\Saleslist $saleslist

	) {
		$this->itemsblock = $itemsblock;
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->orderStatushistory = $orderStatushistory;
        $this->timezoneInterface = $timezoneInterface;
        $this->orderModel = $orderModel;
        $this->block = $block;
        $this->order = $order;
        $this->helper = $helper;
        $this->payoutHelper = $payoutHelper;
        $this->marketplaceOrder = $marketplaceOrder;
        $this->marketplaceOrderCollection = $marketplaceOrderCollection;
        $this->saleslist = $saleslist;
		parent::__construct($context);
	}

	/**
	 * @param $collection
	 * @return mixed
	 */
	public function getFilterCollection($collection)
	{
		return $collection;
	}

	/**
	 * @return mixed
	 */
	public function getFilterCollectionRow(){
        $collection = [];
		return $this->getFilterCollection($collection);
	}

	/**
	 * @param $productId
	 * @param $order
	 * @return mixed
	 */
	public function getBakeryDetails($productId, $order)
	{
		$addresss = $this->itemsblock->getSellerInfo($productId,$order);
		return $addresss;
	}
	
	/**
	 * @param $orderId
	 * @param $createdDate
	 * @return mixed
	 */
	public function getOrderAccRejectTime($orderId, $createdDate)
	{
		$enityId = $orderId;
		$orderdDate = $createdDate;
		$orderdDate=  $this->timezoneInterface->date($orderdDate)->format('m/d/y H:i:s');
		//$orderdDate = date("m/d/y H:i:s",strtotime("+30 minutes",strtotime($orderdDate)));
		$collection = $this->orderStatushistory->getCollection()
		    ->addFieldToSelect(['status','created_at','comment'])
		    ->addFieldToFilter(
		        'status',
		        ['in' => [\Bakeway\Vendorapi\Model\OrderStatus::STATUS_PARTNER_ACCEPTED,
		            \Bakeway\Vendorapi\Model\OrderStatus::STATUS_PARTNER_REJECTED]
		        ]
		    )
		    ->addFieldToFilter('entity_name',['eq'=>'order'])
		    ->addFieldToFilter('parent_id',['eq'=>$enityId])
		    ->getFirstItem();

		$fromDate =  $this->timezoneInterface->date($collection['created_at'])->format('m/d/y H:i:s');
		$fromDate = new \DateTime($fromDate);
		$orderdDate = new \DateTime($orderdDate);
		$interval = $fromDate->diff($orderdDate);

		if($interval->d == 0){
		    $timeDiff = $interval->format('%h hours %I minutes ');
		}
		else{
		    $timeDiff = $interval->format('%d days %h hours %I minutes ');
		}

		if(isset($timeDiff)){
		    return $timeDiff;
		}		
	}

    /**
     * @param $entity_id
     * @param $delivery_time
     * @return string
     */
	public function OrderCompleted($entity_id,$dilivery_time)
    {
        $timeMinusFlag = false;
        $enityId = $entity_id;
        $deliveryDate = $dilivery_time;
        $deliveryDate = date("m/d/y H:i:s",strtotime("+30 minutes",strtotime($deliveryDate)));
        $collection = $this->orderStatushistory->getCollection()
            ->addFieldToSelect(['status','created_at'])
            ->addFieldToFilter(
                'status',
                ['in' => [\Bakeway\Vendorapi\Model\OrderStatus::STATUS_ORDER_COMPLETE]
                ]
            )
            ->addFieldToFilter('entity_name',['eq'=>'order'])
            ->addFieldToFilter('parent_id',['eq'=>$enityId])
            ->getFirstItem();

        if (!empty($collection['entity_id'])){

         $fromDate =  $this->timezoneInterface->date($collection['created_at'])->format('m/d/y H:i:s');

       if($fromDate <  $deliveryDate)
       {
         $timeMinusFlag = '( - )';
       }


        $fromDate = new \DateTime($fromDate);

        $deliveryDate = new \DateTime($deliveryDate);

        $interval = $fromDate->diff($deliveryDate);


        if($interval->d == 0){
            $timeDiff = $interval->format('%h hours %I minutes ');
        }

        else{
            $timeDiff = $interval->format('%d days %h hours %I minutes ');
        }

        if(isset($timeDiff)){
            return $timeMinusFlag." ".$timeDiff;
        }
        }
    }

     /**
     * @param $entity_id
     * @return string
     */
    public function RejectorderStatus($entityId)
    {
        $collection = $this->orderStatushistory->getCollection()
            ->addFieldToSelect(['status','created_at','comment'])
            ->addFieldToFilter(
                'status',
                ['in' => [
                    \Bakeway\Vendorapi\Model\OrderStatus::STATUS_PARTNER_REJECTED]
                ]
            )
            ->addFieldToFilter('entity_name',['eq'=>'order'])
            ->addFieldToFilter('parent_id',['eq'=>$entityId])
            ->getFirstItem();
        if(!empty($collection->getData('comment'))){
            return  $collection->getData('comment');
        }
        return;
    }

     /**
     * @param $status
     * @return type
     */
    public function PaidStatus($status)
    {
        if ($status) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
    
     /**
     * @param $label
     * @param $updateDate
     * @return type
     */
    public function status($label,$updateDate)
    {
        $status = $label;
        if ($status === 'Complete') {
            return date('M d, Y h:i A', strtotime($updateDate));
        } else {
            return '';
        }
    }

     /**
     * @param $userdataGstinNumber
     * @param $entityId
     * @return type
     */
    public function getGst($userdataGstinNumber,$entityId)
    {
        $gstNumber = $userdataGstinNumber;
        if (!isset($gstNumber) && empty($gstNumber)) {
            $Order = $this->orderModel->load($entityId);
            $orderItems = $Order->getAllItems();
            $gst = 0;
            foreach ($orderItems as $item) {
                $gst += $item->getTaxAmount();
            }
            return $gst;
        }
    }

     /**
     * @param $deliveryTime
     * @return string
     */
    public function getDeliveryTime($deliveryTime)
    {
        $deliveryTime = date('M d, Y h:i A', strtotime($deliveryTime));
        return $deliveryTime;
    }

     /**
     * @param $orderTime
     * @return string
     */
    public function getOrderDate($orderTime)
    {
         $created = $this->timezoneInterface->date(new \DateTime($orderTime));
        $orderTime = $created->format('M j, Y g:i A');
        return $orderTime;
    }

    /**
     * @param $increament_id
     * @return type
     */
    public function getTotalSellerAmount($increament_id)
    {
        $actualSellerAmount = 0;
        $order = $this->order->loadByIncrementId($increament_id);
        $mageOrderId = $order->getEntityId();
        $items = $order->getItemsCollection();
        $vendorSubtotal = $codchargesTotal = $totaltax = $couponamount = $vendortotaltax = $refundedShippingAmount = $tcsAmount = $paymentGatewayAmount = $shippingamount = 0;
        $paymentCode = $order->getPayment()->getMethod();
        $deliveryFlag = $order->getData('grab_delivery_flag');
        foreach ($items as $item) {
            $sellerOrderslist = $this->getSellerOrdersList(
                    $mageOrderId, $item->getProductId(), $item->getItemId()
            );
            $sellerItemCost = $codchargesPeritem = $totaltaxPeritem = $couponcharges = 0;
            foreach ($sellerOrderslist as $sellerItem) {
                $sellerItemCost = $sellerItem->getActualSellerAmount();
                if ($paymentCode == 'mpcashondelivery') {
                    $codchargesPeritem = $sellerItem->getCodCharges();
                }
                $totaltaxPeritem = $sellerItem->getTotalTax();
                $couponcharges = $sellerItem->getAppliedCouponAmount();
            }

            $vendorSubtotal += $sellerItemCost;
            $codchargesTotal += $codchargesPeritem;
            $totaltax += $totaltaxPeritem;
            $couponamount += $couponcharges;
        }

        $taxToSeller = $this->helper->getConfigTaxManage();
        $marketplaceOrders = $this->getSellerOrderInfo($mageOrderId);
        foreach ($marketplaceOrders as $order) {
            $refundedShippingAmount = $order->getRefundedShippingCharges();
            $taxToSeller = $order['tax_to_seller'];
            $tcsAmount = $order->getTcsAmount();
            $paymentGatewayAmount = $order->getPaymentGatewayFee();
            $shippingamount = $order->getShippingCharges();
        }

        if ($taxToSeller) {
            $vendortotaltax = $totaltax;
        }

        $tracking = $this->getOrderinfo($mageOrderId);
        if (isset($tracking) && !empty($tracking)) {
            $taxPaidByBakeway = $tracking->getData('tax_paid_by_bakeway');
            if ($taxPaidByBakeway == 1) {
                $vendortotaltax = 0;
                $shippingamount = $this->payoutHelper->getDeliveryFeeExclTax($shippingamount);
            }
        }

        if (!empty($deliveryFlag)) {
            $baseOne = $vendorSubtotal + $codchargesTotal + $vendortotaltax;
        } else {
            $baseOne = $vendorSubtotal + $shippingamount + $codchargesTotal + $vendortotaltax;
        }

        $baseTwo = $refundedShippingAmount + $couponamount + $tcsAmount + $paymentGatewayAmount;
        $base = $baseOne - $baseTwo;
        $actualSellerAmount = $this->block->getOrderedPricebyorder($order, $base);

        return $actualSellerAmount;
    }

    /**
     * Get Order info
     * @param type $orderId
     * @return array
     */
    private function getOrderinfo($orderId)
    {
        $data = [];
        $model = $this->marketplaceOrder
                ->getCollection()
                ->addFieldToFilter(
                'order_id', $orderId
        );

        $salesOrder = $this->marketplaceOrderCollection->getTable('sales_order');

        $model->getSelect()->join(
                $salesOrder . ' as so', 'main_table.order_id = so.entity_id',
                ["order_approval_status" => "order_approval_status", "status" => "status"]
        )->where("so.order_approval_status=1");
        foreach ($model as $tracking) {
            $data = $tracking;
        }

        return $data;
    }

    /**
     * Get seller order list
     * @param type $orderId
     * @param type $proId
     * @param type $itemId
     * @return array
     */
    private function getSellerOrdersList($orderId,
            $proId,
            $itemId)
    {
        $collection = $this->saleslist
                ->getCollection()
                ->addFieldToFilter(
                        'order_id', ['eq' => $orderId]
                )
                ->addFieldToFilter(
                        'mageproduct_id', ['eq' => $proId]
                )
                ->addFieldToFilter(
                        'order_item_id', ['eq' => $itemId]
                )
                ->setOrder('order_id', 'DESC');
        return $collection;
    }

    /**
     * Seller order information
     * @param type $orderId
     * @return array
     */
    private function getSellerOrderInfo($orderId)
    {
        $collection = $this->marketplaceOrder->getCollection()
                ->addFieldToFilter(
                'order_id', ['eq' => $orderId]
        );
        return $collection;
    }

    
}

