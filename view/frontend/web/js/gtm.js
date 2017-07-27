define([
    "jquery",
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function($, Component, customerData){

    customerData.get('cart').subscribe(function(changes) {
        // For this example, we'll just print out the change info
        alert(2);

    }, null, "arrayChange");
    a = customerData.get('cart');

    // var senderGtm = {
    //     loadingReady: false,
    //     widgets: [],
    //     data: {
    //         promos: [],
    //         products: [],
    //         detail : undefined
    //     },
    //
    //     init : function(){
    //         if ((typeof(gtmEnable) != 'undefined') && (gtmEnable === true)) {
    //
    //             this.sendActions({
    //                 'promos': 1,
    //                 'products': 2,
    //                 'event': 3
    //             })
    //         }
    //     },
    //     sendActions : function (data) {
    //         dataLayer.push({
    //             promos : data.promos,
    //             products: data.products,
    //             event : data.event
    //         });
    //     }
    // };
    // // Init sender
    // senderGtm.init();


    // return {
    //     senderGtm : $.mage.senderGtm
    // };
});
