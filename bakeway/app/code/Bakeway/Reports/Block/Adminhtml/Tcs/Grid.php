<?php

namespace Bakeway\Reports\Block\Adminhtml\Tcs;

use Bakeway\Reports\Helper\Data as Reportshelper;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended {

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory]
     */
    protected $_setsFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Type
     */
    protected $_type;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $_status;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_visibility;

    /**
     * @var \Magento\Store\Model\WebsiteFactory
     */
    protected $_websiteFactory;

    /**
     * @var \magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;

    /**
     * @var Reportshelper
     */
    protected $reportshelper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Grid constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Store\Model\WebsiteFactory $websiteFactory
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $collectionFactory
     * @param Reportshelper $reportshelper
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Backend\Helper\Data $backendHelper, \Magento\Store\Model\WebsiteFactory $websiteFactory, \Magento\Sales\Model\OrderFactory $orderFactory, \Webkul\Marketplace\Model\ResourceModel\Orders\CollectionFactory $collectionFactory, Reportshelper $reportshelper, \Magento\Framework\Registry $registry, array $data = []
    ) {

        $this->_collectionFactory = $collectionFactory;
        $this->orderFactory = $orderFactory;
        $this->_websiteFactory = $websiteFactory;
        $this->reportshelper = $reportshelper;
        $this->registry = $registry;
        // $this->_removeButton('add');
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct() {
        parent::_construct();
        $this->setId('tcsamountGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
    }

    /**
     * @return Store
     */
    protected function _getStore() {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection() {
        try {

            /*
             * main  order colllection
             */
            $collection = $this->_collectionFactory->create()
                    ->addFieldToSelect(["order_id", "seller_id", 'created_at', 'tcs_amount', 'delivery_fee_excl_tax', 'grab_delivery_flag'])
                    ->setOrder("created_at", 'DESC');
            $collection->getSelect()->join(array('so' => 'sales_order'), 'main_table.order_id = so.entity_id', array('so.increment_id', 'so.state', 'so.status', 'so.base_subtotal'));
            $collection->getSelect()->join(array('mu' => 'marketplace_userdata'), 'main_table.seller_id = mu.seller_id', array('mu.shop_title', 'userdata_gstin_number'));


            //echo $collection->getSelect();die;
            $collection->getSelect()->group("main_table.order_id");

            $collection->addFilterToMap('created_at', 'main_table.created_at');



            $this->setCollection($collection);

            parent::_prepareCollection();
            return $this;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function setCustomVariable() {
        $this->registry->register('custom_var', 'Added Value');
    }

    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column) {
        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField(
                        'websites', 'catalog_product_website', 'website_id', 'product_id=entity_id', null, 'left'
                );
            }
        }
        return parent::_addColumnFilterToCollection($column);
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns() {

        $this->addColumn(
                'increment_id', [
            'header' => __('Order ID'),
            'type' => 'text',
            'index' => 'increment_id',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );


        $this->addColumn(
                'shop_title', [
            'header' => __('Vendor'),
            'type' => 'text',
            'index' => 'shop_title',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );

        $this->addColumn(
                'userdata_gstin_number', [
            'header' => __('GSTN'),
            'type' => 'text',
            'index' => 'userdata_gstin_number',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );


        $this->addColumn(
                'created_at', [
            'header' => __('Date'),
            'type' => 'datetime',
            'index' => 'created_at',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );



        $this->addColumn(
                'tcs_amount', [
            'header' => __('TCS Amount'),
            'type' => 'text',
            'index' => 'tcs_amount',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
                ]
        );

        $this->addColumn(
                'access_amount', [
            'header' => __('Assess Amount (Product Price + Delivery Charges (Non Grab)'),
            'type' => 'text',
            'index' => 'access_amount',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id',
            'filter' => false,
            'renderer' => 'Bakeway\Reports\Block\Adminhtml\Tcs\Renderer\VendorAccessAmount'
                ]
        );






        /* {{CedAddGridColumn}} */

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }


        $this->addExportType('*/*/exporttcscsv', __('CSV'));

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('customreports/vendor/tcs', ['_current' => true]);
    }

}
