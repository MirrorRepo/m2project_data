<?php
/* 
 
 */
namespace Bakeway\Partnerlocations\Block\Adminhtml\Locations\Edit\Tab;

use Bakeway\Cities\Helper\Data as BakewayCitiesHelper;
use Bakeway\Partnerlocations\Helper\Data as Partnerlocationshelper;
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
    
    protected $_cmsPage;
    /**
     * @var BakewayCitiesHelper
     */
    protected $bakewayCitiesHelper;

    /**
     * @var Partnerlocationshelper
     */
    protected $partnerlocationshelper;

    /**
     * @var Webkul\Marketplace\Helper\Data
     */
    protected $_marketplaceHelper;

    /**
     * Form constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Magento\Cms\Model\Page $cmsPage
     * @param \Magento\Backend\Model\Auth $auth
     * @param BakewayCitiesHelper $bakewayCitiesHelper
     * @param Partnerlocationshelper $partnerlocationshelper
     * @param \Webkul\Marketplace\Helper\Data $_marketplaceHelper
     * @param array $data
     */

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Page $cmsPage,
        \Magento\Backend\Model\Auth $auth,
        BakewayCitiesHelper $bakewayCitiesHelper,
        Partnerlocationshelper $partnerlocationshelper,
        \Webkul\Marketplace\Helper\Data $marketplaceHelper,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_cmsPage = $cmsPage;
        $this->_auth = $auth;
        $this->bakewayCitiesHelper = $bakewayCitiesHelper;
        $this->_marketplaceHelper = $marketplaceHelper;
        $this->partnerlocationshelper = $partnerlocationshelper;
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
        $model = $this->_coreRegistry->registry('partnerlocations_locations');
        
        $isElementDisabled = false;
 
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
 
        $form->setHtmlIdPrefix('page_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Store Addresses')]);
 
        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
        $locality = $model->getData('store_locality_area');
        $cityId = $model->getData('city_id');


        /*
         * Removed the ID field which was editable
         */
        
        /*$fieldset->addField(
            'id',
            'text',
            array(
                'name' => 'id',
                'label' => __('ID'),
                'title' => __('ID'))
        );*/
        

        $fieldset->addField(
            'city_id',
            'select',
            array(
                'name' => 'city_id',
                'label' => __('City'),
                'title' => __('City'),
                'class' => 'required-entry',
                'values' => $this->bakewayCitiesHelper->getCitiesOptionArray()
            )
        );

        $fieldset->addField(
            'store_unique_name',
            'hidden',
            array(
                'name' => 'store_unique_name',
                'hidden' => true
            )
        );

        $fieldset->addField(
            'sub_loc_id',
            'select',
            array(
                'name' => 'sub_loc_id',
                'label' => __('Suburb'),
                'title' => __('Suburb'),
                'class' => 'required-entry',
                'values' => $this->partnerlocationshelper->getFormSuburblist($cityId)
            )
        );


        $fieldset->addField(
            'seller_id',
            'hidden',
            array(
                'name' => 'seller_id',
                'label' => __('Seller ID'),
                'title' => __('Seller ID'),
            )
        );

        $fieldset->addField(
            'store_locality_meta_description',
            'textarea',
            array(
                'name' => 'store_locality_meta_description',
                'label' => __('Meta Description'),
                'title' => __('Meta Description'),
            )
        );
        $fieldset->addField(
            'store_latitude',
            'text',
            array(
                'name' => 'store_latitude',
                'label' => __('Store Latitude'),
                'title' => __('Store Latitude'),
                'class' => 'required-entry',
            )
        );

        $fieldset->addField(
            'store_longitude',
            'text',
            array(
                'name' => 'store_longitude',
                'label' => __('Store Longitude'),
                'title' => __('Store Longitude'),
                'class' => 'required-entry',
            )
        );

        if (isset($locality) && $locality != '') {
            $fieldset->addField(
                'store_locality_area',
                'text',
                array(
                    'name' => 'store_locality_area',
                    'label' => __('Locality'),
                    'title' => __('Locality'),
                    'class' => 'required-entry',
                    'readonly' => true
                )
            );
        } else {
            $fieldset->addField(
                'store_locality_area',
                'text',
                array(
                    'name' => 'store_locality_area',
                    'label' => __('Locality'),
                    'title' => __('Locality'),
                    'class' => 'required-entry',
                )
            );
        }


        $fieldset->addField(
            'store_street_address',
            'text',
            array(
                'name' => 'store_street_address',
                'label' => __('Store Address'),
                'title' => __('Store Address'),
                'class' => 'required-entry',
            )
        );

        $fieldset->addField(
            'store_headline',
            'text',
            array(
                'name' => 'store_headline',
                'label' => __('Store Headline'),
                'title' => __('Store Headline'),
                'class' => 'required-entry',
            )
        );

        $fieldset->addField(
            'is_grab_active',
            'select',
            array(
                'name' => 'is_grab_active',
                'label' => __("GRABS'S Status"),
                'title' => __("GRABS'S Status"),
                'values' => $this->_cmsPage->getAvailableStatuses()
            )
        );



        $fieldset->addField(
            'is_active',
            'select',
            array(
                'name' => 'is_active',
                'label' => __('Status'),
                'title' => __('Status'),
                'values' => $this->_cmsPage->getAvailableStatuses()
            )
        );
        
        /*  ======== BKWYADMIN-1206 : Is featured? status setting ======= */
        $fieldset->addField(
            'is_featured',
            'select',
            array(
                'name' => 'is_featured',
                'label' => __('Is Featured?'),
                'title' => __('Is Featured'),
                'values' => $this->_cmsPage->getAvailableStatuses()
            )
        );
        /*  ======== BKWYADMIN-1206 : Is featured? status setting ======= */

        $dfieldset = $form->addFieldset('delivery_fieldset', ['legend' => __('Store Delivery Information')]);

        $dfieldset->addField(
            'is_delivery_active',
            'select',
            array(
                'name' => 'is_delivery_active',
                'label' => __("Delivery On/Off"),
                'title' => __("Delivery On/Off"),
                'note' => __("Depends on the GRAB status, this option will only be applicable when GRAB is disabled for the store"),
                'values' => $this->_cmsPage->getAvailableStatuses()
            )
        );

        $dfieldset->addField(
            'is_pickup_active',
            'select',
            array(
                'name' => 'is_pickup_active',
                'label' => __("Is Pick up available?"),
                'title' => __("Is Pick up available?"),
                'values' => $this->_cmsPage->getAvailableStatuses()
            )
        );

        $dfieldset->addField(
                'shop_open_timing', 'select', [
            'name' => 'shop_open_timing',
            'data-form-part' => $this->getData('target_form'),
            'label' => __('Shop Open Timing'),
            'title' => __('Shop Open Timing'),
            'class' => 'required-entry',
            'value' => 'shop_open_timing',            
            'values' => $this->_marketplaceHelper->getStoreTimeOptionArray(12),
                ]
        );
        $dfieldset->addField(
                'shop_open_AMPM', 'select', [
            'name' => 'shop_open_AMPM',
            'data-form-part' => $this->getData('target_form'),
            'label' => __(''),
            'class' => 'required-entry',
            'value' => 'shop_open_AMPM',            
            'values' => $this->_marketplaceHelper->geAmPmArray(),
                ]
        );


        $dfieldset->addField(
                'shop_close_timing', 'select', [
            'name' => 'shop_close_timing',
            'data-form-part' => $this->getData('target_form'),
            'label' => __('Shop Close Timing'),
            'title' => __('Shop Close Timing'),
            'class' => 'required-entry',
            'value' => 'shop_close_timing',            
            'values' => $this->_marketplaceHelper->getStoreTimeOptionArray(12),
                ]
        );

        $dfieldset->addField(
                'shop_close_AMPM', 'select', [
            'name' => 'shop_close_AMPM',
            'data-form-part' => $this->getData('target_form'),
            'label' => __(''),
            'class' => 'required-entry',
            'value' => 'shop_close_AMPM',            
            'values' => $this->_marketplaceHelper->geAmPmArray(),
                ]
        );

        $dfieldset->addField(
            'regular_delivery_start_time', 'select', [
                'name' => 'regular_delivery_start_time',
                'after_element_html' => '<br><label style="width:100%;">
                    Time in hours.
                </label>',
                'data-form-part' => $this->getData('target_form'),
                'label' => __('Shop Delivery Start Time'),
                'title' => __('Shop Delivery Start Time'),
                'value' => 'regular_delivery_start_time',
                'values' => $this->_marketplaceHelper->getTimeOptionArray(23),
            ]
        );

        $dfieldset->addField(
            'regular_delivery_end_time', 'select', [
                'name' => 'regular_delivery_end_time',
                'after_element_html' => '<br><label style="width:100%;">
                    Time in hours.
                </label>',
                'data-form-part' => $this->getData('target_form'),
                'label' => __('Shop Delivery End Time'),
                'title' => __('Shop Delivery End Time'),
                'value' => 'regular_delivery_end_time',
                'values' => $this->_marketplaceHelper->getTimeOptionArray(23),
            ]
        );

        $dfieldset->addField(
            'is_midnight_active',
            'select',
            array(
                'name' => 'is_midnight_active',
                'label' => __("Midnight Delivery On/Off"),
                'title' => __("Midnight Delivery On/Off"),
                'values' => $this->_cmsPage->getAvailableStatuses()
            )
        );

        $dfieldset->addField(
            'midnight_delivery_start_time', 'select', [
                'name' => 'midnight_delivery_start_time',
                'after_element_html' => '<br><label style="width:100%;">
                    Time in hours.
                </label>',
                'data-form-part' => $this->getData('target_form'),
                'label' => __('Midnight Delivery Start Time'),
                'title' => __('Midnight Delivery Start Time'),
                'value' => 'midnight_delivery_start_time',
                'values' => $this->_marketplaceHelper->getTimeOptionArray(23),
            ]
        );

        $dfieldset->addField(
            'midnight_delivery_end_time', 'select', [
                'name' => 'midnight_delivery_end_time',
                'after_element_html' => '<br><label style="width:100%;">
                    Time in hours.
                </label>',
                'data-form-part' => $this->getData('target_form'),
                'label' => __('Midnight Delivery End Time'),
                'title' => __('Midnight Delivery End Time'),
                'value' => 'midnight_delivery_end_time',
                'values' => $this->_marketplaceHelper->getTimeOptionArray(23),
            ]
        );

        $dfieldset->addField(
            'is_morning_active',
            'select',
            array(
                'name' => 'is_morning_active',
                'label' => __("Morning Delivery On/Off"),
                'title' => __("Morning Delivery On/Off"),
                'values' => $this->_cmsPage->getAvailableStatuses()
            )
        );

        $dfieldset->addField(
            'morning_delivery_start_time', 'select', [
                'name' => 'morning_delivery_start_time',
                'after_element_html' => '<br><label style="width:100%;">
                    Time in hours.
                </label>',
                'data-form-part' => $this->getData('target_form'),
                'label' => __('Morning Delivery Start Time'),
                'title' => __('Morning Delivery Start Time'),
                'value' => 'morning_delivery_start_time',
                'values' => $this->_marketplaceHelper->getTimeOptionArray(23),
            ]
        );

        $dfieldset->addField(
            'morning_delivery_end_time', 'select', [
                'name' => 'morning_delivery_end_time',
                'after_element_html' => '<br><label style="width:100%;">
                    Time in hours.
                </label>',
                'data-form-part' => $this->getData('target_form'),
                'label' => __('Morning Delivery End Time'),
                'title' => __('Morning Delivery End Time'),
                'value' => 'morning_delivery_end_time',
                'values' => $this->_marketplaceHelper->getTimeOptionArray(23),
            ]
        );
        
        $dfieldset->addField(
            'is_free_delivery_active',
            'select',
            array(
                'name' => 'is_free_delivery_active',
                'label' => __("Free Delivery On/Off"),
                'title' => __("Free Delivery On/Off"),
                'values' => $this->_cmsPage->getAvailableStatuses()
            )
        );

        $dfieldset->addField(
            'free_delivery_threshold',
            'text',
            array(
                'name' => 'free_delivery_threshold',
                'label' => __('Free Delivery Threshold'),
                'title' => __('Free Delivery Threshold'))
        );

        $dfieldset->addField(
            'size_threshold',
            'text',
            array(
                'name' => 'size_threshold',
                'label' => __('Size Threshold'),
                'title' => __('Size Threshold'))
        );

        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }
        if (!$model->getId()) {
            $model->setData('sub_loc_id', $model->getData('city_id'));
        }
 
        $dataModel = $model->getData(); 
        if($model->getId())
            $dataModel["id"] = (int)$model->getId();

        $form->setValues($dataModel);
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
        return __('Store Addresses');
    }
 
    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Store Addresses');
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