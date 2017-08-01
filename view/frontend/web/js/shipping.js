define(
    [
        'Magento_Checkout/js/view/shipping',
        'Magento_Checkout/js/action/set-shipping-information',
        'gtmDatalayer',
        'Magento_Checkout/js/model/step-navigator'
    ],
    function (Component, setShippingInformationAction, gtmDatalayer, stepNavigator) {

        return Component.extend({
            /**
             * Set shipping information handler
             */
            setShippingInformation: function () {
                if (this.validateShippingInformation()) {
                    setShippingInformationAction().done(
                        function () {
                            gtmDatalayer.onShippingSubmit();
                            stepNavigator.next();
                        }
                    );
                }
            }
        });
    }
);
