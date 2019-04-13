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

use Magento\Backend\Block\Widget\Form\Container;

/**
 * Class Edit Block
 *
 * @package Smj\Zohocrm\Block\Adminhtml\Map
 */
class Edit extends Container
{
    /**
     * Initialize  edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'Smj_Zohocrm';
        $this->_controller = 'adminhtml_map';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Mapping'));
        $this->buttonList->add(
            'saveandcontinue',
            [
             'label'          => __('Save and Continue Edit'),
             'class'          => 'save',
             'data_attribute' => [
                                  'mage-init' => [
                                                  'button' => [
                                                               'event'  => 'saveAndContinueEdit',
                                                               'target' => '#edit_form',
                                                              ],
                                                 ],
                                 ],
            ],
            -100
        );
        $this->buttonList->add(
            'updateallfields',
            [
             'label' => __('Update All Fields'),
            ],
            -90
        );
        $this->buttonList->remove('delete');
    }
}
