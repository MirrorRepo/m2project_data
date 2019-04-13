<?php
/**
 * Copyright © 2015 Smj. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Smj_Zohocrm extension
 * NOTICE OF LICENSE
 *
 * @category Smj
 * @package  Smj_Zohocrm
 * @author   Mukund
 */
namespace Smj\Zohocrm\Controller\Adminhtml\Report;

use Smj\Zohocrm\Controller\Adminhtml\Report as ReportController;
use Smj\Zohocrm\Model\ReportFactory as ReportFactory;
use Smj\Zohocrm\Model\ResourceModel\Report\CollectionFactory as CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDelete Report
 *
 * @package Smj\Zohocrm\Controller\Adminhtml\Report
 */
class MassDelete extends ReportController
{
    /**
     * Mass Action Filter
     *
     * @var Filter
     */
    protected $_filter;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ReportFactory $reportFactory
     * @param LayoutFactory $layoutFactory
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ReportFactory $reportFactory,
        LayoutFactory $layoutFactory,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        CollectionFactory $collectionFactory,
        Filter $filter
    ) {
        $this->_filter = $filter;
        parent::__construct($context, $coreRegistry, $reportFactory, $layoutFactory, $resultPageFactory, $resultForwardFactory, $collectionFactory);
    }

    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());

        $delete = 0;
        foreach ($collection as $item) {
            /** @var \Smj\Zohocrm\Model\Report $item */
            $item->delete();
            $delete++;
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $delete));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
