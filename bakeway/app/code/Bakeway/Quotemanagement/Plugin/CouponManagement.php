<?php
/**
 * Bakeway
 *
 * @category  Bakeway
 * @package   Bakeway_CustomAttributes
 * @author    Bakeway
 */

namespace Bakeway\Quotemanagement\Plugin;

use Bakeway\Quotemanagement\Helper\Data as QuotemanagementHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

class CouponManagement
{
    /**
     * @var QuotemanagementHelper
     */
    protected $helper;

    /**
     * @param QuotemanagementHelper $helper
     */
    public function __construct(
        QuotemanagementHelper $helper
    )
    {
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Quote\Model\CouponManagement $subject
     * @param int $cartId The cart ID.
     * @param string $couponCode The coupon code data.
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     * @throws \Magento\Framework\Exception\CouldNotSaveException The specified coupon could not be added.
     */
    public function beforeSet(
        \Magento\Quote\Model\CouponManagement $subject,
        $cartId,
        $couponCode
    ) 
    {
        $iPod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
        /*preg_match("/iPhone|Android|iPad|iPod|webOS/", $_SERVER['HTTP_USER_AGENT'], $matches);
        $os = current($matches);*/

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/coupon.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('------------------- Check Coupon  ---------------');
        $logger->info('Coupon Code : '. strtolower($couponCode));
        if(strtolower($couponCode) === "ny200")
        {
            if(isset($_REQUEST["from_app"]))
                $logger->info('Coupon Code : '. $_REQUEST["from_app"]);

            if(isset($_REQUEST["from_app"]) && $_REQUEST["from_app"] == "true")
            {
                if($iPad || $iPhone || $iPod || $android)
                {
                    return array($cartId, $couponCode);
                }
                else
                {
                    throw new NoSuchEntityException(__('Coupon code is only applicable from our app.'));
                }
            }
            else
            {
                throw new NoSuchEntityException(__('Coupon code is only applicable from our app.'));
            }
        }
        return array($cartId, $couponCode);
    }
}