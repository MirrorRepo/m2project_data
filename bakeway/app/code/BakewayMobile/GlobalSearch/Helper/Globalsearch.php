<?php

/**
 */

namespace BakewayMobile\GlobalSearch\Helper;

use Magento\Customer\Model\Session;

/**
 * Webkul Marketplace Helper Email.
 */
class Globalsearch extends \Magento\Framework\App\Helper\AbstractHelper {

    /**
     * product search status
     * @return int
     */
    public function getProductSearchStatus() {
        return $this->scopeConfig->getValue(
                        'tags_search_terms/search_terms/search_terms_product', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * flavours search status
     * @return int
     */
    public function getFlavoursSearchStatus() {
        return $this->scopeConfig->getValue(
                        'tags_search_terms/search_terms/search_terms_flavours', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * category search status
     * @return int
     */
    public function getCatsSearchStatus() {
        return $this->scopeConfig->getValue(
                        'tags_search_terms/search_terms/search_terms_cats', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Bakeries search status
     * @return int
     */
    public function getBakeriesSearchStatus() {
        return $this->scopeConfig->getValue(
                        'tags_search_terms/search_terms/search_terms_bakery', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Product search limit
     * @return int
     */
    public function getReturnProductLimit() {
        return $this->scopeConfig->getValue(
                        'tags_search_terms/search_terms/search_product_limit', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    
}
