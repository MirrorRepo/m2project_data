<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Block;

use Cryozonic\StripePayments\Helper\Logger;

class Form extends \Magento\Payment\Block\Form\Cc
{
    protected $_template = 'form/cryozonic_stripe.phtml';

    public $config;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Payment\Model\Config $paymentConfig,
        \Cryozonic\StripePayments\Model\Config $config,
        \Cryozonic\StripePayments\Model\StripeCustomer $stripeCustomer,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Cryozonic\StripePayments\Helper\Generic $helper,
        array $data = []
    ) {
        parent::__construct($context, $paymentConfig, $data);
        $this->config = $config;
        $this->stripeCustomer = $stripeCustomer;
        $this->productMetadata = $productMetadata;
        $this->helper = $helper;
    }

    public function getCustomerCards()
    {
        return $this->stripeCustomer->getCustomerCards();
    }

    public function getSwitchSubscriptionBlock()
    {
        try
        {
            if (class_exists('Cryozonic\StripeSubscriptions\Block\Form'))
                return $this->getLayout()->createBlock('Cryozonic\StripeSubscriptions\Block\Form');

            return null;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    public function isSinglePaymentMethod()
    {
        return count($this->getParentBlock()->getMethods()) == 1;
    }

    public function hideIfNotBuggy()
    {
        // Issue: https://github.com/magento/magento2/issues/11380
        $version = $this->productMetadata->getVersion();

        if (version_compare($version, "2.2.0") >= 0 && $this->isSinglePaymentMethod())
            return "";
        else
            return 'style="display:none;';
    }

    public function isNewCustomer()
    {
        if ($this->helper->isAdmin() && !$this->helper->getCustomerId())
            return true;

        return false;
    }
}
