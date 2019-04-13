<?php
/**
 * Copyright © 2015 Bakeway. All rights reserved.
 */
namespace Medma\MarketPlace\Model\ResourceModel;

/**
 * Smj resource
 */
class Bulletin extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('smj_bulletin_board', 'entity_id');
    }

  
}
