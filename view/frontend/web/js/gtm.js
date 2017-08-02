define([
    'jquery',
    'Magento_Customer/js/customer-data',
    'gtmDatalayer'
], function ($, customerData, gtmDatalayer) {
    var Gtm = {
        options: {
            lastOrder: ''
        },

        bindAddToCart: function () {
            customerData.get('gtm-cart').subscribe(function (gtmData) {
                if (gtmData.products) {
                    gtmDatalayer.onAddToCart(gtmData.products);
                }
            });
            customerData.reload(['gtm-cart']);
        },

        bindLoadCheckout: function () {
            var isCheckout = document.querySelector('body').classList.contains('checkout-index-index');
            if (isCheckout) {
                customerData.reload(['cart']).done(function (cart) {
                    gtmDatalayer.onLoadCheckout(cart);
                });
            }
        },

        bindCheckoutSuccess: function () {
            var isCheckoutSucces = document.querySelector('body').classList.contains('checkout-onepage-success');
            if (isCheckoutSucces) {
                gtmDatalayer.onSuccessCheckout(this.lastOrder);
            }
        },

        prepareBindings: function () {
            this.bindAddToCart();
            this.bindLoadCheckout();
            this.bindCheckoutSuccess();
        },

        init: function () {
            if ((typeof(gtmEnable) != 'undefined') && (gtmEnable === true)) {
                if ((typeof(lastOrder) != 'undefined')) {
                    this.lastOrder = lastOrder;
                }
                this.prepareBindings();
            }
        },

        push: function (data) {
            dataLayer.push(data);
        }
    };

    return function (config) {
        Gtm.init(config);
    }
});
