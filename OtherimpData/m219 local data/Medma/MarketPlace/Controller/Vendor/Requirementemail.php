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

namespace Medma\MarketPlace\Controller\Vendor;

use  \Medma\MarketPlace\Model\BulletinFactory  as  BulletinFactory;
use  Magento\Customer\Model\CustomerFactory as CustomerFactory;


class Requirementemail extends \Magento\Framework\App\Action\Action
{
     
  /**
   * @var \Magento\Framework\Controller\Result\ForwardFactory
   */
    protected $_coreRegistry = null;
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $bulletinFactory;
    protected $customerFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
     
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        BulletinFactory $bulletinFactory,
        CustomerFactory $customerFactory
    ) {
        $this->resultPageFactory  = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->bulletinFactory = $bulletinFactory;
        $this->customerFactory = $customerFactory;
        parent::__construct($context);
    }
  
    /**
     * Vendor Items page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $customerId = $this->getRequest()->getParams('cust_id'); 
        if(isset($customerId))
        {
            $customerCollection = $this->customerFactory->create()->getCollection()
                            ->addAttributeToSelect('*')
                     ->addAttributeToFilter('entity_id',['eq'=> $customerId]);

            $customerCollection->getSelect()->joinLeft(
                        ['cbb' => $customerCollection->getTable('smj_bulletin_board')], 'e.entity_id=cbb.customer_id', ['title','product_cat','ldos', 'customer_id']
                ); 






        }

        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
