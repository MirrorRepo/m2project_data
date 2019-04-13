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
use Magenest\ZohocrmIntegration\Model\Sync\Contact;
use Magenest\ZohocrmIntegration\Model\Sync\Account;

/**
 * Class Update
 */
class Approve implements ObserverInterface {

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
     * @var \Magenest\ZohocrmIntegration\Model\Sync\Account
     */
    protected $_account;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Lead $lead
     * @param Contact $contact
     */
    public function __construct(
    ScopeConfigInterface $scopeConfig, Lead $lead, Account $account
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_lead = $lead;
        $this->_account = $account;
    }

    /**
     * Admin/Cutomer edit information address
     *
     * @param  Observer $observer
     * @return string
     */
    public function execute(Observer $observer) {



        try {
            $event = $observer->getEvent();
            /** @var \Magento\Customer\Model\Customer $customer */
            $customer = $event->getSeller();
            $id = $customer->getId();

            if ($this->_scopeConfig->isSetFlag(Data::XML_PATH_ALLOW_SYNC_ACCOUNT, ScopeInterface::SCOPE_STORE)) {

                $isseller = true;


                if (!empty($customer->getDisapprove())) {
                    $isseller = false;
                }

                $this->_account->syncAccount($id, $isseller);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
