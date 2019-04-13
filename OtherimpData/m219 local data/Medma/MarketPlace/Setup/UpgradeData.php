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
 
namespace Medma\MarketPlace\Setup;
 
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Eav\Setup\EavSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    
    protected $dataFactory;

    protected $productFactory;

    protected $customerSetupFactory;
    public function __construct(
        \Medma\MarketPlace\Model\Configuration\DataFactory $dataFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\App\State $state,
        EavSetupFactory $eavSetupFactory,
    \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
    ) {
        $this->dataFactory = $dataFactory;
        $state->setAreaCode('adminhtml');
        $this->productFactory = $productFactory;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
    }
 
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            $data = [
                'group' => 'Email',
                'code' => 'notify_new_order_email',
                'name' => 'notify_new_order_email',
                'type' => 'select',
                'label' => 'Notify New Order Email to Me',
                'title' => 'Notify New Order Email to Me',
                'source_model' => 'adminhtml/system_config_source_yesno',
                    ];
 
            $post = $this->dataFactory->create();
 
            $post->addData($data)->save();
        }
        if(version_compare($context->getVersion(), '100.0.5', '<'))
        {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                    \Magento\Catalog\Model\Product::ENTITY,
                    'shipping_cost',
                    [
                    'group'=> 'General',
                    'type'=>'int',
                    'backend'=>'',
                    'frontend'=>'',
                    'label'=>'Shipping Cost',
                    'input'=>'text',
                    'class'=>'',
                    'source'=> '',
                    'global'=>\Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                    'visible'=>true,
                    'required'=>false,
                    'user_defined'=>true,
                    'default'=>'',
                    'searchable'=>false,
                    'filterable'=>false,
                    'comparable'=>false,
                    'visible_on_front'=>false,
                    'used_in_product_listing'=>false,
                    'unique'=>false,
                    'apply_to'=>'simple,configurable,virtual,bundle,downloadable,grouped'
                    ]
                );
        }

        if(version_compare($context->getVersion(), '100.0.14', '<'))
        {


            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributeCode = "age_address";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'age_address', [
                    'label' => 'Agency Address',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system'=> 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'age_address');
           // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms',['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address','customer_account_create']);
            $customcustomerAttribute->save();



            $attributeCode = "age_contact_person";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'age_contact_person', [
                    'label' => 'Agency Contact Person',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system'=> 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'age_contact_person');
            // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms',['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address','customer_account_create']);
            $customcustomerAttribute->save();



            $attributeCode = "age_phone_number";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'age_phone_number', [
                    'label' => 'Agency Phone Number',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system'=> 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'age_phone_number');
           // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms',['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address','customer_account_create']);
            $customcustomerAttribute->save();




            $attributeCode = "age_website";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'age_website', [
                    'label' => 'Agency Webisite',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system'=> 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'age_website');
           // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms',['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address','customer_account_create']);
            $customcustomerAttribute->save();


            $attributeCode = "age_area_of_pro";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'age_area_of_pro', [
                    'label' => 'Agency Area Of Provinces',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system'=> 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'age_area_of_pro');
           // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms',['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address','customer_account_create']);
            $customcustomerAttribute->save();


            $attributeCode = "age_name";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'age_name', [
                    'label' => 'Agency Name',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system'=> 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'age_name');
            // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms',['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address','customer_account_create']);
            $customcustomerAttribute->save();

        }

        if(version_compare($context->getVersion(), '100.0.16', '<')) {



            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributeCode = "provinces";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'provinces', [
                    'label' => 'Provinces',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system' => 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'provinces');
            // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms', ['adminhtml_checkout', 'adminhtml_customer', 'adminhtml_customer_address', 'customer_account_edit', 'customer_address_edit', 'customer_register_address', 'customer_account_create']);
            $customcustomerAttribute->save();

            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributeCode = "municipality";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'municipality', [
                    'label' => 'Municipality',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system' => 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'municipality');
            // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms', ['adminhtml_checkout', 'adminhtml_customer', 'adminhtml_customer_address', 'customer_account_edit', 'customer_address_edit', 'customer_register_address', 'customer_account_create']);
            $customcustomerAttribute->save();
        }

    if(version_compare($context->getVersion(), '100.0.24', '<')) {

            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributeCode = "location";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'location', [
                    'label' => 'Location',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system' => 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'location');
            // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms', ['adminhtml_checkout', 'adminhtml_customer', 'adminhtml_customer_address', 'customer_account_edit', 'customer_address_edit', 'customer_register_address', 'customer_account_create']);
            $customcustomerAttribute->save();

            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributeCode = "scorecard_level";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'scorecard_level', [
                    'label' => 'scorecard level',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system' => 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'scorecard_level');
            // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms', ['adminhtml_checkout', 'adminhtml_customer', 'adminhtml_customer_address', 'customer_account_edit', 'customer_address_edit', 'customer_register_address', 'customer_account_create']);
            $customcustomerAttribute->save();



              $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributeCode = "industry";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'industry', [
                    'label' => 'Industry',
                    'type' => 'text',
                    'frontend_input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'system' => 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'industry');
            // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms', ['adminhtml_checkout', 'adminhtml_customer', 'adminhtml_customer_address', 'customer_account_edit', 'customer_address_edit', 'customer_register_address', 'customer_account_create']);
            $customcustomerAttribute->save();
        }


        if(version_compare($context->getVersion(), '100.0.25', '<')) {
             $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributeCode = "is_paid";
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode);

            $customerSetup->addAttribute('customer',
                'is_paid', [
                    'label' => 'Is Paid',
                    'type' => 'int',
                    'input' => 'select',
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                    'required' => false,
                    'visible' => true,
                    'system' => 0,
                    'position' => 105,
                ]);

            $customcustomerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'is_paid');
            // $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'age_address');
            $customcustomerAttribute->setData('used_in_forms', ['adminhtml_checkout', 'adminhtml_customer', 'adminhtml_customer_address', 'customer_account_edit', 'customer_address_edit', 'customer_register_address', 'customer_account_create']);
            $customcustomerAttribute->save();

            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);                         
        }
        $setup->endSetup();
    }
}
