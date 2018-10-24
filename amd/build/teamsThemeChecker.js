define(['jquery'], function($) {
    return {
        init: function() {
            microsoftTeams.initialize();

            microsoftTeams.getContext(function (context) {
                theme = context.theme;
                $("div#page").addClass("theme_" + theme);
            });
        }
    }
});
