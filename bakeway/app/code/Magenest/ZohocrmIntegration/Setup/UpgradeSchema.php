<?php
/**
 * Created by PhpStorm.
 * User: canhnd
 * Date: 09/02/2017
 * Time: 11:48
 */
namespace Magenest\ZohocrmIntegration\Setup;

use Magento\Framework\Setup\SetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.0') < 0) {
            $this->createQueueTable($installer);
        }
        
        if(version_compare($context->getVersion(), '2.0.0') < 0){
            $this->createSyncTable($installer);
        }

        $installer->endSetup();
    }

    /**
     * Create the table magenest_zohocrm_queue
     *
     * @param SetupInterface $installer
     * @return void
     */
    private function createQueueTable($installer)
    {
        $tableName = 'magenest_zohocrm_queue';
        $table = $installer->getConnection()
            ->newTable($installer->getTable($tableName))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
                ],
                'Id'
            )
            ->addColumn(
                'type',
                Table::TYPE_TEXT,
                45,
                ['nullable' => true],
                'Entity Type'
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Entity Id'
            )
            ->addColumn(
                'enqueue_time',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Enqueue Time'
            )
            ->addColumn(
                'priority',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false],
                'Enqueue Time'
            )
            ->setComment('ZohoCrm Sync Queue');

        $installer->getConnection()->createTable($table);
    }
    
    /**
     * Create the table bakeway_zoho_order_mg_sync
     *
     * @param SetupInterface $installer
     * @return void
     */
    public function createSyncTable($installer) {
       
       $tableName = 'bakeway_zoho_order_mg_sync';
        $table = $installer->getConnection()
            ->newTable($installer->getTable($tableName))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
                ],
                'Id'
            )
            ->addColumn(
                'order_id',
                Table::TYPE_TEXT,
                null,
                [
                'unsigned' => true,
                'nullable' => false,
                ],
                'Order Id'
            )
            ->addColumn(
            'customer_email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            128,
            [],
            'Customer Email'
            )
            ->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Created At'
            )
            ->addColumn(
            'telephone',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Phone Number'
            )
            ->addColumn(
                'custom_message',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Item Custom Message'
            )
            ->addColumn(
                'sender_firstname',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Sender Firstname'
            )
            ->addColumn(
                'sender_lastname',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Sender Laststname'
            )
            ->addColumn(
                'reciever_firstname',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Reciever Firstname'
            )
            ->addColumn(
                'reciever_lastname',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Reciever Lastname'
            )  
            ->addColumn(
            'dob',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
            null,
            [],
            'Date of Birth'
            )
            ->setComment('ZohoCrm Sync Order');

        $installer->getConnection()->createTable($table); 
        
    }
}
