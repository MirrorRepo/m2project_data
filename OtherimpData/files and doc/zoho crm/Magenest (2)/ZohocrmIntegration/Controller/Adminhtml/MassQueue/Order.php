<?php

namespace Magenest\ZohocrmIntegration\Controller\Adminhtml\MassQueue;


use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magenest\ZohocrmIntegration\Model\Queue;
use Magenest\ZohocrmIntegration\Model\QueueFactory;

class Order extends \Magento\Backend\App\Action
{

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var QueueFactory
     */
    protected $queueFactory;

    protected $type = Queue::TYPE_ORDER;

    protected $dataHelper;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param QueueFactory $queueFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        QueueFactory $queueFactory,
        \Magenest\ZohocrmIntegration\Helper\Data $dataHelper

    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->queueFactory = $queueFactory;
        parent::__construct($context);
        $this->dataHelper = $dataHelper;
    }

    public function execute()
    {
        try {
            $orders = $this->filter->getCollection($this->collectionFactory->create());
            /** @var \Magenest\ZohocrmIntegration\Model\ResourceModel\Queue\Collection $queueCollection */
            $dataInsert = $this->dataHelper->getInsertData($orders->getAllIds(), $this->type);
            $queueCollection = $this->_objectManager->create("Magenest\ZohocrmIntegration\Model\ResourceModel\Queue\Collection");
            $connection = $queueCollection->getResource()->getConnection();
            $connection->insertMultiple(
                $queueCollection->getResource()->getTable('magenest_zohocrm_queue'),
                $dataInsert
            );
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been added to queue', count($dataInsert)));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_ZohocrmIntegration::queue');
    }
}
