<?php
/**
 *
 * Copyright © 2016 Medma. All rights reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 */
 
namespace Medma\MarketPlace\Controller\Adminhtml\Feedback;
 
class Delete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $feedbackFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Medma\MarketPlace\Model\ResourceModel\Feedback\CollectionFactory $collectionFactory,
        \Medma\MarketPlace\Model\FeedbackFactory $feedbackFactory
    ) {
        $this->filter = $filter;
        $this->feedbackFactory = $feedbackFactory;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {

        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $feedbackDeleted = 0;
        foreach ($collection->getItems() as $feedback) {
            $this->feedbackFactory->create()->load($feedback['entity_id'])->delete();
            $feedbackDeleted++;
        }
        $this->_redirect('admin_marketplace/feedback/index');
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $feedbackDeleted)
        );
    }
}