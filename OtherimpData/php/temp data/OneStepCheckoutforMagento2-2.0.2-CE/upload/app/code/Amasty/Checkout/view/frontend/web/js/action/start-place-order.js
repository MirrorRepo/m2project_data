define(
    [
        'jquery',
        'underscore'
    ],
    function ($, _) {
        'use strict';

        return function (selector) {
            if (selector) {
                $(selector).click();
            } else {
                var toolBar = $('.payment-method._active .actions-toolbar');
                if (toolBar.length > 1) {
                    _.each(toolBar, function (element) {
                        if (element.style.display !== 'none') {
                            toolBar = $(element);
                            return; //break
                        }
                    })
                }
                toolBar.find('.action.primary').click();
            }
        };
    }
);
