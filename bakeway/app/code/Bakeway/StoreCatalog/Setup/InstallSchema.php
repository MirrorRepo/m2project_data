<?php
namespace Bakeway\StoreCatalog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        
        $installer = $setup;
        $installer->startSetup();

        /*
         *Start table  bakeway Store Catalog table
        */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('bakeway_store_catalog')
        )->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            array('identity' => true, 'nullable' => false, 'primary' => true,'unsigned' => true),
            'Entity Id'
        )->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            array('nullable' => false,'unsigned' => true,'default' => '0'),
            'Seller Id'
        )->addColumn(
            'product_id',
            Table::TYPE_TEXT,
            255,
            array('nullable' => false),
            'Product Id'
        )->addColumn(
            'store_id',
            Table::TYPE_INTEGER,
            null,
            array('length' => 11,
                'nullable' => false,'unsigned' => false,'default' => '0'),
            'Store Id'
        )->addColumn(
            'status',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Status'
            )
         ->addColumn(
            'created_at',
           Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
            )
         ->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Update Time'
            )
         ->addColumn(
            'created_by',
            Table::TYPE_TEXT,
            155,
            ['nullable' => true, 'default' => null],
            'Created By'
        );


        $installer->getConnection()->createTable($table);
        
        /*
        *End table Bakeway  Store Catalog table
         */
        $installer->endSetup();
    }
}