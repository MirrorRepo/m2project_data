<?php

/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Xnotif
 */

namespace Amasty\Xnotif\Controller\Adminhtml\OrderDispatch;

require(BP . "/lib/dompdf/src/Autoloader.php");
\Dompdf\Autoloader::register();

use \Dompdf\Dompdf;
use Magento\Sales\Model\Order\Address\Renderer as AddressRenderer;

class View extends \Magento\Backend\App\Action {

    CONST FIX_ITEM = 8;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Amasty\Xnotif\Helper\Data
     */
    private $helper;
    protected $addressRenderer;

    public function __construct(
    \Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Amasty\Xnotif\Helper\Data $helper, AddressRenderer $addressRenderer,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper

    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->addressRenderer = $addressRenderer;
        $this->helper = $helper;
        $this->pricingHelper = $pricingHelper;
    }

    public function execute() {

        $orderId = $this->getRequest()->getParam('order_id');

        $htmlPdf = "";
// instantiate and use the dompdf class
        $dompdf = new Dompdf();

        /*         * get logo* */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        /*         * logo image* */
//$logo =  $_SERVER["DOCUMENT_ROOT"].'/bakeway_gi/bakeway/pub/media/invoice_pdf/logo.png';
    
        $logo =  $_SERVER["DOCUMENT_ROOT"].'/media/invoice_pdf/logo.png';
      // die;
       //$logo =  $_SERVER["DOCUMENT_ROOT"].'/media/invoice_pdf/logo.png';
        $orderid = $orderId;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderid);
        $orderId = $order['increment_id'];


        $orderDate = date("d/m/Y", strtotime($order['created_at']));

        $deliveryAddressObj = $order->getShippingAddress();

        $formattedDeliveryAddress = $this->addressRenderer->format($deliveryAddressObj, 'html');

        $formattedBillingAddress = $this->addressRenderer->format($order->getBillingAddress(), 'html');


        $items = [];
      

        foreach ($order->getAllVisibleItems() as $item) {
            $i = 0;

            $items[$item->getSku()]['sku'] = $item->getSku();
            $items[$item->getSku()]['name'] = $item->getName();
            $items[$item->getSku()]['price'] = number_format($item->getPrice(),2);
            $items[$item->getSku()]['qty'] = number_format($item->getQtyOrdered(),false);
            $items[$item->getSku()]['disc'] = number_format($item->getBaseDiscountAmount(),2);
            $items[$item->getSku()]['total'] = number_format(($item->getRowTotal() - $item->getBaseDiscountAmount()) * $item->getQtyOrdered(),2);

            $i++;
        }



          $itemsBelow = [];
      

        foreach ($order->getAllVisibleItems() as $item) {
            $i = 0;

            $itemsBelow[$item->getSku()]['sku'] = $item->getSku();
            $itemsBelow[$item->getSku()]['name'] = $item->getName();
            $itemsBelow[$item->getSku()]['price'] = number_format($item->getPrice(),2);
            $itemsBelow[$item->getSku()]['qty'] = number_format($item->getQtyOrdered(),false);
            $itemsBelow[$item->getSku()]['disc'] = number_format($item->getBaseDiscountAmount(),2);
            $itemsBelow[$item->getSku()]['total'] = number_format(($item->getRowTotal() - $item->getBaseDiscountAmount()) * $item->getQtyOrdered(),2);

            $i++;
        }

 $totOrderItem =  count($order->getAllVisibleItems());
 $totFixItem = self::FIX_ITEM - $totOrderItem;

for($i=1;$i< $totFixItem ;$i++){
$itemsBelow["extra-th ".$i] = [
                 "sku"=>'&nbsp;',
                 "name"=>'',
                 "price"=>'',
                 "qty"=>'',
                 "disc"=>'',
                 "total"=>''
];
}

//echo "<pre>";
       // print_r($itemsBelow);

        $shippingAmount =  $order->getBaseShippingAmount();
        $grandTotal = $order->getBaseGrandTotal();

        /* echo "<pre>";
          print_r($items); */
//fetch whole order information
//print_r($order->getData());
        $htmlPdf .= "<html>
    <head>
        <style>
            @page {
            size: 1000px  600px;
          
        }
   

      
body{
    font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    color:#333;
    text-align:left;
    font-size:15px;
    margin:0;
}
.container{
    margin:0 auto;
    margin-top:10px;
    padding:10px 40px 40px;
    width:750px;
    height:auto;
    background-color:#fff;
}
.itemtable th{ font-weight: normal}
caption{
    font-size:22px;
    margin-bottom:15px;
  border-bottom: 3px solid;
}
.just_retrun_slip{
  font-size:14px;
  margin:25px 0 5px 0;
}
.top_line_p{
 font-size:13px; 
}
tr.trfifty{
  width:50%!important;
}
.set_right{
text-align:right
}
.right_side{
width: 39%;
    display:inline-block;
  text-align:right!important;
}
.left_side{
width: 60%;
display:inline-block;
  text-align:left;
}
table{
    border:1px solid #333;
    border-collapse:collapse;
    margin:0 auto;
    width:740px;
}
td.borderme{
  border:1px solid #333;
}
td, tr, th{
    padding:2px;
  border-right:1px solid #333;
    border-left:1px solid #333;
}
 th{
    border:1px solid #333;
}

th.trfifty{
    background-color: #f0f0f0;
}
h4, p{
    margin:0px;
}
.some_notes{
  width:100%;
}
.return_notes{
  margin-top: 2%;float: left;
}

.left-return-items{ width:75% ;float: left}
.right-table-for-reason{ width:26% ;border: 0px; top:-162px;left:273px; position:relative}
.right-table-for-reason tr {border-left: 0px}
.right-table-for-reason tr th{ font-weight: normal ; text-align:justify; border-left: 0px}

table.itemreturn{
    border:1px solid #333;
    border-collapse:collapse;
    width:741px;
}
.right-table-for-reason th {border: 0px}
.common-footer-div{float: left; margin-top: -157px;}
  </style>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>

    </head>
    <body>";

        $htmlPdf .= "<div class='container'>
    <table>
        <caption> 
         <div class='left_side top_line'><img  width='180' src=" . $logo . "/>  </div> 
    <div class='right_side top_line_p' style='float:right'>  Dispatch/Returns Note</div>
    </div>
        </caption>
        <thead>
      <tr>
        <td >Order No: ".$orderId." </td>
         <td>Order Date: ".$orderDate." </td>
         <td>Customer No: ABCD007</td>
      </tr>
      </thead>
</table>
<br>
<div class='bill_details'>
 <table>

            <tr>
                <th class='trfifty'>Delivery Address</th>
                <th class='trfifty'>Billing Address</th>
            </tr>
            <tr >
                <td >
                    <p>".$formattedDeliveryAddress."</p>
                </td>
                <td >
                    <p>".$formattedBillingAddress."</p>
                </td>
            </tr>

</table>
</div>
<br>
  <table>
    
        <thead>
            
        </thead>
        <tbody>
            <tr>
                <th class='trfifty'>Product Code</th>
                <th class='trfifty'>Description</th>
                <th class='trfifty'>Price &pound</th>
                <th class='trfifty'>Qty</th>
        <th class='trfifty'>Discount</th>
        <th class='trfifty'>Total Price &pound</th>
            </tr>";
        foreach ($items as $valueItems) {
            $htmlPdf .= "<tr class='itemtable'>";
              $htmlPdf .= "<th>" . $valueItems['sku'] . "</th>";
              $htmlPdf .= "<th>" . $valueItems['name'] . "</th>";
              $htmlPdf .= "<th>&#163;" . $valueItems['price'] . "</th>";
              $htmlPdf .= "<th>" . $valueItems['qty'] . "</th>";
              $htmlPdf .= "<th>" . $valueItems['disc'] . "</th>";
              $htmlPdf .= "<th>&#163;" . $valueItems['total'] . "</th>";
             
            $htmlPdf .= "</tr>";
        }

        $htmlPdf .=
                "<tr>
                <th colspan='5' class='set_right trfifty'>Delivery charges</th>
                <td class='borderme'>&#163;".number_format($shippingAmount,2)."</td>
            </tr>
            <tr>
                <th colspan='5' class='set_right trfifty'>Total Order Inc VAT</th>
                
                <td class='borderme'>&#163;".number_format($grandTotal, 2)."</td>
            </tr>
        </tbody>
    </table>

<br>
<table class='itemreturn'>
        <thead>
            
        </thead>
        <tbody>
            <tr style='width:100%'>
                <th  style='width:17%' class='trfifty'>Product Code</th>
                <th style='width:33%'  class='trfifty'>Description</th>
                <th style='width:8%' class='trfifty'>Qty Returned</th>
                <th  style='width:10%' class='trfifty'>Reason Code</th>
                <th class='trfifty'>Return Reason</th>
            </tr>";
            $i=0;
              foreach ($itemsBelow as $valueItems) {
                if($i<=7):
            $htmlPdf .= "<tr class='itemtable' >";
              $htmlPdf .= "<th>" . $valueItems['sku'] . "</th>";
              $htmlPdf .= "<th>" . $valueItems['name'] . "</th>";
              $htmlPdf .= "<th></th>";
              $htmlPdf .= "<th></th>";
              $htmlPdf .= "<th ></th>";
             
            $htmlPdf .= "</tr>";
             $i++;
             endif;
        }
           $htmlPdf .=  "
        </tbody>
       
    </table>

    <table class='right-table-for-reason'>
     <tbody>
           
            <tr><th>1. Faulty</th></tr>
            <tr><th>2. Not Required</th></tr>
            <tr><th>3. Incorrect size</th></tr>
            <tr><th>4. Doesn't Fit properly</th></tr>
            <tr><th>5. Incorrect item received</th></tr>
            <tr><th>6. Other</th></tr>
            <tr><th>7. Not Required</th></tr>

     </tbody>       
    </table>


<div class='common-footer-div'>
    <div class='just_retrun_slip'>
    
    <div class='left_side'> Return Slip - Please detach this slip and return with parcel </div> 
    <div class='right_side'><strong> Order No: ".$orderId."</strong></div>
    </div>
     

      <div class='return_notes'>
    <h4> Return Options</h4>
<p>Not happy with your order? If you want to return something you can do so easily within 14 days of receiving your order.</p>
 <div class='some_notes'>

 <br> 
   <h4>Free UK Returns by Post</h4>
<p>Returning items via Royal Mail is FREE, simply use the pee off label supplied separately with this disptach note and drop your parcel off at your Local post office.
</p><br>


<p>For full details of our returns and refunds policy, including exclusions, please visit our website - www.livebyverve.com Please allow up-to 21 days to process your returns when we receive your items..</p>
<br>
      <h4>VAT No. 309103635</h4>
  </div>
</div>
</div>
</div>";

        $htmlPdf .= " </body>
</html>";
    //  echo $htmlPdf;
     //die;
        $dompdf->loadHtml($htmlPdf);
// (Optional) Setup the paper size and orientation
//$dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
        $dompdf->render();


        //exit;
// Output the generated PDF to Browser
        $dompdf->stream("orderdispatch_".$orderid . "pdf");

        $resultPage = $this->resultPageFactory->create();


        return $resultPage;
    }




public function priceFormat($price){

  return $this->pricingHelper->currency($price,true,false);

}

}
