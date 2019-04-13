<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Bakeway\Reports\Plugins;

use Magento\Framework\Message\ManagerInterface as MessageManager;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as SalesOrderGridCollection;

/**
 * Description of AddColumnsSalesOrderGridCollection
 *
 * @author Admin
 */
class AddColumnsSalesOrderGridCollection
{

    private $messageManager;
    private $collection;

    public function __construct(MessageManager $messageManager,
            SalesOrderGridCollection $collection
    )
    {
        $this->messageManager = $messageManager;
        $this->collection = $collection;
    }

    public function aroundGetReport(
    \Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory $subject,
            \Closure $proceed,
            $requestName
    )
    {
        $result = $proceed($requestName);
        if ($requestName == 'sales_order_grid_data_source') {
            if ($result instanceof $this->collection
            ) {
                $select = $this->collection->getSelect();
                $select->joinLeft(array('mo' => 'marketplace_orders'),
                        'mo.order_id = main_table.entity_id', array());
                $select->joinLeft(array('bpl' => 'bakeway_partner_locations'),
                        'bpl.seller_id= mo.seller_id', array());
                $select->joinLeft(array('bc' => 'bakeway_cities'),
                        'bc.id = bpl.city_id', array('bc.name'));
            }
        }
        return $this->collection;
    }

}
