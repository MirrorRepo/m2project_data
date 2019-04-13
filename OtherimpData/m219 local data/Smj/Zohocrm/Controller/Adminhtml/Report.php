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
namespace Smj\Zohocrm\Controller\Adminhtml;

use Smj\Zohocrm\Model\ReportFactory as ReportFactory;
use Smj\Zohocrm\Model\ResourceModel\Report\CollectionFactory as CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;

/**
 * Class Report
 *
 * @package Smj\Zohocrm\Controller\Adminhtml
 */
abstract class Report extends Action
{
    /**
     * @var ReportFactory
     */
    protected $_reportFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param Context        $context
     * @param Registry       $coreRegistry
     * @param ReportFactory  $reportFactory
     * @param LayoutFactory  $layoutFactory
     * @param PageFactory    $resultPageFactory
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
        $this->_reportFactory       = $reportFactory;
        $this->layoutFactory        = $layoutFactory;
        $this->resultPageFactory    = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_collectionFactory   = $collectionFactory;

        parent::__construct($context);
    }

    /**
     * Check ACL
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smj_Zohocrm::report');
    }
}
