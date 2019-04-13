define(
    [
        'jquery',
        'mage/utils/wrapper',
        'Amasty_Checkout/js/action/focus-first-error',
        'Amasty_Checkout/js/action/start-place-order',
        'Magento_Checkout/js/action/set-shipping-information',
        'Magento_Checkout/js/model/quote'
    ],
    function ($, wrapper, focusFirstError, startOrderPlace, saveShipping, quote) {
        'use strict';

        return function (target) {
            var isShippingSaveAllowed = !quote.isVirtual();
            /**
             * Focus first error after validation
             * and save shipping information
             */
            target.validate = wrapper.wrapSuper(target.validate, function () {
                var result = this._super();
                if (!result) {
                    isShippingSaveAllowed = !quote.isVirtual();
                    focusFirstError();
                } else if (isShippingSaveAllowed) {
                    isShippingSaveAllowed = false;
                    // save shipping information because of extensions which can mixin on shipping save
                    // but Amasty checkout don't need this, we have dynamically saving
                    saveShipping().always(function () {
                        startOrderPlace();
                    });
                    return false;
                }

                return result;
            });

            return target;
        };
    }
);
