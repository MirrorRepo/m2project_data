<?php

namespace BakewayMobile\GlobalSearch\Api;

interface GlobalSearchRepositoryInterface
{
    
    /**
     * Get search result of tag specfic for product
     * @api
     * @param string|null $city
     * @param string|null $lat
     * @param string|null $long
     * @param string $query
     * @return array
     * @throws NotFoundException
     */

    public function getSearchResult($city = null, $lat = null, $long = null, $query);
}