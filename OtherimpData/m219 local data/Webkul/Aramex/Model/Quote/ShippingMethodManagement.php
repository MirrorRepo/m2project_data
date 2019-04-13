<?php
/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_Aramex
 * @author Webkul
 * @copyright Copyright (c) 2010-2016 Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */
namespace Webkul\Aramex\Model\Quote;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Reflection\DataObjectProcessor;

/**
 * Shipping method read service.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ShippingMethodManagement extends \Magento\Quote\Model\ShippingMethodManagement
{   
    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor
     */
    private $dataProcessor;

    /**
     * {@inheritDoc}
     */
    public function estimateByAddress($cartId, \Magento\Quote\Api\Data\EstimateAddressInterface $address)
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);

        // no methods applicable for empty carts or carts with virtual products
        if ($quote->isVirtual() || 0 == $quote->getItemsCount()) {
            return [];
        }
        $quote->getShippingAddress()->setCity($address->getCity());
        return $this->getAramexShippingMethods($quote, $address);
        
    }

    /**
     * @inheritdoc
     */
    public function estimateByExtendedAddress($cartId, AddressInterface $address)
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);

        // no methods applicable for empty carts or carts with virtual products
        if ($quote->isVirtual() || 0 == $quote->getItemsCount()) {
            return [];
        }
        $quote->getShippingAddress()->setCity($address->getCity());

        return $this->getAramexShippingMethods($quote, $address);
    }
   
    /**
     * {@inheritDoc}
     */
    public function estimateByAddressId($cartId, $addressId)
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);

        // no methods applicable for empty carts or carts with virtual products
        if ($quote->isVirtual() || 0 == $quote->getItemsCount()) {
            return [];
        }
        $address = $this->addressRepository->getById($addressId);
        $quote->getShippingAddress()->setCity($address->getCity());
        
        return $this->getAramexShippingMethods($quote, $address);
    }

    /**
     * Get list of available shipping methods
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Framework\Api\ExtensibleDataInterface $address
     * @return \Magento\Quote\Api\Data\ShippingMethodInterface[]
     */
    private function getAramexShippingMethods(Quote $aramexQuote, $address)
    {
        $shippingAddress = $aramexQuote->getShippingAddress();
        $shippingAddress->addData($this->extractAddressData($address));
        $shippingAddress->setCollectShippingRates(true);
        $output = [];
        
        $collector = $this->totalsCollector->collectAddressTotals($aramexQuote, $shippingAddress);
        $aramexShippingRates = $shippingAddress->getGroupedAllShippingRates();
        foreach ($aramexShippingRates as $aramexCarrierRates) {
            foreach ($aramexCarrierRates as $aramexRate) {
                $output[] = $this->converter->modelToDataObject($aramexRate, $aramexQuote->getQuoteCurrencyCode());
            }
        }
        return $output;
    }

    /**
     * Get address interface into Array
     * @param \Magento\Framework\Api\ExtensibleDataInterface  $address
     * @return array
     */
    private function extractAddressData($aramexAddress)
    {
        $className = \Magento\Customer\Api\Data\AddressInterface::class;
        if ($aramexAddress instanceof \Magento\Quote\Api\Data\AddressInterface) {
            $className = \Magento\Quote\Api\Data\AddressInterface::class;
        } elseif ($aramexAddress instanceof EstimateAddressInterface) {
            $className = EstimateAddressInterface::class;
        }
        return $this->getDataObjectProcessor()->buildOutputDataArray(
            $aramexAddress,
            $className
        );
    }

    /**
     * Gets the data object processor
     *
     * @return \Magento\Framework\Reflection\DataObjectProcessor
     * @deprecated 100.2.0
     */
    private function getDataObjectProcessor()
    {
        if ($this->dataProcessor === null) {
            $this->dataProcessor = ObjectManager::getInstance()
                ->get(DataObjectProcessor::class);
        }
        return $this->dataProcessor;
    }
}