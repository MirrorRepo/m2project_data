<?php

/**
 * Evince
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Evince.com license that is
 * available through the world-wide-web at this URL:
 *   
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Evince
 * @package     Evince_Mainslider
 * @copyright   Copyright (c) 2015-2016 Evince Development Pvt. Ltd (http://www.evincedev.com/)
 *   
 */

namespace Medma\MarketPlace\Controller\Adminhtml;

/**
 * Slider Abstract Action
 * @category Evince
 * @package  Evince_Mainslider
 * @module   Mainslider
 * @author   Evince Developer
 */
abstract class Bulletin extends \Medma\MarketPlace\Controller\Adminhtml\AbstractAction
{
    /**
     * Check if admin has permissions to visit related pages.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Medma_MarketPlace::manage_requirements');
    }
}
