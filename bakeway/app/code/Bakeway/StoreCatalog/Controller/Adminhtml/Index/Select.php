<?php

namespace Bakeway\StoreCatalog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory as JsonFactory;

class Select extends Action {

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\Page
     */
    protected $resultPage;

    /**
     * @var JsonFactory 
     */
    protected $resultJsonFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
    Context $context, PageFactory $resultPageFactory, JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute() {
        $this->resultPage = $this->resultPageFactory->create();
        $sellerId = $this->getRequest()->getParam('seller_id');
        $storeLocalityId = $this->getRequest()->getParam('locality_id');

        $result = $this->resultJsonFactory->create();

        if (isset($sellerId) && isset($storeLocalityId)) {
            $sellerid = $sellerId;
            $localityId = $storeLocalityId;
            return $result->setData(['success' => true, 'seller_id' => $sellerId, 'store_id' => $storeLocalityId]);
        } else {
            return $result->setData(['success' => false]);
        }
    }

}
