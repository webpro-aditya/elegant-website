"use strict";

// Class definition
var IpixJsSocials = function() {};

IpixJsSocials.createShare = function() {
    // Check if jQuery included
    if (typeof jQuery == 'undefined') {
        return;
    }

    // Check if select2 included
    if (typeof $.fn.rating === 'undefined') {
        return;
    }

    var elements = [].slice.call(document.querySelectorAll('[data-control="jssocials"]'));

    elements.map(function(element) {
        if (element.getAttribute("data-kt-initialized") === "1") {
            return;
        }

        window.IpixJson.jssocials[element.getAttribute('id')] = $(element).jsSocials(IpixJson.options.jssocials);

        element.setAttribute("data-kt-initialized", "1");
    });
}

IpixJsSocials.init = function() {
    IpixJsSocials.createShare();
};

IpixUtil.onDOMContentLoaded(function() {
    IpixJsSocials.init();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixJsSocials;
}