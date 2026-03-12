//
// Global init of core components
//

// Init components
var IpixComponents = function() {
    // Public methods
    return {
        init: function() {
            IpixApp.init();
            IpixDrawer.init();
            IpixMenu.init();
            IpixScroll.init();
            IpixSticky.init();
            IpixSwapper.init();
            IpixToggle.init();
            IpixDialer.init();
            IpixPasswordMeter.init();
        }
    }
}();

// On document ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", function() {
        IpixComponents.init();
    });
} else {
    IpixComponents.init();
}

// Init page loader
window.addEventListener("load", function() {
    IpixApp.hidePageLoading();
});

// Declare IpixApp for Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    window.IpixComponents = module.exports = IpixComponents;
}