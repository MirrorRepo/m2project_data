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
 
namespace Medma\MarketPlace\Controller\Adminhtml\Transaction;
 
class Vendor extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    protected $_adminSession;
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
         /*if ($this->getRequest()->getQuery('ajax')) {
		 $this->_forward('grid');
		 return;
		 }*/
         
         $roleId = $this->vendorHelper->getConfig('general', 'vendor_role');
         $current_user = $this->_adminSession->getUser();
        if ($current_user->getRole()->getRoleId() != $roleId) {
                    $this->_forward('empty');
            return;
        }
         $resultPage = $this->resultPageFactory->create();
         $this->_view->loadLayout();
         //$this->_setActiveMenu('Medma_MarketPlace::manage_vendors');
         $this->_addBreadcrumb(__('Balance Sheets'), __('Balance Sheets'));
         $resultPage->getConfig()->getTitle()->prepend(__('Balance Sheets'));
         $this->_view->renderLayout();
    }
    protected function _isAllowed()
    {
        return true;
    }
}