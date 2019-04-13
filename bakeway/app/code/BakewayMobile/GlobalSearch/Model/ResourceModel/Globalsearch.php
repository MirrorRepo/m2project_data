<?php
/**
 * Copyright © 2015 Bakeway. All rights reserved.
 */
namespace BakewayMobile\GlobalSearch\Model\ResourceModel;

/**
 * Commison resource
 */
class Globalsearch extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('bakeway_globalsearchtag', 'entity_id');
    }

  
}
