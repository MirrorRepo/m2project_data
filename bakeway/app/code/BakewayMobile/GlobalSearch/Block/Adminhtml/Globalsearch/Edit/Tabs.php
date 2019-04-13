<?php
namespace BakewayMobile\GlobalSearch\Block\Adminhtml\Globalsearch\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_globalsearch_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Globalsearch Information'));
    }
}