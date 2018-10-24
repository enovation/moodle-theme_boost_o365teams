define(['jquery'], function($) {
    return {
        init: function() {
            microsoftTeams.initialize();

            microsoftTeams.getContext(function (context) {
                theme = context.theme;
                $("div#page").addClass("theme_" + theme);
            });

            microsoftTeams.registerOnThemeChangeHandler(function (theme) {
                $("div#page").removeClass("theme_default");
                $("div#page").removeClass("theme_dark");
                $("div#page").removeClass("theme_contrast");
                $("div#page").addClass("theme_" + theme);
            });
        }
    }
});
