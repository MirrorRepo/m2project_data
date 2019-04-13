<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Checkout
 */


namespace Amasty\Checkout\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @var Operation\CreateAdditionalTable
     */
    private $createAdditionalTable;

    public function __construct(Operation\CreateAdditionalTable $createAdditionalTable)
    {
        $this->createAdditionalTable = $createAdditionalTable;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.6.0', '<')) {
            $this->addDeliveryDateCommentColumn($setup);
        }

        if ($context->getVersion() && version_compare($context->getVersion(), '2.0.0', '<')) {
            $this->createAdditionalTable->execute($setup);
        }

        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    protected function addDeliveryDateCommentColumn(SchemaSetupInterface $setup)
    {
        $table = $setup->getTable('amasty_amcheckout_delivery');
        $connection = $setup->getConnection();

        $connection->addColumn(
            $table,
            'comment',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Delivery Comment'
            ]
        );
    }
}
