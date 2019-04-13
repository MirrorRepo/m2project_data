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
namespace Smj\Zohocrm\Block\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

/**
 * Class Password: hide pass in Configuration
 *
 * @package Smj\Zohocrm\Block\System\Config\Form\Field
 */
class Password extends Field
{
    /**
     * Add password attribute
     *
     * @param  AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setType('password');
        return $element->getElementHtml();
    }
}
