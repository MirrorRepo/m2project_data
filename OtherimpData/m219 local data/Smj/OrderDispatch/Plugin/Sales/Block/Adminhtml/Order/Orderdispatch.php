<?php
/**
 * Copyright © 2015 Smj. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Smj_Zohocrm extension
 * NOTICE OF LICENSE
 *
 * @category Smj
 * @package  Smj_Zohocrm
 * @author   Mukund
 */
namespace  Smj\OrderDispatch\Plugin\Sales\Block\Adminhtml\Order;

use Magento\Sales\Block\Adminhtml\Order\View as OrderView;

class Orderdispatch
{
    public function beforeSetLayout(OrderView $subject)
    {
        $subject->addButton(
            'order_custom_button',
            [
                'label' => __('Order Dispatch'),
                'class' => __('order-dispatch'),
                'id' => 'order-view-custom-button',
                'onclick' => 'setLocation(\'' . $subject->getUrl('xnotif/orderdispatch/view') . '\')'
            ]
        );
    }
}