<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Block\Adminhtml\Payment;

use Magento\Framework\Phrase;
use Magento\Payment\Block\ConfigurableInfo;
use Cryozonic\StripePayments\Gateway\Response\FraudHandler;
use Cryozonic\StripePayments\Helper\Logger;

class Info extends ConfigurableInfo
{
    public $charge;
    public $cards = array();

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Payment\Gateway\ConfigInterface $config,
        \Cryozonic\StripePayments\Helper\Generic $helper,
        \Cryozonic\StripePayments\Helper\Api $api,
        \Magento\Directory\Model\Country $country,
        \Magento\Payment\Model\Info $info,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $config, $data);
        $this->helper = $helper;
        $this->api = $api;
        $this->country = $country;
        $this->info = $info;
        $this->registry = $registry;
    }

    public function shouldDisplayStripeSection()
    {
        return ($this->getMethod()->getMethod() == 'cryozonic_stripe');
    }

    public function getMethod()
    {
        $order = $this->registry->registry('current_order');
        return $order->getPayment();
    }

    public function getInfo()
    {
        $payment = $this->getMethod();
        $this->info->setData($payment->getData());
        return $this->info;
    }

    public function getSourceInfo()
    {
        $info = $this->getInfo()->getAdditionalInformation('source_info');

        if (empty($info))
            return null;

        $data = json_decode($info, true);

        return $data;
    }

    public function getCard()
    {
        $charge = $this->getCharge();

        if (empty($charge))
            return null;

        if (empty($charge->source))
            return null;

        if (isset($charge->source->object) && $charge->source->object == 'card')
            return $charge->source;

        if (isset($charge->source->type)
            && $charge->source->type == 'three_d_secure'
            // && isset($charge->customer)
            /* && $charge->source->three_d_secure->card */)
        {
            $cardId = $charge->source->three_d_secure->card;
            if (isset($this->cards[$cardId]))
                return $this->cards[$cardId];

            // try
            // {
            //     $stripe = Mage::getModel('cryozonic_stripe/standard');
            //     $customer = $stripe->getStripeCustomer($charge->customer);
            //     $this->cards[$cardId] = $customer->sources->retrieve($cardId);
            // }
            // catch (Exception $e)
            // {
                $card = new \stdClass();
                $card->address_line1_check = $charge->source->three_d_secure->address_line1_check;
                $card->address_zip_check = $charge->source->three_d_secure->address_zip_check;
                $card->cvc_check = $charge->source->three_d_secure->cvc_check;
                $this->cards[$cardId] = $card;
            // }

            return $this->cards[$cardId];
        }

        if (empty($charge->source->card))
            return null;

        return $charge->source->card;
    }

    public function getStreetCheck()
    {
        $card = $this->getCard();

        if (empty($card))
            return 'unchecked';

        if (empty($card->address_line1_check))
            return 'unchecked';

        return $card->address_line1_check;
    }

    public function getZipCheck()
    {
        $card = $this->getCard();

        if (empty($card))
            return 'unchecked';

        if (empty($card->address_zip_check))
            return 'unchecked';

        return $card->address_zip_check;
    }

    public function getCVCCheck()
    {
        $card = $this->getCard();

        if (empty($card))
            return 'unchecked';

        if (empty($card->cvc_check))
            return 'unchecked';

        return $card->cvc_check;
    }

    public function getRadarRisk()
    {
        $charge = $this->getCharge();

        if (isset($charge->outcome->risk_level))
            return $charge->outcome->risk_level;

        return 'Unchecked';
    }

    public function getChargeOutcome()
    {
        $charge = $this->getCharge();

        if (isset($charge->outcome->type))
            return $charge->outcome->type;

        return 'None';
    }

    public function getCharge()
    {
        if (isset($this->charge))
            return $this->charge;

        try
        {
            $token = $this->helper->cleanToken($this->getMethod()->getLastTransId());

            // Subscriptions will not have a charge ID
            if (empty($token))
                return null;

            $this->charge = $this->api->retrieveCharge($token);
        }
        catch (\Stripe\Error\Card $e)
        {
            $this->helper->dieWithError($e->getMessage(), $e);
            return null;
        }
        catch (\Stripe\Error $e)
        {
            $this->helper->dieWithError($e->getMessage(), $e);
            return null;
        }
        catch (\Exception $e)
        {
            $this->helper->dieWithError($e->getMessage(), $e);
            return null;
        }

        return $this->charge;
    }

    public function getCaptured()
    {
        $charge = $this->getCharge();

        if (isset($charge->captured) && $charge->captured == 1)
            return "Yes";

        return 'No';
    }

    public function getRefunded()
    {
        $charge = $this->getCharge();

        if (isset($charge->amount_refunded) && $charge->amount_refunded > 0)
            return $charge->amount_refunded;

        return 'No';
    }

    public function getCustomerId()
    {
        $charge = $this->getCharge();

        if (isset($charge->customer) && !empty($charge->customer))
            return $charge->customer;

        return null;
    }

    public function getPaymentId()
    {
        $charge = $this->getCharge();

        if (isset($charge->id))
            return $charge->id;

        return null;
    }

    public function getCardCountry()
    {
        $charge = $this->getCharge();

        if (isset($charge->source->country))
            $country = $charge->source->country;
        else if (isset($charge->source->card->country))
            $country = $charge->source->card->country;
        else
            return "Unknown";

        return $this->country->load($country)->getName();
    }

    public function getSourceType()
    {
        $charge = $this->getCharge();

        if (!isset($charge->source->type))
            return null;

        return ucwords(str_replace("_", " ", $charge->source->type));
    }
}
