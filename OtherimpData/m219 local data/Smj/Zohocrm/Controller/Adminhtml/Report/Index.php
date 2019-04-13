<?php
/**
 * Copyright © 2015 Smj. All rights reserved.
 * See COPYING.txt for license details.
 *
 * MSmj_Zohocrm extension
 * NOTICE OF LICENSE
 *
 * @category Smj
 * @package  Smj_Zohocrm
 * @author   Mukund
 */
namespace Smj\Zohocrm\Controller\Adminhtml\Report;

use Smj\Zohocrm\Controller\Adminhtml\Report as ReportController;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Smj\Zohocrm\Model\ReportFactory as ReportFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Smj\Zohocrm\Model\ResourceModel\Report\CollectionFactory as CollectionFactory;

/**
 * Class Index
 *
 * @package Smj\Zohocrm\Controller\Adminhtml\Report
 */
class Index extends ReportController
{
    /**
     * Page result factory
     *
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Page factory
     *
     * @var Page
     */
    protected $_resultPage;


    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ReportFactory $reportFactory
     * @param LayoutFactory $layoutFactory
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ReportFactory $reportFactory,
        LayoutFactory $layoutFactory,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry, $reportFactory, $layoutFactory, $resultPageFactory, $resultForwardFactory, $collectionFactory);
    }

    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $this->_setPageData();
        return $this->getResultPage();
    }

    /**
     * instantiate result page object
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page
     */
    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }

        return $this->_resultPage;
    }

    /**
     * set page data
     *
     * @return $this
     */
    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->getConfig()->getTitle()->prepend((__('View Report')));

        return $this;
    }
}
