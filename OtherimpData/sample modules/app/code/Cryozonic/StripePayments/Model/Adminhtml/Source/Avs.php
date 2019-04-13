<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model\Adminhtml\Source;

class Avs
{
    public function toOptionArray()
    {
        return [
            [
                'value' => false,
                'label' => __('Disabled')
            ],
            [
                'value' => true,
                'label' => __('Enabled')
            ],
        ];
    }
}
