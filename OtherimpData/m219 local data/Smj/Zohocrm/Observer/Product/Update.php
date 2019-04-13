<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smj\Zohocrm\Observer\Product;

use Smj\Zohocrm\Model\Queue;
use Smj\Zohocrm\Model\QueueFactory;
use Smj\Zohocrm\Observer\SyncObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Smj\Zohocrm\Model\Sync\Product;

/**
 * Class Update
 * @package Smj\Zohocrm\Observer\Product
 */
class Update extends SyncObserver
{
    protected $pathEnable = 'zohocrm/zohocrm_sync/product';
    protected $pathSyncOption = 'zohocrm/sync/product_mode';
    
    /**
     * Core Config Data
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Smj\Zohocrm\Model\Sync\Product
     */
    protected $_product;


    /**
     * Update constructor.
     * @param QueueFactory $queueFactory
     * @param Product $product
     * @param ScopeConfigInterface $config
     */
    public function __construct(
        QueueFactory $queueFactory,
        Product $product,
        ScopeConfigInterface $config
    ) {
        $this->_product     = $product;
        parent::__construct($queueFactory, $config);
    }

    /**
     * Admin edit a product
     *
     * @param  Observer $observer
     * @return string|void
     */
    public function execute(Observer $observer)
    {
        if ($this->getConfigValue($this->pathEnable)) {
            $event = $observer->getEvent();
            /** @var  $product \Magento\Catalog\Model\Product */
            $product = $event->getProduct();
            if ($this->getConfigValue($this->pathSyncOption) == 1) {
                $this->addToQueue(Queue::TYPE_PRODUCT, $product->getId());
            } else {
                $id      = $product->getId();
                $this->_product->sync($id);
            }
        }
    }
}
