<?php
namespace Bakeway\Deliveryrangeprice\Controller\Delivery;

class Editsave extends \Magento\Framework\App\Action\Action
{

	/**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var \Magento\Framework\App\Cache\StateInterface
     */
    protected $_cacheState;

    /**
     * @var \Magento\Framework\App\Cache\Frontend\Pool
     */
    protected $_cacheFrontendPool;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $rangepriceFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    /**
     * @param Action\Context $context
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\StateInterface $cacheState
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheState = $cacheState;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->resultPageFactory = $resultPageFactory;
        $this->rangepriceFactory = $rangepriceFactory;
        $this->coreRegistry = $coreRegistry;

    }
	
    /**
     * Flush cache storage
     *
     */
    public function execute()
    {
        $response = array();
        $this->resultPage = $this->resultPageFactory->create();
        $this->resultPage->getConfig()->getTitle()->set('Delivery Range & Price');
        
        $_id = $this->getRequest()->getParam('delivery_id');
        $_fieldid = $this->getRequest()->getParam('field_id');
        $_status = $this->getRequest()->getParam('is_active');
        $_fromkms = $this->getRequest()->getParam('from_kms');
        $_tokms  = $this->getRequest()->getParam('to_kms');
        $_deliveryprice = $this->getRequest()->getParam('delivery_price');
        $midnightPrice = $this->getRequest()->getParam('midnight_price');
        $morningPrice = $this->getRequest()->getParam('morning_price');
        if($midnightPrice == "" or !is_numeric($midnightPrice))
            $midnightPrice = null;
        if($morningPrice == "" or !is_numeric($morningPrice))
            $morningPrice = null;
		$_updateddate = $this->getRequest()->getParam('updated_time');

        if($_status == "Enable"):
        $_status  = 1; 
        else:
        $_status  = 0; 
        endif;


        if(!empty($_id) && !empty($_tokms) && !is_null( $_deliveryprice)):
            $deliveryRangePrice =  $this->rangepriceFactory->create()->load($_id);
            $deliveryRangePrice->setFieldId($_fieldid );
            $deliveryRangePrice->setIsActive($_status);
            $deliveryRangePrice->setFromKms($_fromkms);
            $deliveryRangePrice->setToKms($_tokms);
            $deliveryRangePrice->setDeliveryPrice($_deliveryprice);
            $deliveryRangePrice->setMidnightPrice($midnightPrice);
            $deliveryRangePrice->setMorningPrice($morningPrice);
    		$deliveryRangePrice->setUpdatedAt($_updateddate);
            try
            {
                $deliveryRangePrice->save();
                $response['savedsuccess'] = 'Delivery Charges has been saved.';            
            }
            catch( \Exception $e)
            {
                 $response['savederror']  = 'Something went wrong while saving.';
            }
		 endif;
       die;
    }
}