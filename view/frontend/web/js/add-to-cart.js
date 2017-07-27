define([
    'jquery',
    'jquery/ui',
    "domReady!",
    'mage/validation/validation'
], function($){

    $.widget('gtm.validation', $.mage.validation, {
        _init: function () {
            this._super();
            this.bindAddToCartButton(this.element);
        },
        
        bindAddToCartButton: function (form) {
            form.find('#product-addtocart-button').click(function () {
                debugger;
            })
        }
    });

    return $.gtm.validation;
});