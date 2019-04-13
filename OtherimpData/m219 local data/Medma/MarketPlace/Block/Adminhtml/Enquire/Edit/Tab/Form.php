<?php
/* 
 
 */
namespace Medma\MarketPlace\Block\Adminhtml\Enquire\Edit\Tab;

class Form extends \Magento\Backend\Block\Widget\Form\Generic 
implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
 
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    //protected $_wysiwygConfig;
    /**
     * @var \Magento\Backend\Model\Auth
     */
    protected $_auth;

    protected $marketplacehelper;

    protected $_cmsPage;
 
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Page $cmsPage,
        \Magento\Backend\Model\Auth $auth,
        \Medma\MarketPlace\Helper\Data $marketplacehelper,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_cmsPage = $cmsPage;
        $this->_auth = $auth;
        $this->marketplacehelper = $marketplacehelper;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    
    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('enquiry_form_data');
        $isElementDisabled = false;
 
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
 
        $form->setHtmlIdPrefix('page_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Enquiry Details')]);
 
        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        }
        
        
	   
	    $fieldset->addField(
            'product_sku',
            'text',
            [
                'name' => 'product_sku',
                'label' => __('SKU'),
                'title' => __('SKU'),
                'required' => true,
                'class' => 'required-entry',
            ]
        );
		
		$fieldset->addField(
            'msg',
            'text',
            [
                'name' => 'msg',
                'label' => __('Message'),
                'title' => __('Message'),
                'required' => true,
                'class' => 'required-entry',
            ]
        );

        $fieldset->addField(
            'approve',
            'select',
            [
                'label' => __('Status'),
                'name' => 'approve',
                'required' => true,
                'class' => 'required-entry',
                'values' => $this->marketplacehelper->getAvailableStatuses(),
            ]
        );
        
		$fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Email Id'),
                'title' => __('Email Id'),
                'required' => true,
				'class'    => 'validate-email',
            ]
        );

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
                'class'    => 'required-entry',
            ]
        );

        
        if (!$model->getId()) {
            $model->setData('approve', $isElementDisabled ? '0' : '1');
        }
 
        $form->setValues($model->getData());
        $this->setForm($form);
 
        return parent::_prepareForm();
    }
    
    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Enquiry Details');
    }
 
    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Enquiry Details');
    }
 
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
 
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
 
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }    
}