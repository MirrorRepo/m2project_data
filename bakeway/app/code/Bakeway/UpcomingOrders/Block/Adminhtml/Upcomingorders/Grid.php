<?php

namespace Bakeway\UpcomingOrders\Block\Adminhtml\Upcomingorders;

use Magento\Customer\Controller\RegistryConstants;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry|null
     */
    protected $_coreRegistry = null;

    /**
     * @var \Bakeway\Deliveryrangeprice\Model\ResourceModel\Rangeprice\Collection
     */
    protected $_collectionFactory;
    protected $_cmsPage;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Sales\Model\Resource\Order\Grid\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Cms\Model\Page $cmsPage,

        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        $this->_collectionFactory = $collectionFactory;
        $this->_cmsPage = $cmsPage;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Initialize the orders grid.
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('commissionid');
        $this->setDefaultSort('id');
        $this->setUseAjax(false);
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

  

    /**
     * @return Store
     */
    protected function _getStore()
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }


    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->getRequest()->getParam('id');
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareCollection()
    {
       
       $from =date("Y-m-d");
            $to = date("Y-m-d 23:59:59", strtotime($from ." + 4 day") );
        try {
             
            $collection = $this->_collectionFactory->create()
                ->setOrder("delivery_time", 'ASC');

                $collection->addFieldToSelect(array('increment_id', 'delivery_type', 'created_at', 'updated_at', 'delivery_time','status','state'));

                $collection->getSelect()->joinLeft(array('mo' => 'marketplace_orders'),
                    'main_table.entity_id = mo.order_id',
                    array());

                $collection->getSelect()->joinLeft(array('mu' => 'marketplace_userdata'),
                    'mo.seller_id = mu.seller_id',
                    array('mu.business_name'));

                $collection->getSelect()->joinLeft(array('sos' => 'sales_order_status'),
                    'main_table.status = sos.status', array('sos.label'));

                $collection->addFieldToFilter(
                    'main_table.status',
                    ['st' => [\Bakeway\Vendorapi\Model\OrderStatus::STATUS_PARTNER_ACCEPTED]]
                );

                $collection->addFieldToFilter('main_table.delivery_time', array('from' => $from, 'to' => $to));

                $collection->addFilterToMap('delivery_time', 'main_table.delivery_time');

               $collection->addFilterToMap('business_name', 'mu.business_name');
                 //echo $collection->getSelect(); exit;
           
            $this->setCollection($collection);
            parent::_prepareCollection();
            return $this;
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }


    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField(
                    'websites',
                    'catalog_product_website',
                    'website_id',
                    'product_id=entity_id',
                    null,
                    'left'
                );
            }
        }


        return parent::_addColumnFilterToCollection($column);
    }


    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {





        $this->addColumn(
            'increment_id',
            [
                'header' => __('Order Id'),
                'index' => 'increment_id',
                'class' => 'commision',

            ]
        );

        $this->addColumn(
                'delivery_type',
                [
            'header' => __('Order Type'),
            'type' => 'text',
            'index' => 'delivery_type',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );

        $this->addColumn(
                'delivery_time',
                [
            'header' => __('Delivery Date & Time'),
            'type' => 'datetime',
            'index' => 'delivery_time',

            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id',
            
                ]
        );

     


        $this->addColumn(
                'business_name',
                [
            'header' => __('Bakery Name'),
            'type' => 'text',
            'index' => 'business_name',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );

        


        return parent::_prepareColumns();
    }

    /**
     * Get headers visibility
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getHeadersVisibility()
    {
        return $this->getCollection()->getSize() >= 0;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('upcomingorders/upcomingorders/index', ['_current' => true]);
    }


    public function getRowUrl($row)
    {
        return $this->getUrl(
                        'sales/order/view/order_id',
                        ['store' => $this->getRequest()->getParam('store'), 'order_id' => $row->getEntityId()]
        );
    }


}