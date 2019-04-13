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

namespace Medma\MarketPlace\Block;


class Agency extends \Magento\Framework\View\Element\Template
{

  protected $customerSession;
  
  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
     \Magento\Customer\Model\Session $customerSession
    )
    { 
       $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Hello World');
    }
    

    public function getSelectedAoo(){
      $customerSession = $this->customerSession;
       if($customerSession->isLoggedIn()) {  
          $id =  $customerSession->getCustomerId();
          $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
          $customerObj = $objectManager->create('Magento\Customer\Model\Customer')->load($id);
          return $customerObj->getData('age_area_of_pro');
      } else{
          return;
      }
    }


}
