<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Exception;

class WebhookException extends \Magento\Framework\Exception\LocalizedException
{
    public $statusCode;

    public function __construct($msg, $statusCode = 400)
    {
        $this->statusCode = $statusCode;
        if (is_string($msg))
            parent::__construct(__($msg));
        else
            parent::__construct($msg);
    }

}