<?php

namespace Bakeway\EventsListing\Controller\Adminhtml\Stoppayment;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action {

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\Page
     */
    protected $resultPage;
    private $orderFactory;
    protected $jsonResultFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
    Context $context, PageFactory $resultPageFactory, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->orderFactory = $orderFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonResultFactory = $resultJsonFactory;
    }

    public function execute() {
        $response = [];
        $orderId = $this->getRequest()->getParam('orderId');
        $order = $this->orderFactory->create();
        $order->load($orderId);
        $order->setStatus("bakeway_order_stop_payment");
        $order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING, true);
        $_Response = $this->jsonResultFactory->create();
        try {
            $order->save();
            $response['return'] = true;
        } catch (\Exception $e) {
            $response['return'] = $e->getMessage();
        }
        

        return $_Response->setData($response);

    }

}
