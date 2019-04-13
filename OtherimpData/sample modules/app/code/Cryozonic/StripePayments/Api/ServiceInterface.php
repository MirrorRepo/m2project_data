<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Api;

interface ServiceInterface
{
    /**
     * Returns Redirect Url
     *
     * @api
     * @return string Redirect Url
     */
    public function redirect_url();
}
