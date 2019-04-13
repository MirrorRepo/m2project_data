<?php
/* 
 * Save Action for Hubassignments
 * @vendor Dischem
 * @module Dischem_Hubassignments
 * @created at 13-01-2016 03:52 PM IST
 * @modified at 14-01-2016 11:06 AM IST 
 * @author Srinihi D<srinidhi.damle@zensar.in>
 */
namespace Medma\MarketPlace\Controller\Adminhtml\Enquire;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
   
    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $jsHelper;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;
	

    /**
     * @param Action\Context $context
     * @param Magento\Backend\Helper\Js $jsHelper
     * @param Magento\Framework\Mail\Template\TransportBuilder
     */
    public function __construct(Action\Context $context,
        \Magento\Backend\Helper\Js $jsHelper,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation)
    {
        $this->jsHelper = $jsHelper;
        $this->_transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->inlineTranslation = $inlineTranslation;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }   
    
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    { 
die;
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Dischem\Hubassignments\Model\Grid $model */
            $model = $this->_objectManager->create('Medma\MarketPlace\Model\Enquirymessage');
            $id = $this->getRequest()->getParam('entity_id');
            //set updated time
            if ($id) {
                $model->load($id);
            }
            $model->setData($data);

            
            try {
                
                $model->save();
                $this->messageManager->addSuccess(__('Enquiry data has been updated.'));
              
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getDayId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Hub.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }    
    
    
}