define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (Component, customerData) {
    // 'use strict';

    return Component.extend({
        initialize: function () {
            this._super();
            // customerData.reload(['gtm-cart']);
            customerData.get('gtm-cart').subscribe(function(newValue){
                console.log(newValue);
            });
        }
    });
});