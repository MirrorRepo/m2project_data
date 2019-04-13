define(
    [
        'knockout',
        'mage/utils/wrapper'
    ],
    function (ko, wrapper) {
        'use strict';

        return function (target) {
            /**
             * Override isVisible to isActive function;
             * because in onestepcheckout all steps should be visible
             */
            target.registerStep = wrapper.wrapSuper(target.registerStep, function (code, alias, title, isVisible, navigate, sortOrder) {
                var isActive = ko.observable(isVisible());
                this._super(code, alias, title, isActive, navigate, sortOrder);
            });

            /**
             * Override for avoid hash in url
             */
            target.next =  wrapper.wrapSuper(target.next, function() {
                var activeIndex = 0;
                this.steps.sort(this.sortItems).forEach(function(element, index) {
                    if (element.isVisible()) {
                        element.isVisible(false);
                        activeIndex = index;
                    }
                });
                if (this.steps().length > activeIndex + 1) {
                    this.steps()[activeIndex + 1].isVisible(true);
                }
            });

            return target;
        };
    }
);

