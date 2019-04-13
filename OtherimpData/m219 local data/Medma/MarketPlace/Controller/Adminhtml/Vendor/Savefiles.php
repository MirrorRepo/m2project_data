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

class Savefiles extends \Magento\Backend\App\Action
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

        $created_at = $this->timezoneInterface->date()->format('m/d/y H:i:s');


        if(isset($_FILES['import_rating_file']['name']) && $_FILES['import_rating_file']['name'] != ''):
            try{

             //   str_replace(" ","",$_FILES['import_rating_file']['name']);

                $target = BP.'/pub/media/quotefile/';
                $uploader = $this->_fileUploaderFactory->create(array('fileId' => 'import_rating_file'));
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'pdf', 'xls' ,'csv','xml' ,'doc' ,'docx']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $result = $uploader->save($target);
                $imageName = $uploader->getUploadedFileName();
                $data['vendor_rating_file'] = $imageName;
            }catch (Exception $e) {
                $data['vendor_rating_file'] = $_FILES['import_rating_file']['name'];
            }

        else:
             $data['vendor_rating_file'] = 'N/A';

        endif;
         $id = $this->marketplacehelper->getLoggedInAdminUserId();
        $profileData = $this->marketplacehelper->getProfile($id);
        $sellerid = $profileData->getData('entity_id');
        if(isset($sellerid)){
           $sellerLoad =  $this->profilefactory->create()->load($sellerid );
           $sellerLoad->setVendorRatingFile($data['vendor_rating_file']);
            $sellerLoad->setCreatedAt($created_at);
           try{
             $sellerLoad->save();
            $this->messageManager->addSuccess(__('File has been uploaded successfully'));  

           }catch(Exception $e)
           {
            echo $e->getMessage();
           }

       
        }
      
        $this->_redirect('admin_marketplace/vendor/indexfiles');

    }
}
