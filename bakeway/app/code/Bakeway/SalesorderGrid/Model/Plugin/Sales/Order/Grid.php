<?php
namespace Bakeway\SalesorderGrid\Model\Plugin\Sales\Order;

class Grid
{

    public static $table = 'sales_order_grid';
    public static $leftJoinTable = 'marketplace_orders';


    public function afterSearch($intercepter, $collection)
    {
        if ($collection->getMainTable() === $collection->getConnection()->getTableName(self::$table)) {
            /*$leftJoinTableName = $collection->getConnection()->getTableName(self::$leftJoinTable);
            $collection->getSelect()->join( array('mo'=>'marketplace_orders'),  'main_table.entity_id = mo.order_id', array('mo.seller_id'));
            $collection->getSelect()->join( array('mu'=>'marketplace_userdata'),  'mo.seller_id = mu.seller_id', array('mu.business_name','mu.store_owner_mobile_no','mu.store_manager_mobile_no'));
            $collection->getSelect()->join( array('ce'=>'customer_entity'),  'mo.seller_id = ce.entity_id', array('ce.firstname'))
            ->distinct('main_table.entity_id');
            echo $collection->getSelect();die;
            $collection->addFilterToMap('created_at', 'main_table.created_at');
            */
            $collection->getSelect();
        } 
        return $collection;


    }

    public function getConfig($path)
    {
        return $this->_scopeConfig->getValue($path);
    }

    public function __construct(\Magento\Framework\View\Element\Context $context,
                                array $data = []
    )
    {
        $this->_scopeConfig = $context->getScopeConfig();
    }


}