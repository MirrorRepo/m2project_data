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
 
namespace Medma\MarketPlace\Controller\Adminhtml\Configuration;
 
class Vendor extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    protected $adminSession;
    protected $vendorHelper;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
   
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\Auth\Session $adminSession,
        \Medma\MarketPlace\Helper\Data $vendorHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_adminSession = $adminSession;
        $this->vendorHelper = $vendorHelper;
        parent::__construct($context);
    }
 
    public function execute()
    {
    
    
         $resultPage = $this->resultPageFactory->create();
         $this->_view->loadLayout();
         //$this->_setActiveMenu('Medma_MarketPlace::manage_vendors');
         $this->_addBreadcrumb(__('Configuration'), __('Configuration'));
         $resultPage->getConfig()->getTitle()->prepend(__('Configuration'));
         $this->_view->renderLayout();
    }
}