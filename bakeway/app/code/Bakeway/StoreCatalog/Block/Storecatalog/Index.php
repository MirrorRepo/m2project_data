<?php
/**
 * Copyright © 2015 Bakeway . All rights reserved.
 */
namespace Bakeway\StoreCatalog\Block\Storecatalog;

use Magento\Customer\Model\Customer;
use Bakeway\Partnerlocations\Model\PartnerlocationsFactory as PartnerlocationsFactory;
class Index extends \Magento\Framework\View\Element\Template
{
    
    const SELLER_ACTIVE = 1;

    /**
     * @var \Magento\Customer\Model\Customer
     */
    public $customer;
    /**
     * @var Session
     */
    public $_customerSession;

    /**
     * @var ObjectManagerInterface
     */
    public $_objectManager;

    public $deliverydata;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    protected $rangepriceFactory;
    
    /*
     * @var PartnerlocationsFactory                   
     */
    protected $partnerlocationsFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        Customer $customer,
        \Magento\Customer\Model\Session $customerSession,
        \Bakeway\Deliveryrangeprice\Helper\Data $deliverydata,
        \Magento\Framework\Registry $coreRegistry,
        \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory,
        PartnerlocationsFactory $partnerlocationsFactory,
        array $data = []
    )
    {
        $this->Customer = $customer;
        $this->_objectManager = $objectManager;
        $this->_customerSession = $customerSession;
        $this->deliverydata = $deliverydata;
        $this->coreRegistry = $coreRegistry;
        $this->rangepriceFactory = $rangepriceFactory;
        $this->partnerlocationsFactory = $partnerlocationsFactory;
        parent::__construct($context, $data);
    }



   
   public function getSellerCcCount()
    {
        $_Collection = $this->deliverydata->getCurrentSellerData()
            ->addFieldToFilter('delivery_deleted',0)
            ->addFieldToFilter('seller_id', $this->getCustomerId());
        
        
        if (count($_Collection) > 0) {
            return $_Collection;
        } else {
            return false;
        }
    }
   
    
    public function getCustomerId()
    {
        return $this->_customerSession->getCustomerId();
    }

    public function getSellerInformation()
    {
        // will return current seller id  to  edit
        $_Sellerdata = $this->rangepriceFactory->create()->load($this->getCustomerId());
        return $_Sellerdata->getData();
    }

    public function getSellerid()
    {
        // will return current seller id  to  edit
        return $this->coreRegistry->registry('sellerid');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSellerEmail($id)
    {
        return $this->deliverydata->getEmail($id);
    }

    /**
     * 
     * @return boolean
     */
    public function getSellerData()
    {
        $_Collection =  $this->partnerlocationsFactory->create()->getCollection()
            ->addFieldToFilter('is_active',self::SELLER_ACTIVE)
            ->addFieldToFilter('seller_id', $this->getCustomerId());
        if (count($_Collection) > 0) {
            return $_Collection->getData();
        } else {
            return false;
        }
    }
    
  
    
}
