<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model;

use Cryozonic\StripePayments\Api\ServiceInterface;
use Cryozonic\StripePayments\Helper\Logger;

class Service implements ServiceInterface
{
    /**
     * @var \Magento\Checkout\Helper\Data
     */
    private $checkoutHelper;

    /**
     * Constructor
     * @param \Magento\Checkout\Helper\Data $checkoutHelper
     */
    public function __construct(
        \Magento\Checkout\Helper\Data $checkoutHelper
    ) {

        $this->checkoutHelper = $checkoutHelper;
    }

	/**
	 * Return URL
	 * @return string
	 */
    public function redirect_url()
    {
        return $this->checkoutHelper->getCheckout()->getStripePaymentsRedirectUrl();
    }
}
