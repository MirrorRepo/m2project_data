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

use Magento\Customer\Model\Session;
use Symfony\Component\Config\Definition\Exception\Exception;

class Sendrequiremsg extends \Magento\Framework\App\Action\Action
{
  
   
  /**
   * @var \Magento\Framework\Controller\Result\ForwardFactory
   */
    protected $_coreRegistry = null;
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $customerSession;
    protected $detailfactory;
    protected $messagefactory;
    protected $timezoneInterface;
    protected $enqirymessagechainFactory;
    protected $messagerequireFactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    /**
     * Sendrequiremsg constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param Session $customerSession
     * @param \Medma\MarketPlace\Model\DetailFactory $detailfactory
     * @param \Medma\MarketPlace\Model\MessageFactory $messagefactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
     * @param \Medma\MarketPlace\Model\EnquirymessagechainFactory $enqirymessagechainFactory
     * @param \Medma\MarketPlace\Model\EnquirymessageFactory $messageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        Session $customerSession,
        \Medma\MarketPlace\Model\DetailFactory $detailfactory,
        \Medma\MarketPlace\Model\MessageFactory $messagefactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
        \Medma\MarketPlace\Model\EnquirymessagechainFactory $enqirymessagechainFactory,
        \Medma\MarketPlace\Model\EnquirymessageFactory $messagerequireFactory
    ) {
        $this->resultPageFactory  = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->detailfactory = $detailfactory;
        $this->messagefactory = $messagefactory;
        $this->timezoneInterface = $timezoneInterface;
        $this->enqirymessagechainFactory = $enqirymessagechainFactory;
        $this->messagerequireFactory = $messagerequireFactory;
        parent::__construct($context);
        $this->customerSession = $customerSession;
    }
  
    /**
     * Vendor Profile page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $created_at = $this->timezoneInterface->date()->format('m/d/y H:i:s');
        $customerid = $this->customerSession->getCustomer()->getId();
        //$updateStatus = $this->getSinglemessages($params['msg_id'],$params['quote_status']);
        $singleRecordObj = $this->messagerequireFactory->create()->load($params['msg_id']);
        $singleRecordObj->setQuoteStatus($params['quote_status']);
        try {
            $singleRecordObj->save();

        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
       //check for require message
        if(isset($params['msg_id'])):
            $messagefactory = $this->enqirymessagechainFactory->create();
            $messagefactory->setMsgId($params['msg_id']);
            $messagefactory->setType('customer');
            $messagefactory->setMsgString($params['message']);
            $messagefactory->setCreatedAt($created_at);
            $messagefactory->save();

        endif;
    }

    public function getSinglemessages($id,$status)
    {

        if(!empty($id)):
            $singleRecordObj = $this->messagerequireFactory->create()->load($id);
            $singleRecordObj->setQuoteStatus($status);
            try {
               $singleRecordObj->save();

            }catch (Exception $e)
            {
                echo $e->getMessage();
            }
        else:
            return ;
        endif;
    }
}
