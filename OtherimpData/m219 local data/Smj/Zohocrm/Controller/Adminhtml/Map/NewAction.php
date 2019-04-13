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
namespace Smj\Zohocrm\Controller\Adminhtml\Map;

use Smj\Zohocrm\Controller\Adminhtml\Map as MapController;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Smj\Zohocrm\Model\MapFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Smj\Zohocrm\Model\ResourceModel\Map\CollectionFactory;

/**
 * Class NewAction: Create new a mapping
 *
 * @package Smj\Zohocrm\Controller\Adminhtml\Map
 */
class NewAction extends MapController
{
    /**
     * @var \Magento\Backend\Model\View\Result\Forward
     */
    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param MapFactory $mapFactory
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        MapFactory  $mapFactory,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $coreRegistry, $resultPageFactory, $mapFactory, $collectionFactory);
    }

    /**
     * Forward to edit controller
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
