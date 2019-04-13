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

class Operationsave extends \Magento\Framework\App\Action\Action
{
  
   
  /**
   * @var \Magento\Framework\Controller\Result\ForwardFactory
   */
    protected $_coreRegistry = null;
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $_customerRepositoryInterface;
    protected $medmahelper;
    protected $customer;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
     
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
         \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
         \Medma\MarketPlace\Helper\Data $medmahelper,
         \Magento\Customer\Model\Customer $customer
    ) {
        $this->resultPageFactory  = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->medmahelper = $medmahelper;
        $this->customer = $customer;
        parent::__construct($context);
    }
  
    /**
     * Vendor Profile page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
       
        $data = $this->getRequest()->getParams();
        if(isset($data['age_area_of_pro'])){

        $areaOfPro = $data['age_area_of_pro'];
        
        $areaOfPro = implode(",",$areaOfPro);
   
        $id = $this->medmahelper->getLoggedInUser();

       
         $customer = $this->customer->load($id);
         $customer->setAgeAreaOfPro($areaOfPro);
                                   
        try {
            $this->customer->save();
            $this->_redirect($this->_redirect->getRefererUrl());
            $this->messageManager->addSuccess(__('My Area Of Operations has saved successfully'));
        } catch (\Magento\Framework\Validator\Exception $e) {
            $this->_redirect($this->_redirect->getRefererUrl());
            $this->messageManager->addError(__('My Area Of Operationsis was not submitted'));
        }
    }
 }
}
