<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\ZohocrmIntegration\Model\ResourceModel\OrderSync;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    public function _construct() {
        $this->_init('Magenest\ZohocrmIntegration\Model\OrderSync', 'Magenest\ZohocrmIntegration\Model\ResourceModel\OrderSync');
    }

}
