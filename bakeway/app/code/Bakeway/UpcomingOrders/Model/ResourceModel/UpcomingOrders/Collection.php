<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bakeway\UpcomingOrders\Model\ResourceModel\UpcomingOrders;

/**
 * Commisons Collection
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {



    /**
     * Define model & resource model
     */
   // const YOUR_TABLE = 'bakeway_commissionlog';

    public function __construct(
    \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory, 
     \Psr\Log\LoggerInterface $logger, 
    \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
    \Magento\Framework\Event\ManagerInterface $eventManager, 
            \Magento\Store\Model\StoreManagerInterface $storeManager, 
            \Magento\Framework\DB\Adapter\AdapterInterface $connection = null, 
            \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        
       $this->_init(
               'Bakeway\UpcomingOrders\Model\UpcomingOrders', 'Bakeway\UpcomingOrders\Model\ResourceModel\UpcomingOrders' 
               );
       parent::__construct(
                $entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource
        );
       $this->storeManager = $storeManager;
    }

    
   

}
