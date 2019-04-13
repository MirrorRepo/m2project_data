<?php

namespace Bakeway\Deliveryrangeprice\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface {

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context) {

        /*
         *adding columns deleted and seller log
        */

        if (version_compare($context->getVersion(), '1.0.1', '<')) {

            $setup->getConnection()->addColumn(
                $setup->getTable('bakeway_delivery_rangeprice'),
                'delivery_deleted',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length'    => 10,
                    'comment'   => 'Delivery deleted flag'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('bakeway_delivery_rangeprice'),
                'seller_log',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'comment'   => 'Deleting log details'
                ]
            );

            
        }

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('marketplace_userdata'), 'max_price', [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'default' => '0.0000',
                    'unsigned' => true,
                    'nullable' => false,
                    'comment' => 'Max Inout Price For Free Delivery'
                ]
            );

        }

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('marketplace_userdata'), 'max_price', [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'default' => '0.0000',
                    'unsigned' => true,
                    'nullable' => false,
                    'comment' => 'Max Inout Price For Free Delivery'
                ]
            );

        }

        if (version_compare($context->getVersion(), '1.0.3', '<')) {

            $table = $setup->getTable('marketplace_userdata');
            $sql = "ALTER TABLE $table CHANGE `max_price` `is_deivery_max_price` DECIMAL(10,0) NOT NULL DEFAULT '0' COMMENT 'Max Inout Price For Free Delivery' ";
            $setup->run($sql);

        }

        if (version_compare($context->getVersion(), '1.0.4', '<')) {

            $setup->getConnection()->addColumn(
                $setup->getTable('marketplace_userdata'), 'is_free_delivery', [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'unsigned' => true,
                    'nullable' => false,
                    'comment' => 'Seller Free Delivery Status'
                ]
            );

        }
        if (version_compare($context->getVersion(), '1.0.5', '<')) {

        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_delivery_rangeprice'),
        	    'midnight_price',
        	    [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
        	        'length' => 255,
        	        'nullable' => true,
        	        'comment' => 'Midnight Price'
        	    ]
        	);

        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_delivery_rangeprice'),
        	    'morning_price',
        	    [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
        	        'length' => 255,
        	        'nullable' => true,
        	        'comment' => 'Early Morning Price'
        	    ]
        	);

        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_delivery_rangeprice'),
        	    'store_id',
        	    [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        	        'length' => 10,
        	        'nullable' => false,
                    'default' => '0',
        	        'comment' => 'Seller Store Id'
        	    ]
        	);        	
        }
        if (version_compare($context->getVersion(), '1.0.6', '<')) {
        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_partner_locations'), 'regular_delivery_start_time', [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        	        'unsigned' => true,
        	        'nullable' => false,
        	        'default' => '0',
        	        'comment' => 'Shop Regular Delivery Start Time'
        	    ]
        	);

        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_partner_locations'), 'regular_delivery_end_time', [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        	        'unsigned' => true,
        	        'nullable' => false,
        	        'default' => '0',
        	        'comment' => 'Shop Regular Delivery End Time'
        	    ]
        	);

        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_partner_locations'), 'midnight_delivery_start_time', [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        	        'unsigned' => true,
        	        'nullable' => false,
        	        'default' => '23',
        	        'comment' => 'Shop Midnight Delivery Start Time'
        	    ]
        	);

        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_partner_locations'), 'midnight_delivery_end_time', [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        	        'unsigned' => true,
        	        'nullable' => false,
        	        'default' => '2',
        	        'comment' => 'Shop Midnight Delivery End Time'
        	    ]
        	);
        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_partner_locations'), 'morning_delivery_start_time', [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        	        'unsigned' => true,
        	        'nullable' => false,
        	        'default' => '6',
        	        'comment' => 'Shop Early Morning Delivery Start Time'
        	    ]
        	);

        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_partner_locations'), 'morning_delivery_end_time', [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        	        'unsigned' => true,
        	        'nullable' => false,
        	        'default' => '8',
        	        'comment' => 'Shop Early Morning Delivery End Time'
        	    ]
        	);

        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_partner_locations'),
        	    'is_midnight_active',
        	    [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
        	        'length' => 2,
        	        'nullable' => false,
        	        'default' => '0',
        	        'comment' => 'Midnight Delivery Status'
        	    ]
        	);

        	$setup->getConnection()->addColumn(
        	    $setup->getTable('bakeway_partner_locations'),
        	    'is_morning_active',
        	    [
        	        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
        	        'length' => 2,
        	        'nullable' => false,
        	        'default' => '0',
        	        'comment' => 'Early Morning Delivery Status'
        	    ]
        	);
        }
        if (version_compare($context->getVersion(), '1.0.7', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('bakeway_partner_locations'), 'is_free_delivery_active', [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'comment' => 'Seller Store wise Free Delivery Status'
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.8', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('bakeway_partner_locations'), 'is_pickup_active', [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '1',
                    'comment' => 'Seller Store wise Pickup Status'
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.9', '<')) {
            $delType = $setup->getTable('bakeway_delivery_type');
            if ($setup->getConnection()->isTableExists($delType) != false) 
            {
                $setup->startSetup();
                $connection = $setup->getConnection();
                $connection->dropTable($connection->getTableName($delType));
                $setup->endSetup();
            }
            $delRangeprice = $setup->getTable('bakeway_delivery_timing');
            if ($setup->getConnection()->isTableExists($delRangeprice) != false) 
            {
                $setup->startSetup();
                $connection = $setup->getConnection();
                $connection->dropTable($connection->getTableName($delRangeprice));
                $setup->endSetup();
            }            
        }
        if (version_compare($context->getVersion(), '1.0.10', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('bakeway_partner_locations'), 'shop_open_timing', [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'comment' => 'Shop Open Time'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('bakeway_partner_locations'), 'shop_open_AMPM', [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '1',
                    'comment' => 'Seller Store Open AM PM'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('bakeway_partner_locations'), 'shop_close_timing', [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '0',
                    'comment' => 'Shop Close Time'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('bakeway_partner_locations'), 'shop_close_AMPM', [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'unsigned' => true,
                    'nullable' => false,
                    'default' => '2',
                    'comment' => 'Seller Store Close AM PM'
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.11', '<')) 
        {
            if ($setup->getConnection()->tableColumnExists($setup->getTable('bakeway_partner_locations'), 'is_delivery_active') === false) 
            {
                $setup->getConnection()->addColumn(
                    $setup->getTable('bakeway_partner_locations'),
                    'is_delivery_active',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'length' => 2,
                        'nullable' => false,
                        'default' => '1',
                        'comment' => 'Manage Delivery foreach Store'
                    ]
                );
            }

            if ($setup->getConnection()->tableColumnExists($setup->getTable('bakeway_partner_locations'), 'free_delivery_threshold') === false) 
            {
                $setup->getConnection()->addColumn(
                    $setup->getTable('bakeway_partner_locations'),
                    'free_delivery_threshold',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => false,
                        'comment' => 'Free Delivery Threshold'
                    ]
                );            
            }

            if ($setup->getConnection()->tableColumnExists($setup->getTable('bakeway_partner_locations'), 'size_threshold') === false) 
            {
                $setup->getConnection()->addColumn(
                    $setup->getTable('bakeway_partner_locations'),
                    'size_threshold',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => false,
                        'comment' => 'Size Threshold'
                    ]
                );

            }
        }

    }
}