<?php
namespace Bakeway\ReviewRating\Model\Rewrite\ResourceModel;

class Rating extends \Magento\Review\Model\ResourceModel\Rating
{
    const RATING_ID = '4';
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Review\Model\ResourceModel\Review\Summary $reviewSummary
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Review\Model\ResourceModel\Review\Summary $reviewSummary,
        $connectionName = null
    ) {
        $this->moduleManager = $moduleManager;
        $this->_storeManager = $storeManager;
        $this->_logger = $logger;
        $this->_reviewSummary = $reviewSummary;
        parent::__construct($context,$logger,$moduleManager,$storeManager,$reviewSummary,$connectionName);
    }
    
    /**
     * Review summary
     *
     * @param \Magento\Review\Model\Rating $object
     * @param boolean $onlyForCurrentStore
     * @return array
     */
    public function getReviewSummary($object, $onlyForCurrentStore = true)
    {
        $connection = $this->getConnection();

        $sumColumn = new \Zend_Db_Expr("SUM(rating_vote.{$connection->quoteIdentifier('percent')})");
        $countColumn = new \Zend_Db_Expr('COUNT(*)');
        $select = $connection->select()->from(
            ['rating_vote' => $this->getTable('rating_option_vote')],
            ['sum' => $sumColumn, 'count' => $countColumn]
        )->joinLeft(
            ['review_store' => $this->getTable('review_store')],
            'rating_vote.review_id = review_store.review_id',
            ['review_store.store_id']
        );
        if (!$this->_storeManager->isSingleStoreMode()) {
            $select->join(
                ['rating_store' => $this->getTable('rating_store')],
                'rating_store.rating_id = rating_vote.rating_id AND rating_store.store_id = review_store.store_id',
                []
            );
        }
        $select->where(
            'rating_vote.review_id = :review_id'
        )->where(
            'rating_vote.rating_id !='.self::RATING_ID
        )->group(
            'rating_vote.review_id'
        )->group(
            'review_store.store_id'
        );

        $data = $connection->fetchAll($select, [':review_id' => $object->getReviewId()]);

        if ($onlyForCurrentStore) {
            foreach ($data as $row) {
                if ($row['store_id'] == $this->_storeManager->getStore()->getId()) {
                    $object->addData($row);
                }
            }
            return $object;
        }

        $result = [];

        $stores = $this->_storeManager->getStore()->getResourceCollection()->load();

        foreach ($data as $row) {
            $clone = clone $object;
            $clone->addData($row);
            $result[$clone->getStoreId()] = $clone;
        }

        $usedStoresId = array_keys($result);

        foreach ($stores as $store) {
            if (!in_array($store->getId(), $usedStoresId)) {
                $clone = clone $object;
                $clone->setCount(0);
                $clone->setSum(0);
                $clone->setStoreId($store->getId());
                $result[$store->getId()] = $clone;
            }
        }

        return array_values($result);
    }

}
