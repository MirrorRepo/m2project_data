<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 03-05-2018
 * Time: 15:29
 */

namespace Bakeway\GstReport\Block\Adminhtml\Registered\Renderer;

use Magento\Framework\DataObject;

class FeeIGST extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @param DataObject $row
     * @return float|int|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function render(DataObject $row)
    {
        if($row->getName() == "Pune")
        {
            $totalFeeIgst = "NA";
            $row->setFeeIgst($totalFeeIgst);            
        }
        else
        {
            $totalFeeIgst = $row->getTotalFee() * 0.18;
            $row->setFeeIgst($totalFeeIgst);            
        }

        return $totalFeeIgst;
    }
}