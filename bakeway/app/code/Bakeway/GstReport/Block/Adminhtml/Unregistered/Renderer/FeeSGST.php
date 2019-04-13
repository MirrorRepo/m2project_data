<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 03-05-2018
 * Time: 15:29
 */

namespace Bakeway\GstReport\Block\Adminhtml\Unregistered\Renderer;

use Magento\Framework\DataObject;

class FeeSGST extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
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
            $totalFee = $row->getTotalFee() * 0.09;
            $row->setFeeSgst($totalFee);
        }
        else
        {
            $totalFee = "NA";
            $row->setFeeSgst($totalFee);
        }

        return $totalFee;
    }
}