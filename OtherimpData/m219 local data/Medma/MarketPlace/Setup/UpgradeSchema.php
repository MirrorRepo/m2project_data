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
 
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
 
class UpgradeSchema implements UpgradeSchemaInterface
{
 
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
 
        $installer->startSetup();
        
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('medma_marketplace_prooftype')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Name'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                25,
                [],
                'Status'
            )->setComment(
                'Marketplace Profile Table'
            );
                
            $installer->getConnection()->createTable($table);
        }
        
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('medma_marketplace_transaction')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'vendor_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                [],
                'Vendor id'
            )->addColumn(
                'transaction_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Transaction Date'
            )->addColumn(
                'order_number',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Order Number'
            )->addColumn(
                'information',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'information'
            )->addColumn(
                'amount',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                '12,4',
                [],
                'amount'
            )->addColumn(
                'type',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'type'
            )->setComment(
                'Marketplace Transaction Table'
            );
            
            $installer->getConnection()->createTable($table);
        }
        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('medma_marketplace_configuration')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'vendor_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                [],
                'Vendor id'
            )->addColumn(
                'value',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'value'
            )->setComment(
                'Marketplace Configuration Table'
            );
            
            $installer->getConnection()->createTable($table);
        }
        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('medma_marketplace_configuration_data')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'group',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Group'
            )
                ->addColumn(
                    'code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Code'
                )
                ->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Name'
                )
                ->addColumn(
                    'group',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Group'
                )
                ->addColumn(
                    'type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'type'
                )
                ->addColumn(
                    'label',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Label'
                )
                ->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Title'
                )
                ->addColumn(
                    'class',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Class'
                )
                ->addColumn(
                    'style',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Style'
                )
                ->addColumn(
                    'class',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Class'
                )
                ->addColumn(
                    'options',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Options'
                )
                ->addColumn(
                    'source_model',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Source Model'
                )
                ->addColumn(
                    'after_element_html',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'After Element Html'
                )
                ->addColumn(
                    'disable',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    [],
                    'Disable'
                )
                ->addColumn(
                    'readonly',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    [],
                    'Readonly'
                )
                ->addColumn(
                    'readonly',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    [],
                    'Readonly'
                )->setComment(
                    'Marketplace Configuration Data Table'
                );
            
            $installer->getConnection()->createTable($table);
        }
        
        if (version_compare($context->getVersion(), '1.0.6', '<')) {
            $connection = $installer->getConnection();

            $column = [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length' => 11,
                'nullable' => false,
                'comment' => 'Seller Vacation Mode',
                'default' => '0'
            ];
            $connection->addColumn($installer->getTable('admin_user'), 'seller_vacation_mode', $column);
        }
        
        if (version_compare($context->getVersion(), '1.0.7', '<')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('medma_marketplace_review_rating')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'vendor_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [],
                'Vendor Id'
            )
                ->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [],
                    'Customer Id'
                )
                ->addColumn(
                    'quality',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [],
                    'Quality'
                )
                ->addColumn(
                    'price',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [],
                    'Price'
                )
                ->addColumn(
                    'shipping',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [],
                    'Shipping'
                )
                ->addColumn(
                    'nickname',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Nickname'
                )
                ->addColumn(
                    'summary',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Summary'
                )
                ->addColumn(
                    'review',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    1000,
                    [],
                    'Review'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Created At'
                )
                ->setComment(
                    'Marketplace Review Rating'
                );
            
            $installer->getConnection()->createTable($table);
            
            $table = $installer->getConnection()->newTable(
                $installer->getTable('medma_vendor_msgs')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'msg_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Msg Id'
            )
                ->addColumn(
                    'type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Type'
                )
                ->addColumn(
                    'content',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    1000,
                    [],
                    'Content'
                )->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Created At'
                )->setComment(
                    'Vendor Messaging'
                );
                
            $installer->getConnection()->createTable($table);
        }
        if(version_compare($context->getVersion(), '100.0.5', '<'))
        {
            $eavTable = $installer->getTable('medma_marketplace_profile');

            $columns = [
                'client_email_id' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Client email ID',
                ],
                'client_id' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Client ID',
                ],
                'client_secret' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Client Secret',
                ],
                'stripe_email_id' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Stripe Email ID',
                ],
                'stripe_secret_api_key' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Stripe Secret API Key',
                ],
                'stripe_publishable_api_key' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Stripe Publishable API Key',
                ],

            ];

            $connection = $installer->getConnection();
            foreach ($columns as $name => $definition) {
                $connection->addColumn($eavTable, $name, $definition);
            }
                }



        if(version_compare($context->getVersion(), '100.0.7', '<'))
        {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('smj_enquire_detail')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'seller_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Seller Id'
            )->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Customer Id'
            )->addColumn(
                    'product_sku',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'product sku'
            )->addColumn(
                    'msg',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    1000,
                    ['nullable' => false],
                    'message'
            )->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Created At'
            )->addColumn(
                    'approve',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'approve'
            )
           ->setComment(
                    'Vendor Messaging'
                );

            $installer->getConnection()->createTable($table);


            $table = $installer->getConnection()->newTable(
                $installer->getTable('smj_enquire_message')
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )->addColumn(
                'msg_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'Message Id'
            )->addColumn(
                'type',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Id'
            )->addColumn(
                'msg_string',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Msg String'

            )->setComment(
                    'Smj Enquire Messages'
                );
            $installer->getConnection()->createTable($table);

        }

        if(version_compare($context->getVersion(), '100.0.8', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'email',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Customer Email'
                ]
            );
        }

        if(version_compare($context->getVersion(), '100.0.9', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'name',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Customer Name'
                ]
            );
        }

        if(version_compare($context->getVersion(), '100.0.10', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_message'),
                'created_at',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Created At'
                ]
            );
        }

        if(version_compare($context->getVersion(), '100.0.11', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'price',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Price'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'quantity',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Quantity'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'attchment',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Attchment'
                ]
            );

        }
        if(version_compare($context->getVersion(), '100.0.12', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('medma_marketplace_profile'),
                'latitude',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Latitude'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('medma_marketplace_profile'),
                'longitude',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Longitude'
                ]
            );
        }


        if(version_compare($context->getVersion(), '100.0.13', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'quote_status',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                     null,
                    'comment'   => 'Quote Status'
                ]
            );

        }

        if(version_compare($context->getVersion(), '100.0.15', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'quote_no',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    'comment'   => 'Quote Number'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'date',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                     null,
                     'comment'   => 'Quote Date'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'vendor_name',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    'comment'   => 'Vendor Name'
                ]
            );


            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'vat',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    'comment'   => 'Quote Vat'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'trans',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    'comment'   => 'Transportation'
                ]
            );

        }
        if(version_compare($context->getVersion(), '100.0.17', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'seller_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    'comment' => 'Seller Name'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('smj_enquire_detail'),
                'product_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    'comment' => 'Product Name'
                ]
            );

        }

        if(version_compare($context->getVersion(), '100.0.18', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('medma_marketplace_profile'),
                'age_name',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Business Type'
                ]
            );

        }
         if(version_compare($context->getVersion(), '100.0.19', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('medma_marketplace_profile'),
                'vendor_rating_file',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'rating file'
                ]
            );


            $setup->getConnection()->addColumn(
                $setup->getTable('medma_marketplace_profile'),
                'agency_rating',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Agency Rating to Vendor'
                ]
            );

        }

         if(version_compare($context->getVersion(), '100.0.20', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('medma_marketplace_profile'),
                'created_at',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'length'    => 255,
                    'comment'   => 'load file time'
                ]
            );



        }
     
          if(version_compare($context->getVersion(), '100.0.22', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('medma_marketplace_profile'),
                'vendor_scorecard',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'vendor scorecard'
                ]
            );


            $setup->getConnection()->addColumn(
                $setup->getTable('medma_marketplace_profile'),
                'vendor_industry',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'vendor industry'
                ]
            );

        }



        if(version_compare($context->getVersion(), '100.0.23', '<'))
        {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('smj_bulletin_board')
            )->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'Entity Id'
            )->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Customer Id'
            )->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Title'
            )->addColumn(
                    'product_cat',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Product Category'
            )->addColumn(
                    'volume',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Volume'
            )->addColumn(
                    'requirements',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    1000,
                    ['nullable' => false],
                    'Requirements'
            )->addColumn(
                    'ldos',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                     null,
                    ['nullable' => false],
                    'last Date of Submission'
            )->addColumn(
                    'image_upload',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                     255,
                    ['nullable' => false],
                    'Image Upload'
            )
            ->addColumn(
                            'created_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Creation Time'
                    )
                    ->addColumn(
                            'updated_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE], 'Update Time'
                    )->addColumn(
                    'approve',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'approve'
            )
           ->setComment(
                    'Smj Buttletin Board Table'
                );

            $installer->getConnection()->createTable($table);


        }


     if(version_compare($context->getVersion(), '100.0.26', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('medma_marketplace_profile'),
                'is_paid',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    'comment'   => 'Paid Vendor'
                ]
            );

        }


      $installer->endSetup();
    }
}
