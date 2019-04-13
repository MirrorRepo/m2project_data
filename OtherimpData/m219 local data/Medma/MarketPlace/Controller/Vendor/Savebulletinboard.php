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
use Magento\Framework\Image\AdapterFactory;



class Savebulletinboard extends \Magento\Framework\App\Action\Action
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
    /** @var \Magento\Framework\Controller\Result\JsonFactory */
    protected $jsonResultFactory;
    protected $enqirymessageFactory;
    protected $enqirymessagechainFactory;
    protected $_mediaDirectory;
    protected $_fileUploaderFactory;
    protected $adapterFactory;
    protected $filesystemfile;
    protected $category;
    protected $categoryRepository;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        Session $customerSession,
        \Medma\MarketPlace\Model\DetailFactory $detailfactory,
        \Medma\MarketPlace\Model\MessageFactory $messagefactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Medma\MarketPlace\Model\EnquirymessageFactory $enqirymessageFactory,
        \Medma\MarketPlace\Model\BulletinFactory $enqirymessagechainFactory,
        \Magento\Framework\Filesystem $filesystem,
       \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
       AdapterFactory $adapterFactory,
       \Magento\Framework\Filesystem\Io\File  $filesystemfile,
         \Magento\Catalog\Helper\Category $category,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository
    ) {
        $this->resultPageFactory  = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->detailfactory = $detailfactory;
        $this->messagefactory = $messagefactory;
        $this->timezoneInterface = $timezoneInterface;
        $this->enqirymessageFactory = $enqirymessageFactory;
        $this->enqirymessagechainFactory = $enqirymessagechainFactory;
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->filesystemfile = $filesystemfile;
        $this->category = $category;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Vendor Profile page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {

    $params = $this->getRequest()->getParams();

    /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
    $resultRedirect = $this->resultRedirectFactory->create();
    if(isset($_FILES['upia']['name']) && $_FILES['upia']['name'] != '') {
            try{
               // $imagePath = 'smj/pathofdoc'.$result['file'];

                $uploader = $this->_fileUploaderFactory->create(['fileId' => 'upia']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $path = $this->_mediaDirectory->getAbsolutePath('smj/pathofdoc/');

                if (!is_dir($path)) {
                $ioAdapter = $this->filesystemfile;
                $ioAdapter->mkdir($path, 0777);
                }

                $result = $uploader->save($path);


                $uploadedImage =  $result['file'];
            } catch (\Exception $e) {
            }
        }
        $collection = $this->enqirymessagechainFactory->create();

        $categories = $this->category->getStoreCategories();

   

        foreach($categories as $category) {
            
            if($category->getId() == 20):

            $categoryObj = $this->categoryRepository->get($category->getId());
            $subcategories = $categoryObj->getChildrenCategories();
            foreach($subcategories as $subcategorie) {
                 $subcategorie->getName().'<br/>';
            }
            endif;
        }

      try{
           if(isset($uploadedImage) && isset($params['title'])) {
                $customerSession = $this->customerSession;
                $customerId = "";
                if($customerSession->isLoggedIn()) {  
                  $customerId =  $customerSession->getCustomerId();
                }
                $collection->setTitle($params['title']);
                $collection->setProductCat($params['product_cats']);
                $collection->setVolume($params['volume']);
                $collection->setRequirements($params['product_cats']);
                $collection->setLdos($params['ldos']);
                $collection->setCustomerId($customerId);
                $collection->setImageUpload($uploadedImage);
                $collection->save();

                $this->messageManager->addSuccess(__('Your Message has been sent successfully'));
            }
        }catch(Exception $e){

            echo $e->getMessage();
        }


        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setRefererOrBaseUrl();
        return $resultRedirect;

       



    }
}
