<?php

namespace Bakeway\Reports\Block\Adminhtml\Tcs\Renderer;

use Magento\Framework\DataObject;
use Magento\Sales\Api\OrderRepositoryInterface as OrderRepositoryInterface;
use Bakeway\OrderstatusEmail\Model\Email as OrderStatusModel;

class VendorAccessAmount extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer {

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $orderRepositoryInterface;

    /**
     * @var OrderStatusModel
     */
    protected $orderStatusModel;

    /**
     * Orderreviewlink constructor.
     * @param OrderRepositoryInterface $orderRepositoryInterface
     * @param OrderStatusModel $orderStatusModel
     */
    public function __construct(
    OrderRepositoryInterface $orderRepositoryInterface, OrderStatusModel $orderStatusModel
    ) {
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->orderStatusModel = $orderStatusModel;
    }

    /**
     * get Review status
     * @param  DataObject $row
     * @return string
     */
    public function render(DataObject $row) {
        $orderSubTotal = $row->getBaseSubtotal();

        
        $orderDeliveryFee = $row['delivery_fee_excl_tax'];


        if($row['grab_delivery_flag'] == 1){
            $orderDeliveryFee = "";
        }
        
        $accessAmount = $orderSubTotal + $orderDeliveryFee;
        
        return $accessAmount;
    }

}
