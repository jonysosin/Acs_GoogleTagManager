/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/*global define,alert*/
define(
    [
        'Magento_Customer/js/customer-data',
        'ko'
    ],
    function (customerData, ko) {
        'use strict';

        return {
            placeOrder: ko.observable(),

            _buildProductsItemCheckout: function (cart) {
                var products = [];

                if (cart.items) {
                    cart.items.forEach(function (item, i) {
                        products.push(item.gtm);
                    });
                }

                return products;
            },

            _buildCheckoutStep: function (data, step) {
                return {
                    'ecommerce': {
                        'checkout': {
                            'actionField': {'step': step},
                            'products': this._buildProductsItemCheckout(data)
                        }
                    },
                    'event': 'checkout' + step
                };
            },

            onAddToCart: function (products) {
                this.push({
                    'ecommerce': {
                        'add': {
                            'products': [products]
                        }
                    },
                    'event': 'addToCart'
                });
            },

            onBeforePlaceOrder: function () {
                var self = this;
                customerData.reload(['cart']).done(function (response) {
                    self.placeOrder(response.cart);
                });
            },

            onPlaceOrder: function () {
                this.push(this._buildCheckoutStep(this.placeOrder(), 3));
            },

            onLoadCheckout: function (data) {
                this.push(this._buildCheckoutStep(data.cart, 1));
            },

            onSuccessCheckout: function (actionField) {
                this.push({
                    'ecommerce': {
                        'purchase': actionField
                    },
                    'event': 'purchase'
                });
            },

            onShippingSubmit: function () {
                var self = this;
                customerData.reload(['cart']).done(function (response) {
                    self.push(self._buildCheckoutStep(response.cart, 2));
                });
            },

            push: function (data) {
                console.log(data);
                dataLayer.push(data);
            }
        };
    }
);
