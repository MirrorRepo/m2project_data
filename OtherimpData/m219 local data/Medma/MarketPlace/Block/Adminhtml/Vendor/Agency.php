<?php
/**
 * Copyright © 2015 Bakeway . All rights reserved.
 */
namespace Medma\MarketPlace\Block\Adminhtml\Vendor;
class Agency extends \Magento\Backend\Block\Template
{

    protected $profilefactory;
    /**
     * @var string
     */

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Template\Context $context, 
        \Medma\MarketPlace\Model\ProfileFactory $profilefactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->profilefactory = $profilefactory;
        $this->setUseContainer(true);
    }


	public function getVendorId()
    {
        return  $vendorId = $this->getRequest()->getParam('id');
    }

   
}
