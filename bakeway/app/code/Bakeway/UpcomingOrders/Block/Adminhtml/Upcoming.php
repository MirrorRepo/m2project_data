<?php
namespace Bakeway\UpcomingOrders\Block\Adminhtml;
class Upcoming extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
       
        $this->_controller = 'adminhtml_upcomingorders';/*block grid.php directory*/
        $this->_blockGroup = 'Bakeway_UpcomingOrders';
        $this->_headerText = __('Upcoming orders');
        $this->_addButtonLabel = __('Add New Entry');
        parent::_construct();
        $this->removeButton('add');

     
        $this->removeButton('saveandcontinue');
    }
}
