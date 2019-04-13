<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 03-05-2018
 * Time: 15:00
 */

namespace Bakeway\GstReport\Block\Adminhtml\Unregistered\Renderer;

use Magento\Framework\DataObject;
class IGST extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var \Webkul\Marketplace\Model\ResourceModel\Saleslist\CollectionFactory
     */
    protected $sellerFactory;

    /**
     * SGST constructor.
     * @param \Webkul\Marketplace\Model\ResourceModel\Saleslist\CollectionFactory $sellerFactory
     */
    public function __construct(
        \Webkul\Marketplace\Model\ResourceModel\Saleslist\CollectionFactory $sellerFactory
    )
    {
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * @param DataObject $row
     * @return int|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function render(DataObject $row)
    {
        if($row->getName() == "Pune")
        {
            $totalIgst = "NA";
            $row->setIgst($totalIgst);            
        }
        else
        {
            $totalIgst = $row->getTotalCommission() * 0.18;
            $row->setIgst($totalIgst);
        }

        return $totalIgst;
    }
}