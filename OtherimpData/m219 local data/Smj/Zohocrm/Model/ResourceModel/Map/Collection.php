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
namespace Smj\Zohocrm\Model\ResourceModel\Map;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection Map
 *
 * @package Smj\Zohocrm\Model\ResourceModel\Map
 */
class Collection extends AbstractCollection
{
    /**
     * ID Field Name
     *
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'smj_zohocrm_map_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'map_collection';


    /**
     * Initialize resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Smj\Zohocrm\Model\Map', 'Smj\Zohocrm\Model\ResourceModel\Map');
    }//end _construct()
}//end class
