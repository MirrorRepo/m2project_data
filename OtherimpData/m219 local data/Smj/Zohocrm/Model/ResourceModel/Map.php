<?php
/**
 * Copyright © 2015 Smj. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Smj_Zohocrm extension
 * NOTICE OF LICENSE
 *
 * @category Smj
 * @package  Smj_Zohocrm
 * @author   Mukund
 */
namespace Smj\Zohocrm\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Map
 *
 * @package Smj\Zohocrm\Model\ResourceModel
 */
class Map extends AbstractDb
{
    /**
     * Set main entity table name and primary key field name
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('smj_zohocrm_map', 'id');
    }
}
