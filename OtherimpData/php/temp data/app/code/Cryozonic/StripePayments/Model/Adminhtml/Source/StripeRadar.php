<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model\Adminhtml\Source;

class StripeRadar
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 0,
                'label' => __('Disabled')
            ),
            array(
                'value' => 10,
                'label' => __('Enabled')
            )
        );
    }
}
