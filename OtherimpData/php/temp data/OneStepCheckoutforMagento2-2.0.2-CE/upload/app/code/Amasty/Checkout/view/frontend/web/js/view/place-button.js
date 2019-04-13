define(
    [
        'jquery',
        'uiComponent',
        'uiRegistry',
        'Magento_Checkout/js/model/quote',
        'Amasty_Checkout/js/action/start-place-order',
        'Amasty_Checkout/js/model/amalert',
        'mage/translate'
    ],
    function (
        $,
        Component,
        registry,
        quote,
        startPlaceOrderAction,
        alert,
        $t
    ) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Amasty_Checkout/onepage/place-order',
                defaultLabel: $t('Place Order')
            },
            initObservable: function () {
                this._super().observe({
                    label: this.defaultLabel,
                    isPlaceOrderActionAllowed: false
                });
                quote.paymentMethod.subscribe(this.updateLabel.bind(this));
                if (quote.paymentMethod()) {
                    this.updateLabel(quote.paymentMethod());
                }

                return this;
            },

            updateLabel: function(payment) {
                this.isPlaceOrderActionAllowed(!!payment);
                if (payment) {
                    // selected payment is don't have class `_active` yet
                    var button = jQuery('#' + payment.method).parents('.payment-method')
                        .find('.actions-toolbar:not([style*="display: none"]) .action.primary');
                    if (button.length) {
                        if (button.text()) {
                            this.label(button.text());
                            return;
                        }
                        if (button.attr('title')) {
                            this.label(button.attr('title'));
                            return;
                        }
                    }
                }

                this.label(this.defaultLabel);
            },

            placeOrder: function () {
                if (!quote.paymentMethod()) {
                    var errorMessage = 'No payment method selected';
                    alert({content: $t(errorMessage)});
                    return;
                }

                startPlaceOrderAction();
            }
        });
    }
);