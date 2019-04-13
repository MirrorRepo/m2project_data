<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Xnotif
 */
namespace Amasty\Xnotif\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\ProductAlert\Model\Email;
use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Magento\Bundle\Model\Product\Type as BundleType;
use Amasty\Xnotif\Model\Analytics\Collector;

class Observer extends \Magento\ProductAlert\Model\Observer
{
    /**
     * @var array
     */
    private $colFactorys = [];

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    private $customerFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Amasty\Xnotif\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable
     */
    private $configurableType;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Store\Model\App\Emulation
     */
    private $appEmulation;

    /**
     * @var AdminNotification
     */
    private $adminNotification;

    /**
     * @var Collector
     */
    private $collector;

    public function __construct(
        \Magento\Catalog\Helper\Data $catalogData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\ProductAlert\Model\ResourceModel\Price\CollectionFactory $priceColFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateFactory,
        \Magento\ProductAlert\Model\ResourceModel\Stock\CollectionFactory $stockColFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\ProductAlert\Model\EmailFactory $emailFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Registry $registry,
        \Amasty\Xnotif\Helper\Data $helper,
        Configurable $configurableType,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Store\Model\App\Emulation $appEmulation,
        \Psr\Log\LoggerInterface $logger,
        AdminNotification $adminNotification,
        Collector $collector
    ) {
        parent::__construct(
            $catalogData,
            $scopeConfig,
            $storeManager,
            $priceColFactory,
            $customerRepository,
            $productRepository,
            $dateFactory,
            $stockColFactory,
            $transportBuilder,
            $emailFactory,
            $inlineTranslation
        );
        $this->colFactorys['price'] = $priceColFactory;
        $this->colFactorys['stock'] = $stockColFactory;
        $this->customerFactory = $customerFactory;
        $this->registry = $registry;
        $this->helper = $helper;
        $this->configurableType = $configurableType;
        $this->logger = $logger;
        $this->appEmulation = $appEmulation;
        $this->adminNotification = $adminNotification;
        $this->collector = $collector;
    }

    public function processWithLimit()
    {
        /** @var \Magento\ProductAlert\Model\Email $email */
        $email = $this->_emailFactory->create();
        $this->sendNotifications('stock', $email);
        $this->_sendErrorEmail();
        if ($this->helper->isAdminNotificationEnabled()) {
            $this->adminNotification->sendAdminNotifications();
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function _processStock(Email $email)
    {
        if (!$this->helper->enableQtyLimit()) {
            $this->sendNotifications('stock', $email);
        }
    }

    /**
     * @inheritdoc
     */
    protected function _processPrice(Email $email)
    {
        $this->sendNotifications('price', $email);
    }

    protected function _sendErrorEmail()
    {
        if (!empty($this->_errors)) {
            foreach ($this->_errors as $error) {
                $this->logger->error($error);
            }
            parent::_sendErrorEmail();
        }
    }

    /**
     * @param $type
     * @param Email $email
     *
     * @return $this
     */
    private function sendNotifications($type, Email $email)
    {
        try {
            $collection = $this->colFactorys[$type]->create()
                ->addFieldToFilter('status', 0)
                ->setCustomerOrder();
        } catch (\Exception $e) {
            $this->_errors[] = $e->getMessage();
            return $this;
        }

        $prevCustomerEmail = null;
        $email->setType($type);
        $productJoinAlertData = [];
        $productNotifications = 0;
        $tempNotifications = 0;

        foreach ($collection as $alert) {
            try {
                $websiteId = $alert->getWebsiteId();
                $website = $this->_storeManager->getWebsite($websiteId);
                $storeId = $alert->getStoreId() ? $alert->getStoreId() : $website->getDefaultStore()->getId();
                if ($this->registry->registry('amasty_store_id')) {
                    $this->registry->unregister('amasty_store_id');
                }
                $this->registry->register('amasty_store_id', $storeId);
                
                $email->setWebsite($website);

                if (!$this->_scopeConfig->getValue(
                    'catalog/productalert/allow_' . $type,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                    $website->getDefaultGroup()->getDefaultStore()->getId()
                )) {
                    continue;
                }

                $customer = $this->getCustomerFromAlert($alert, $websiteId);
                if (!$customer) {
                    continue;
                }
                if ($customer->getEmail() !== $prevCustomerEmail) {
                    if ($prevCustomerEmail) {
                        $email->send();
                        $productNotifications += $tempNotifications;
                        $tempNotifications = 0;
                        $this->deleteTemporaryEmail();
                    }

                    $email->clean();
                    $email->setCustomerData($customer);
                }
                $prevCustomerEmail = $customer->getEmail();
                if (!$customer->getId()) {
                    $this->saveTemporaryEmail($prevCustomerEmail);
                }

                try {
                    $product = $this->productRepository->getById(
                        $alert->getProductId(),
                        false,
                        $storeId
                    );
                } catch (\Magento\Framework\Exception\NoSuchEntityException $ex) {
                    continue;
                }

                if ('stock' == $type) {
                    if ($this->helper->enableQtyLimit()) {
                        if (array_key_exists($alert->getProductId(), $productJoinAlertData)) {
                            if ($productJoinAlertData[$alert->getProductId()]['qty']
                                <= $productJoinAlertData[$alert->getProductId()]['counter']) {
                                continue;
                            } else {
                                $productJoinAlertData[$alert->getProductId()]['counter']++;
                            }
                        } else {
                            $productJoinAlertData[$alert->getProductId()] = [
                                'qty' => $this->helper->getProductQty($product),
                                'counter' => 1
                            ];
                        }
                    }

                    if ($product = $this->checkStockSubscription($product, $alert, $website)) {
                        $email->addStockProduct($product);
                        $tempNotifications++;
                    }
                } else {
                    if ($product = $this->checkPriceSubscription($product, $alert)) {
                        $email->addPriceProduct($product);
                    }
                }
            } catch (\Exception $e) {
                $this->_errors[] = $e->getMessage();
                $tempNotifications = 0;
                continue;
            }
        }

        if ($prevCustomerEmail) {
            try {
                $email->send();
                $productNotifications += $tempNotifications;
            } catch (\Exception $e) {
                $this->_errors[] = $e->getMessage();
            }
        }

        if ($productNotifications) {
            $this->collector->updateDaily(Collector::ACTION_SENT, $productNotifications);
        }

        return $this;
    }

    /**
     * @param $product
     * @param $alert
     * @return null
     */
    private function checkPriceSubscription($product, $alert)
    {
        if ($alert->getPrice() > $product->getFinalPrice()) {
            $productPrice = $product->getFinalPrice();
            $product->setFinalPrice(
                $this->_catalogData->getTaxPrice(
                    $product,
                    $productPrice
                )
            );
            $product->setPrice(
                $this->_catalogData->getTaxPrice(
                    $product,
                    $product->getPrice()
                )
            );

            $alert->setPrice($productPrice);
            $alert->setLastSendDate(
                $this->_dateFactory->create()->gmtDate()
            );
            $alert->setSendCount($alert->getSendCount() + 1);
            $alert->setStatus(1);
            $alert->save();

            return $product;
        }

        return null;
    }

    /**
     * @param $product
     * @param $alert
     * @param $website
     * @return \Magento\Catalog\Api\Data\ProductInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function checkStockSubscription($product, $alert, $website)
    {
        $minQuantity = (int)$this->helper->getModuleConfig('general/min_qty');
        $minQuantity = ($minQuantity < 1) ? 1 : $minQuantity;

        $isInStock = false;
        if ($product->canConfigure() && $product->isSalable()) {
            $allProducts = $this->getUsedProducts($product);
            foreach ($allProducts as $simpleProduct) {
                $quantity = $this->helper->getProductQty($simpleProduct);
                $isInStock = ($simpleProduct->isSalable() || $simpleProduct->isSaleable())
                    && $quantity >= $minQuantity;
                if ($isInStock) {
                    break;
                }
            }
        } else {
            $quantity = $this->helper->getProductQty($product);
            $isInStock = $product->isSalable() && ($quantity >= $minQuantity);
        }

        if ($isInStock) {
            if ($alert->getParentId()
                && $alert->getParentId() != $alert->getProductId()
                && !$product->canConfigure()
            ) {
                $productParent = $this->productRepository->getById(
                    $alert->getParentId(),
                    false,
                    $website->getDefaultStore()->getId()
                );

                $product = $productParent;
            }

            $alert->setSendDate(
                $this->_dateFactory->create()->gmtDate()
            );
            $alert->setSendCount($alert->getSendCount() + 1);
            $alert->setStatus(1);
            $alert->save();

            return $product;
        }

        return null;
    }

    /**
     * @param $alert
     * @param $websiteId
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCustomerFromAlert($alert, $websiteId = null)
    {
        if (!$websiteId) {
            $websiteId = $this->_storeManager->getStore()->getWebsite()->getId();
        }

        if ($alert->getCustomerId()) {
            try {
                $customer = $this->customerRepository->getById(
                    $alert->getCustomerId()
                );
            } catch (NoSuchEntityException $noSuchEntityException) {
                return null;
            }
        } else {
            try {
                $customer = $this->customerRepository->get(
                    $alert->getEmail(),
                    $websiteId
                );
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $customer = $this->customerFactory->create()->getDataModel();
                $customer->setWebsiteId(
                    $websiteId
                )->setEmail(
                    $alert->getEmail()
                )->setLastname(
                    $this->helper->getModuleConfig('general/customer_name')
                )->setGroupId(
                    0
                )->setId(
                    0
                );
            }
        }

        $customer->setStoreId($alert->getStoreId());

        return $customer;
    }

    /**
     * @param $alert
     * @throws LocalizedException
     */
    public function sendTestNotification($alert)
    {
        $emailAddress = $this->helper->getModuleConfig('general/test_notification_email');
        if (!$emailAddress) {
            throw new LocalizedException(
                __(
                    'Please specify email address: Store -> Configuration -> '
                    . 'Amasty Out of Stock Notification -> Test Stock Notification'
                )
            );
        }
        $alert->setCustomerId(null)->setEmail($emailAddress);

        /** @var \Magento\ProductAlert\Model\Email  $email */
        $email = $this->_emailFactory->create();
        $email->setType('stock');

        $websiteId = $alert->getWebsiteId();
        $websiteId = explode(',', $websiteId);
        $websiteId = $websiteId[0];

        $website = $this->_storeManager->getWebsite($websiteId);
        $storeId = $alert->getStoreId() ? $alert->getStoreId() : $website->getDefaultStore()->getId();
        $email->setWebsite($website);
        if (!$this->_scopeConfig->getValue(
            'catalog/productalert/allow_stock',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $website->getDefaultGroup()->getDefaultStore()->getId()
        )) {
            throw new LocalizedException(
                __(
                    'Please enable stock notifications: Store -> Configuration -> Catalog -> '
                    . 'Catalog -> Test Stock Notification'
                )
            );
        }

        $this->appEmulation->startEnvironmentEmulation($storeId, 'frontend', true);

        $productId = $alert->getProductId();
        if ($alert->getParentId()
            && $alert->getParentId() != $productId
        ) {
            $productId = $alert->getParentId();
        }

        try {
            $product = $this->productRepository->getById(
                $productId,
                false,
                $storeId
            );
        } catch (\Magento\Framework\Exception\NoSuchEntityException $ex) {
            throw new LocalizedException(
                __(
                    'Can`t load product with id: %1',
                    $alert->getProductId()
                )
            );
        }

        $email->addStockProduct($product);
        $customer = $this->getCustomerFromAlert($alert, $websiteId);
        $email->setCustomerData($customer);
        if (!$customer->getId()) {
            $this->saveTemporaryEmail($customer->getEmail());
        }

        $this->registry->register('xnotif_test_notification', true);
        $email->send();
        $this->registry->unregister('xnotif_test_notification');
        $this->appEmulation->stopEnvironmentEmulation();
    }

    /**
     * Save guest email for current iteration
     * @param string $email
     */
    private function saveTemporaryEmail($email)
    {
        $this->deleteTemporaryEmail();
        $this->registry->register(
            'amxnotif_data',
            [
                'guest' => 1,
                'email' => $email
            ]
        );
    }

    private function deleteTemporaryEmail()
    {
        $this->registry->unregister('amxnotif_data');
    }

    /**
     * @param Product $product
     * @return array|\Magento\Catalog\Api\Data\ProductInterface[]
     */
    private function getUsedProducts(Product $product)
    {
        $result = [];
        switch ($product->getTypeId()) {
            case Configurable::TYPE_CODE:
                $result = $this->configurableType->getUsedProducts($product);
                break;
            case Grouped::TYPE_CODE:
                $result = $product->getTypeInstance(true)->getAssociatedProducts($product);
                break;
            case BundleType::TYPE_CODE:
                $result = $product->getTypeInstance(true)->getSelectionsCollection(
                    $product->getTypeInstance(true)->getOptionsIds($product),
                    $product
                );
                break;
        }

        return $result;
    }
}
