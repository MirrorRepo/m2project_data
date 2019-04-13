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

class Sellerquotesave extends \Magento\Backend\App\Action
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
        $created_at = $this->timezoneInterface->date()->format('m/d/y H:i:s');
        $params = $this->getRequest()->getParams();

        if(isset($_FILES['quotefile']['name']) && $_FILES['quotefile']['name'] != ''):
            try{
                $target = BP.'/pub/media/quotefile/';
                $uploader = $this->_fileUploaderFactory->create(array('fileId' => 'quotefile'));
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'pdf', 'xls' ,'csv','xml' ,'doc' ,'docx']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $result = $uploader->save($target);
                $data['quotefile'] = $_FILES['quotefile']['name'];
            }catch (Exception $e) {
                $data['quotefile'] = $_FILES['quotefile']['name'];
            }

        else:
             $data['quotefile'] = 'N/A';

        endif;


        if(isset($params['entity_id'])):

            $messagefactory = $this->_enquirymessage->load($params['entity_id']);
            $messagefactory->setQuoteNo($params['quote_no']);
            $messagefactory->setPrice($params['price']);
            $messagefactory->setVendorName($params['vendor_name']);
            $messagefactory->setQuantity($params['quantity']." ".$params['op-measure']);
            $messagefactory->setAttchment($data['quotefile']);
            $messagefactory->setVat($params['vat']);
            $messagefactory->setTrans($params['trans']);
            $messagefactory->setMunicipality($params['municipality']);
            $messagefactory->setAttchment($data['quotefile']);
            $messagefactory->save();

        endif;
        $this->messageManager->addSuccess(__('Your Message has been sent successfully'));
        $this->_redirect('admin_marketplace/enquiremessage/view/');

    }
}
