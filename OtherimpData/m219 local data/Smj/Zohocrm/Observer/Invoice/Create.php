<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smj\Zohocrm\Observer\Invoice;

use Smj\Zohocrm\Model\Queue;
use Smj\Zohocrm\Model\QueueFactory;
use Smj\Zohocrm\Observer\SyncObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Smj\Zohocrm\Model\Sync\Invoice;

/**
 * Class Create
 */
class Create extends SyncObserver
{

    protected $pathEnable = 'zohocrm/zohocrm_sync/invoice';
    protected $pathSyncOption = 'zohocrm/sync/invoice_mode';

    /**
     * Core Config Data
     *
     * @var $_scopeConfig \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Smj\Zohocrm\Model\Sync\Invoice
     */
    protected $_invoice;


    /**
     * Create constructor.
     * @param QueueFactory $queueFactory
     * @param ScopeConfigInterface $config
     * @param Invoice $invoice
     */
    public function __construct(
        QueueFactory $queueFactory,
        ScopeConfigInterface $config,
        Invoice $invoice
    ) {
        $this->_invoice     = $invoice;
        parent::__construct($queueFactory, $config);
    }

    /**
     * Admin/Cutomer create a invoice
     *
     * @param  Observer $observer
     * @return string|void
     */
    public function execute(Observer $observer)
    {
        if ($this->getConfigValue($this->pathEnable)) {
            $event = $observer->getEvent();
            /** @var  $product \Magento\Catalog\Model\Product */
            $incrementId = $event->getInvoice()->getIncrementId();
            if ($this->getConfigValue($this->pathSyncOption) == 1) {
                $this->addToQueue(Queue::TYPE_INVOICE, $incrementId);
            } else {
                $this->_invoice->sync($incrementId);
            }
        }
    }
}
