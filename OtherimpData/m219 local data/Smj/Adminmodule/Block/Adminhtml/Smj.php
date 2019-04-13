<?php
namespace Smj\Adminmodule\Block\Adminhtml;
class Smj extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_smj';/*block grid.php directory*/
        $this->_blockGroup = 'Smj_Adminmodule';
        $this->_headerText = __('Smj');
        $this->_addButtonLabel = __('Add New Entry'); 
        parent::_construct();
		
    }
}
