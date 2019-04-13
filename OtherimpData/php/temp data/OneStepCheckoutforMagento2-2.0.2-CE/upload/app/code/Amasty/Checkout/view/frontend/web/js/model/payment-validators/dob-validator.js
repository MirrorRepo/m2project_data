
define([
    'uiRegistry'
], function (registry) {
    'use strict';

    return {
        /**
         * Validate Date of Birth if available
         *
         * @returns {Boolean}
         */
        validate: function () {
            var amastyDob = registry.get('checkout.sidebar.additional.date_of_birth'),
                amastyCreateAcc = registry.get('checkout.sidebar.additional.register');
            if (amastyCreateAcc && amastyCreateAcc.visible() && amastyCreateAcc.checked() && amastyDob) {
                var validate = amastyDob.validate();
                if (validate == false) {
                    return false;
                }
                return validate.valid;
            }

            return true;
        }
    };
});
