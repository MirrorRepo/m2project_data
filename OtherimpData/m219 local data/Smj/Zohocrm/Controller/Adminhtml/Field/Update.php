<?php
/**
 * Copyright © 2015 Smj. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Smj_Zohocrm extension
 * NOTICE OF LICENSE
 *
 * @category Smj
 * @package  Smj_Zohocrm
 * @author   Mukund
 */
namespace Smj\Zohocrm\Controller\Adminhtml\Field;

use Smj\Zohocrm\Model\FieldFactory;
use Magento\Backend\App\Action;

/**
 * Class Update
 *
 * @package Smj\Zohocrm\Controller\Adminhtml\Field
 */
class Update extends Action
{
    /**
     * @var FieldFactory
     */
    protected $_fieldFactory;

    /**
     * Update constructor.
     * @param Action\Context $context
     * @param FieldFactory $fieldFactory
     */
    public function __construct(
        Action\Context $context,
        FieldFactory $fieldFactory
    ) {
        parent::__construct($context);
        $this->_fieldFactory = $fieldFactory;
    }

    /**
     * execute
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $model = $this->_fieldFactory->create();
            $table = $model->getAllTable();
            foreach ($table as $s_table => $m_table) {
                $model->saveFields($s_table, $m_table, true);
            }
        }

        return;
    }

    /**
     * ACL
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
