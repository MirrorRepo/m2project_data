<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\ZohocrmIntegration\Observer\Customer;

use Magenest\ZohocrmIntegration\Model\Queue;
use Magenest\ZohocrmIntegration\Model\QueueFactory;
use Magenest\ZohocrmIntegration\Observer\SyncObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magenest\ZohocrmIntegration\Model\Data as Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magenest\ZohocrmIntegration\Model\Sync\Lead;
use Magenest\ZohocrmIntegration\Model\Sync\Contact;
use Magenest\ZohocrmIntegration\Model\Sync\Account;

/**
 * Class Register Observer
 *
 * @package Magenest\ZohocrmIntegration\Observer\Customer
 */
class RegisterAfterCheckout extends SyncObserver
{
    protected $pathEnableLead = 'zohocrm/zohocrm_sync/lead';

    protected $pathSyncOptionLead = 'zohocrm/sync/lead_mode';

    protected $pathEnableAccount = 'zohocrm/zohocrm_sync/account';

    protected $pathSyncOptionAccount = 'zohocrm/sync/account_mode';

    protected $pathEnableContact = 'zohocrm/zohocrm_sync/contact';

    protected $pathSyncOptionContact = 'zohocrm/sync/contact_mode';

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
     * @var \Magenest\ZohocrmIntegration\Model\Sync\Contact
     */
    protected $_contact;

    /**
     * @var Account
     */
    protected $_account;

    /**
     * Register constructor.
     * @param QueueFactory $queueFactory
     * @param ScopeConfigInterface $config
     * @param Lead $lead
     * @param Contact $contact
     * @param Account $account
     */
    public function __construct
    (
        QueueFactory $queueFactory,
        ScopeConfigInterface $config,
        Lead $lead,
        Contact $contact,
        Account $account
    )
    {
        parent::__construct($queueFactory, $config);
        $this->_lead = $lead;
        $this->_contact = $contact;
        $this->_account = $account;
    }

    /**
     * Customer register success event
     *
     * @param  Observer $observer
     * @return void|string
     */
    public function execute(Observer $observer)
    {
        try {
            /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
            $customer = $observer->getEvent()->getCustomerDataObject();




            $id = $customer->getId();

            if ($this->getConfigValue($this->pathEnableAccount)) {

                    $this->addToQueue(Queue::TYPE_ACCOUNT, $id);


            }

            if ($this->getConfigValue($this->pathEnableContact)) {

                    $this->addToQueue(Queue::TYPE_CONTACT, $id);


            }

            if ($this->getConfigValue($this->pathEnableLead)) {

                    $this->addToQueue(Queue::TYPE_LEAD, $id);


            }
//            $this->_lead->sync($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
