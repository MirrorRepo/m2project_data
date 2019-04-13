<?php

/*

 */

namespace Medma\MarketPlace\Block\Adminhtml\Enquiremessage;


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

    protected $enquirymessagechainFactory;

    protected $adminSession;

    protected $enquirymessage;

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
             \Medma\MarketPlace\Model\EnquirymessagechainFactory $enquirymessagechain,
             \Magento\Backend\Model\Auth\Session $adminSession,
             \Medma\MarketPlace\Model\EnquirymessageFactory $enquirymessage,
            array $data = []
    ) {
        $this->_cmsPage = $cmsPage;
        $this->moduleManager = $moduleManager;
        $this->_objectManager = $objectManager;
        $this->enquirymessagechainFactory = $enquirymessagechain;
        $this->adminSession = $adminSession;
        $this->enquirymessage = $enquirymessage;
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
        $current_user = $this->adminSession->getUser();
      /*  $collection = $this->enquirymessagechainFactory->create()->getCollection()
                        ->addFieldToFilter('approve', array("eq"=>1))
                        ->addFieldToFilter('seller_id', $current_user->getId());
        $collection->getSelect()->join( array('edetails'=>'smj_enquire_detail'),  'main_table.msg_id = edetails.entity_id', array('edetails.seller_id','edetails.email','edetails.created_at'));
        //$collection->getSelect()->group('smj_enquire_message.msg_id');
       */
        $collection = $this->enquirymessage->create()->getCollection();

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
            'product_cat', [
                'header' => __('Product Category'),
                'type' => 'text',
                'index' => 'product_cat',
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
            'action',
            [
                'header' => __('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('View'),
                        'url' => ['base' => '*/*/view'],
                        'field' => 'id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
            ]
        );



        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }
        

        return parent::_prepareColumns();
    }
    
    
    
    
    


    /**
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('admin_marketplace/enquiremessage/grid', ['_current' => true]);
    }

    public function getRowUrl($row) {
        return $this->getUrl(
                        'admin_marketplace/enquiremessage/view', ['entity_id' => $row->getId()]
        );
    }

}
