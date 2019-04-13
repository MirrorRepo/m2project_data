<?php
namespace Bakeway\EventsListing\Plugin;

class PluginBeforeView extends \Magento\Backend\Block\Widget\Grid\Container
{

    public function beforeGetOrderId(\Magento\Sales\Block\Adminhtml\Order\View $subject){
       
    $status1 = \Magento\Sales\Model\Order::STATE_COMPLETE;
   
    $status2 = $subject->getOrder()->getData('status');
    $orderId = $subject->getOrder()->getData('entity_id');


    if($status1 == $status2)
    {
       
        $ajaxUrl =  $this->getUrl('stoppayment/stoppayment/index', ['_secure' => true]);
        $subject->addButton(
           'payment_custom_button',
           [
               'label' => __('Stop Payment'),
               'class' => __('reset_class_'.$orderId."_class_".$ajaxUrl),
               'id' => 'stop-payment-custom-button',
           ]
       );
    }
        return null;
    }

}



//$subject->addButton(
//                'stopbutton',
//                ['label' => __('Stop Payment'), 
//                 'onclick' => 'window.location="'.$url.'";',
//                 'class' => 'reset'],
//                -1
//            );