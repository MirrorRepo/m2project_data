<?php
/**
 *
 * Copyright © 2015 Bakewaycommerce. All rights reserved.
 */
namespace Bakeway\Deliveryrangeprice\Controller\Delivery;

use Magento\Framework\App\RequestInterface;

class Rangepriceajax extends \Magento\Framework\App\Action\Action
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
    public $_customerSession;
    protected $logger;

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
        \Magento\Customer\Model\Session $customerSession,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheState = $cacheState;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->resultPageFactory = $resultPageFactory;
        $this->rangepriceFactory = $rangepriceFactory;
        $this->_customerSession = $customerSession;
        $this->logger = $logger;

    }

    /**
     * Check customer authentication.
     *
     * @param RequestInterface $request
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        $loginUrl = $this->_objectManager->get(
            'Magento\Customer\Model\Url'
        )->getLoginUrl();

        if (!$this->_customerSession->authenticate($loginUrl)) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }

        return parent::dispatch($request);
    }


    /**
     * Flush cache storage
     *
     */
    public function execute()
    {

        $response = array();
        $this->resultPage = $this->resultPageFactory->create();
        $this->resultRedirectPage = $this->resultRedirectFactory->create();
        $this->resultPage->getConfig()->getTitle()->set('Delivery Range & Price');
        $_sellerid = $this->getRequest()->getParam('seller_id');
        $storeId = $this->getRequest()->getParam('store_id');
        $_fieldid = $this->getRequest()->getParam('field_id');
        $_status = $this->getRequest()->getParam('is_active');

        if ($_status == "Enable"):
            $_status = 1;
        else:
            $_status = 0;
        endif;

        $_fromkms = $this->getRequest()->getParam('from_kms');
        $_tokms = $this->getRequest()->getParam('to_kms');
        $_deliveryprice = $this->getRequest()->getParam('delivery_price');
        $midnightPrice = $this->getRequest()->getParam('midnight_price');
        $morningPrice = $this->getRequest()->getParam('morning_price');
        if($midnightPrice == "" or !is_numeric($midnightPrice))
            $midnightPrice = null;
        if($morningPrice == "" or !is_numeric($morningPrice))
            $morningPrice = null;
        $data = $this->getRequest()->getPostValue();

        //$rangePriceCollection = $this->rangepriceFactory->create()->getCollection()->addFieldToFilter('seller_id', $this->_customerSession->getCustomerId());

        $deliveryRangePrice = $this->rangepriceFactory->create();
        $deliveryRangePrice->setSellerId($_sellerid);
        $deliveryRangePrice->setStoreId($storeId);
        $deliveryRangePrice->setFieldId($_fieldid);
        $deliveryRangePrice->setIsActive($_status);
        $deliveryRangePrice->setFromKms($_fromkms);
        $deliveryRangePrice->setToKms($_tokms);
        $deliveryRangePrice->setDeliveryPrice($_deliveryprice);
        $deliveryRangePrice->setMidnightPrice($midnightPrice);
        $deliveryRangePrice->setMorningPrice($morningPrice);
        $deliveryRangePrice->setDeliveryDeleted(false);

        try 
        {
            if (!empty($_sellerid) && !empty($storeId) && !empty($_tokms) && !is_null($_deliveryprice)):
                $deliveryRangePrice->save();
            endif;
        } 
        catch (\Exception $e)
        {
             $response['savederror']  = $e->getMessage();
        }


        $rangePriceCollectionUpdate = $this->rangepriceFactory->create()->getCollection()
                                    ->addFieldToFilter('seller_id', $this->_customerSession->getCustomerId())
                                    ->getLastItem();
        $response['id'] = $rangePriceCollectionUpdate['id'];
        $response['fkms'] = $rangePriceCollectionUpdate['from_kms'];
        $response['tkms'] = $rangePriceCollectionUpdate['to_kms'];
        $response['price'] = $rangePriceCollectionUpdate['delivery_price'];
        $response['midnightPrice'] = $rangePriceCollectionUpdate['midnight_price'];
        $response['morningPrice'] = $rangePriceCollectionUpdate['morning_price'];
        $response['status'] = $rangePriceCollectionUpdate['is_active'];

        $response['savedsuccess'] = $rangePriceCollectionUpdate['id'];

        $this->messageManager->addSuccess(__('Updated successfully'));

        echo json_encode($response);
        die;
    }

    public function getCollectionseller()
    {
        $rangePriceCollection1 = $this->rangepriceFactory->create()->getCollection()
            ->addFieldToFilter('seller_id', $this->_customerSession->getCustomerId());
    }
}
