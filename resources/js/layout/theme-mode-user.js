"use strict";

// Class definition
var IpixThemeModeUser = function() {

    var handleSubmit = function() {
        // Update chart on theme mode change
        IpixThemeMode.on("kt.thememode.change", function() {
            var menuMode = IpixThemeMode.getMenuMode();
            var mode = IpixThemeMode.getMode();
            console.log("user selected theme mode:" + menuMode);
            console.log("theme mode:" + mode);

            // Submit selected theme mode menu option via ajax and 
            // store it in user profile and set the user opted theme mode via HTML attribute
            // <html data-theme-mode="light"> .... </html>
        });
    }

    return {
        init: function() {
            handleSubmit();
        }
    };
}();

// Initialize app on document ready
IpixUtil.onDOMContentLoaded(function() {
    IpixThemeModeUser.init();
});

// Declare IpixThemeModeUser for Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixThemeModeUser;
}