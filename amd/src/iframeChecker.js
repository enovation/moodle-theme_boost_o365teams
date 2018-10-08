define(['jquery'], function ($) {
    return {
        init: function() {
            if ($(window).self !== $(window).top) {
                // in iframe
                $("nav.navbar").hide();
                $("div#nav-drawer").hide();
                $("aside#block-region-side-pre").parent().hide();
                $("footer#page-footer").hide();
            }
        }
    }
});
