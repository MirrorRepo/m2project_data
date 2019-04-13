<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model\Adminhtml\Source;

class Mode
{
    const TEST = 'test';
    const LIVE = 'live';

    public function toOptionArray()
    {
        return [
            [
                'value' => Mode::TEST,
                'label' => __('Test')
            ],
            [
                'value' => Mode::LIVE,
                'label' => __('Live')
            ],
        ];
    }
}
