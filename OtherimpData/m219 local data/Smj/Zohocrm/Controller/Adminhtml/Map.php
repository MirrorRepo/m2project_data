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
use Magento\Framework\Registry;
use Smj\Zohocrm\Model\MapFactory;
use Smj\Zohocrm\Model\ResourceModel\Map\CollectionFactory as MapCollectionFactory;
use \Magento\Framework\View\Result\PageFactory;

/**
 * Reviews admin controller
 */
abstract class Map extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * Map model factory
     *
     * @var \Smj\Zohocrm\Model\MapFactory
     */
    protected $_mapFactory;

    /**
     * Map Collection factory
     *
     * @var \Smj\Zohocrm\Model\MapFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;


    /**
     * Map constructor.
     * @param Action\Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param MapFactory $mapFactory
     * @param MapCollectionFactory $collectionFactory
     */
    public function __construct(
        Action\Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        MapFactory  $mapFactory,
        MapCollectionFactory $collectionFactory
    ) {
        $this->_context           = $context;
        $this->coreRegistry       = $coreRegistry;
        $this->_mapFactory        = $mapFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->resultPageFactory  = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smj_Zohocrm::mapping')
            ->addBreadcrumb(__('Manage Mapping'), __('Manage Mapping'));

        return $resultPage;
    }

    /**
     * Check ACL
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smj_Zohocrm::mapping');
    }
}
