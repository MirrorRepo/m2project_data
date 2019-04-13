<?php
namespace Smj\Adminmodule\Block\Adminhtml\Smj\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_smj_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Smj Information'));
    }
}