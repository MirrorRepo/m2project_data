<?php
/**
 * Copyright © 2015 Smj. All rights reserved.
 */
namespace Smj\Adminmodule\Model\ResourceModel;

/**
 * Smj resource
 */
class Smj extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('adminmodule_smj', 'id');
    }

  
}
