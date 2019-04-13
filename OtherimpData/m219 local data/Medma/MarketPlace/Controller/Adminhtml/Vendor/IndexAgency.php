<?php
/*
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

class IndexAgency extends \Magento\Backend\App\Action
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
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->detailfactory = $detailfactory;
        $this->messagefactory = $messagefactory;
        $this->timezoneInterface = $timezoneInterface;
        $this->enqirymessagechainFactory = $enqirymessagechainFactory;
        $this->_enquirymessage = $enquirymessage;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context);
    }
    
     
    /**
     * Vendor Profile page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
