<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smj\Zohocrm\Observer\SalesOrder;

use Smj\Zohocrm\Model\Queue;
use Smj\Zohocrm\Model\QueueFactory;
use Smj\Zohocrm\Observer\SyncObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Smj\Zohocrm\Model\Sync\SalesOrder;

/**
 * Class Create
 * @package Smj\Zohocrm\Observer\SalesOrder
 */
class Create extends SyncObserver
{
    protected $pathEnable = 'zohocrm/zohocrm_sync/order';
    protected $pathSyncOption = 'zohocrm/sync/order_mode';

    /**
     * @var \Smj\Zohocrm\Model\Sync\SalesOrder
     */
    protected $_order;


    /**
     * Create constructor.
     * @param QueueFactory $queueFactory
     * @param ScopeConfigInterface $config
     * @param SalesOrder $order
     */
    public function __construct(
        QueueFactory $queueFactory,
        ScopeConfigInterface $config,
        SalesOrder $order
    ) {
        $this->_order       = $order;
        parent::__construct($queueFactory, $config);
    }

    /**
     * Admin/Cutomer create a order
     *
     * @param  Observer $observer
     * @return string|void
     */
    public function execute(Observer $observer)
    {
        if ($this->getConfigValue($this->pathEnable)) {
            /** @var \Magento\Sales\Model\Order $order */
            $order        = $observer->getEvent()->getOrder();
            if ($this->getConfigValue($this->pathSyncOption) == 1) {
                $this->addToQueue(Queue::TYPE_ORDER, $order->getIncrementId());
            } else {
                $increment_id = $order->getIncrementId();

                $this->_order->sync($increment_id);
            }
        }
    }
}
