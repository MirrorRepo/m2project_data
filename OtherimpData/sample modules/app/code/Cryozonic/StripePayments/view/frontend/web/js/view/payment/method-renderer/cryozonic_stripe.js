// Copyright © Cryozonic Ltd. All rights reserved.
//
// @package    Cryozonic_StripePayments
// @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
// @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
define(
    [
        'ko',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Ui/js/model/messageList',
        'Magento_Checkout/js/model/quote',
        'Magento_Customer/js/model/customer',
        'Cryozonic_StripePayments/js/action/get-payment-url',
        'mage/translate',
        'mage/url',
        'jquery',
    ],
    function (
        ko,
        Component,
        globalMessageList,
        quote,
        customer,
        getPaymentUrlAction,
        $t,
        url,
        $
    ) {
        'use strict';

        return Component.extend({
            externalRedirectUrl: null,
            defaults: {
                template: 'Cryozonic_StripePayments/payment/form',
                cryozonicStripeCardSave: true,
                cryozonicStripeShowApplePaySection: false,
                cryozonicApplePayToken: null
            },

            initObservable: function ()
            {
                this._super()
                    .observe([
                        'cryozonicStripeError',
                        'cryozonicStripeCardName',
                        'cryozonicStripeCardNumber',
                        'cryozonicStripeCardExpMonth',
                        'cryozonicStripeCardExpYear',
                        'cryozonicStripeCardVerificationNumber',
                        'cryozonicStripeJsToken',
                        'cryozonicApplePayToken',
                        'cryozonicStripeCardSave',
                        'cryozonicStripeSelectedCard',
                        'cryozonicStripeShowNewCardSection',
                        'cryozonicStripeShowApplePaySection',
                        'cryozonicApplePayToken',
                        'cryozonicCreatingToken',
                        'isPaymentRequestAPISupported'
                    ]);

                this.cryozonicStripeSelectedCard.subscribe(this.onSelectedCardChanged, this);
                this.cryozonicStripeSelectedCard('new_card');
                if (!this.hasSavedCards())
                    this.cryozonicStripeShowNewCardSection(true);

                this.showSavedCardsSection = ko.computed(function()
                {
                    return this.hasSavedCards() && this.isBillingAddressSet() && !this.cryozonicApplePayToken();
                }, this);

                this.showNewCardSection = ko.computed(function()
                {
                    return this.cryozonicStripeShowNewCardSection() &&
                        this.isBillingAddressSet() &&
                        !this.cryozonicApplePayToken();
                }, this);

                this.showSaveCardOption = ko.computed(function()
                {
                    return this.config().showSaveCardOption && customer.isLoggedIn() && (this.showNewCardSection() || this.cryozonicApplePayToken());
                }, this);

                this.securityMethod = this.config().securityMethod;

                cryozonic.checkoutPaymentForm = this;
                cryozonic.params3DSecure = this.config().params3DSecure;

                quote.billingAddress.subscribe(function (address)
                {
                    cryozonic.paramsApplePay = this.getApplePayParams();
                    cryozonic.setAVSFieldsFrom(address);

                    if (cryozonic.stripeJsV3)
                        cryozonic.initPaymentRequestButton();
                }
                , this);

                return this;
            },

            hasSavedCards: function()
            {
                return (typeof this.config().savedCards != 'undefined'
                    && this.config().savedCards != null
                    && this.config().savedCards.length);
            },

            onSelectedCardChanged: function(newValue)
            {
                if (newValue == 'new_card')
                    this.cryozonicStripeShowNewCardSection(true);
                else
                    this.cryozonicStripeShowNewCardSection(false);
            },

            onCheckoutFormRendered: function()
            {
                var self = cryozonic.checkoutPaymentForm;
                if (self.config().securityMethod > 0)
                    initStripe(self.config().stripeJsKey, self.config().securityMethod);
            },

            isBillingAddressSet: function()
            {
                return quote.billingAddress() && quote.billingAddress().canUseForBilling();
            },

            onStripeInit: function(err)
            {
                if (err)
                {
                    this.cryozonicStripeError(err);
                    return this.showError(this.maskError(err));
                }
                else
                    this.cryozonicStripeError(null);
            },

            isPlaceOrderEnabled: function()
            {
                if (this.cryozonicStripeError())
                    return false;

                if (this.cryozonicCreatingToken())
                    return false;

                if (this.isBillingAddressSet())
                    cryozonic.setAVSFieldsFrom(quote.billingAddress());

                return this.isBillingAddressSet();
            },

            isZeroDecimal: function(currency)
            {
                var currencies = ['bif', 'djf', 'jpy', 'krw', 'pyg', 'vnd', 'xaf',
                    'xpf', 'clp', 'gnf', 'kmf', 'mga', 'rwf', 'vuv', 'xof'];

                return currencies.indexOf(currency) >= 0;
            },

            isApplePayEnabled: function()
            {
                return this.config().isApplePayEnabled;
            },

            getApplePayParams: function()
            {
                if (!this.isApplePayEnabled())
                    return null;

                if (!this.isBillingAddressSet())
                    return null;

                var amount, currency;
                if (this.config().useStoreCurrency)
                {
                    currency = quote.totals().quote_currency_code;
                    amount = quote.totals().grand_total + quote.totals().tax_amount;
                }
                else
                {
                    currency = quote.totals().base_currency_code;
                    amount = quote.totals().base_grand_total;
                }

                currency = currency.toLowerCase();

                var cents = 100;
                if (this.isZeroDecimal(currency))
                    cents = 1;

                amount = Math.round(amount * cents);

                var description = quote.billingAddress().firstname + " " + quote.billingAddress().lastname;

                if (typeof customer.customerData.email != 'undefined')
                    description += " <" + customer.customerData.email + ">";

                return {
                    "country": quote.billingAddress().countryId,
                    "currency": currency,
                    "total": {
                        "label": description,
                        "amount": amount
                    }
                };
            },

            beginApplePay: function()
            {
                var self = this;
                var paymentRequest = this.getApplePayParams();
                var session = Stripe.applePay.buildSession(paymentRequest, function(result, completion)
                {
                    self.setApplePayToken(result.token);
                    self.cryozonicStripeJsToken(result.token.id + ':' + result.token.card.brand + ':' + result.token.card.last4);
                    completion(ApplePaySession.STATUS_SUCCESS);
                },
                function(error)
                {
                    alert(error.message);
                });

                session.begin();
            },

            setApplePayToken: function(token)
            {
                this.cryozonicApplePayToken(token);
                this.cryozonicStripeShowApplePaySection(false);
            },

            resetApplePay: function()
            {
                this.cryozonicApplePayToken(null);
                this.cryozonicStripeShowApplePaySection(true);
                this.cryozonicStripeJsToken(null);
            },

            showApplePaySection: function()
            {
                return this.cryozonicStripeShowApplePaySection || this.isPaymentRequestAPISupported;
            },

            showApplePayButton: function()
            {
                return !this.isPaymentRequestAPISupported;
            },

            config: function()
            {
                return window.checkoutConfig.payment[this.getCode()];
            },

            isActive: function(parents)
            {
                return true;
            },

            isNewCard: function()
            {
                if (!this.hasSavedCards()) return true;
                if (this.cryozonicStripeSelectedCard() == 'new_card') return true;
                return false;
            },

            maskError: function(err)
            {
                return cryozonic.maskError(err);
            },

            stripeJsPlaceOrder: function()
            {
                if (this.cryozonicApplePayToken())
                {
                    this.placeOrder();
                }
                else if (this.config().securityMethod > 0)
                {
                    var self = this;

                    this.cryozonicStripeJsToken(null);
                    this.cryozonicCreatingToken(true);
                    cryozonic.setAVSFieldsFrom(quote, customer);

                    createStripeToken(function(err, token, response)
                    {
                        self.cryozonicCreatingToken(false);
                        if (err)
                        {
                            return self.showError(self.maskError(err));
                        }
                        else
                        {
                            self.cryozonicStripeJsToken(token);
                            if (self.shouldUse3DSecure(response))
                                self.redirectAfterPlaceOrder = false;
                            self.placeOrder();
                        }
                    });
                }
                else
                    this.placeOrder();

            },
            shouldUse3DSecure: function(response)
            {
                if (!cryozonic.is3DSecureEnabled())
                    return false;

                // if (!response)
                //     return false;

                // if (typeof response.card == 'undefined')
                //     return false;

                // if (typeof response.card.three_d_secure == 'undefined')
                //     return false;

                // if (response.card.three_d_secure == 'required')
                //     return true;

                // if (response.card.three_d_secure == 'optional' && this.config().three_d_secure == 2)
                //     return true;

                return true;
            },
            redirect3DSecure: function(proceedCallback)
            {
                getPaymentUrlAction(this.messageContainer)
                    .done(function (response) {
                        if (response.length > 0)
                            window.location.replace(response);
                        else
                            proceedCallback();
                    })
                    .error(function () {
                        globalMessageList.addErrorMessage({
                            message: $t('An error occurred on the server. Please try to place the order again.')
                        });
                    });
            },

            showError: function(message)
            {
                document.getElementById('checkout').scrollIntoView(true);
                globalMessageList.addErrorMessage({ "message": message });
            },

            afterPlaceOrder: function()
            {
                if (this.redirectAfterPlaceOrder)
                    return;

                this.redirect3DSecure(function(){
                    window.location.replace(url.build('checkout/onepage/success/'));
                });
            },

            validate: function(elm)
            {
                if (this.cryozonicApplePayToken)
                    return true;

                // @todo Replace these with proper form validation
                var data = this.getData().additional_data;

                if (this.isNewCard())
                {
                    if (this.config().securityMethod > 0)
                    {
                        if (!this.cryozonicStripeJsToken())
                            return this.showError('Could not process card details, please try again.');
                    }
                    else
                    {
                        if (!data.cc_owner) return this.showError('Please enter the cardholder name');
                        if (!data.cc_number) return this.showError('Please enter your card number');
                        if (!data.cc_exp_month) return this.showError('Please enter your card\'s expiration month');
                        if (!data.cc_exp_year) return this.showError('Please enter your card\'s expiration year');
                        if (!data.cc_cid) return this.showError('Please enter your card\'s security code (CVN)');
                    }
                }
                else if (!this.cryozonicStripeSelectedCard() || this.cryozonicStripeSelectedCard().indexOf('card_') !== 0)
                    return this.showError('Please select a card!');

                return true;
            },

            getCode: function()
            {
                return 'cryozonic_stripe';
            },

            shouldSaveCard: function()
            {
                return ((this.showSaveCardOption() && this.cryozonicStripeCardSave()) || this.config().alwaysSaveCard);
            },

            getData: function()
            {
                var data = {
                    'method': this.item.method
                };

                if (this.cryozonicStripeSelectedCard() && this.cryozonicStripeSelectedCard() != 'new_card')
                {
                    data.additional_data = {
                        'cc_saved': this.cryozonicStripeSelectedCard()
                    };
                }
                else if (this.config().securityMethod >= 1)
                {
                    data.additional_data = {
                        'cc_stripejs_token': this.cryozonicStripeJsToken(),
                        'cc_save': this.shouldSaveCard()
                    };
                }
                else
                {
                    data.additional_data = {
                        'cc_owner': this.cryozonicStripeCardName(),
                        'cc_number': this.cryozonicStripeCardNumber(),
                        'cc_exp_month': this.cryozonicStripeCardExpMonth(),
                        'cc_exp_year': this.cryozonicStripeCardExpYear(),
                        'cc_cid': this.cryozonicStripeCardVerificationNumber(),
                        'cc_save': this.shouldSaveCard()
                    };
                }

                return data;
            },

            getCcMonthsValues: function() {
                return $.map(this.getCcMonths(), function(value, key) {
                    return {
                        'value': key,
                        'month': value
                    };
                });
            },

            getCcYearsValues: function() {
                return $.map(this.getCcYears(), function(value, key) {
                    return {
                        'value': key,
                        'year': value
                    };
                });
            },

            getCcMonths: function()
            {
                return window.checkoutConfig.payment[this.getCode()].months;
            },

            getCcYears: function()
            {
                return window.checkoutConfig.payment[this.getCode()].years;
            },

            getCvvImageUrl: function() {
                return window.checkoutConfig.payment[this.getCode()].cvvImageUrl;
            },

            getCvvImageHtml: function() {
                return '<img src="' + this.getCvvImageUrl() +
                    '" alt="' + 'Card Verification Number Visual Reference' +
                    '" title="' + 'Card Verification Number Visual Reference' +
                    '" />';
            }
        });
    }
);
