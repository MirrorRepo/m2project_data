<?php
/**
 * Created by PhpStorm.
 * User: canhnd
 * Date: 09/02/2017
 * Time: 14:06
 */
namespace Smj\Zohocrm\Model\ResourceModel;

class Queue extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('smj_zohocrm_queue', 'id');
    }
}
