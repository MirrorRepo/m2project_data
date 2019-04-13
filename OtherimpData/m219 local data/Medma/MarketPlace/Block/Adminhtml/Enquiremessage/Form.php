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
 
namespace Medma\MarketPlace\Block\Adminhtml\Enquiremessage;
 
class Form extends \Magento\Backend\Block\Widget\Grid\Extended
{
 
    /**
     * @var \Magento\Backend\Helper\Data
     */
    protected $backendHelper;
 
    /**
     * @var \Medma\MarketPlace\Model\ProfileFactory $profileFactory
     */
    protected $messageFactory;
    protected $messagechainFactory;
    protected $adminSession;
    protected $profilefactory;

    protected $_template = 'formenquiremessage.phtml';
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Medma\MarketPlace\Model\ProfileFactory $profileFactory
     * @param \Magento\User\Model\UserFactory $UserFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Medma\MarketPlace\Helper\Data $vendorHelper
     * @param \Magento\Authorization\Model\RoleFactory $rolesFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Medma\MarketPlace\Model\EnquirymessageFactory $messageFactory,
        \Medma\MarketPlace\Model\EnquirymessagechainFactory $messagechainFactory,
        \Magento\Backend\Model\Auth\Session $adminSession,
        \Medma\MarketPlace\Model\ProfileFactory $profilefactory,
        array $data = []
    ) {
    
        $this->messageFactory = $messageFactory;
        $this->adminSession = $adminSession;
        $this->messagechainFactory = $messagechainFactory;
        $this->profilefactory = $profilefactory;

        parent::__construct($context, $backendHelper, $data);
    }
    public function getMessages()
    {
        $id = $this->getRequest()->getParam('id');
        return $this->messagechainFactory->create()->getCollection()->addFieldToFilter('entity_id', $id);
    }
    public function getVendorName()
    {
        return $this->adminSession->getUser()->getName();
    }
    public function getCreatedDate()
    {
        $id = $this->getRequest()->getParam('id');
        $singleRecord = $this->messagechainFactory->create()->getCollection()->addFieldToFilter('entity_id', $id)
                       ->getFirstItem();

        if(!empty($singleRecord['msg_id'])):
        $collection = $this->messageFactory->create()->getCollection()
                       ->addFieldToFilter("entity_id",$singleRecord['msg_id'])
                      ->getFirstItem();
         return $collection->getData();
        else:
            return ;
        endif;
    }
    public function getFirstMsgid()
    {
        $id = $this->getRequest()->getParam('id');
        $singleRecord = $this->messagechainFactory->create()->getCollection()->addFieldToFilter('entity_id', $id)
            ->getFirstItem();
        return $singleRecord['msg_id'];
    }

    public function getChildmessages()
    {
        $id = $this->getRequest()->getParam('id');
        $singleRecord = $this->messageFactory->create()->getCollection()->addFieldToFilter('entity_id', $id)
            ->getFirstItem();
        if(!empty($singleRecord['entity_id'])):
            $collection = $this->messagechainFactory->create()->getCollection()
                ->addFieldToFilter("msg_id",$singleRecord['entity_id']);
            return $collection->getData();
        else:
            return ;
        endif;
    }

    public function getSinglemessages()
    {
        $id = $this->getRequest()->getParam('id');
        $singleRecord = $this->messageFactory->create()->getCollection()->addFieldToFilter('entity_id', $id)
            ->getFirstItem();
        if(!empty($singleRecord['entity_id'])):
            return $singleRecord->getData();
        else:
            return ;
        endif;
    }

    public function getMessageData($id)
    {

        $msgcollecition = $this->messageFactory->create()->getCollection()->addFieldToFilter('entity_id', $id)
            ->getLastItem();

        return $msgcollecition;
    }

}
