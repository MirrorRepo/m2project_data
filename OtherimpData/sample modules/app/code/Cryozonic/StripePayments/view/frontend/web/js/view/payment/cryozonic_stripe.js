// Copyright © Cryozonic Ltd. All rights reserved.
//
// @package    Cryozonic_StripePayments
// @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
// @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)

define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'cryozonic_stripe',
                component: 'Cryozonic_StripePayments/js/view/payment/method-renderer/cryozonic_stripe'
            }
        );
        // Add view logic here if needed
        return Component.extend({});
    }
);
