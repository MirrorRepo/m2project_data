<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Medma\MarketPlace\Controller\Adminhtml\Enquire;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
 
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
 
    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
       /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->_resultForwardFactory->create();
            $resultForward->forward('grid');

            return $resultForward;
        }
        
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb(__('CMS'), __('CMS'));
        $resultPage->addBreadcrumb(__('Manage Store Address'), __('Manage Enquiries'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Enquiries'));
 
        return $resultPage;
    }
}
