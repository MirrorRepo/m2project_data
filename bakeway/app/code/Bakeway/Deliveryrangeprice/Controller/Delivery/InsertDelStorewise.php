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

class InsertDelStorewise extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Bakeway\Deliveryrangeprice\Model\RangepriceFactory
     */
    protected $rangepriceFactory;

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
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\StateInterface $cacheState
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Bakeway\Deliveryrangeprice\Model\RangepriceFactory $rangepriceFactory,
        MarketplaceHelper $marketplaceHelper,
        PartnerLocation $partnerLocation,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->rangepriceFactory = $rangepriceFactory;
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
        $collection = $this->rangepriceFactory->create()->getCollection()
                      ->addFieldToFilter('store_id', 0)
                      ->addFieldToFilter('is_active', 1)
                      ->addFieldToFilter('delivery_deleted', 0);
                                            
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/storeWdelivery.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $executedSeller = array();
        $totalCount = 0;

        if(count($collection) > 0)
        {
            foreach ($collection as $rangePrice) 
            {
               $seller_id = $rangePrice->getSellerId();
               $isSellerReady = $this->marketplaceHelper->isSellerReady($seller_id);

               if(in_array($seller_id, $executedSeller) || !$isSellerReady)
                 continue;

                $logger->info('--- Conglomerate Seller : '.$seller_id.'---');
                $sellerCollection = $this->rangepriceFactory->create()->getCollection()->addFieldToFilter('seller_id',$seller_id);
                $logger->info('--- Conglomerate Seller Delivery Rules Count: '.count($sellerCollection).'---');

                if(count($sellerCollection) > 0)
                {
                    $partnerLocation = $this->partnerLocation->getCollection()->addFieldToSelect('id')->addFieldToFilter('seller_id',$seller_id);
                    if(count($partnerLocation) > 0)
                    {
                        $executedSeller[] = $seller_id;
                        $count = count($sellerCollection) * count($partnerLocation);
                        $totalCount += $count;

                        $logger->info('--- Conglomerate Seller Stores/Partner Count: '.count($partnerLocation).'---');
                        $logger->info('--- Total Rules Count tobe generates Storewise : '.count($sellerCollection) .'*'.count($partnerLocation) .' is equal to : '.$count.' ---');
                        foreach ($sellerCollection as $sellerRangePrice)
                        {
                            foreach ($partnerLocation as $partner) 
                            {
                                try 
                                {
                                    $rangeFactory = $this->rangepriceFactory->create();
                                    $rangeFactory->setSellerId($sellerRangePrice->getSellerId());
                                    $rangeFactory->setStoreId($partner->getId());
                                    $rangeFactory->setIsActive($sellerRangePrice->getIsActive());
                                    $rangeFactory->setFromKms($sellerRangePrice->getFromKms());
                                    $rangeFactory->setToKms($sellerRangePrice->getToKms());
                                    $rangeFactory->setDeliveryPrice($sellerRangePrice->getDeliveryPrice());
                                    $rangeFactory->setDeliveryDeleted($sellerRangePrice->getDeliveryDeleted());
                                    $rangeFactory->setSellerLog($sellerRangePrice->getSellerLog());
                                    $rangeFactory->save();
                                    $logger->info('--- Delivery Rule added for Stores/Partner: '.$partner->getId().'---');
                                }
                                catch (\Exception $e) 
                                {
                                    $logger->info($e->getMessage());
                                    echo $e->getMessage()."<br />";
                                }
                            }
                            try 
                            {
                                $delFactory =  $this->rangepriceFactory->create()->load($sellerRangePrice['id']);
                                $delFactory->delete();
                                $logger->info('--- Global Delivery Rule deleted for Conglomerate Seller: '.$sellerRangePrice['id'].'---');
                            }
                            catch (\Exception $e) 
                            {
                                $logger->info($e->getMessage());
                                echo $e->getMessage()."<br />";
                            }
                        }
                        $logger->info('--- Conglomerate Seller executed : '.$seller_id.'---');
                        $count = 0;
                    }
                }
            }
            $logger->info('--- Total Counts Inserted are : '.$totalCount.'---');
        }

        exit("Data Saved Successfully");
    }
}