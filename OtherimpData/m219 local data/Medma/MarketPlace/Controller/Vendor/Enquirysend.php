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
use Magento\Framework\App\Config\ScopeConfigInterface;

class Enquirysend extends \Magento\Framework\App\Action\Action
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
    protected $_transportBuilder;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
     /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
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
        \Medma\MarketPlace\Model\EnquirymessagechainFactory $enqirymessagechainFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
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
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Vendor Profile page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {

        $params = $this->getRequest()->getParams();
        
        $seller_id = $params['seller_Id'];
        $customer_id = $params['customer_Id'];
        $name = $params['name'];
        $email = $params['email'];
        $msg = $params['msg'];
        $sku = $params['product_sku'];
        $checkGuest = $params['check_guest'];
        $qty = $params['quantity'];
        $price = $params['price'];
        $sellerName = $params['seller_name'];
        $productName = $params['product_name'];
        $qtyUnit =$params['op-measure'];

        $created_at = $this->timezoneInterface->date()->format('m/d/y H:i:s');

        $customerLog = $this->customerSession->isLoggedIn();



        if($customerLog == 1 ):
        $checkcustomer = $this->enqirymessageFactory->create()->getCollection()
            ->addFieldToFilter('seller_id',$seller_id)
            ->addFieldToFilter('product_sku', $sku)
            ->addFieldToFilter('customer_id', $customer_id);

        if (count($checkcustomer) > 0) {
            $checkcustomer = $this->enqirymessageFactory->create()->getCollection()
                ->addFieldToFilter('seller_id',$seller_id)
                ->addFieldToFilter('customer_id', $customer_id)
                ->getFirstItem();
            $msgid = $checkcustomer->getId();
            $messagefactory = $this->enqirymessagechainFactory->create();
            $messagefactory->setType('customer');
            $messagefactory->setMsgId($msgid);
            $messagefactory->setCreatedAt($created_at);
            $messagefactory->setMsgString($msg);
            if($checkGuest != 1):
                $messagefactory->save();
            $this->enquiryemailScript($sellerName,$msg,$sku,$qty,$price,$productName,$name,$qtyUnit ,$email);

            endif;

           // $this->_redirectReferer();
            $this->messageManager->addSuccess(__('Your Message has been sent successfully'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();
            return $resultRedirect;
        } else {

            $checkcustomer = $this->enqirymessageFactory->create();
            $checkcustomer->setSellerId($seller_id);
            $checkcustomer->setCustomerId($customer_id);
            $checkcustomer->setProductSku($sku);
            $checkcustomer->setMsg($msg);
            $checkcustomer->setCreatedAt($created_at);
            $checkcustomer->setApprove(0);
            $checkcustomer->setEmail($email);
            $checkcustomer->setName($name);
            $checkcustomer->setQuantity($qty);
            $checkcustomer->setPrice($price);
            $checkcustomer->setProductName($productName);
            $checkcustomer->setSellerName($sellerName);
            $checkcustomer->save();
            $checkcustomerData = $this->enqirymessageFactory->create()->getCollection()
                ->addFieldToFilter('seller_id',$seller_id)
                ->addFieldToFilter('product_sku', $sku)
                ->addFieldToFilter('customer_id', $customer_id);

            $msgid = $checkcustomerData->getFirstItem()->getId();
            $messagefactory = $this->enqirymessagechainFactory->create();
            $messagefactory->setMsgId($msgid);
            $messagefactory->setType('customer');
            $messagefactory->setMsgString($msg);
            $messagefactory->setCreatedAt($created_at);
            

            try{
                $messagefactory->save();
            $this->enquiryemailScript($sellerName,$msg,$sku,$qty,$price,$productName,$name,$qtyUnit ,$email);

            $this->messageManager->addSuccess(__('Your Message has been sent successfully'));
            }catch(Exception $e){

                echo $e->getMessage();
            }


            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();
            return $resultRedirect;

        }


        else:
            /*
            * for guest customer
            */
            $checkcustomer = $this->enqirymessageFactory->create();
            $checkcustomer->setSellerId($seller_id);
            $checkcustomer->setCustomerId($customer_id);
            $checkcustomer->setProductSku($sku);
            $checkcustomer->setMsg($msg);
            $checkcustomer->setCreatedAt($created_at);
            $checkcustomer->setApprove(0);
            $checkcustomer->setEmail($email);
            $checkcustomer->setName($name);
            $checkcustomer->setQuantity($qty);
            $checkcustomer->setPrice($price);
            $checkcustomer->setProductName($productName);
            $checkcustomer->setSellerName($sellerName);

            try{
                 $checkcustomer->save();
            $this->enquiryemailScript($sellerName,$msg,$sku,$qty,$price,$productName,$name,$qtyUnit ,$email);

            $this->messageManager->addSuccess(__('Your Message has been sent successfully'));
            }catch(Exception $e){

                echo $e->getMessage();
            }
           

            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();
            return $resultRedirect;
        endif;


    }



 
    public function enquiryemailScript($sellerName,$msg,$sku,$qty,$price,$productName,$name ,$qtyUnit ,$email)
    {

       
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        
        $emailSender = $this->scopeConfig->getValue('marketplace/vendor_enquiry/email',$storeScope);

        $senderName  =$this->scopeConfig->getValue('marketplace/vendor_enquiry/name',$storeScope);


        $emailReceivers =  array($emailSender);

        $emailcommaSeperated = $emailReceivers;

        $templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->_storeManager->getStore()->getId());

        $templateVars = 
        array(
        'store' => $this->_storeManager->getStore(),
        'customername' => $name,
        'sellername'=>$sellerName,
        'message' => $msg,
        'sku' => $sku,
        'qty' => $qty,
        'productName' => $productName,
        'qtyUnit' => $qtyUnit,
        'price' =>$price,
        'email' => $email
         );


        $from = array('email' => $emailSender, 'name' => $senderName);
        
        $to = $emailcommaSeperated;

        $transport = $this->_transportBuilder->setTemplateIdentifier('enquiry_email_template')
                        ->setTemplateOptions($templateOptions)
                        ->setTemplateVars($templateVars)
                        ->setFrom($from)
                        ->addTo($to)
                        ->getTransport();
       
        try{
             $transport->sendMessage();
        }
        catch (Exception $e ){
            echo $e->getMessage();         
        } 
        

    }
}
