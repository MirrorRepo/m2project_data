<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Model\Adminhtml\Source;

class CcType
{
    public function toOptionArray()
    {
        $options = [
          [
            'value' => 'visa',
            'label' => 'Visa',
            'order' => 10,
          ],
          [
            'value' => 'mastercard',
            'label' => 'MasterCard',
            'order' => 20,
          ],
          [
            'value' => 'amex',
            'label' => 'American Express',
            'order' => 30,
          ],
          [
            'value' => 'jcb',
            'label' => 'JCB',
            'order' => 40,
          ],
          [
            'value' => 'discover',
            'label' => 'Discover',
            'order' => 50,
          ],
          [
            'value' => 'diners',
            'label' => 'Diners',
            'order' => 60,
          ]
        ];

        return $options;
    }
}
