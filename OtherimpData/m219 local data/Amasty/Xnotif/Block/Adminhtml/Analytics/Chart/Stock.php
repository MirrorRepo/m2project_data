<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Xnotif
 */


namespace Amasty\Xnotif\Block\Adminhtml\Analytics\Chart;

use Magento\Backend\Block\Template;
use Amasty\Xnotif\Model\ResourceModel\Analytics\Request\Stock\CollectionFactory as AnalyticsCollectionFactory;
use Amasty\Xnotif\Model\ResourceModel\Analytics\Request\Stock\Collection as AnalyticsCollection;
use Magento\Directory\Model\Currency;
use Magento\Directory\Model\Currency\DefaultLocator;
use Magento\Directory\Model\CurrencyFactory;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Locale\CurrencyInterface;
use Magento\Framework\Phrase;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Api\Data\StoreInterface;

class Stock extends Template
{
    protected $_template = 'Amasty_Xnotif::analytics/chart/stock.phtml';

    /**
     * @var AnalyticsCollectionFactory
     */
    private $stockAnalyticsFactory;

    /**
     * @var EncoderInterface
     */
    private $jsonEncoder;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var StoreInterface
     */
    private $store;

    /**
     * @var Currency
     */
    private $defaultBaseCurrency;

    /**
     * @var CurrencyInterface
     */
    private $localeCurrency;

    /**
     * @var string
     */
    private $defaultBaseCurrencyCode;

    /**
     * @var string
     */
    private $symbol;

    /**
     * @var null|array
     */
    private $totals;

    public function __construct(
        AnalyticsCollectionFactory $stockAnalyticsFactory,
        EncoderInterface $jsonEncoder,
        DateTime $dateTime,
        Template\Context $context,
        StoreInterface $store,
        DefaultLocator $currencyLocator,
        CurrencyFactory $currencyFactory,
        CurrencyInterface $localeCurrency,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->stockAnalyticsFactory = $stockAnalyticsFactory;
        $this->jsonEncoder = $jsonEncoder;
        $this->dateTime = $dateTime;
        $this->store = $store;
        $this->defaultBaseCurrencyCode = $currencyLocator->getDefaultCurrency($this->_request);
        $this->defaultBaseCurrency = $currencyFactory->create()->load($this->defaultBaseCurrencyCode);
        $this->localeCurrency = $localeCurrency;
        $this->symbol =  $localeCurrency->getCurrency($this->defaultBaseCurrencyCode)->getSymbol();
    }

    /**
     * @return Phrase
     */
    public function getTitle()
    {
        return __('Back in Stock Requests');
    }

    /**
     * @return string
     */
    public function getAnalyticsData()
    {
        $analyticsConfig = [];
        /** @var AnalyticsCollection $analyticsData */
        $analyticsData = $this->stockAnalyticsFactory->create()
            ->groupByMonth();
        foreach ($analyticsData as $key => $analyticData) {
            $analyticsConfig[] = $analyticData->toArray(['subscribed', 'sent', 'orders', 'date']);
            $analyticsConfig[$key]['date'] = $this->dateTime->date('F, Y', $analyticsConfig[$key]['date']);
            $analyticsConfig[$key]['orders'] = $this->convertPrice($analyticsConfig[$key]['orders']);
        }

        return $this->jsonEncoder->encode($analyticsConfig);
    }

    /**
     * @param string $price
     *
     * @return string
     */
    private function convertPrice($price)
    {
        $price = (float)$price * $this->defaultBaseCurrency->getRate($this->defaultBaseCurrencyCode);

        return $price;
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->symbol;
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function getTotal($field)
    {
        if (!$this->totals) {
            $this->totals = $this->stockAnalyticsFactory->create()
                ->getTotalRow();
            if (isset($this->totals['orders'])) {
                $this->totals['orders'] = $this->priceOutput(
                    $this->convertPrice($this->totals['orders'])
                );
            }
        }
        $result = isset($this->totals[$field]) ? $this->totals[$field] : '';

        return $result;
    }

    /**
     * @param $price
     *
     * @return string
     */
    private function priceOutput($price)
    {
        return $this->localeCurrency->getCurrency($this->defaultBaseCurrencyCode)->toCurrency(
            $price,
            ['symbol' => '']
        );
    }
}
