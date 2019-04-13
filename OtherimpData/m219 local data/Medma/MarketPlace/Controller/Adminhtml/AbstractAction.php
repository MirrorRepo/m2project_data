<?php

/**
 * Evince
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Evince.com license that is
 * available through the world-wide-web at this URL:
 *   
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Evince
 * @package     Evince_Mainslider
 * @copyright   Copyright (c) 2015-2016 Evince Development Pvt. Ltd (http://www.evincedev.com/)
 *   
 */

namespace Medma\MarketPlace\Controller\Adminhtml;

/**
 * Abstract Action
 * @category Evince
 * @package  Evince_Mainslider
 * @module   Mainslider
 * @author   Evince Developer
 */
abstract class AbstractAction extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $_jsHelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    

    protected $_storeinfoFactory;
	
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * A factory that knows how to create a "page" result
     * Requires an instance of controller action in order to impose page type,
     * which is by convention is determined from the controller action class.
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;



    /**
     * Banner factory.
     *
     * @var \Evince\Mainslider\Model\BannerFactory
     */

    /**
     * Banner Collection Factory.
     *
     * @var \Evince\Mainslider\Model\ResourceModel\Banner\CollectionFactory
     */

    /**
     * Registry object.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * File Factory.
     *
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_fileFactory;

    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Helper\Js $jsHelper
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->_storeManager = $storeManager;
        $this->_jsHelper = $jsHelper;

        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        $this->_resultForwardFactory = $resultForwardFactory;


    }
}
