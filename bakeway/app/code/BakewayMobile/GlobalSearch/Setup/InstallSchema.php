<?php

namespace BakewayMobile\GlobalSearch\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface {

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;
        $installer->startSetup();

        /*
         * Start table  bakeway CommisonLog table
         */
        $table = $installer->getConnection()->newTable(
                        $installer->getTable('bakeway_globalsearchtag')
                )->addColumn(
                        'entity_id', Table::TYPE_INTEGER, null, array('identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true), 'Entity Id'
                )->addColumn(
                        'product_id', Table::TYPE_INTEGER, null, array('unsigned' => true, 'nullable' => false, 'default' => '0'), 'Entity Id'
                )->addColumn(
                        'tags', Table::TYPE_TEXT, 255, ['nullable' => true, 'default' => null], 'Tags'
                )->addColumn(
                        'created_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Created At'
                )->addColumn(
                        'updated_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE], 'Update At'
                )->addColumn(
                'created_by', Table::TYPE_TEXT, 255, ['nullable' => true, 'default' => null], 'Created By'
        );

      
        $installer->getConnection()->createTable($table);
        /*
         * End table  bakeway_globalsearchtag table
         */
        $installer->endSetup();
        
        $installer->getConnection()->addForeignKey(
                $setup->getFkName(
                        'bakeway_globalsearchtag', 'product_id', 'catalog_product_entity', 'entity_id'
                ), $setup->getTable('bakeway_globalsearchtag'), 'product_id', $setup->getTable('catalog_product_entity'), 'entity_id', \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );

          
          
    }

}
