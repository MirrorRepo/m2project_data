<?php

namespace Bakeway\Uc\Ui\DataProvider;

use Bakeway\CommissionLog\Model\ResourceModel\CommissionLog;

/**
 * Class ProductDataProvider
 */

class CommisionlogDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $commissionLog;


    protected $addFieldStrategies;

    protected $addFilterStrategies;

    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CommissionLog $collectionFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->commissionLog = $collectionFactory;
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
    }

   

}
