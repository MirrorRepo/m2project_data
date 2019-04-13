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

namespace Medma\MarketPlace\Controller\Adminhtml\Enquire;

/**
 * Slider Grid action
 * @category Evince
 * @package  Evince_Mainslider
 * @module   Mainslider
 * @author   Evince Developer
 */
class Grid extends \Medma\MarketPlace\Controller\Adminhtml\Enquire
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        
        
        $resultLayout = $this->_resultLayoutFactory->create();

        return $resultLayout;
    }
}
