<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 03-05-2018
 * Time: 15:29
 */

namespace Bakeway\GstReport\Block\Adminhtml\Unregistered\Renderer;

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
            $totalFee = "NA";
            $row->setFeeIgst($totalFee);
        }
        else
        {
            $totalFee = $row->getTotalFee() * 0.18;
            $row->setFeeIgst($totalFee);
        }

        return $totalFee;
    }
}