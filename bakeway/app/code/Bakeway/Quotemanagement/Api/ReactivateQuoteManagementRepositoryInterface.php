<?php

namespace Bakeway\Quotemanagement\Api;

/**
 * Razor QuoteOrder management API.
 */
interface ReactivateQuoteManagementRepositoryInterface 
{

    /**
     * @api
     * @param int $customerId
     * @param int $cartId
     * @param int $reactivateQuote
     * @return array
     * @throws \Magento\Framework\Exception\NotFoundException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function reactivateQuote($customerId, $cartId, $reactivateQuote);

    /**
     * @api
     * @param string $cartId
     * @param int $reactivateQuote
     * @return array
     * @throws \Magento\Framework\Exception\NotFoundException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function reactivateGuestQuote($cartId, $reactivateQuote);
}
