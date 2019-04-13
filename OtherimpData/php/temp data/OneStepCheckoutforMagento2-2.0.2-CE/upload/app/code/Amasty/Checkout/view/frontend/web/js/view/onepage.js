define(
    [
        'jquery',
        'underscore',
        'uiComponent',
        'ko',
        'uiRegistry',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Amasty_Checkout/js/model/payment-validators/shipping-validator',
        'Magento_Checkout/js/action/select-billing-address'
    ],
    function (
        $,
        _,
        Component,
        ko,
        registry,
        quote,
        paymentValidatorRegistry,
        shippingValidator,
        selectBillingAddress
    ) {
        'use strict';

        return Component.extend({
            defaults: {
                modules: {
                    shippingComponent: 'checkout.steps.shipping-step.shippingAddress'
                }
            },

            initObservable: function () {
                this._super();

                quote.shippingAddress.subscribe(this.shippingAddressObserver.bind(this));

                if (!quote.isVirtual()) {
                    paymentValidatorRegistry.registerValidator(shippingValidator);
                }
                registry.get('checkout.steps.billing-step.payment', function (component) {
                    //initialize payment information
                    component.isVisible(true);
                    component.navigate();
                }.bind(this));

                return this;
            },

            shippingAddressObserver: function (address) {
                if (!address) {
                    return;
                }
                if (_.isNull(address.street) || _.isUndefined(address.street)) {
                    // fix: some payments (paypal) takes street.0 without checking
                    address.street = [];
                }

                // fix default "My billing and shipping address are the same" checkbox behaviour
                var methodComponent = registry.get('checkout.steps.billing-step.payment.afterMethods.billing-address-form');
                if (methodComponent && !methodComponent.isAddressSameAsShipping()) {
                    return;
                }
                var paymentMethod = quote.paymentMethod();
                if (!paymentMethod || methodComponent) {
                    selectBillingAddress(address);
                } else {
                    methodComponent = registry.get('checkout.steps.billing-step.payment.payments-list.'+quote.paymentMethod().method+'-form');
                    if (!methodComponent || methodComponent.isAddressSameAsShipping()) {
                        selectBillingAddress(address);
                    }
                }
            },

            /**
             * Used in templates
             *
             * @param {string} name
             * @returns {observable}
             */
            requestComponent: function (name) {
                var observable = ko.observable();

                registry.get(name, function (summary) {
                    observable(summary);
                }.bind(this));
                return observable;
            }
        });
    }
);
