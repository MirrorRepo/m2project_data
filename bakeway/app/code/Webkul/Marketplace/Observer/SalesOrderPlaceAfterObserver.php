<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_Marketplace
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\Marketplace\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManager;
use Magento\Quote\Model\QuoteRepository;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Magento\Framework\Unserialize\Unserialize;
use Bakeway\PayoutsCalculation\Helper\Data as PayoutsHelper;
use Bakeway\CustomFee\Helper\Data as FeeHelper;
use Magento\Sales\Model\Order as SalesOrder;

/**
 * Webkul Marketplace SalesOrderPlaceAfterObserver Observer Model.
 */
class SalesOrderPlaceAfterObserver implements ObserverInterface
{
    /**
     * @var eventManager
     */
    protected $_eventManager;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * [$_coreSession description].
     *
     * @var SessionManager
     */
    protected $_coreSession;

    /**
     * @var QuoteRepository
     */
    protected $_quoteRepository;

    /**
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepository;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var MarketplaceHelper
     */
    protected $_marketplaceHelper;

    /**
     * @var Unserialize
     */
    protected $_unserializer;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;
    
    /**
     * @var PayoutsHelper 
     */
     protected $payoutsHelper;

    /**
     * @var FeeHelper
     */
    protected $feeHelper;

    /**
     * @param \Magento\Framework\Event\Manager            $eventManager
     * @param \Magento\Framework\ObjectManagerInterface   $objectManager
     * @param \Magento\Customer\Model\Session             $customerSession
     * @param \Magento\Checkout\Model\Session             $checkoutSession
     * @param SessionManager                              $coreSession
     * @param QuoteRepository                             $quoteRepository
     * @param OrderRepositoryInterface                    $orderRepository
     * @param CustomerRepositoryInterface                 $customerRepository
     * @param ProductRepositoryInterface                  $productRepository
     * @param MarketplaceHelper                           $marketplaceHelper
     * @param Unserialize                                 $unserializer
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param PayoutsHelper								  $payoutsHelper
     * @param FeeHelper                                   $feeHelper
     */
    public function __construct(
        \Magento\Framework\Event\Manager $eventManager,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        SessionManager $coreSession,
        QuoteRepository $quoteRepository,
        OrderRepositoryInterface $orderRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        MarketplaceHelper $marketplaceHelper,
        Unserialize $unserializer,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        PayoutsHelper $payoutsHelper,
        FeeHelper $feeHelper
    ) {
        $this->_eventManager = $eventManager;
        $this->_objectManager = $objectManager;
        $this->_customerSession = $customerSession;
        $this->_checkoutSession = $checkoutSession;
        $this->_coreSession = $coreSession;
        $this->_quoteRepository = $quoteRepository;
        $this->_orderRepository = $orderRepository;
        $this->_customerRepository = $customerRepository;
        $this->_productRepository = $productRepository;
        $this->_marketplaceHelper = $marketplaceHelper;
        $this->_unserializer = $unserializer;
        $this->_date = $date;
        $this->payoutsHelper = $payoutsHelper;
        $this->feeHelper = $feeHelper;
    }

    /**
     * Sales Order Place After event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $isMultiShipping = $this->_checkoutSession->getQuote()->getIsMultiShipping();
        $order = $observer->getOrder();
        $state = SalesOrder::STATE_PAYMENT_REVIEW;
        $status = SalesOrder::STATUS_FRAUD;
        
        if ($order->getState() == $state && $order->getStatus() == $status)
        {
            return;
        }

        $state = SalesOrder::STATE_NEW;
        $status = 'bakeway_payment_pending';
        if ($order->getState() == $state && $order->getStatus() == $status)
        {
            return;
        }
        
        if (!$isMultiShipping) {
            /** @var $orderInstance Order */
            $order = $observer->getOrder();
            $lastOrderId = $observer->getOrder()->getId();
            $this->orderPlacedOperations($order, $lastOrderId);
        } else {
            $quoteId = $this->_checkoutSession->getLastQuoteId();
            $quote = $this->_quoteRepository->get($quoteId);
            if ($quote->getIsMultiShipping() == 1 || $isMultiShipping == 1) {
                $orderIds = $this->_coreSession->getOrderIds();
                foreach ($orderIds as $ids => $orderIncId) {
                    $lastOrderId = $ids;
                    /** @var $orderInstance Order */
                    $order = $this->_orderRepository->get($lastOrderId);
                    $this->orderPlacedOperations($order, $lastOrderId);
                }
            }
        }
    }

    /**
     * Order Place Operation method.
     *
     * @param \Magento\Sales\Model\Order $order
     * @param int                        $lastOrderId
     */
    public function orderPlacedOperations($order, $lastOrderId)
    {
        $this->productSalesCalculation($order);

        /*send placed order mail notification to seller*/
        $paymentCode = '';
        if ($order->getPayment()) {
            $paymentCode = $order->getPayment()->getMethod();
        }

        $shippingInfo = '';
        $shippingDes = '';

        $billingId = $order->getBillingAddress()->getId();

        $billaddress = $this->_objectManager->create(
            'Magento\Sales\Model\Order\Address'
        )->load($billingId);
        $billinginfo = $billaddress['firstname'].'<br/>'.
        $billaddress['street'].'<br/>'.
        $billaddress['city'].' '.
        $billaddress['region'].' '.
        $billaddress['postcode'].'<br/>'.
        $this->_objectManager->create(
            'Magento\Directory\Model\Country'
        )->load($billaddress['country_id'])->getName().'<br/>T:'.
        $billaddress['telephone'];

        $order->setOrderApprovalStatus(1)->save();

        $payment = $order->getPayment()->getMethodInstance()->getTitle();

        if ($order->getShippingAddress()) {
            $shippingId = $order->getShippingAddress()->getId();
            $address = $this->_objectManager->create(
                'Magento\Sales\Model\Order\Address'
            )->load($shippingId);
            $shippingInfo = $address['firstname'].'<br/>'.
            $address['street'].'<br/>'.
            $address['city'].' '.
            $address['region'].' '.
            $address['postcode'].'<br/>'.
            $this->_objectManager->create(
                'Magento\Directory\Model\Country'
            )->load($address['country_id'])->getName().'<br/>T:'.
            $address['telephone'];
            $shippingDes = $order->getShippingDescription();
        }

        $adminStoremail = $this->_marketplaceHelper->getAdminEmailId();
        $defaultTransEmailId = $this->_marketplaceHelper->getDefaultTransEmailId();
        $adminEmail = $adminStoremail ? $adminStoremail : $defaultTransEmailId;
        $adminUsername = 'Admin';

        $sellerOrder = $this->_objectManager->create(
            'Webkul\Marketplace\Model\Orders'
        )
        ->getCollection()
        ->addFieldToFilter('order_id', $lastOrderId)
        ->addFieldToFilter('seller_id', ['neq' => 0]);
        foreach ($sellerOrder as $info) {
            $userdata = $this->_customerRepository->getById($info['seller_id']);
            $username = $userdata->getFirstname();
            $useremail = $userdata->getEmail();

            $senderInfo = [];
            $receiverInfo = [];

            $receiverInfo = [
                'name' => $username,
                'email' => $useremail,
            ];
            $senderInfo = [
                'name' => $adminUsername,
                'email' => $adminEmail,
            ];
            $totalprice = '';
            $totalTaxAmount = 0;
            $codCharges = 0;
            $shippingCharges = 0;
            $orderinfo = '';

            $saleslistIds = [];
            $collection1 = $this->_objectManager->create(
                'Webkul\Marketplace\Model\Saleslist'
            )->getCollection()
            ->addFieldToFilter('order_id', $lastOrderId)
            ->addFieldToFilter('seller_id', $info['seller_id'])
            ->addFieldToFilter('parent_item_id', ['null' => 'true'])
            ->addFieldToFilter('magerealorder_id', ['neq' => 0])
            ->addFieldToSelect('entity_id');

            $saleslistIds = $collection1->getData();

            $fetchsale = $this->_objectManager->create(
                'Webkul\Marketplace\Model\Saleslist'
            )
            ->getCollection()
            ->addFieldToFilter(
                'entity_id',
                ['in' => $saleslistIds]
            );
            $fetchsale->getSellerOrderCollection();
            foreach ($fetchsale as $res) {
                $product = $this->_productRepository->getById($res['mageproduct_id']);
                $productObj = $this->_objectManager->create('Magento\Catalog\Model\Product')->load($res['mageproduct_id']);
                $vendorProductCode = $productObj->getData('vendor_product_code');

                /* product name */
                $productName = $res->getMageproName();
                $result = [];
                $result = $this->getProductOptionData($res, $result);
                $productName = $this->getProductNameHtml($result, $productName);
                /* end */

                $sku = $product->getSku();
                $orderinfo = $orderinfo."<tbody><tr>
                                <td class='item-info'>".$productName."</td>
                                <td class='item-info'>".$vendorProductCode."</td>
                                <td class='item-info'>".$sku."</td>
                                <td class='item-qty'>".($res['magequantity'] * 1)."</td>
                                <td class='item-price'>".
                                    $order->formatPrice(
                                        $res['magepro_price'] * $res['magequantity']
                                    ).
                                '</td>
                             </tr></tbody>';
                $totalTaxAmount = $totalTaxAmount + $res['total_tax'];
                $totalprice = $totalprice + ($res['magepro_price'] * $res['magequantity']);

                /*
                * Low Stock Notification mail to seller
                */
                if ($this->_marketplaceHelper->getlowStockNotification()) {
                    $stockItemQty = $product['quantity_and_stock_status']['qty'];
                    if ($stockItemQty <= $this->_marketplaceHelper->getlowStockQty()) {
                        $orderProductInfo = "<tbody><tr>
                                <td class='item-info'>".$productName."</td>
                                <td class='item-info'>".$sku."</td>
                                <td class='item-qty'>".($res['magequantity'] * 1).'</td>
                             </tr></tbody>';

                        $emailTemplateVariables = [];
                        $emailTempVariables['myvar1'] = $orderProductInfo;
                        $emailTempVariables['myvar2'] = $username;

                        $this->_objectManager->get(
                            'Webkul\Marketplace\Helper\Email'
                        )->sendLowStockNotificationMail(
                            $emailTemplateVariables,
                            $senderInfo,
                            $receiverInfo
                        );
                    }
                }
            }
            $shippingCharges = $info->getShippingCharges();
            $totalCod = 0;

            if ($paymentCode == 'mpcashondelivery') {
                $totalCod = $info->getCodCharges();
                $codRow = "<tr class='subtotal'>
                            <th colspan='3'>".__('Cash On Delivery Charges')."</th>
                            <td colspan='3'><span>".
                                $order->formatPrice($totalCod).
                            '</span></td>
                            </tr>';
            } else {
                $codRow = '';
            }

            $orderinfo = $orderinfo."<tfoot class='order-totals'>
                                <tr class='subtotal'>
                                    <th colspan='4'>".__('Shipping & Handling Charges')."</th>
                                    <td colspan='4'><span>".
                                    $order->formatPrice($shippingCharges)."</span></td>
                                </tr>
                                <tr class='subtotal'>
                                    <th colspan='4'>".__('Tax Amount')."</th>
                                    <td colspan='4'><span>".
                                    $order->formatPrice($totalTaxAmount).'</span></td>
                                </tr>'.$codRow."
                                <tr class='subtotal'>
                                    <th colspan='4'>".__('Grandtotal')."</th>
                                    <td colspan='4'><span>".
                                    $order->formatPrice(
                                        $totalprice +
                                        $totalTaxAmount +
                                        $shippingCharges +
                                        $totalCod
                                    ).'</span></td>
                                </tr></tfoot>';

            $emailTemplateVariables = [];
            if ($shippingInfo != '') {
                $isNotVirtual = 1;
            } else {
                $isNotVirtual = 0;
            }
            $emailTempVariables['myvar1'] = $order->getRealOrderId();
            $emailTempVariables['myvar2'] = $order['created_at'];
            $emailTempVariables['myvar4'] = $billinginfo;
            $emailTempVariables['myvar5'] = $payment;
            $emailTempVariables['myvar6'] = $shippingInfo;
            $emailTempVariables['isNotVirtual'] = $isNotVirtual;
            $emailTempVariables['myvar9'] = $shippingDes;
            $emailTempVariables['myvar8'] = $orderinfo;
            $emailTempVariables['myvar3'] = $username;

            if ($this->_marketplaceHelper->getOrderApprovalRequired()) {
                $emailTempVariables['seller_id'] = $info['seller_id'];
                $emailTempVariables['order_id'] = $lastOrderId;
                $emailTempVariables['sender_name'] = $senderInfo['name'];
                $emailTempVariables['sender_email'] = $senderInfo['email'];
                $emailTempVariables['receiver_name'] = $receiverInfo['name'];
                $emailTempVariables['receiver_email'] = $receiverInfo['email'];

                $orderPendingMailsCollection = $this->_objectManager->create(
                    'Webkul\Marketplace\Model\OrderPendingMails'
                );
                $orderPendingMailsCollection->setData($emailTempVariables);
                $orderPendingMailsCollection->setCreatedAt($this->_date->gmtDate());
                $orderPendingMailsCollection->setUpdatedAt($this->_date->gmtDate());
                $orderPendingMailsCollection->save();
                $order->setOrderApprovalStatus(0)->save();
            } else {
                $this->_objectManager->get(
                    'Webkul\Marketplace\Helper\Email'
                )->sendPlacedOrderEmail(
                    $emailTempVariables,
                    $senderInfo,
                    $receiverInfo
                );
            }
        }
    }

    /**
     * Get Order Product Option Data Method.
     *
     * @param \Magento\Sales\Model\Order\Item $item
     * @param array                           $result
     *
     * @return array
     */
    public function getProductOptionData($item, $result = [])
    {
        if ($options = $this->_unserializer->unserialize($item->getProductOptions())) {
            if (isset($options['options'])) {
                $result = array_merge($result, $options['options']);
            }
            if (isset($options['additional_options'])) {
                $result = array_merge($result, $options['additional_options']);
            }
            if (isset($options['attributes_info'])) {
                $result = array_merge($result, $options['attributes_info']);
            }
        }

        return $result;
    }

    /**
     * Get Order Product Name Html Data Method.
     *
     * @param array  $result
     * @param string $productName
     *
     * @return string
     */
    public function getProductNameHtml($result, $productName)
    {
        if ($_options = $result) {
            $proOptionData = '<dl class="item-options">';
            foreach ($_options as $_option) {
                $proOptionData .= '<dt>'.$_option['label'].'</dt>';

                $proOptionData .= '<dd>'.$_option['value'];
                $proOptionData .= '</dd>';
            }
            $proOptionData .= '</dl>';
            $productName = $productName.'<br/>'.$proOptionData;
        } else {
            $productName = $productName.'<br/>';
        }

        return $productName;
    }

    /**
     * Seller Product Sales Calculation Method.
     *
     * @param \Magento\Sales\Model\Order $order
     */
    public function productSalesCalculation($order)
    {
        /*
        * Marketplace Order details save before Observer
        */
        $this->_eventManager->dispatch(
            'mp_order_save_before',
            ['order' => $order]
        );

        /*
        * Get Global Commission Rate for Admin
        */
        $percent = $this->_marketplaceHelper->getConfigCommissionRate();

        /*
        * Get Current Store Currency Rate
        */
        $currentCurrencyCode = $this->_marketplaceHelper->getCurrentCurrencyCode();
        $baseCurrencyCode = $this->_marketplaceHelper->getBaseCurrencyCode();
        $allowedCurrencies = $this->_marketplaceHelper->getConfigAllowCurrencies();
        $rates = $this->_marketplaceHelper->getCurrencyRates(
            $baseCurrencyCode,
            array_values($allowedCurrencies)
        );
        if (empty($rates[$currentCurrencyCode])) {
            $rates[$currentCurrencyCode] = 1;
        }

        $lastOrderId = $order->getId();

        /*
        * Marketplace Credit Management module Observer
        */
        $this->_eventManager->dispatch(
            'mp_discount_manager',
            ['order' => $order]
        );

        $this->_eventManager->dispatch(
            'mp_advance_commission_rule',
            ['order' => $order]
        );

        $sellerData = $this->getSellerProductData($order, $rates[$currentCurrencyCode]);
        
        $sellerProArr = $sellerData['seller_pro_arr'];
        $sellerTaxArr = $sellerData['seller_tax_arr'];

        $taxToSeller = $this->_marketplaceHelper->getConfigTaxManage();
        $shippingAll = $this->_coreSession->getData('shippinginfo');
        $shippingAllCount = count($shippingAll);
        /**
         * Saving custom Bakeway fields
         */
        $shippingInclTax = $order->getShippingAmount();
        $shippingExclTax = $this->payoutsHelper->getDeliveryFeeExclTax($shippingInclTax);
        $convenienceFeeInclTax = $this->feeHelper->getCustomFee();
        $convenienceFeeExlTax = $this->feeHelper->getCustomFeeExclTax();
        $subtotal = $order->getSubtotal();
        $grandTotal = $order->getGrandTotal();
        $orderPgPercent = $this->payoutsHelper->getOrderPaymentGatewayPercentage();
        $pgFee = ($grandTotal - $convenienceFeeInclTax) * ($orderPgPercent/100);
        $orderDiscount = $order->getDiscountAmount();
        $grabDeliveryaFlg  = $order->getGrabDeliveryFlag();
        if(!empty($grabDeliveryaFlg)){
            $grabDeliveryaFlg = $order->getGrabDeliveryFlag();
        }else{
            $grabDeliveryaFlg = 0;
        }

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/order_marketplacecheck.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        $tcsShippingPriceInclTax = $shippingInclTax;
        $logger->info("shupping incl tax ".$tcsShippingPriceInclTax);
        /**
         * TCS fees set 0 in case of grab 
         */
        if($grabDeliveryaFlg == 1){
            $logger->info('grab flag  is active for order id '.$lastOrderId);
            $tcsShippingPriceInclTax = 0;
        }
       
        $tcsAmount = $this->payoutsHelper->getTCSAmount($subtotal, $tcsShippingPriceInclTax);

        $logger->info("returned tcs amount ".$tcsAmount);
        $logger->info('----------------------');
        foreach ($sellerProArr as $key => $value) {
            $isTaxPaidByBakeway = $this->payoutsHelper->isTaxPaidByBakeway($key);
            if ($isTaxPaidByBakeway == true) {
                $bakewayTaxPaid = 1;
            } else {
                $bakewayTaxPaid = 0;
            }
            $productIds = implode(',', $value);
            $data = [
                'order_id' => $lastOrderId,
                'product_ids' => $productIds,
                'seller_id' => $key,
                'shipping_charges' => $shippingInclTax, //Added by bakeway team for calculations
                'total_tax' => $sellerTaxArr[$key],
                'tax_to_seller' => $taxToSeller,
                'delivery_fee' => $shippingInclTax,
                'delivery_fee_excl_tax' => $shippingExclTax,
                'convenience_fee' => $convenienceFeeExlTax,
                'convenience_fee_incl_tax' => $convenienceFeeInclTax,
                'tcs_amount' => $tcsAmount,
                'payment_gateway_fee' =>$pgFee,
                'payment_gateway_percentage'=> $orderPgPercent,
                'tax_paid_by_bakeway' => $bakewayTaxPaid,
                'coupon_amount' => abs($orderDiscount),
                'grab_delivery_flag' => $grabDeliveryaFlg
            ];
            if (!$shippingAllCount && $key == 0) {
                $shippingCharges = $order->getShippingAmount();
                $data = [
                    'order_id' => $lastOrderId,
                    'product_ids' => $productIds,
                    'seller_id' => $key,
                    'shipping_charges' => $shippingCharges,
                    'total_tax' => $sellerTaxArr[$key],
                    'tax_to_seller' => $taxToSeller,
                    'delivery_fee' => $shippingInclTax,
                    'delivery_fee_excl_tax' => $shippingExclTax,
                    'convenience_fee' => $convenienceFeeExlTax,
                    'convenience_fee_incl_tax' => $convenienceFeeInclTax,
                    'tcs_amount' => $tcsAmount,
                    'payment_gateway_fee' =>$pgFee,
                    'payment_gateway_percentage'=> $orderPgPercent,
                    'tax_paid_by_bakeway' => $bakewayTaxPaid,
                    'coupon_amount' => abs($orderDiscount),
                    'grab_delivery_flag' => $grabDeliveryaFlg
                ];
            }
            $collection = $this->_objectManager->create(
                'Webkul\Marketplace\Model\Orders'
            );
            $collection->setData($data);
            $collection->setCreatedAt($this->_date->gmtDate());
            $collection->setSellerPendingNotification(1);
            $collection->setUpdatedAt($this->_date->gmtDate());
            $collection->save();
        }
        /*
        * Marketplace Order details save after Observer
        */
        $this->_eventManager->dispatch(
            'mp_order_save_after',
            ['order' => $order]
        );
    }

    /**
     * Get Seller's Product Data.
     *
     * @param \Magento\Sales\Model\Order $order
     * @param int                        $ratesPerCurrency
     *
     * @return array
     */
    public function getSellerProductData($order, $ratesPerCurrency)
    {
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/orderitemids.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("---start inside in observer after placing order to update saleslist table--"); 
        $logger->info("---Order Item Id for quote id ".$order->getQuoteId());
        $lastOrderId = $order->getId();
        /*
        * Get Global Commission Rate for Admin
        */
        $percent = $this->_marketplaceHelper->getConfigCommissionRate();

        $sellerProArr = [];
        $sellerTaxArr = [];
        $isShippingFlag = [];
        /*
        * Marketplace Credit discount data
        */
        $discountDetails = [];
        $discountDetails = $this->_coreSession->getData('salelistdata');
        
        foreach ($order->getAllItems() as $item) {
            $itemData = $item->getData();
            $bundleSelectionAttributes = $this->getBundleSelectionAttributes($itemData);
            if (!$bundleSelectionAttributes['option_id']) {
                $sellerId = $this->getSellerIdPerProduct($item);

                $isShippingFlag = $this->getShippingFlag($item, $sellerId, $isShippingFlag);

                $price = $this->getProductPrice($item, $discountDetails, $ratesPerCurrency);

                $taxamount = $this->_marketplaceHelper->getOrderedPricebyorder($order, $itemData['tax_amount']);
                $qty = $item->getQtyOrdered();

                $totalamount = $qty * $price;

                $advanceCommissionRule = $this->_customerSession->getData(
                    'advancecommissionrule'
                );
                $commission = $this->getCommission($sellerId, $totalamount, $item, $advanceCommissionRule);
                
                $bakewayCommissionArray = $this->payoutsHelper->getBakewayCommission($commission, $sellerId);
                $bakeayCommission = $bakewayCommissionArray['bakeway_commission'];
                $bakewayCommissionTaxDetails = $bakewayCommissionArray['commission_tax_details'];

                $actparterprocost = $totalamount - $bakeayCommission;

                $actparterprocostExlTax = $totalamount - $commission;

                $collectionsave = $this->_objectManager->create(
                    'Webkul\Marketplace\Model\Saleslist'
                );
                $collectionsave->setMageproductId($item->getProductId());
                $collectionsave->setOrderItemId($item->getItemId());
                $collectionsave->setParentItemId($item->getParentItemId());
                $collectionsave->setOrderId($lastOrderId);
                $collectionsave->setMagerealorderId($order->getIncrementId());
                $collectionsave->setMagequantity($qty);
                $collectionsave->setSellerId($sellerId);
                $collectionsave->setCpprostatus(\Webkul\Marketplace\Model\Saleslist::PAID_STATUS_PENDING);
                $collectionsave->setMagebuyerId($this->_customerSession->getCustomerId());
                $collectionsave->setMageproPrice($price);
                $collectionsave->setMageproName($item->getName());
                if ($totalamount != 0) {
                    $collectionsave->setTotalAmount($totalamount);
                    $commissionRate = ($commission * 100) / $totalamount;
                } else {
                    $collectionsave->setTotalAmount($price);
                    $commissionRate = $percent;
                }
                $collectionsave->setTotalTax($taxamount);
                $collectionsave->setTotalCommission($commission);
                $collectionsave->setActualSellerAmount($actparterprocost);
                $collectionsave->setActualSellerAmountExclTax($actparterprocostExlTax);
                $collectionsave->setCommissionRate($commissionRate);
                if (isset($isShippingFlag[$sellerId])) {
                    $collectionsave->setIsShipping($isShippingFlag[$sellerId]);
                }
                $collectionsave->setCreatedAt($this->_date->gmtDate());
                $collectionsave->setUpdatedAt($this->_date->gmtDate());
                /**
                 * Saving custom bakeway fields
                 **/
                $collectionsave->setCommissionInclTax($bakeayCommission);
                $collectionsave->setCommissionTaxDetails(serialize($bakewayCommissionTaxDetails));
               
                /*
                 * @BKWYADMIN-1074
                 * 07-09-2018
                 */
                
             
                 $checkItemId = $this->checkDuplicateOrderItem($item->getItemId());
                 $logger->info("quote id ".$order->getQuoteId()." item-id is ".$item->getItemId());
                 $logger->info("return value of item id ".$item->getItemId()." is ".$checkItemId);
                 
                 if($checkItemId === false){
                   $collectionsave->save();
                 }
                
                $qty = '';
                if (!isset($sellerTaxArr[$sellerId])) {
                    $sellerTaxArr[$sellerId] = 0;
                }
                $sellerTaxArr[$sellerId] = $sellerTaxArr[$sellerId] + $taxamount;
                if ($price != 0.0000) {
                    if (!isset($sellerProArr[$sellerId])) {
                        $sellerProArr[$sellerId] = [];
                    }
                    array_push($sellerProArr[$sellerId], $item->getProductId());
                } else {
                    if (!$item->getParentItemId()) {
                        if (!isset($sellerProArr[$sellerId])) {
                            $sellerProArr[$sellerId] = [];
                        }
                        array_push($sellerProArr[$sellerId], $item->getProductId());
                    }
                }
            }
        }
        $logger->info("---end inside in observer after placing order to update saleslist table--"); 

        return ['seller_pro_arr' => $sellerProArr, 'seller_tax_arr' => $sellerTaxArr];
    }

    /**
     * Get Order Bundle Product Selection Attributes.
     *
     * @param \Magento\Sales\Model\Order\Item $itemData
     *
     * @return array
     */
    public function getBundleSelectionAttributes($itemData)
    {
        $attrselection = $this->_unserializer->unserialize(
            serialize($itemData['product_options'])
        );
        $bundleSelectionAttributes = [];
        if (isset($attrselection['bundle_selection_attributes'])) {
            $bundleSelectionAttributes = $this->_unserializer->unserialize(
                serialize($attrselection['bundle_selection_attributes'])
            );
        } else {
            $bundleSelectionAttributes['option_id'] = 0;
        }

        return $bundleSelectionAttributes;
    }

    /**
     * Get Order Product Price Method.
     *
     * @param \Magento\Sales\Model\Order\Item $item
     * @param array                           $discountDetails
     * @param int                             $ratesPerCurrency
     *
     * @return array
     */
    public function getProductPrice($item, $discountDetails, $ratesPerCurrency)
    {
        if ($discountDetails[$item->getProductId()]) {
            $price = $discountDetails[$item->getProductId()]['price']
            / $ratesPerCurrency;
        } else {
            $price = $item->getPrice() / $ratesPerCurrency;
        }

        return $price;
    }

    /**
     * Get Commission Amount.
     *
     * @param int                             $sellerId
     * @param float                           $totalamount
     * @param \Magento\Sales\Model\Order\Item $item
     * @param array                           $advanceCommissionRule
     *
     * @return float
     */
    public function getCommission($sellerId, $totalamount, $item, $advanceCommissionRule)
    {
        /*
        * Get Global Commission Rate for Admin
        */
        $percent = $this->_marketplaceHelper->getConfigCommissionRate();

        $commission = 0;

        $collection1 = $this->_objectManager->create(
            'Webkul\Marketplace\Model\Saleperpartner'
        )
        ->getCollection()
        ->addFieldToFilter(
            'seller_id',
            $sellerId
        );
        if ($collection1->getSize() != 0) {
            foreach ($collection1 as $rowdatasale) {
                $commission = ($totalamount * $rowdatasale->getCommissionRate()) / 100;
            }
        } else {
            $commission = ($totalamount * $percent) / 100;
        }

        if (!$this->_marketplaceHelper->getUseCommissionRule()) {
            $wholedata['id'] = $item->getProductId();
            $this->_eventManager->dispatch(
                'mp_advance_commission',
                [$wholedata]
            );

            $advancecommission = $this->_customerSession->getData('commission');
            if ($advancecommission != '') {
                $percent = $advancecommission;
                $commType = $this->_marketplaceHelper->getCommissionType();
                if ($commType == 'fixed') {
                    $commission = $percent;
                } else {
                    $commission = ($totalamount * $advancecommission) / 100;
                }
                if ($commission > $totalamount) {
                    $commission = $totalamount * $this->_marketplaceHelper->getConfigCommissionRate() / 100;
                }
            }
        } else {
            if (count($advanceCommissionRule)) {
                if ($advanceCommissionRule[$item->getId()]['type'] == 'fixed') {
                    $commission = $advanceCommissionRule[$item->getId()]['amount'];
                } else {
                    $commission =
                    ($totalamount * $advanceCommissionRule[$item->getId()]['amount']) / 100;
                }
            }
        }

        return $commission;
    }

    /**
     * Get Seller ID Per Product.
     *
     * @param \Magento\Sales\Model\Order\Item $item
     *
     * @return int
     */
    public function getSellerIdPerProduct($item)
    {
        $infoBuyRequest = $item->getProductOptionByCode('info_buyRequest');

        $mpassignproductId = 0;
        if (isset($infoBuyRequest['mpassignproduct_id'])) {
            $mpassignproductId = $infoBuyRequest['mpassignproduct_id'];
        }
        if ($mpassignproductId) {
            $mpassignModel = $this->_objectManager->create(
                'Webkul\MpAssignProduct\Model\Items'
            )->load($mpassignproductId);
            $sellerId = $mpassignModel->getSellerId();
        } elseif (array_key_exists('seller_id', $infoBuyRequest)) {
            $sellerId = $infoBuyRequest['seller_id'];
        } else {
            $sellerId = '';
        }
        if ($sellerId == '') {
            $collectionProduct = $this->_objectManager->create(
                'Webkul\Marketplace\Model\Product'
            )
            ->getCollection()
            ->addFieldToFilter(
                'mageproduct_id',
                $item->getProductId()
            );
            foreach ($collectionProduct as $value) {
                $sellerId = $value->getSellerId();
            }
        }
        if ($sellerId == '') {
            $sellerId = 0;
        }

        return $sellerId;
    }

    /**
     * Get Shipping Flag Per Seller Method.
     *
     * @param \Magento\Sales\Model\Order\Item $item
     * @param int                             $sellerId
     * @param array                           $result
     *
     * @return array
     */
    public function getShippingFlag($item, $sellerId, $isShippingFlag = [])
    {
        if (($item->getProductType() != 'virtual') && ($item->getProductType() != 'downloadable')) {
            if (!isset($isShippingFlag[$sellerId])) {
                $isShippingFlag[$sellerId] = 1;
            } else {
                $isShippingFlag[$sellerId] = 0;
            }
        }

        return $isShippingFlag;
    }
    
    /**
     * 
     * @param type $itemId
     * @return boolean
     */
    public function checkDuplicateOrderItem($itemId) {
       if(empty($itemId)){
            return false;
        }
        
        $collection = $this->_objectManager->create(
           'Webkul\Marketplace\Model\Saleslist')
        ->getCollection()
        ->addFieldToFilter("order_item_id",$itemId)
        ->addFieldToSelect("order_item_id")
        ->getFirstItem();
         
        $orderitemId = $collection->getData('order_item_id');       
        
        $itemIdFlag = false;

        if(isset($orderitemId) && !empty($orderitemId)){
           $itemIdFlag = true;
        }
        return $itemIdFlag;
         
    }
}
