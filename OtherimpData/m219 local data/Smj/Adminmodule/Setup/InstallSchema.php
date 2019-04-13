<?php
/**
 * Copyright © 2015 Smj. All rights reserved.
 */

namespace Smj\Adminmodule\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
	
        $installer = $setup;

        $installer->startSetup();

		/**
         * Create table 'adminmodule_smj'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('adminmodule_smj')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'adminmodule_smj'
        )
		/*{{CedAddTableColumn}}}*/
		
		
        ->setComment(
            'Smj Adminmodule adminmodule_smj'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/

        $installer->endSetup();

    }
}
