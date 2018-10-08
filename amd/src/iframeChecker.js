define(['jquery'], function ($) {
    return {
        init: function() {
            if (window.location == window.parent.location) {
                // not in iframe, show page elements
                $("nav.navbar").show();
                $("nav.navbar").css('display', 'flex');
                $("div#nav-drawer").show();
                $("aside#block-region-side-pre").parent().show();
                $("footer#page-footer").show();
            } else {
                // in iframe, hide page elements
                $("body.drawer-open-left").css('margin-left', '0');
                $("#page").css('margin-top', '0');
                $("#region-main.has-blocks").css('width', '100%');
                $("#page-wrapper").css('margin-bottom', '0');
            }

            $("body").fadeIn(150);
        }
    }
});
