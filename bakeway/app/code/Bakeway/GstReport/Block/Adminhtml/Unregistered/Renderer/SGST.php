<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 03-05-2018
 * Time: 15:00
 */

namespace Bakeway\GstReport\Block\Adminhtml\Unregistered\Renderer;

use Magento\Framework\DataObject;
class SGST extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
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
            $totalSgst = $row->getTotalCommission() * 0.09;
            $row->setSgst($totalSgst);
        }
        else
        {
            $totalSgst = "NA";
            $row->setIgst($totalSgst);                        
        }

        return $totalSgst;
    }
}