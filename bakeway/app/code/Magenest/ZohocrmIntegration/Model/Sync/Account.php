<?php

/**
 * Copyright © 2015 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Magenest_ZohocrmIntegration extension
 * NOTICE OF LICENSE
 *
 * @category Magenest
 * @package  Magenest_ZohocrmIntegration
 * @author   ThaoPV
 */

namespace Magenest\ZohocrmIntegration\Model\Sync;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Model\ResourceModel\Config as ResourceConfig;
use Magento\Framework\HTTP\ZendClientFactory;
use Magenest\ZohocrmIntegration\Model\ReportFactory;
use Magento\Customer\Model\Customer;
use Magenest\ZohocrmIntegration\Model\Connector;
use Magenest\ZohocrmIntegration\Model\Data;
use Magenest\ZohocrmIntegration\Model\QueueFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Customer\Model\AddressFactory;

/**
 * Class Account
 * Sync Customer to Account table
 *
 * @package Magenest\ZohocrmIntegration\Model\Sync
 */
class Account extends Connector {

    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $_customer;

    /**
     * @var QueueFactory
     */
    protected $_queueFactory;
    protected $_logger;
    protected $_addressFactory;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ResourceConfig $resourceConfig
     * @param ZendClientFactory $httpClientFactory
     * @param Data $data
     * @param ReportFactory $reportFactory
     * @param Customer $customer
     * @param AddressFactory $addressFactory
     */
    public function __construct(
    \Psr\Log\LoggerInterface $logger, ScopeConfigInterface $scopeConfig, ResourceConfig $resourceConfig, ZendClientFactory $httpClientFactory, Data $data, ReportFactory $reportFactory, QueueFactory $queueFactory, Customer $customer, AddressFactory $addressFactory
    ) {
        parent::__construct($scopeConfig, $resourceConfig, $httpClientFactory, $reportFactory);
        $this->_type = 'Accounts';
        $this->_table = 'customer';
        $this->_data = $data;
        $this->_customer = $customer;
        $this->_queueFactory = $queueFactory;
        $this->_logger = $logger;
        $this->_addressFactory = $addressFactory;
    }

    /**
     * Create/Update a record in Account tables
     *
     * @param  $id
     * @return string
     */
    public function sync($id) {
        $mobile = $email = $firstName = $lastName = $dob = "";

        $model = $this->_customer->load($id);
        $email = $model->getEmail();
        $params = $this->_data->getCustomer($model, $this->_type);

        /* $addressObj = $this->_addressFactory->create()->getCollection()
          ->addFieldToSelect("parent_id")
          ->addFieldToFilter("parent_id", ["eq" => $id])
          ->getFirstItem();
         */

        $firstName = $model->getFirstname();
        $lastName = $model->getLastname();
        $mobile = $model->getMobileNumber();
        $dob = $model->getDob();

        $params += ['Account Name' => $email];

        $params += ['First Name' => $firstName];
        $params += ['Last Name' => $lastName];
        $params += ['Phone' => $mobile];
        $params += ['Date Of Birth' => $dob];
        // For Telephone
        // Format XML send data
        $postXml = '<Accounts><row no="1">';
        foreach ($params as $key => $value) {
            $postXml .= '<FL val="' . $key . '">' . $value . '</FL>';
        }

        $postXml .= '</row></Accounts>';
        $id = $this->insertRecords($this->_type, $postXml);

        return $id;
    }

    /**
     * Create/Update a record in Account tables
     *
     * @param  $id
     * @return string
     */
    public function syncAccount($id, $isseller) {
        $model = $this->_customer->load($id);
        $email = $model->getEmail();
        $params = $this->_data->getCustomer($model, $this->_type);
        $params += ['Account Name' => $email];
        $params += ['Is Seller' => $isseller];

        // Format XML send data
        $postXml = '<Accounts><row no="1">';
        foreach ($params as $key => $value) {
            $postXml .= '<FL val="' . $key . '">' . $value . '</FL>';
        }

        $postXml .= '</row></Accounts>';
        $id = $this->insertRecords($this->_type, $postXml);

        return $id;
    }

    /**
     * Sync by email if customer not register
     *
     * @param  $email
     * @return string
     */
    public function syncByEmail($email) {

        $params = ['Account Name' => $email];

        // Format XML send data
        $postXml = '<Accounts><row no="1">';
        foreach ($params as $key => $value) {
            $postXml .= '<FL val="' . $key . '">' . trim($value) . '</FL>';
        }

        $postXml .= '</row></Accounts>';
        $id = $this->insertRecords($this->_type, $postXml);

        return $id;
    }

    /**
     * Delete Record
     *
     * @param string $email
     */
    public function delete($email) {
        $id = $this->searchRecords($this->_type, $email);
        if ($id) {
            $this->deleteRecords($this->_type, $id);
        }

        return;
    }

    /**
     * Sync all old data Accounts
     *
     * @return string
     */
    public function syncAllQueue() {
        $collections = $this->_queueFactory->create()
                ->getCollection()
                ->addFieldToFilter('type', 'Account')
               // ->addFieldToFilter('id',["in"=>[8141,8140]])
                ->getData();

        if ($collections) {
            $syncAccounts = $this->getAllAccount($collections);

            $all = $this->insertRecords($this->_type, $syncAccounts);

            return $all;
        }
    }

    public function getAllAccount($collections) {
        $postStartXml = '<Accounts>';
        $postEndXml = '</Accounts>';
        $postXml = "";
        $numberConfig = $this->_scopeConfig->getValue('zohocrm/sync/number', ScopeInterface::SCOPE_STORE);

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/zoho_accounts_existing.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('------------------start---------------');

        $number = 1;
        $firstName = $lastName = $mobile = $dob = "";
        
        foreach ($collections as $collection) {
          //   if ($number <= $numberConfig) {
            $model = $this->_customer->load($collection['entity_id']);
            $email = $model->getEmail();
            $logger->info('Email is ' . $email);
            $params = $this->_data->getFullCustomer($collection['entity_id'], $this->_type);
            $params += ['Account Name' => $email];

            $isseller = true;


            if (!empty($model->getDisapprove())) {
                $isseller = false;
            }

            $firstName = $model->getFirstname();
            $lastName = $model->getLastname();
            $mobile = $model->getMobileNumber();
            $dob = $model->getDob();


            $params += ['First Name' => $firstName];
            $params += ['Last Name' => $lastName];
            $params += ['Phone' => $mobile];
            $params += ['Date Of Birth' => $dob];


            $params += ['Is Seller' => $isseller];

            // Format XML send data
            $postXml = '<row no="' . $number . '">';
            foreach ($params as $key => $value) {
                $postXml .= '<FL val="' . $key . '">' . $value . '</FL>';
            }

            $postXml .= '</row>';
           //  }

            $number++;
            $postStartXml .= $postXml;

            $queue = $this->_queueFactory->create()->load($collection['id']);
            $queue->delete();
        }

        $postStartXml.= $postEndXml;

        return $postStartXml;
    }

}
