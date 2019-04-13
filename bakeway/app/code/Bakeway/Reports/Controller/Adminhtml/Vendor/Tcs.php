<?php
namespace Bakeway\Reports\Controller\Adminhtml\Vendor;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;


class Tcs extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\Page
     */
    protected $resultPage;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $this->resultPage = $this->resultPageFactory->create();
        $this->resultPage->setActiveMenu('Bakeway_Reports::report_custom_review_rating');
        $this->resultPage ->getConfig()->getTitle()->set((__('Vendors TCS Reports')));
        return $this->resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bakeway_Reports::report_custom_report_tcs');
    }
}
