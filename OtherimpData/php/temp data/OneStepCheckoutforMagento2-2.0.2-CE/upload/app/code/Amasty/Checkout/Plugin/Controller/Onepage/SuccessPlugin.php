<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Checkout
 */


namespace Amasty\Checkout\Plugin\Controller\Onepage;

class SuccessPlugin
{

    /**
     * @var \Amasty\Checkout\Model\Account
     */
    private $account;

    /**
     * @var \Amasty\Checkout\Model\Config
     */
    private $config;

    /**
     * @var \Amasty\Checkout\Api\AdditionalFieldsManagementInterface
     */
    private $fieldsManagement;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $session;

    public function __construct(
        \Amasty\Checkout\Model\Account $account,
        \Amasty\Checkout\Model\Config $config,
        \Amasty\Checkout\Api\AdditionalFieldsManagementInterface $fieldsManagement,
        \Magento\Checkout\Model\Session $session
    ) {
        $this->account = $account;
        $this->config = $config;
        $this->fieldsManagement = $fieldsManagement;
        $this->session = $session;
    }

    /**
     * @param \Magento\Checkout\Controller\Onepage\Success $subject
     * @return null
     */
    public function beforeExecute(\Magento\Checkout\Controller\Onepage\Success $subject)
    {
        if (!$this->config->isEnabled()) {
            return null;
        }
        $order = $this->session->getLastRealOrder();
        if (!$order || $order->getCustomerId()) {
            return null;
        }
        $fields = $this->fieldsManagement->getByQuoteId($order->getQuoteId());

        if ($fields->getRegister()) {
            $this->account->create($order->getId(), $fields);
        }

        return null;
    }
}
