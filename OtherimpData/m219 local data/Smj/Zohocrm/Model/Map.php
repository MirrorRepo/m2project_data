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
namespace Smj\Zohocrm\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Map
 *
 * @package Smj\Zohocrm\Model
 */
class Map extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'map';

    /**
     *
     */
    public function _construct()
    {
        $this->_init('Smj\Zohocrm\Model\ResourceModel\Map');
    }
}
