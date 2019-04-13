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

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Smj\Zohocrm\Model\MapFactory;
use Magento\Framework\View\Result\PageFactory;
use Smj\Zohocrm\Model\ResourceModel\Map\CollectionFactory as MapCollectionFactory;
use Smj\Zohocrm\Controller\Adminhtml\Map as MapController;

/**
 * Class Index Controller
 *
 * @package Smj\Zohocrm\Controller\Adminhtml\Map
 */
class Index extends MapController
{
    /**
     * Page result factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Page factory
     *
     * @var PageFactory
     */
    protected $_resultPage;


    /**
     * @param Context              $context
     * @param Registry             $coreRegistry
     * @param PageFactory          $resultPageFactory
     * @param MapFactory           $mapFactory
     * @param MapCollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        MapFactory  $mapFactory,
        MapCollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $coreRegistry, $resultPageFactory, $mapFactory, $collectionFactory);
    }


    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $this->_setPageData();
        return $this->getResultPage();
    }

    /**
     * Instantiate result page object
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page
     */
    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->resultPageFactory->create();
        }

        return $this->_resultPage;
    }

    /**
     * Set page data
     *
     * @return $this
     */
    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->getConfig()->getTitle()->prepend((__('Manage Mapping')));
        return $this;
    }
}
