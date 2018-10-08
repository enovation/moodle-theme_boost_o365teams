define(['jquery'], function ($) {
    return {
        init: function() {
            if (window.location == window.parent.location) {
                // in iframe
                $("nav.navbar").show();
                $("nav.navbar").setAttribute('display', 'flex');
                $("div#nav-drawer").show();
                $("aside#block-region-side-pre").parent().show();
                $("footer#page-footer").show();
            } else {

            }

            $("body").fadeIn(150);
        }
    }
});
