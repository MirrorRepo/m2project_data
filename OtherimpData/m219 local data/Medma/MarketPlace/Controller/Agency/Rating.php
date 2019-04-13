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

namespace Medma\MarketPlace\Controller\Agency;

class Rating extends \Magento\Framework\App\Action\Action
{
  
   
  /**
   * @var \Magento\Framework\Controller\Result\ForwardFactory
   */
    protected $_coreRegistry = null;
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;


    protected $profilefactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
     
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Medma\MarketPlace\Model\ProfileFactory $profilefactory
    ) {
        $this->resultPageFactory  = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->profilefactory = $profilefactory;
        parent::__construct($context);
    }
  
    /**
     * Vendor Profile page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $postData = $this->getRequest()->getParams();
        $vendorId = $postData['vendorId'];
        $ratingVal = $postData['rating'];
        if(isset($vendorId) && isset($ratingVal)){

        $sellerObj = $this->profilefactory->create()->load($vendorId);
        $sellerObj->setAgencyRating($ratingVal);
          
          try{
            $sellerObj->save();
            $this->messageManager->addSuccess(__('Rating has been submitted successfully.'));
         }catch(Expection $e)
          {
            echo $e->getMessage();
          }
        } else {

        $this->messageManager->addError(__('Rating is Required Value.'));
        }
        
        
       $this->_redirect($this->_redirect->getRefererUrl());
    }
}
