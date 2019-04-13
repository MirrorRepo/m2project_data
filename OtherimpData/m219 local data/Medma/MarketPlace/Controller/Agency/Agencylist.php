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

class Agencylist extends \Magento\Framework\App\Action\Action
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
    protected $customerFactory;
    protected $customerRepositoryInterface;
    protected $resultJsonFactory;
    protected $marketpalcehelper;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
     
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Medma\MarketPlace\Model\ProfileFactory $profilefactory,
        \Magento\Customer\Model\CustomerFactory $CustomerFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
         \Magento\Framework\Controller\Result\JsonFactory    $resultJsonFactory,
         \Medma\MarketPlace\Helper\Data $marketpalcehelper

    ) {
        $this->resultPageFactory  = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->profilefactory = $profilefactory;
        $this->customerFactory = $CustomerFactory;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->resultJsonFactory  = $resultJsonFactory;
        $this->marketpalcehelper = $marketpalcehelper;
        parent::__construct($context);
    }
  
    /**
     * Vendor Profile page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {

        $result  = $this->resultJsonFactory->create();
        
        

     $option = $this->getRequest()->getParam('option');         
     $collection = $this->marketpalcehelper->getAllCustProfile();


     if(isset($option)){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $agencyname = [];
       foreach($collection as $customerEntity)
       {
          $customerID = $customerEntity['entity_id'];
          
          $customerObj = $objectManager->create('Magento\Customer\Model\Customer')->load($customerID);

          
          $agencyProvience = $customerObj['age_area_of_pro'];
      
          if(isset($agencyProvience))
          {
             $proviArray = explode(',',$agencyProvience);

             if(in_array($option, $proviArray)){

              
                // echo   $suburbData['id'];
                $agencyname[] =     "<option value=".$customerObj['entity_id'].">".$customerObj['firstname']." ".$customerObj['lastname']."</option>";

             }
        
          }
                    
          

       }
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
        return $this->getResponse()->representJson(
            $objectManager->get(
                'Magento\Framework\Json\Helper\Data'
            )->jsonEncode($agencyname)
        );
   
     } 
     

    }
}
