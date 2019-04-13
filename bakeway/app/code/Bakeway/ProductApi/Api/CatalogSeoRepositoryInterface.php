<?php
/**
 * Bakeway
 *
 * @category  Bakeway
 * @package   Bakeway_ProductApi
 * @author    Bakeway
 */
namespace Bakeway\ProductApi\Api;

/**
 * Catalog SEO Interface.
 */
interface CatalogSeoRepositoryInterface {
    
    /**
     * Get Url Details
     * @param string $url
     * @param string|null $store
     * @return array
     * @throws NotFoundException
     * @throws NoSuchEntityException
     */
    public function getUrlDetails($url, $store = null);

    /**
     * Get Seller Store Details
     * @param int $vendorId
     * @param string $city
     * @param string $lat
     * @param string $long
     * @param string|null $sku
     * @param bool|false $single
     * @param int|null $deliveryStoreradious
     * @param int|null $includePickup
     * @return array
     * @throws NotFoundException
     * @throws LocalizedException
     */
    public function getStoreDetails($vendorId, $city, $lat, $long, $sku = null,$single = false, $deliveryStoreradious = null, $includePickup = null);
}