<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\ZohocrmIntegration\Observer\Customer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magenest\ZohocrmIntegration\Model\Data as Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magenest\ZohocrmIntegration\Model\Sync\Lead;
use Magenest\ZohocrmIntegration\Model\Sync\Account;

/**
 * Class Register Observer
 *
 * @package Magenest\ZohocrmIntegration\Observer\Customer
 */
class Register implements ObserverInterface {

    /**
     * Core Config Data
     *
     * @var $_scopeConfig \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magenest\ZohocrmIntegration\Model\Sync\Lead
     */
    protected $_lead;

    /**
     * @var Magenest\ZohocrmIntegration\Model\Sync\Account
     */
    protected $_account;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Lead $lead
     */
    public function __construct(
    ScopeConfigInterface $scopeConfig, Lead $lead, Account $account
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_lead = $lead;
        $this->_account = $account;
    }

    /**
     * Customer register success event
     *
     * @param  Observer $observer
     * @return void|string
     */
    public function execute(Observer $observer) {
        if (!$this->_scopeConfig->isSetFlag(Data::XML_PATH_ALLOW_SYNC_ACCOUNT, ScopeInterface::SCOPE_STORE)) {
            return;
        }

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/zohocrm_account_log.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        try {
            $event = $observer->getEvent();
            $customer = $event->getCustomer();
            $id = $customer->getId();
            $logger->info('-------start zoho magento crm account auto sync-------');
            $logger->info('customer id for auto sync is .' . $id);
            $this->_account->sync($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
