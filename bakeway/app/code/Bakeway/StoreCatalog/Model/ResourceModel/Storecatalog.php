<?php
/**
 * Copyright © 2015 Bakeway. All rights reserved.
 */
namespace Bakeway\StoreCatalog\Model\ResourceModel;

/**
 * Smj resource
 */
class Storecatalog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('bakeway_store_catalog', 'entity_id');
    }

  
}