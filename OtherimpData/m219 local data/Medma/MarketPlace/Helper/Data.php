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
 
namespace Medma\MarketPlace\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $scopeConfig;
    protected $directory_list;
    protected $listsInterface;
    protected $prooftypeFactory;
    protected $listProduct;
    
    
    const XML_PATH_EMAIL_REGISTER_TEMPLATE_FIELD  = 'marketplace/vendor_registration_email/email_template';
    
    const XML_PATH_EMAIL_REGISTER_CONFIRM_TEMPLATE_FIELD = 'marketplace/registration_confirmation_email/email_template';
    
    const XML_PATH_EMAIL_ACTIVATION_TEMPLATE_FIELD  = 'marketplace/vendor_activation_email/email_template';

    const STATUS_ENABLED = "1";

    const STATUS_DISABLED = "0";
       /**
        * @var \Magento\Framework\App\Config\ScopeConfigInterface
        */

    protected $_storeManager;
 
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;
 
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
     
    /**
     * @var string
     */
    protected $temp_id;
    
    protected $profile;
    protected $customerFactory;
    protected $userfactory;
    protected $profilefactory;
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Config\Model\Config\Factory $scopeConfig,
        \Magento\Directory\Model\Country $countryCollectionFactory,
        \Magento\Framework\Locale\ListsInterface $ListsInterface,
        \Magento\Framework\App\Filesystem\DirectoryList $directory_list,
        \Magento\Catalog\Block\Product\ListProduct $listProduct,
        \Medma\MarketPlace\Model\ProoftypeFactory $prooftypeFactory,
        \Medma\MarketPlace\Model\ProfileFactory $profile,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\User\Model\UserFactory $userfactory,
        \Medma\MarketPlace\Model\ProfileFactory $profilefactory,
        \Medma\MarketPlace\Model\ConfigurationFactory $configurationFactory,
        \Magento\Backend\Helper\Data $HelperBackend
    ) {
    
        $this->scopeConfig = $scopeConfig;
        $this->prooftypeFactory = $prooftypeFactory;
        $this->directory_list = $directory_list;
        $this->listsInterface = $ListsInterface;
        $this->listProduct = $listProduct;
        $this->profile = $profile;
        $this->customerFactory = $customerFactory;
         $this->userfactory = $userfactory;
        $this->_storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
         $this->profilefactory = $profilefactory;
         $this->configurationFactory = $configurationFactory;
         $this->HelperBackend = $HelperBackend;
        parent::__construct($context);
    }
    
    public function getConfig($group, $field)
    {
        return $this->scopeConfig->getValue('marketplace/' . $group . '/' . $field, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    public function checkSellerInFavorite($vendorId, $customerId)
    {
        $profilemodel = $this->profile->create();
        $profileModel = $profilemodel->load($vendorId);
        $favourites = $profileModel->getFavourites();
                        
        if (!is_null($favourites) && !empty($favourites)) {
            $favourites = json_decode($favourites, true);
            if (($key = array_search($customerId, $favourites)) !== false) {
                return true;
            }
        }
        return false;
    }
    
    public function getLoggedInUser()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()) {
            return $customerSession->getId();
  
        }
        return false;
    }



    public function getLoggedInAdminUser()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $adminSession = $objectManager->get('Magento\Backend\Model\Auth\Session');
        return $adminSession->getUser()->getRole()->getRoleId();
    }
    public function getLoggedInAdminUserId()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $adminSession = $objectManager->get('Magento\Backend\Model\Auth\Session');
        return $adminSession->getUser()->getId();
    }
    public function getCustomerName($customer_id)
    {
        $customer = $this->customerFactory->create()->load($customer_id)->getName();
        return $customer;
    }
    
    public function getMediaPath($type)
    {
        if ($type=="media") {
            $object_manager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $object_manager->get('Magento\Store\Model\StoreManagerInterface');
            $currentStore = $storeManager->getStore();
            return  $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        }
    }
    
    public function getDir($type)
    {
        if ($type=="root") {
            return $this->directory_list->getRoot();
        } elseif ($type=="media") {
            return $this->directory_list->getPath('media');
        } elseif ($type=="app") {
            return $this->directory_list->getPath('app');
        } elseif ($type=="etc") {
            return $this->directory_list->getPath('etc');
        } elseif ($type=="lib_internal") {
            return $this->directory_list->getPath('lib_internal');
        } elseif ($type=="lib_web") {
            return $this->directory_list->getPath('lib_web');
        } elseif ($type=="pub") {
            return $this->directory_list->getPath('pub');
        } elseif ($type=="static") {
            return $this->directory_list->getPath('static');
        } elseif ($type=="var") {
            return $this->directory_list->getPath('var');
        } elseif ($type=="tmp") {
            return $this->directory_list->getPath('tmp');
        } elseif ($type=="pub") {
            return $this->directory_list->getPath('cache');
        } elseif ($type=="log") {
            return $this->directory_list->getPath('log');
        } elseif ($type=="session") {
            return $this->directory_list->getPath('session');
        } elseif ($type=="setup") {
            return $this->directory_list->getPath('setup');
        } elseif ($type=="di") {
            return $this->directory_list->getPath('di');
        } elseif ($type=="pub") {
            return $this->directory_list->getPath('generation');
        } elseif ($type=="upload") {
            return $this->directory_list->getPath('upload');
        } elseif ($type=="composer_home") {
            return $this->directory_list->getPath('composer_home');
        } elseif ($type=="view_preprocessed") {
            return $this->directory_list->getPath('view_preprocessed');
        } elseif ($type=="html") {
            return $this->directory_list->getPath('html');
        }
    }
    
    public function getImagesDir($type)
    {
        $path = $this->getDir("media"). '/marketplace/vendor/'.$type . '/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
            
        return $path;
    }
    
    
    public function getImagesUrl($type)
    {
        return $this->getMediaPath('media') . 'marketplace/vendor/'.$type.'/' ;
    }
    
    public function switchTemplate()
    {
        
        $configValue = $this->marketHelper->getConfig("general", "product_view_layout");
        switch ($configValue) {
            case 'empty';
                return 'page/empty.phtml';
            case 'one_column';
                return 'page/1column.phtml';
            case 'two_columns_left';
                return 'page/2columns-left.phtml';
            case 'two_columns_right';
                return 'page/2columns-right.phtml';
            case 'three_columns';
                return 'page/3columns.phtml';
        }
        return 'page/1column.phtml';
    }
    
    public function getCountryName($code)
    {
        return $this->listsInterface->getCountryTranslation($code);
    }
    
    public function getVarificationProofTypeList()
    {
        $proofType=[];
                
        $prooftypeCollection = $this->prooftypeFactory->create()->getCollection()->addFieldToFilter('status', 1);

        foreach ($prooftypeCollection as $prooftype) {
            $proofType[$prooftype->getEntityId()] = $prooftype->getName();
        }
        
        return $prooftypeCollection;
    }
    
    public function getVendorProductCollection($id)
    {
        return $this->listProduct->getLoadedProductCollection()
                                ->addFieldToFilter('status', 1)
                                ->addAttributeToFilter('vendor', $id)
                                ->addAttributeToFilter('approved', 1);
    }
    
    
    public function checkIsProductInfoLayout()
    {
        $position = $this->getConfig("general", "shop_info_display");
        if ($position == 'product_info') {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function checkIsLeftRightLayout()
    {
        $position = $this->getConfig("general", "shop_info_display");
        if ($position != 'product_info') {
            return 1;
        } else {
            return 0;
        }
    }
    
    
    
    
    /**
     * Return store configuration value of your template field that which id you set for template
     *
     * @param string $path
     * @param int $storeId
     * @return mixed
     */
    protected function getConfigValue($path, $storeId)
    {
        
        $val = $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        
        return $val;
    }
 
    /**
     * Return store
     *
     * @return Store
     */
    public function getStore()
    {
        return $this->_storeManager->getStore();
    }
 
    /**
     * Return template id according to store
     *
     * @return mixed
     */
    public function getTemplateId($xmlPath)
    {
        $temp_id =  $this->getConfigValue($xmlPath, $this->getStore()->getStoreId());
        
        return $temp_id;
    }
 
    /**
     * [generateTemplate description]  with template file and tempaltes variables values
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     * @return void
     */
    public function generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $template =  $this->_transportBuilder->setTemplateIdentifier($this->temp_id)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND, /* here you can defile area and
                                                                                 store of template for which you prepare it */
                        'store' => $this->_storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars($emailTemplateVariables)
                ->setFrom($senderInfo)
                ->addTo($receiverInfo['email'], $receiverInfo['name']);
        return $this;
    }
    public function generateTemplateAdmin($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $template =  $this->_transportBuilder->setTemplateIdentifier($this->temp_id)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_ADMINHTML, /* here you can defile area and
                                                                                 store of template for which you prepare it */
                        'store' => $this->_storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars($emailTemplateVariables)
                ->setFrom($senderInfo)
                ->addTo($receiverInfo['email'], $receiverInfo['name']);
        return $this;
    }
    
    /**
     * [sendInvoicedOrderEmail description]
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     * @return void
     */
    /* your send mail method*/
    public function sendRegistrationEmailToVendor($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->temp_id = $this->getTemplateId(self::XML_PATH_EMAIL_REGISTER_TEMPLATE_FIELD);
        $this->inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }
    
    public function sendConfirmationEmail($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->temp_id = $this->getTemplateId(self::XML_PATH_EMAIL_REGISTER_CONFIRM_TEMPLATE_FIELD);
        $this->inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }
    public function sendActivationEmailToVendor($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->temp_id = $this->getTemplateId(self::XML_PATH_EMAIL_ACTIVATION_TEMPLATE_FIELD);
        $this->inlineTranslation->suspend();
        $this->generateTemplateAdmin($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }
    public function getProductId()
    {
        return $this->getRequest()->getParam('id');
    }
    public function getSellerRegistrationLabelConfig()
    {
        return $this->getConfig('vendor_registration', 'request_seller_label');
    }
    public function getProductConfig()
    {
        return $this->scopeConfig->getValue('productsearch/general/extension_status');
    }
    public function getVendorSearchLabelConfig()
    {
        return $this->scopeConfig->getValue('productsearch/vendor/vendorlabel');
    }
    
     public function getVendorLoginlink()
    {
        return $this->medmahelper->getSellerUrl();
    }

    

    public function getUser($userid)
    {
        return $this->userfactory->create()->load($userid);
    }
    public function getProfile($userid)
    {
       

        return $this->profilefactory->create()->getCollection()->addFieldToFilter('user_id', $userid)->getFirstItem();
    }

  
    /* check Notify New order Email To Vendor */

    public function getNotifyNewOrderEmail($vendorId)
    {
        $configurationValue = $this->configurationFactory->create()->getCollection()->addFieldToFilter('vendor_id',$vendorId)->getData();
        if(count($configurationValue))
        {
           $configValue = json_decode($configurationValue[0]['value'],true);
           if($configValue['notify_new_order_email'] == 1)
           {
              return true;
           }
        }
        return false;
    }
    public function getSellerUrl()
    {
        return $this->HelperBackend->getHomePageUrl();
    }

    public function getAvailableStatuses()
    {
        return [
            ['label' => __('Approved'), 'value' => self::STATUS_ENABLED],
            ['label' => __('Disapproved'), 'value' => self::STATUS_DISABLED],
            ['label' => __('Pending'), 'value' => '2'],
            ['label' => __('Negotiation'), 'value' => '3']
             ];
    }

    public function getAvailableStatusesonGrid()
    {
    
        return [
            self::STATUS_ENABLED => __('Approved'),
            self::STATUS_DISABLED => __('Disapproved'),
            2 => __('Pending'),
            3 => __('Negotiation')
        ];
    }

    public function getAvailableMeasurement()
    {

        return [
            ['label' => __('Kg'), 'value' => '1'],
            ['label' => __('Liter'), 'value' => '2'],
            ['label' => __('MM'), 'value' => '3'],
            ['label' => __('Inch'), 'value' => '4'],
            ['label' => __('Feet'), 'value' => '5'],
            ['label' => __('Dozens'), 'value' => '6'],
            ['label' => __('Pounds'), 'value' => '7'],
            ['label' => __('Cms'), 'value' => '8'],
            ['label' => __('Packets'), 'value' => '9'],
            ['label' => __('Barrel'), 'value' => '10'],
            ['label' => __('Sqr feet'), 'value' => '11'],
            ['label' => __('Dozens'), 'value' => '12'],
            ['label' => __('Pieces'), 'value' => '13']
        ];
    }

    public function getStatusById($id)
    {

        $array =  [
            0 => __('Approved'),
            1 => __('Disapproved'),
            2 => __('Pending'),
            3 => __('Negotiation')
        ];
        return $array[$id];
    }

 
    /**
    * return group id
    */

    public function getCustomerGroupId()
    {

       $groupId = "";
       $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
       $groupCollection = $objectManager->create("Magento\Customer\Model\Group")->getCollection()
                        ->addFieldToFilter('customer_group_code','Agency')
                        ->getFirstItem();
                        
       return $groupCollection->getData('customer_group_id');
    }

 

     public function getCurrentUrl()
    {
        
        return $this->_storeManager->getStore()->getCurrentUrl(false);
    }

    public function getAllProvinces(){

           return [
                  'Eastern Cape' => 'Eastern Cape',
                  'Free State' => 'Free State',
                  'Gauteng' => 'Gauteng',
                  'KwaZulu-Natal' => 'KwaZulu-Natal',
                  'Limpopo' => 'Limpopo',
                  'Mpumalanga' => 'Mpumalanga',
                  'Northern Cape' => 'Northern Cape',
                  'North West' => 'North West',
                  'Western Cape' => 'Western Cape'

           ];

    }

   

    public function getAllRatingAgency()
    {

      $collection = $this->customerFactory->create()->getCollection()
                   ->addAttributeToFilter("group_id",$this->getCustomerGroupId());

                        
       return $collection->getData();
    }


    public function getAgencyname($id)
    {

      $collection = $this->customerFactory->create()->getCollection()
                   ->addAttributeToFilter("group_id",$this->getCustomerGroupId())
                   ->addAttributeToFilter("entity_id",$id)
                   ->getFirstItem();;

                        
       return $collection->getData();
    }

    public function getAgencyVendors($agencyId){
        $collection = $this->profilefactory->create()->getCollection()
        ->addFieldToFilter("age_name",$agencyId);
        return $collection->getData();

    }


    public function getAgencyCustgroup()
    {
       $groupId = "";
       $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
       $groupCollection = $objectManager->create("Magento\Customer\Model\Group")->getCollection()
                        ->addFieldToFilter('customer_group_code','Agency')
                        ->getFirstItem();
      $groupId = $groupCollection->getData('customer_group_id');

       if(isset($groupId))
       {

        return $groupId;
       }
    }
    
    public function getAllCustProfile(){
        return  $this->customerFactory->create()->getCollection()
                 ->addAttributeToFilter('group_id',$this->getAgencyCustgroup());
   }


  public function getAllMunicipalities(){

                            return [
                            'Amajuba District Municipality' => 'Amajuba District Municipality',
                            'eThekwini Metropolitan Municipality' => 'eThekwini Metropolitan Municipality',
                            'Harry Gwala District Municipality' => 'Harry Gwala District Municipality',
                            'iLembe District Municipality' => 'iLembe District Municipalityl',
                            'King Cetshwayo District Municipality' => 'King Cetshwayo District Municipality',
                            'Ugu District Municipality' => 'Ugu District Municipality',
                            'uMgungundlovu District Municipality' => 'uMgungundlovu District Municipality',
                            'uMkhanyakude District Municipality' => 'uMkhanyakude District Municipality',
                            'uMzinyathi District Municipality' => 'uMzinyathi District Municipality',
                            'uThukela District Municipality' => 'uThukela District Municipality',
                            'Zululand District Municipality' => 'Zululand District Municipality',
                            'Abaqulusi Local Municipality' => 'Abaqulusi Local Municipality',
                            'Alfred Duma Local Municipality' => 'Alfred Duma Local Municipality',
                            'Big Five Hlabisa Local Municipality' => 'Big Five Hlabisa Local Municipality',
                            'Dannhauser Local Municipality' => 'Dannhauser Local Municipality',
                            'Dr Nkosazana Dlamini Zuma Local Municipality' => 'Dr Nkosazana Dlamini Zuma Local Municipality',
                            'eDumbe Local Municipality' => 'eDumbe Local Municipality',
                            'eMadlangeni Local Municipality' => 'eMadlangeni Local Municipality',
                            'Endumeni Local Municipality' => 'Endumeni Local Municipality',
                            'eThekwini Metropolitan Municipality' => 'eThekwini Metropolitan Municipality',

                            'Greater Kokstad Local Municipality' => 'Greater Kokstad Local Municipality',
                            'Impendle Local Municipality' => 'Impendle Local Municipality',
                            'Inkosi Langalibalele Local Municipality' => 'Inkosi Langalibalele Local Municipality',
                            'Jozini Local Municipality' => 'Jozini Local Municipality',


                            'KwaDukuza Local Municipality' => 'KwaDukuza Local Municipality',
                            'eMadlangeni Local Municipality' => 'eMadlangeni Local Municipality',
                            'Endumeni Local Municipality' => 'Endumeni Local Municipality',
                            'eThekwini Metropolitan Municipality' => 'eThekwini Metropolitan Municipality',


                            'Greater Kokstad Local Municipality' => 'Greater Kokstad Local Municipality',
                            'Impendle Local Municipality' => 'Impendle Local Municipality',
                            'Inkosi Langalibalele Local Municipality' => 'Inkosi Langalibalele Local Municipality',
                            'Jozini Local Municipality' => 'Jozini Local Municipality',

                            'KwaDukuza Local Municipality' => 'KwaDukuza Local Municipality',
                            'Mandeni Local Municipality' => 'Mandeni Local Municipality',

                            'Maphumulo Local Municipality' => 'Maphumulo Local Municipality',
                            'Mkhambathini Local Municipality' => 'Mkhambathini Local Municipality',

                            'Mpofana Local Municipality' => 'Mpofana Local Municipality',


                            'Msinga Local Municipality' => 'Msinga Local Municipality',
                            'Msunduzi Local Municipality' => 'Msunduzi Local Municipality',
                            'Mthonjaneni Local Municipality' => 'Mthonjaneni Local Municipality',

                            'Mtubatuba Local Municipality' => 'Mtubatuba Local Municipality',
                            'Ndwedwe Local Municipality' => 'Ndwedwe Local Municipality',

                            'Newcastle Local Municipality' => 'Newcastle Local Municipality',
                            'Nkandla Local Municipality' => 'Nkandla Local Municipality',
                            'Nongoma Local Municipality' => 'Nongoma Local Municipality',
                            'Nqutu Local Municipality' =>'Nqutu Local Municipality',
                            'Okhahlamba Local Municipality'  =>'Okhahlamba Local Municipality',
                            'Ray Nkonyeni Local Municipality' =>'Ray Nkonyeni Local Municipality',
                            'Richmond Local Municipality' =>'Richmond Local Municipality',
                            'Ubuhlebezwe Local Municipality' =>'Ubuhlebezwe Local Municipality',
                            'Ulundi Local Municipality' =>'Ulundi Local Municipality',
                            'uMdoni Local Municipality' =>'uMdoni Local Municipality',
                            'uMfolozi Local Municipality' =>'uMfolozi Local Municipality',
                            'uMhlabuyalingana Local Municipality'=>'uMhlabuyalingana Local Municipality',
                            'uMhlathuze Local Municipality'=>'uMhlathuze Local Municipality',
                            'uMlalazi Local Municipality'=>'uMlalazi Local Municipality',
                            'uMngeni Local Municipality'=>'uMngeni Local Municipality',
                            'uMshwathi Local Municipality'=>'uMshwathi Local Municipality',
                            'uMuziwabantu Local Municipality'=>'uMuziwabantu Local Municipality',
                            'Umvoti Local Municipality'=>'Umvoti Local Municipality',
                            'Umzimkhulu Local Municipality'=>'Umzimkhulu Local Municipality',
                            'Umzumbe Local Municipality'=>'Umzumbe Local Municipality',
                            'uPhongolo Local Municipality'=>'uPhongolo Local Municipality',

                            'City of Johannesburg Metropolitan Municipality'=>'City of Johannesburg Metropolitan Municipality',
                            'City of Tshwane Metropolitan Municipality'=>'City of Tshwane Metropolitan Municipality',
                            'Ekurhuleni Metropolitan Municipality'=>'Ekurhuleni Metropolitan Municipality',
                            'Sedibeng District Municipality'=>'Sedibeng District Municipality',
                            'West Rand District Municipality'=>'West Rand District Municipality',

                            'City of Johannesburg Metropolitan Municipality'=>'City of Johannesburg Metropolitan Municipality',

                            'City of Tshwane Metropolitan Municipality'=>'City of Tshwane Metropolitan Municipality',

                            'Ekurhuleni Metropolitan Municipality'=>'Ekurhuleni Metropolitan Municipality',

                            'Emfuleni Local Municipality'=>'Emfuleni Local Municipality',

                            'Lesedi Local Municipality'=>'Lesedi Local Municipality',

                            'Merafong City Local Municipality'=>'Merafong City Local Municipality',

                            'Midvaal Local Municipality'=>'Midvaal Local Municipality',

                            'Mogale City Local Municipality'=>'Mogale City Local Municipality',

                            'Rand West City Local Municipality'=>'Rand West City Local Municipality',


];

    }


 public function getAllAgency(){

           return [
                  'Agri-BEE Sector Code' => 'Agri-BEE Sector Code',
                  'Financial Sector Code' => 'Financial Sector Code',
                  'Information,Communication and Technology (ICT)' => 'Information,Communication and Technology (ICT)',
                  'Property Sector' => 'Property Sector',
                  'Inregrated Transport Sector' => 'Inregrated Transport Sector',
                  'Inregrated Sector Code' => 'Inregrated Sector Code',
                  'Forestry Sector Code' => 'Forestry Sector Code',
                  'Construction Sector Code' => 'Construction Sector Code',
                  'Tourism Sector Code' => 'Tourism Sector Code',
                  'Marketing, Adversting and Communication (MAC) Sector Code' => 'Marketing, Adversting and Communication (MAC) Sector Code'
           ];

    }

       public function getAllScorecardLevel(){

           return [
                    'Level 1' => 'Level 1',
                    'Level 2' => 'Level 2',
                    'Level 3' => 'Level 3',
                    'Level 4' => 'Level 4',
                    'Level 5' => 'Level 5',
                    'Level 6' => 'Level 6',
                    'Level 7' => 'Level 7',
                    'Level 8' => 'Level 8',
                    'Non-Compliant' => 'Non-Compliant'

           ];

    }

    
}
