<?php
/**
 *
 * Copyright © 2016 Medma. All rights reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 */
 
namespace Medma\MarketPlace\Model\ResourceModel;

class Transaction extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
    
        $this->_init('medma_marketplace_transaction', 'entity_id');
    }
}
