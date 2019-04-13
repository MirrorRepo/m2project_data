<?php


namespace Bakeway\UpcomingOrders\Model;

use Magento\Framework\Model\AbstractModel;
use Bakeway\UpcomingOrders\Api\Data\UpcomingOrdersInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Marketplace Saleslist Model.
 *
 * @method \Webkul\Marketplace\Model\ResourceModel\Saleslist _getResource()
 * @method \Webkul\Marketplace\Model\ResourceModel\Saleslist getResource()
 */
class UpcomingOrders extends AbstractModel implements IdentityInterface
{
    /**
     * No route page id.
     */
    const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * Paid Order status.
     */
    const PAID_STATUS_PENDING = '0';
    const PAID_STATUS_COMPLETE = '1';
    const PAID_STATUS_HOLD = '2';
    const PAID_STATUS_REFUNDED = '3';
    const PAID_STATUS_CANCELED = '4';

    /**
     * Marketplace Saleslist cache tag.
     */
    const CACHE_TAG = 'sales_order';

    /**
     * @var string
     */
    protected $_cacheTag = 'sales_order';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'sales_order';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Bakeway\UpcomingOrders\Model\ResourceModel\UpcomingOrders');
    }

    /**
     * Load object data.
     *
     * @param int|null $id
     * @param string   $field
     *
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteUpcomingOrders();
        }

        return parent::load($id, $field);
    }

    /**
     * Load No-Route Saleslist.
     *
     * @return \Webkul\Marketplace\Model\Saleslist
     */
    public function noRouteUpcomingOrders()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }

    /**
     * Get identities.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    /**
     * Get ID.
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * Set ID.
     *
     * @param int $id
     *
     * @return \Webkul\Marketplace\Api\Data\SaleslistInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
}
