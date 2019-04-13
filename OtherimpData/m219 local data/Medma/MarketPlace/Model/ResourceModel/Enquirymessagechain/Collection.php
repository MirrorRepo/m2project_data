<?php
/**
 *
 * Copyright © 2016 Medma. All rights reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 */
  
namespace Medma\MarketPlace\Model\ResourceModel\Enquirymessagechain;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init('Medma\MarketPlace\Model\Enquirymessagechain', 'Medma\MarketPlace\Model\ResourceModel\Enquirymessagechain');
    }
}
