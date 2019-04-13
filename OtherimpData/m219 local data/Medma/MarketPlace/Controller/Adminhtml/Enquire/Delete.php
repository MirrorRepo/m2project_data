<?php

/* 
 
 */
namespace Medma\MarketPlace\Controller\Adminhtml\Enquire;

use Magento\Backend\App\Action;

class Delete extends \Magento\Backend\App\Action{
    
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */    
    public function execute()
    {

        $params = $this->getRequest()->getParams();
        $ids =   $params['id'];
        $feedbackApproved = 0;
        foreach ($ids as $enquiry) {

            $obj =  $this->_objectManager->create('\Medma\MarketPlace\Model\Enquirymessage')->load($enquiry);
            $obj->delete();
            $feedbackApproved++;
        }

        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted', count($ids))
        );
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');


    }    
}