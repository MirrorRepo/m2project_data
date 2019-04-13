<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 03-05-2018
 * Time: 15:29
 */

namespace Bakeway\GstReport\Block\Adminhtml\Unregistered\Renderer;

use Magento\Framework\DataObject;

class TotalCGST extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @param DataObject $row
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function render(DataObject $row)
    {
        if($row->getName() == "Pune")
            $totalCGST = $row->getOrderAmountCSGT() + $row->getCgst() + $row->getFeeCgst();
        else
            $totalCGST = "NA";
        return $totalCGST;
    }
}