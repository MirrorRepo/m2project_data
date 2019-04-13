<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace BakewayMobile\GlobalSearch\Model\ResourceModel\Globalsearch;

/**
 * Commisons Collection
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('BakewayMobile\GlobalSearch\Model\Globalsearch', 'BakewayMobile\GlobalSearch\Model\ResourceModel\Globalsearch');
    }
    
    /**
     * Add field filter to collection.
     *
     * @param array|string          $field
     * @param string|int|array|null $condition
     *
     * @return $this
     */
    public function addFieldToFilter($field, $condition = null)
    {
        return parent::addFieldToFilter($field, $condition);
    }
    
     /**
     * Processing collection items after loading
     * Adding url rewrites, minimal prices, final prices, tax percents
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        if (count($this)) { 
            $this->_eventManager->dispatch('global_search_tags_collection_load_after', ['collection' => $this]);
        }

        return $this;
    }
}
