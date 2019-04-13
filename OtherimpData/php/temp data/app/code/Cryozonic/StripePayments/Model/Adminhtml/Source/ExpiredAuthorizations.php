<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model\Adminhtml\Source;

class ExpiredAuthorizations
{
    public function toOptionArray()
    {
        return [
            [
                'value' => 0,
                'label' => __('Warn admin and don\'t capture')
            ],
            [
                'value' => 1,
                'label' => __('Try to re-create the charge with a saved card')
            ],
        ];
    }
}
