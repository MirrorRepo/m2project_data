<?php

/**
 * Copyright © 2015 Bakeway. All rights reserved.
 */

namespace Magenest\ZohocrmIntegration\Model\ResourceModel;

class OrderSync extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct() {
        $this->_init('bakeway_zoho_order_mg_sync', 'entity_id');
    }

}
