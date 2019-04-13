<?php
/**
 * @category Dischem
 * @package  Dischem_Storeinfo
 * @module   Storeinfo
 * @author   kushagra.daharwal@zensar.in
 */
namespace Medma\MarketPlace\Block\Adminhtml;

class Bulletin extends \Magento\Backend\Block\Widget\Container
{
    /**
     * @var string
     */
    protected $_template = 'bulletin/view.phtml';
    
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    
    /**
     * Prepare button and gridCreate Grid , edit/add grid row and installer
     *
     * @return \Magento\Catalog\Block\Adminhtml\Product
     */
    protected function _prepareLayout()
    {
        
        $this->setChild(
            'grid',
           $this->getLayout()->createBlock('Medma\MarketPlace\Block\Adminhtml\Bulletin\Grid', 'grid.view.grid')
        );
        return parent::_prepareLayout();
    }
    
   

    /**
     * Render grid
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
    
}