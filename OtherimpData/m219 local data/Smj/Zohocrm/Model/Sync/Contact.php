<?php
/**
 * Copyright © 2015 Smj. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Smj_Zohocrm extension
 * NOTICE OF LICENSE
 *
 * @category Smj
 * @package  Smj_Zohocrm
 * @author   Mukund
 */
namespace Smj\Zohocrm\Model\Sync;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Model\ResourceModel\Config as ResourceConfig;
use Magento\Framework\HTTP\ZendClientFactory;
use Smj\Zohocrm\Model\ReportFactory;
use Magento\Customer\Model\Customer;
use Smj\Zohocrm\Model\Connector;
use Smj\Zohocrm\Model\Data;
use Smj\Zohocrm\Model\QueueFactory;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Contact using to sync to Contacts table
 *
 * @package Smj\Zohocrm\Model\Sync
 */
class Contact extends Connector
{
    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $_customer;

    /**
     * @var QueueFactory
     */
    protected $_queueFactory;
    
    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ResourceConfig $resourceConfig
     * @param ZendClientFactory $httpClientFactory
     * @param Data $data
     * @param ReportFactory $reportFactory
     * @param Customer $customer
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ResourceConfig $resourceConfig,
        ZendClientFactory $httpClientFactory,
        Data $data,
        ReportFactory $reportFactory,
        QueueFactory $queueFactory,
        Customer $customer
    ) {
        parent::__construct($scopeConfig, $resourceConfig, $httpClientFactory, $reportFactory);
        $this->_type     = 'Contacts';
        $this->_table    = 'customer';
        $this->_data     = $data;
        $this->_customer = $customer;
        $this->_queueFactory = $queueFactory;
    }

    /**
     * Update or create new a Contact
     *
     * @param  int $id
     * @return string
     */
    public function sync($id)
    {
        $model     = $this->_customer->load($id);
        $email     = $model->getEmail();
        $firstname = $model->getFirstname();
        $lastname  = $model->getLastname();
        $params    = $this->_data->getCustomer($model, $this->_type);
        $params   += [
                      'Last Name'  => $lastname,
                      'First Name' => $firstname,
                      'Email'      => $email,
                     ];

        // Format XML send data
        $postXml = '<Contacts><row no="1">';
        foreach ($params as $key => $value) {
            $postXml .= '<FL val="'.$key.'">'.trim($value).'</FL>';
        }

        $postXml .= '</row></Contacts>';

        $id = $this->insertRecords($this->_type, $postXml);

        return $id;
    }

    /**
     * If customer not register
     *
     * @param  array $data
     * @return string
     */
    public function syncByEmail($data)
    {
        $params = $data;

        // Format XML send data
        $postXml = '<Contacts><row no="1">';
        foreach ($params as $key => $value) {
            $postXml .= '<FL val="'.$key.'">'.trim($value).'</FL>';
        }

        $postXml .= '</row></Contacts>';
        $id       = $this->insertRecords($this->_type, $postXml);

        return $id;
    }

    /**
     * Delete Record
     *
     * @param string $email
     */
    public function delete($email)
    {
        $id = $this->searchRecords($this->_type, $email);
        if ($id) {
            $this->deleteRecords($this->_type, $id);
        }

        return;
    }

    /**
     * Sync all contact old data
     *
     * @return string
     */
    public function syncAllQueue()
    {
        $collections = $this->_queueFactory->create()
            ->getCollection()
            ->addFieldToFilter('type', 'Contact')
            ->getData();

        if ($collections) {
            $syncContact = $this->getAllContact($collections);

            $all      = $this->insertRecords($this->_type, $syncContact);

            return $all;
        }
    }

    /**
     * Get All Record Contact
     *
     * @param $collections
     * @return string
     */
    public function getAllContact($collections)
    {
        $postStartXml = '<Contacts>';
        $postEndXml = '</Contacts>';

        $numberConfig = $this->_scopeConfig->getValue('zohocrm/sync/number', ScopeInterface::SCOPE_STORE);

        $number = 1;
        foreach ($collections as $collection) {
                $model     = $this->_customer->load($collection['entity_id']);
                $email     = $model->getEmail();
                $firstname = $model->getFirstname();
                $lastname  = $model->getLastname();
                $params    = $this->_data->getFullCustomer($collection['entity_id'], $this->_type);
                $params   += [
                    'Last Name'  => $lastname,
                    'First Name' => $firstname,
                    'Email'      => $email,
                ];

                // Format XML send data
                $postXml = '<row no="'.$number.'">';
                foreach ($params as $key => $value) {
                    $postXml .= '<FL val="'.$key.'">'.trim($value).'</FL>';
                }

                $postXml .= '</row>';

            $number++;
            $postStartXml .= $postXml;

            $queue = $this->_queueFactory->create()->load($collection['id']);
            $queue->delete();
        }

        $postStartXml.= $postEndXml;

        return $postStartXml;
    }
}
