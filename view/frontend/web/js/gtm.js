define([
    "jquery",
    "jquery/ui",
    "matchMedia",
    "mage/mage",
    "domReady!"
], function($){
    'use strict';

    // Current product data
    var currentProductData = false;

    // Flag to check if main slider exists
    var mainSliderExists = false;

    var senderGtm = {
        loadingReady: false,
        widgets: [],
        data: {
            promos: [],
            products: [],
            detail : undefined,
        },

        init : function(){
            if ((typeof(gtmEnable) != 'undefined') && (gtmEnable === true)) {
                
                // Add positions to widgets
                var widgets = this._sortWidgets();
                
                // Get widgets elements
                var widgetsElements = this._getWidgetsElements(widgets);
                
                // Create widgets
                this._createWidgets(widgetsElements);
                
                if (this.widgets.length == 0) {
                    this.sendImpressions();
                }
                this.loadingReady = true;
            }
        },
        sendActions : function (data) {
            dataLayer.push({
                promos : data.promos,
                products: data.products,
                event : data.event
            });
        }
    };

    // Init sender
    senderGtm.init();


    return {
        senderGtm               : $.mage.senderGtm
    };
});
