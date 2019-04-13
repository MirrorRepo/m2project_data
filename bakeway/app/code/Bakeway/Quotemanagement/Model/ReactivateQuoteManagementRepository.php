<?php

namespace Bakeway\Quotemanagement\Model;

use Bakeway\Quotemanagement\Api\ReactivateQuoteManagementRepositoryInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\GuestCartRepositoryInterface;
use Magento\Quote\Api\GuestCartManagementInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Api\CartManagementInterface;
use Bakeway\Razorpay\Api\PaymentgatewayRepositoryInterface as RazorpayInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Quote\Model\Quote;
use Magento\Store\Model\StoreManagerInterface;

class ReactivateQuoteManagementRepository implements ReactivateQuoteManagementRepositoryInterface
{
    /**
     * @var CartManagementInterface
     */
    protected $cartManagementInterface;

    /**
     * @var GuestCartManagementInterface
     */
    protected $guestCartManagementInterface;

    /**
     * @var QuoteFactory
     */
    protected $quoteFactory;
    
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var GuestCartRepositoryInterface
     */
    protected $guestCartRepository;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * QuoteOrderManagementRepository constructor.
     * @param GuestCartManagementInterface $guestCartManagementInterface
     * @param CartManagementInterface $cartManagementInterface
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param GuestCartRepositoryInterface $guestCartRepository
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        GuestCartManagementInterface $guestCartManagementInterface,
        CartManagementInterface $cartManagementInterface,
        CartRepositoryInterface $quoteRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        GuestCartRepositoryInterface $guestCartRepository,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        StoreManagerInterface $storeManager,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->guestCartManagementInterface = $guestCartManagementInterface;
        $this->cartManagementInterface = $cartManagementInterface;
        $this->quoteRepository = $quoteRepository;
        $this->customerRepository = $customerRepository;
        $this->guestCartRepository = $guestCartRepository;
        $this->orderRepository = $orderRepository;
        $this->quoteFactory = $quoteFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @api
     * @param int $customerId
     * @param int $cartId
     * @param int $reactivateQuote
     * @return array
     * @throws \Magento\Framework\Exception\NotFoundException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function reactivateQuote($customerId, $cartId, $reactivateQuote) 
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/payQuote.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $response = array();

        $logger->info("=============== Code to reactivate quote for registered customer ===============");
        $logger->info("=============== Request Customer : ".$customerId." ===============");
        $logger->info("=============== Request Cart Id : ".$cartId." ===============");
        $logger->info("=============== Request Activate Quote? : ".$reactivateQuote." ===============");

        if(isset($reactivateQuote) && $reactivateQuote == 1)
        {
            $quote = $this->quoteFactory->create();
            $quote->setStoreId($this->storeManager->getStore()->getId());
            $quote->load($cartId);

            //$quote = $this->quoteRepository->getForCustomer($customerId);
            if (!$quote->getIsActive())
            {
                $logger->info("=============== Quote : ".$quote->getData('entity_id')." is not active ===============");
                if (($quote->getId()) && $cartId == $quote->getId()) 
                {
                    try 
                    {
                        $quote->setIsActive(1)->setReservedOrderId(null)->save();
                        $response["success"] = true;
                        $logger->info("=============== Reactivated Quote : ".$quote->getData('entity_id')." ===============");
                        return $response;
                    } 
                    catch (\Exception $e) 
                    {
                        $logger->info("=============== Exception : ".$e->getMessage()." ===============");
                        throw new LocalizedException(__("'Unable to reactivate quote."));
                    }
                }
                else
                {
                    $logger->info("=============== Error : ".$quote->getData('entity_id')." Requested cartId not matching ===============");
                    throw new LocalizedException(__("Active cartId not matching with requested cartId"));
                }
            }
            else
            {
                $logger->info("=============== Quote : ".$quote->getData('entity_id')." is already active ===============");
                $response["success"] = false;
                return $response;
            }
        }
        else
        {
            $logger->info("No need to reactiveate Quote: ".$cartId);
            $response["success"] = false;
            return $response;
        }
    }

    /**
     * @api
     * @param string $cartId
     * @param int $reactivateQuote
     * @return int
     * @throws \Magento\Framework\Exception\NotFoundException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function reactivateGuestQuote($cartId, $reactivateQuote) 
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/payQuote.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $response = array();

        $logger->info("=============== Code to reactivate quote for guest customer ===============");
        $logger->info("=============== Request Cart Id : ".$cartId." ===============");
        $logger->info("=============== Request Activate Quote? : ".$reactivateQuote." ===============");

        if(isset($reactivateQuote) && $reactivateQuote == 1)
        {
            $quote = $this->guestCartRepository->get($cartId);

            //$quote = $this->quoteRepository->get($cartId);
            if (!$quote->getIsActive())
            {
                $logger->info("=============== Quote : ".$quote->getData('entity_id')." is not active ===============");

                if ($quote->getId()) 
                {
                    try 
                    {
                        $quote->setIsActive(1)->setReservedOrderId(null)->save();
                        $response["success"] = true;
                        $logger->info("=============== Reactivated Quote : ".$quote->getData('entity_id')." ===============");
                        return $response;
                    } 
                    catch (\Exception $e) 
                    {
                        $logger->info("=============== Exception : ".$e->getMessage()." ===============");
                        throw new LocalizedException(__("'Unable to reactivate quote."));
                    }
                }
                else
                {
                    $logger->info("=============== Error : ".$quote->getData('entity_id')." Requested cartId not matching ===============");
                    throw new LocalizedException(__("Active cartId not matching with requested cartId"));
                }
            }
            else
            {
                $logger->info("=============== Quote : ".$quote->getData('entity_id')." is already active ===============");
                $response["success"] = false;
                return $response;
            }
        }
        else
        {
            $logger->info("No need to reactiveate Quote: ".$cartId);
            $response["success"] = false;
            return $response;
        }
    }
}