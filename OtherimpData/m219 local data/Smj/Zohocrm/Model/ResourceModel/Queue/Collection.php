<?php
/**
 * Created by PhpStorm.
 * User: canhnd
 * Date: 09/02/2017
 * Time: 14:06
 */
namespace Smj\Zohocrm\Model\ResourceModel\Queue;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Smj\Zohocrm\Model\Queue', 'Smj\Zohocrm\Model\ResourceModel\Queue');
    }
}
