<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Bakeway\StoreCatalog\Block\Adminhtml\Customer\Edit\Tab;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Ui\Component\Layout\Tabs\TabInterface;
use Bakeway\Partnerlocations\Model\PartnerlocationsFactory as PartnerlocationsFactory;

/**
 * Customer account form block
 */
class Storecatalog extends \Magento\Backend\Block\Widget\Form\Generic implements TabInterface
{
   
     /**
     * @var string
     */
    protected $_template = 'customer/index.phtml';
    /**
     * @var \Magento\Newsletter\Model\SubscriberFactory
     */
    protected $_subscriberFactory;

    /**
     * @var AccountManagementInterface
     */
    protected $customerAccountManagement;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;
    
    /**
     * @var PartnerlocationsFactory
     */
    protected $partnerlocationsFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
     * @param AccountManagementInterface $customerAccountManagement
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        AccountManagementInterface $customerAccountManagement,
        \Magento\Framework\ObjectManagerInterface $objectManager,
         PartnerlocationsFactory $partnerlocationsFactory,
        array $data = []
    )
    {
        $this->_subscriberFactory = $subscriberFactory;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->_objectManager = $objectManager;
        $this->partnerlocationsFactory = $partnerlocationsFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Return Tab label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Manage Store Catalogue');
    }

    /**
     * Return Tab title
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Manage Store Catalogue');
    }

    /**
     * Tab class getter
     *
     * @return string
     */
    public function getTabClass()
    {
        return '';
    }

    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl()
    {
        return '';

    }

    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded()
    {
        return false;
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        $coll = $this->_objectManager->create(
            'Webkul\Marketplace\Block\Adminhtml\Customer\Edit'
        )->getMarketplaceUserCollection();
        $isSeller = false;
        foreach ($coll as $row) {
            $isSeller = $row->getIsSeller();
        }
        if ($this->getCustomerId() && $isSeller) {
            return true;
        }

        return false;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        $coll = $this->_objectManager->create(
            'Webkul\Marketplace\Block\Adminhtml\Customer\Edit'
        )->getMarketplaceUserCollection();
        $isSeller = false;
        foreach ($coll as $row) {
            $isSeller = $row->getIsSeller();
        }
        if ($this->getCustomerId() && $isSeller) {
            return true;
        }

        return false;
    }

    /**
     * Initialize the form.
     *
     * @return $this
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function initForm()
    {
        if (!$this->canShowTab()) {
            return $this;
        }
        /**@var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('_newsletter_locations');
        $this->setForm($form);
        return $this;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->canShowTab()) {
            $this->initForm();
            return parent::_toHtml();
        } else {
            return '';
        }
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function getSellerData()
    {
        $_Collection =  $this->partnerlocationsFactory->create()->getCollection()
            ->addFieldToFilter('is_active',\Bakeway\StoreCatalog\Block\Storecatalog\Index::SELLER_ACTIVE)
            ->addFieldToFilter('seller_id', $this->getCustomerId());
        if (count($_Collection) > 0) {
            return $_Collection->getData();
        } else {
            return false;
        }
    }
    


}
