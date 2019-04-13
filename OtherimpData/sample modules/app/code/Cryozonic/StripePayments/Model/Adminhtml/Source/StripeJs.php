<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model\Adminhtml\Source;

class StripeJs
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 0,
                'label' => __('None')
            ),
            array(
                'value' => 1,
                'label' => __('Stripe.js v2')
            ),
            array(
                'value' => 2,
                'label' => __('Stripe.js v3 + Stripe Elements')
            ),
        );
    }
}
