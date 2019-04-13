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
namespace  Smj\Zohocrm\Block\Adminhtml\Map;

use Magento\Backend\Block\Template;

/**
 * Class UpdateFields
 *
 * @package Smj\Zohocrm\Block\Adminhtml\Map
 */
class UpdateFields extends Template
{
    /**
     * Get Url retrieve
     *
     * @return string
     */
    public function getUpdateUrl()
    {
        return $this->getUrl('zohocrm/field/retrieve', ['_current' => false]);
    }

    /**
     * Get Url Update All Fields
     *
     * @return string
     */
    public function getUpdateAllFields()
    {
        return $this->getUrl('zohocrm/field/update', ['_current' => false]);
    }
}
