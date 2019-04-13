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
namespace Smj\Zohocrm\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Smj\Zohocrm\Model\FieldFactory;
use Smj\Zohocrm\Model\Connector as Connector;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Field Mapping admin controller
 */
abstract class Field extends Action
{
    /**
     * @var Context
     */
    protected $_context;

    /**
     * @var Connector
     */
    protected $_connector;

    /**
     * Array of actions which can be processed without secret key validation
     *
     * @var array
     */
    protected $_publicActions = ['edit'];

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * Review model factory
     *
     * @var \Smj\Zohocrm\Model\MapFactory
     */

    protected $_fieldFactory;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @param Context      $context
     * @param Registry     $coreRegistry
     * @param FieldFactory $fieldFactory
     * @param Connector    $connector
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FieldFactory  $fieldFactory,
        Connector $connector,
        JsonFactory $jsonFactory
    ) {
        $this->resultJsonFactory = $jsonFactory;
        $this->_context      = $context;
        $this->coreRegistry  = $coreRegistry;
        $this->_fieldFactory = $fieldFactory;
        $this->_connector    = $connector;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
