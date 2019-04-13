<?php
/**
 *
 * Copyright © 2016 Medma. All rights reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 */

namespace Medma\MarketPlace\Controller\Vendor;

use Magento\Customer\Model\Session;

class Enquirysave extends \Magento\Framework\App\Action\Action
{


    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $customerSession;
    protected $detailfactory;
    protected $messagefactory;
    protected $timezoneInterface;
    /** @var \Magento\Framework\Controller\Result\JsonFactory */
    protected $jsonResultFactory;
    protected $enqirymessageFactory;
    protected $enqirymessagechainFactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        Session $customerSession,
        \Medma\MarketPlace\Model\DetailFactory $detailfactory,
        \Medma\MarketPlace\Model\MessageFactory $messagefactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        \Medma\MarketPlace\Model\EnquirymessageFactory $enqirymessageFactory,
        \Medma\MarketPlace\Model\EnquirymessagechainFactory $enqirymessagechainFactory
    ) {
        $this->resultPageFactory  = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->detailfactory = $detailfactory;
        $this->messagefactory = $messagefactory;
        $this->timezoneInterface = $timezoneInterface;
        $this->enqirymessageFactory = $enqirymessageFactory;
        $this->enqirymessagechainFactory = $enqirymessagechainFactory;
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->jsonResultFactory = $jsonResultFactory;
    }

    /**
     * Vendor Profile page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {

       die; $params = $this->getRequest()->getParams();

print_r( $params);

    }
}
