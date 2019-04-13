<?php
namespace BakewayMobile\PartnerMobileApi\Api;

interface MobilePartnerInterface
{
 /**
     * Get Partner List With Products.
     *
     * @api
     * @param string|null $city
     * @param string|null $lat
     * @param string|null $long
     * @param string|null $deliverydate
     * @param string|null $searchterm
     * @param \Magento\Framework\Api\SearchCriteria|null $searchCriteria The search criteria.
     * @return array
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function getMobilePartnerList($city = null, $lat = null, $long = null, $deliverydate = null, $searchterm = null, \Magento\Framework\Api\SearchCriteria $searchCriteria = null);
}
