<?php
/**
 * @category Dischem
 * @package  Dischem_Storeinfo
 * @module   Storeinfo
 * @author   kushagra.daharwal@zensar.in
 */
namespace Medma\MarketPlace\Block\Adminhtml\Bulletin\Edit\Tab;

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
    
    protected $_storedays; 
    

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
        \Medma\MarketPlace\Helper\Data $storedays,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Page $cmsPage,
        \Magento\Backend\Model\Auth $auth,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_storedays = $storedays;
        $this->_cmsPage = $cmsPage;
        $this->_auth = $auth;
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
        $model = $this->_coreRegistry->registry('requirement_form_data');
        $isElementDisabled = false;
 
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
 
        $form->setHtmlIdPrefix('page_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Requirements Information')]);
 
        if ($model->getId()) {
            $fieldset->addField('day_id', 'hidden', ['name' => 'day_id']);
        }
        
         $fieldset->addField(
            'title',
            'text',
            [
                'name'     => 'title',
                'label'    => __('Title'),
                'title'    => __('Title'),
                'required' => true
            ]
        );

           $fieldset->addField(
            'product_cat',
            'text',
            [
                'name'     => 'product_cat',
                'label'    => __('Product cat'),
                'title'    => __('Title'),
                'required' => true
            ]
        );

        
        $val = ['1' => __('Approved'), '0' => __('Dispproved')];
        $fieldset->addField(
            'approve',
            'select',
            [
                'name'     => 'approve',
                'label'    => __('Status'),
                'title'    => __('Status'),
                'required' => true,
                'values' => $val
            ]
        );

        $fieldset->addField(
            'volume',
            'text',
            [
                'name'     => 'volume',
                'label'    => __('Volume'),
                'title'    => __('Volume'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'requirements',
            'textarea',
            [
                'name'     => 'requirements',
                'label'    => __('Requirements'),
                'title'    => __('Requirements'),
                'required' => true,
            ]
        );

          $fieldset->addField(
            'ldos',
            'date',
            [
                'name'     => 'ldos',
                'label'    => __('Last Date Of Submission'),
                'title'    => __('Last Date Of Submission'),
                'required' => true,
               'date_format' => 'yyyy-MM-dd hh:mm:ss',
            ]
        );
 


/*
     $fieldset->addField(
           'image_upload',
            'label',
            [
                'name'     => 'image_upload',
                'label'    => __('Attachment'),
                'title'    => __('Attachment'),
                'renderer',
        '\Medma\MarketPlace\Block\Adminhtml\Bulletin\Edit\Renderer\attachment'
        
            ]
        );*/


       // $contentField = $fieldset->addField(
         //   'is_active',
           // 'options',
            //[
              //  'name' => 'is_active',
               // 'label'    => __('Sub Hub'),
                //'title'    => __('Sub Hub'),
                //'required' => true,
                //'disabled' => $isElementDisabled,
                 //'options' => $this->_cmsPage->getAvailableStatuses()
            //]
        //);

         
        
        
        
        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
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
        return __('Requirements Information');
    }
 
    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Requirements Information');
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