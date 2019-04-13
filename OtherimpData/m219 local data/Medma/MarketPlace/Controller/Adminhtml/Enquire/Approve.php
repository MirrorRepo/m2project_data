<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Medma\MarketPlace\Controller\Adminhtml\Enquire;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Approve extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $enquiryFactory;
    protected $enquiryobjFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Medma\MarketPlace\Model\ResourceModel\Enquirymessage\CollectionFactory $collectionFactory,
        \Medma\MarketPlace\Model\EnquirymessageFactory $enquirymessage
    ) {
        $this->filter = $filter;
        $this->enquiryFactory = $collectionFactory;
        $this->enquiryobjFactory = $enquirymessage;
        parent::__construct($context);
    }

    public function execute()
    {

        $params = $this->getRequest()->getParams();
        $ids =   $params['id'];
        $feedbackApproved = 0;
        foreach ($ids as $enquiry) {

            $obj =  $this->enquiryobjFactory->create()->load($enquiry);
            $obj->setApprove(1);
            $obj->save();
            $feedbackApproved++;
        }
        $this->_redirect('admin_marketplace/enquire/index');
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been approved.', $feedbackApproved)
        );
    }
}
