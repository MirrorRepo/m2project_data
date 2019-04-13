<?php
namespace BakewayMobile\GlobalSearch\Block\Adminhtml;
class Globalsearch extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_globalsearch';/*block grid.php directory*/
        $this->_blockGroup = 'BakewayMobile_GlobalSearch';
        $this->_headerText = __('Globalsearch');
        $this->_addButtonLabel = __('Add New Entry'); 
        parent::_construct();
		
    }
}
