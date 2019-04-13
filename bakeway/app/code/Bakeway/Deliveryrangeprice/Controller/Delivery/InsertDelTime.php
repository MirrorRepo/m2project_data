<?php
/**
 *
 * Copyright © 2015 Bakewaycommerce. All rights reserved.
 */
namespace Bakeway\Deliveryrangeprice\Controller\Delivery;

use Magento\Framework\App\RequestInterface;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Bakeway\Partnerlocations\Model\Partnerlocations as PartnerLocation;
use Psr\Log\LoggerInterface as LoggerInterface;

class InsertDelTime extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Bakeway\Deliveryrangeprice\Model\RangepriceFactory
     */
    protected $partnerLocationsFactory;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;

    /**
     * @var PartnerLocation
     */
    protected $partnerLocation;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Bakeway\Partnerlocations\Model\PartnerlocationsFactory $partnerLocationsFactory
     * @param MarketplaceHelper $marketplaceHelper
     * @param PartnerLocation $partnerLocation
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Bakeway\Partnerlocations\Model\PartnerlocationsFactory $partnerLocationsFactory,
        MarketplaceHelper $marketplaceHelper,
        PartnerLocation $partnerLocation,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->partnerLocationsFactory = $partnerLocationsFactory;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->partnerLocation = $partnerLocation;
        $this->logger = $logger;

    }

    /**
     * Flush cache storage
     *
     */
    public function execute()
    {
        $sellerCollection = $this->_objectManager->create('Webkul\Marketplace\Model\Seller')->getCollection()->addFieldToSelect(array('seller_id','delivery','is_free_delivery','is_deivery_max_price','shop_delivery_open_time','shop_delivery_close_time','is_pickup','shop_open_timing','shop_open_AMPM','shop_close_timing','shop_close_AMPM'));

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/regularDelTime.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('--- Total Sellers : '.$sellerCollection->count().'---');
        $totalCount = 0;

        if ($sellerCollection->count() > 0) 
        {
            foreach ($sellerCollection as $seller) 
            {
                $sellerData = $seller->getData();
                $seller_id = $sellerData['seller_id'];
                $logger->info('--- Current Seller : '.$seller_id.'---');

                $partnerLocation = $this->partnerLocation->getCollection()->addFieldToSelect('id')->addFieldToFilter('seller_id',$seller_id);
                $logger->info('--- Total Store Addresses for SellerId : '.$seller_id.' are '.count($partnerLocation).'---');
                if(count($partnerLocation) > 0)
                {
                    foreach ($partnerLocation as $partner) 
                    {
                        try 
                        {
                            $logger->info('--- Current Partner : '.$partner->getId().'---');
                            $partnerModel =  $this->partnerLocationsFactory->create()->load($partner->getId());
                            $partnerModel->setIsDeliveryActive((int)$sellerData['delivery']);
                            $partnerModel->setIsFreeDeliveryActive((int)$sellerData['is_free_delivery']);
                            $partnerModel->setFreeDeliveryThreshold($sellerData['is_deivery_max_price']);
                            $partnerModel->setRegularDeliveryStartTime($sellerData['shop_delivery_open_time']);
                            $partnerModel->setRegularDeliveryEndTime($sellerData['shop_delivery_close_time']);
                            $partnerModel->setShopOpenTiming($sellerData['shop_open_timing']);
                            $partnerModel->setShopOpenAMPM($sellerData['shop_open_AMPM']);
                            $partnerModel->setShopCloseTiming($sellerData['shop_close_timing']);
                            $partnerModel->setShopCloseAMPM($sellerData['shop_close_AMPM']);
                            $partnerModel->setIsPickupActive((int)$sellerData['is_pickup']);
                            $partnerModel->save();
                            $totalCount += 1;
                            $logger->info('--- Time Updated for Seller : '.$seller_id.' for store  '.$partner->getId().'---');
                        }
                        catch (\Exception $e) 
                        {
                            $logger->info($e->getMessage());
                            echo $e->getMessage()."<br />";
                        }
                    }
                }
                else
                    continue;

            }
            $logger->info('--- Total Counts Inserted are : '.$totalCount.'---');
        }
        exit("Data Saved Successfully");
    }
}