<?php 
namespace Bakeway\ExportCsv\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Bakeway\ExportCsv\Helper\Data as ExportCsvHelper;

class OrderList extends \Magento\Framework\DataObject
{
       /**
      *@var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
      */ 
       protected $_orderCollectionFactory;
       /**
      * @var \Bakeway\OrderstatusEmail\Block\Order\Email\Items
      */ 
        protected $emailItems;

      /**
       * @var ExportCsvHelper
       */ 
        protected $exportCsvHelper;

        /**
      *Construct
      * @param  \Magento\Sales\Model\OrderFactory $orderFactory
      * @param  \Bakeway\OrderstatusEmail\Block\Order\Email\Items $emailItems
      * @param  \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
      * @param  \Magento\Framework\App\Response\Http\FileFactory $fileFactory
      * @param  Filesystem $filesystem
      * @param array $data
      */
	 public function __construct(
              
          \Magento\Sales\Model\OrderFactory $orderFactory,
          \Bakeway\OrderstatusEmail\Block\Order\Email\Items $emailItems,
	 	      \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
		      \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
		      Filesystem $filesystem,
          ExportCsvHelper $exportCsvHelper,
		      array $data = []
         ){
		parent::__construct($data);
	       $this->orderFactory = $orderFactory;
         $this->emailItems = $emailItems;
         $this->exportCsvHelper = $exportCsvHelper;
		     $this->_orderCollectionFactory = $orderCollectionFactory;
         $this->_fileFactory = $fileFactory;
         $this->directory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
	}

  /**
   * @param $formDate
   * @param $toDate
   * @return $this
   */
	public function orderexport($fromDate,$toDate){ 

        /*$fromdate = $this->exportCsvHelper->getStoreWiseFromDate($fromDate);
        $todate   = $this->exportCsvHelper->getStoreWiseToDate($toDate);*/
        $fromdate = $fromDate ." ".date('00:00:00');
        $fromdate = date("Y-m-d H:i:s", strtotime("-330 minutes", strtotime($fromdate)));

        $todate   = $toDate . " ".date('23:59:59');
        $todate = date("Y-m-d H:i:s", strtotime("-330 minutes", strtotime($todate)));

        $headers = array(
                'Order ID',
                'Delivery Type',
                'Order Date & Time',
                'Seller Id',
                'Bakery Name',
                'Time to accept/ Reject',
                'Delay to Mark as Completed',
                'Reject Reason',
                'Store Owner Mobile No.',
                'Store Manager Mobile No.',
                'Note to bakery',
                'Sender Name',
                'Sender Email',
                'Sender Address',
                'Delivery Date & Time',
                'Delivery Person Name',
                'Delivery Address',
                'Order Value',
                'Shipping & Handling Charges',
                'Payment Mode',
                'Offer Applied Coupon',
                'Bakery Address',
                'Product Name',
                'Product Sku',
                'Product Price',
                'Product Image',
                'Product Flavour',
                'Weight of Product',
                'Ingredients',
                'Sender Phone number',
                'Delivery Person number',
                'Message on the cake',
                'Commission',
                'Convenience Fee',
                'Payment Gateway Charge',
                'Discount Amount',
                'GST Amount',
                'City Name',
                'Order Status',
                'Actual Seller Amount',
                'Paid Status',
                'Completed At'
                
            );
          

             $orders = $this->_orderCollectionFactory->create()->addFieldToSelect('*');
             $orders->getSelect()->joinLeft(array('mo' => 'marketplace_orders'),
                    'main_table.entity_id = mo.order_id',
                    array('mo.seller_id', 'mo.payment_gateway_fee', 'mo.coupon_amount'));

             $orders->getSelect()->joinLeft(array('mu' => 'marketplace_userdata'),
                    'mo.seller_id = mu.seller_id',
                    array('mu.business_name', 'mu.store_owner_mobile_no', 'mu.store_manager_mobile_no',
			    'mu.store_street_address', 'mu.userdata_gstin_number'));
             $orders->getSelect()->joinLeft(array('sog' => 'sales_order_grid'),
                    'main_table.entity_id = sog.entity_id',
                    array('sog.billing_name', 'sog.customer_email', 'sog.billing_address', 'sog.shipping_name','sog.shipping_address', 'sog.payment_method'));
             $orders->getSelect()->joinLeft(array('sosh' => 'sales_order_status_history'),
                    'main_table.entity_id = sosh.parent_id',
                    array('sosh.comment'));
            $orders->getSelect()->joinLeft(array('bpl' => 'bakeway_partner_locations'),
                    'bpl.seller_id = mo.seller_id', array());
            $orders->getSelect()->joinLeft(array('bc' => 'bakeway_cities'),
                    'bc.id = bpl.city_id', array('bc.name'));
            $orders->getSelect()->joinLeft(array('sos' => 'sales_order_status'),
                    'main_table.status = sos.status', array('sos.label'));
            $orders->getSelect()->joinInner(array('mksl' => 'marketplace_saleslist'),
                    'main_table.increment_id = mksl.magerealorder_id',
                    array('mksl.actual_seller_amount', 'mksl.paid_status'));
            $orders->getSelect()->joinLeft(array('soit' => 'sales_order_item'),
                    'main_table.entity_id = soit.order_id',
                     array('soit.custom_message'));
            $orders->getSelect()->columns([ "commission_incl_tax" => new \Zend_Db_Expr("(SELECT  SUM(commission_incl_tax) FROM marketplace_saleslist WHERE order_id = main_table.entity_id GROUP BY order_id)")]);
           $orders->getSelect()->where('main_table.status NOT IN ("bakeway_payment_pending", "canceled")');
           $orders->getSelect()->group("main_table.entity_id");

           $orders->addFilterToMap('created_at', 'main_table.created_at');
           $orders->addFilterToMap('customer_email', 'sog.customer_email');
           $orders->addFilterToMap('seller_id', 'mo.seller_id');
           $orders->addFilterToMap('increment_id',
                    'main_table.increment_id');
           $orders->addFilterToMap('commission_incl_tax',
                    'commission_incl_tax');
           $orders->addFilterToMap('userdata_gstin_number',
                    'mu.userdata_gstin_number');
           $orders->addFilterToMap('payment_gateway_fee',
                    'mo.payment_gateway_fee');
           $orders->addFilterToMap('coupon_amount', 'mo.coupon_amount');
           $orders->addFilterToMap('store_owner_mobile_no',
                    'mu.store_owner_mobile_no');
           $orders->addFilterToMap('store_manager_mobile_no',
                    'mu.store_manager_mobile_no');
           $orders->addFilterToMap('comment', 'sosh.comment');
           $orders->addFilterToMap('business_name', 'mu.business_name');
           $orders->addFilterToMap('payment_method', 'sog.payment_method');
           $orders->addFilterToMap('billing_name', 'sog.billing_name');
           $orders->addFilterToMap('billing_address', 'sog.billing_address');
           $orders->addFilterToMap('delivery_time',
                    'main_table.delivery_time');
           $orders->addFilterToMap('shipping_name', 'sog.shipping_name');
           $orders->addFilterToMap('shipping_address',
                    'sog.shipping_address');
           $orders->addFilterToMap('base_grand_total',
                    'main_table.base_grand_total');
           $orders->addFilterToMap('label', 'sos.label');
           $orders->addFilterToMap('name', 'bc.name');            
           $orders->addAttributeToFilter('created_at', array('from'=>$fromdate ,'to'=>$todate));
           $orders->setOrder('main_table.entity_id', 'ASC');
           $this->setCollection($orders);
        
         $exportfile = $this->getCsvdataFile($headers,$orders,$fromDate);
	
        }

   public function getCsvdataFile($headers,$orders,$fromDate)
    	{
        $fromdate = date('Y-m-01', strtotime($fromDate));
        $toDate = date('Y-m-t', strtotime($fromDate));
        $file = 'reports/orderexport' . $fromdate.'to'.$toDate. '.csv';
        $this->directory->create('reports');

        $start_day = date('Y-m-01', strtotime($fromDate));
        if($start_day == $fromDate)
        {
          $stream = $this->directory->openFile($file, 'w+');
          $stream->lock();
          $stream->writeCsv($headers);
        }
        else
        {
          $stream = $this->directory->openFile($file, 'a');
        }

        
            $orderdetails = array();
        
        foreach($orders as $orderdata){

          $exportCsvHelper = $this->exportCsvHelper;

    $orderdetail['Order Id'] = $orderdata->getData('increment_id');
    $orderdetail['Delivery Type'] = $orderdata->getData('delivery_type');
    $orderdetail['Order Date & Time'] =$exportCsvHelper->getOrderDate($orderdata->getData('created_at'));
               
    $orderdetail['Seller Id'] = $orderdata->getData('seller_id');
    $orderdetail['Bakery Name'] = $orderdata->getData('business_name');
    $orderdetail['Time To Accept/Reject'] = $exportCsvHelper->getOrderAccRejectTime($orderdata->getData('entity_id'), $orderdata->getData('created_at'));
    $orderdetail['Delay to Mark as Completed'] = $exportCsvHelper->OrderCompleted($orderdata->getData('entity_id'), $orderdata->getData('delivery_time'));
           
    $orderdetail['Reject Reason'] =$exportCsvHelper->RejectorderStatus($orderdata->getData('entity_id'));
           
    $orderdetail['Store Owner Mobile No.'] = $orderdata->getData('store_owner_mobile_no');
    $orderdetail['Store Manager Mobile No.'] = $orderdata->getData('store_manager_mobile_no');
    $orderdetail['Note to bakery'] = $orderdata->getData('customer_notes');
    $orderdetail['Sender Name'] = $orderdata->getData('billing_name');
    $orderdetail['Sender Email'] = $orderdata->getData('customer_email');
    $orderdetail['Sender Address'] = $orderdata->getData('billing_address');
    $orderdetail['Delivery Date & Time'] = $exportCsvHelper->getDeliveryTime($orderdata->getData('delivery_time'));   
    $orderdetail['Delivery Person Name'] = $orderdata->getData('shipping_name');
    $orderdetail['Delivery Address'] = $orderdata->getData('shipping_address');
    $orderdetail['Order Value'] = $orderdata->getData('base_grand_total');
    $orderdetail['Shipping & Handling Charges'] = $orderdata->getData('base_shipping_amount');
    $orderdetail[ 'Payment Mode'] = $orderdata->getData('payment_method');
    $orderdetail['Offer Applied Coupon'] = $orderdata->getData('coupon_rule_name');

                   $orderData = $this->orderFactory->create()->loadByIncrementId($orderdata->getData('increment_id'));
                   
                    $orderItemData = $orderData->getAllVisibleItems();
                   
              $_items = $orderData->getItemsCollection();
                    foreach ($_items as $_item) {
                        if ($_item->getParentItem()) {
                            continue;
                        }
                        try {
                            $getSku = $_item->getSku();
                        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                            $getSku = false;
                        }
                        if (!empty($getSku)) {

                            $cakeFlavour = $_item["item_flavour"];
                            $cakeIngre = $_item["item_ingredient"];
                            $cakeWeight = $_item["item_weight"];
                            $imageUrl = $_item['item_image_url'];
                            $bakeryDetails = $this->emailItems->getSellerAddressDetails($_item);
                            if (isset($bakeryDetails['street_address'])) {
                                $bakeryAddress = $bakeryDetails['street_address'];
                            } else {
                                $bakeryAddress = "NA";
                            }
            


    $orderdetail['Bakery Address'] = $bakeryAddress;
    $orderdetail['Product Name'] =  $_item->getName();
    $orderdetail['Product Sku'] = $_item->getSku();

                         if ($_item['base_price_incl_tax']) {
                                $price = $_item['base_price_incl_tax'];
                            } else {
                                $price = $_item['base_price'];
                            }

    $orderdetail['Product Price'] = $price;
    $orderdetail['Product Image'] = $imageUrl;
    $orderdetail['Product Flavour'] = $cakeFlavour;
    $orderdetail['Weight of Product'] = $cakeWeight;
    $orderdetail['Ingredients'] = $cakeIngre;
    $orderdetail[ 'Sender Phone number'] = $orderData->getBillingAddress()->getTelephone();
    $orderdetail['Delivery Person number'] = $orderData->getShippingAddress()->getTelephone();
    }
  }
    $orderdetail['Message on the cake'] = $orderdata->getData('custom_message');
    $orderdetail['Commission'] = $orderdata->getData('commission_incl_tax');
    $orderdetail['Convenience Fee'] = $orderdata->getData('fee');
    $orderdetail['Payment Gateway Charge'] = $orderdata->getData('payment_gateway_fee');
    $orderdetail['Discount Amount'] = $orderdata->getData('coupon_amount');
    $orderdetail['GST Amount'] =$exportCsvHelper->getGst($orderdata->getData('userdata_gstin_number'),$orderdata->getData('entity_id'));
    $orderdetail['City Name'] = $orderdata->getData('name');
    $orderdetail['Order Status'] = $orderdata->getData('label');
    $orderdetail['Actual Seller Amount'] = $exportCsvHelper->getTotalSellerAmount($orderdata->getData('increment_id'));
    $orderdetail['Paid Status'] =$exportCsvHelper->PaidStatus($orderdata->getData('paid_status'));
    
    $orderdetail[ 'Completed At'] = $exportCsvHelper->status($orderdata->getData('label'),$orderdata->getData('updated_at'));
   
            $stream->writeCsv($orderdetail);
            
     }
        $stream->unlock();
        $stream->close();
        return [
            'type' => 'filename',
            'value' => $file,
            'rm' => true  // can delete file after use
        ];
    }

}	

