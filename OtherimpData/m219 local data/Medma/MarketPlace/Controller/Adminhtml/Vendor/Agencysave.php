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

namespace Medma\MarketPlace\Controller\Adminhtml\Vendor;
use Magento\Framework\App\Filesystem\DirectoryList;

class Agencysave extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    protected $detailfactory;
    protected $messagefactory;
    protected $timezoneInterface;

    protected $enqirymessagechainFactory;
    protected $_enquirymessage;
    protected $_fileUploaderFactory;
    protected $marketplacehelper;
    protected $profilefactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Medma\MarketPlace\Model\DetailFactory $detailfactory,
        \Medma\MarketPlace\Model\MessageFactory $messagefactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
        \Medma\MarketPlace\Model\EnquirymessagechainFactory $enqirymessagechainFactory,
        \Medma\MarketPlace\Model\Enquirymessage $enquirymessage,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Medma\MarketPlace\Helper\Data $marketplacehelper,
        \Medma\MarketPlace\Model\ProfileFactory $profilefactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->detailfactory = $detailfactory;
        $this->messagefactory = $messagefactory;
        $this->timezoneInterface = $timezoneInterface;
        $this->enqirymessagechainFactory = $enqirymessagechainFactory;
        $this->_enquirymessage = $enquirymessage;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->marketplacehelper = $marketplacehelper;
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
        
        $params = $this->getRequest()->getParams();
        
        $sellerId = $params['seller_id'];
        $agencyId = $params['agency_id'];

        if(isset($sellerId) && isset($agencyId)){
          $sellerData= $this->profilefactory->create()->getCollection()
                       ->addFieldToFilter("user_id",$sellerId)
                       ->getFirstItem();
          $sellerObj = $this->profilefactory->create()->load($sellerData['entity_id']);            
          $sellerObj->setAgeName($agencyId);
          try{
            $sellerObj->save();

            $this->messageManager->addSuccess(__('Data has been submitted successfully.'));
          }catch(Exception $e){
            echo $e->getMessage();
          }
          
        }
    die;
        $this->_redirect('admin_marketplace/vendor/indexfiles');

    }
}
