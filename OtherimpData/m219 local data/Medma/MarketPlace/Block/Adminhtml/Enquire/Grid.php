<?php

/*

 */

namespace Medma\MarketPlace\Block\Adminhtml\Enquire;


class Grid extends \Magento\Backend\Block\Widget\Grid\Extended {

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Dischem\Hubassignments\Model\GridFactory
     */

    protected $_cmsPage;
    


	protected $_objectManager;

    protected $enquirymessageFactory;

    protected $marketplacehelper;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Dischem\Hubassignments\Model\HubFactory $hubFactory
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
           \Magento\Backend\Block\Template\Context $context, 
            \Magento\Backend\Helper\Data $backendHelper, 
            \Magento\Cms\Model\Page $cmsPage,
            \Magento\Framework\Module\Manager $moduleManager,
             \Magento\Framework\ObjectManagerInterface $objectManager,
             \Medma\MarketPlace\Model\EnquirymessageFactory $enquirymessage,
           \Medma\MarketPlace\Helper\Data $marketplacehelper,
            array $data = []
    ) {
        $this->_cmsPage = $cmsPage;
        $this->moduleManager = $moduleManager;
        $this->_objectManager = $objectManager;
        $this->enquirymessageFactory = $enquirymessage;
        $this->marketplacehelper = $marketplacehelper;
        parent::__construct($context, $backendHelper, $data);
    }


    
    
    
    /**
     * @return void
     */
    protected function _construct() {

        parent::_construct();
        $this->setId('enquirymessageGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('grid_record');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection() {
        $collection = $this->enquirymessageFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }
     

    
    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns() {


        $this->addColumn(
            'entity_id', [
            'header' => __('ID'),
            'type' => 'number',
            'index' => 'entity_id',
            'width' => '20px',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );

        $this->addColumn(
            'seller_id', [
                'header' => __('Seller ID'),
                'type' => 'number',
                'index' => 'seller_id',
                'width' => '20px',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );


        $this->addColumn(
            'customer_id', [
                'header' => __('Customer ID'),
                'type' => 'number',
                'index' => 'customer_id',
                'width' => '20px',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
		
		$this->addColumn(
            'product_sku',
            [
                'header' => __('Sku'),
                'index' => 'product_sku',
                'class' => 'xxx',
                'width' => '35px',
            ]
        );
		$this->addColumn(
            'msg',
            [
                'header' => __('Message'),
                'index' => 'msg',
                'class' => 'xxx',
                'width' => '20px',
            ]
        );
		
		$this->addColumn(
            'approve',
            [
                'header' => __('Status'),
                'index' => 'approve',
                'type' => 'options',
                'class' => 'xxx',
                'width' => '20px',
                'options' => $this->marketplacehelper->getAvailableStatusesonGrid()
            ]
        );

    	$this->addColumn(
            'email',
            [
                'header' => __('Email'),
                'index' => 'email',
                'class' => 'xxx',
                'width' => '20px',
            ]
        );
		
		$this->addColumn(
            'created_at',
            [
                'header' => __('Created At'),
                'type' => 'date',
                'index' => 'created_at',
                'class' => 'xxx',
                'width' => '20px',
            ]
        );
		
		
		$this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'class' => 'xxx',
                'width' => '20px',
            ]
        );


        $this->addColumn(
            'edit',
            [
                'header' => __('Action'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => '*/*/edit'],
                        'field' => 'entity_id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }
        
         $this->addExportType('*/*/exportCsv', __('CSV'));
         $this->addExportType('*/*/exportXml', __('XML'));
         $this->addExportType('*/*/exportExcel', __('Excel'));

        return parent::_prepareColumns();
    }
    
    
    
    
    
    /**
     * @return $this
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem(
                'delete', [
            'label' => __('Delete'),
            'url' => $this->getUrl('admin_marketplace/enquire/delete'),
            'confirm' => __('Are you sure?')
                ]
        );


        $this->getMassactionBlock()->addItem(
            'Approve', [
                'label' => __('Approve'),
                'url' => $this->getUrl('admin_marketplace/enquire/approve'),
                'confirm' => __('Are you sure?')
            ]
        );

        $this->getMassactionBlock()->addItem(
            'Disapprove', [
                'label' => __('Disapprove'),
                'url' => $this->getUrl('admin_marketplace/enquire/disapprove'),
                'confirm' => __('Are you sure?')
            ]
        );



        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('admin_marketplace/enquire/grid', ['_current' => true]);
    }

    public function getRowUrl($row) {
        return $this->getUrl(
                        'admin_marketplace/enquire/edit', ['entity_id' => $row->getId()]
        );
    }

}
