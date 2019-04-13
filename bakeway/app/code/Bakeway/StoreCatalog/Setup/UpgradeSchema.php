<?php

namespace Bakeway\StoreCatalog\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

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

        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {

            $setup->getConnection()->addForeignKey(
                    $setup->getFkName(
                            'bakeway_store_catalog', 'store_id', 'bakeway_partner_locations', 'id'
                    ), $setup->getTable('bakeway_store_catalog'), 'store_id', $setup->getTable('bakeway_partner_locations'), 'id', \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
        }


        if (version_compare($context->getVersion(), '1.0.2', '<')) {

            /*
             * Start table  bakeway Store Catalog Category
             */
            $table = $installer->getConnection()->newTable(
                            $installer->getTable('bakeway_store_catalog_category')
                    )->addColumn(
                            'entity_id', Table::TYPE_INTEGER, null, array('identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true), 'Entity Id'
                    )->addColumn(
                            'seller_id', Table::TYPE_INTEGER, null, array('nullable' => false, 'unsigned' => true, 'default' => '0'), 'Seller Id'
                    )->addColumn(
                            'categories_id', Table::TYPE_TEXT, 455, array('nullable' => false), 'Categories Id'
                    )
                    ->addColumn(
                            'enable_categories_id', Table::TYPE_TEXT, 455, array('nullable' => false), 'Categories Id'
                    )->addColumn(
                            'store_id', Table::TYPE_INTEGER, null, array('length' => 11,
                        'nullable' => false, 'unsigned' => false, 'default' => '0'), 'Store Id'
                    )->addColumn(
                            'status', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false, 'default' => '0'], 'Status'
                    )
                    ->addColumn(
                            'created_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Creation Time'
                    )
                    ->addColumn(
                            'updated_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE], 'Update Time'
                    )
                    ->addColumn(
                    'created_by', Table::TYPE_TEXT, 155, ['nullable' => true, 'default' => null], 'Created By'
            );


            $installer->getConnection()->createTable($table);

            /*
             * End table bakeway Store Catalog Category
             */
            $installer->endSetup();
        }
        
         if (version_compare($context->getVersion(), '1.0.3', '<')) {

            $setup->getConnection()->addForeignKey(
                    $setup->getFkName(
                            'bakeway_store_catalog_category', 'store_id', 'bakeway_partner_locations', 'id'
                    ), $setup->getTable('bakeway_store_catalog_category'), 'store_id', $setup->getTable('bakeway_partner_locations'), 'id', \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
        }
    }

}
