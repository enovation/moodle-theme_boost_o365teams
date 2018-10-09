define(['jquery'], function ($) {
    return {
        init: function() {
            if (window.location == window.parent.location) {
                // not in iframe, show page elements
                $('nav.navbar').show();
                $('nav.navbar').css('display', 'flex');
                $('div#nav-drawer').show();
                $('section[data-region="blocks-column"]').show();
                $('footer#page-footer').show();
            } else {
                // in iframe, hide page elements
                $('body.drawer-open-left').css('margin-left', '0');
                $('div#page').css('margin-top', '0');
                $('section#region-main.has-blocks').css('width', '100%');
                $('div#page-wrapper').css('margin-bottom', '0');
                $('div.context-header-settings-menu').css('display', 'none');
                $('div.region-main-settings-menu').css('display', 'none');
                $('div.region_main_settings_menu_proxy').css('display', 'none');
            }

            $("body").fadeIn(150);
        }
    }
});
