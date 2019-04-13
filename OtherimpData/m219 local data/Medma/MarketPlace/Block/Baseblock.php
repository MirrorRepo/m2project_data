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
 
class Baseblock extends \Magento\Framework\View\Element\Template
{
   

    /*
     * \Magento\Customer\Model\Session
     */
    protected $customerSesssion;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
         \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->customerSesssion = $customerSesssion;
        parent::__construct($context);

    }

   

  } 
