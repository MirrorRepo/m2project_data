<?php


namespace Medma\MarketPlace\Block\Adminhtml\Bulletin;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended {

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Dischem\Hubassignments\Model\GridFactory
     */
    protected $_storedayseaddressFactory;
    
    protected $_cmsPage;
    

    protected $_storedays;
    
    protected $_objectManager;
    
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
            \Medma\MarketPlace\Model\BulletinFactory $storedayseaddressFactory,
            \Magento\Cms\Model\Page $cmsPage,
            \Magento\Framework\Module\Manager $moduleManager,
             \Magento\Framework\ObjectManagerInterface $objectManager,
              \Medma\MarketPlace\Helper\Data $marketplacehelper,
            array $data = []
    ) {
        $this->_storedayseaddressFactory = $storedayseaddressFactory;
        $this->_cmsPage = $cmsPage;
        $this->moduleManager = $moduleManager;
        $this->_objectManager = $objectManager;
        $this->marketplacehelper = $marketplacehelper;
        parent::__construct($context, $backendHelper, $data);
    }


    
    
    
    /**
     * @return void
     */
    protected function _construct() {
        parent::_construct();
        $this->setId('storeaddressGrid');
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
        $collection = $this->_storedayseaddressFactory->create()->getCollection();
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
            'title', [
            'header' => __('Title'),
            'type' => 'text',
            'index' => 'title',
            'width' => '20px',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );
        

             $this->addColumn(
            'volume', [
            'header' => __('Volume'),
            'type' => 'text',
            'index' => 'volume',
            'width' => '20px',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );


             $this->addColumn(
            'requirements', [
            'header' => __('Requirements'),
            'type' => 'text',
            'index' => 'requirements',
            'width' => '20px',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );
        
            $this->addColumn(
            'ldos', [
            'header' => __('Last Date Of Submission'),
            'type' => 'date',
            'index' => 'ldos',
            'width' => '20px',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
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
        
     
        return parent::_prepareColumns();
    }
    
    /**
     * @return $this
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('requirementsids');

        $this->getMassactionBlock()->addItem(
                'approve', [
            'label' => __('Delete'),
            'url' => $this->getUrl('admin_marketplace/bulletin/delete'),
            'confirm' => __('Are you sure?')
                ]
        );


        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('admin_marketplace/bulletin/grid', ['_current' => true]);
    }

    public function getRowUrl($row) {
        return $this->getUrl(
                        'admin_marketplace/bulletin/edit', ['entity_id' => $row->getEntityId(),'status' => $row->getApprove()]
        );
    }

}