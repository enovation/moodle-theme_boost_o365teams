define(['jquery', 'core/cfg'], function ($, cfg) {
    return {
        init: function() {
            console.log(cfg);
            $('body').append('<img id="loadingicon" src="'+cfg.loadingicon+'" />');

            if (window.location != window.parent.location) {
                // in iframe
                $("nav.navbar").hide();
                $("div#nav-drawer").hide();
                $("aside#block-region-side-pre").parent().hide();
                $("footer#page-footer").hide();
            }

            $("div#page").fadeIn(150);
            $("img#loadingicon").fadeOut(150);
        }
    }
});
