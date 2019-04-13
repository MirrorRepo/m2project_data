<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model\Adminhtml\Source;

class Enabled
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => false,
                'label' => __('Disabled')
            ),
            array(
                'value' => true,
                'label' => __('Enabled')
            )
        );
    }
}
