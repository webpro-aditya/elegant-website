"use strict";

// Class definition
var IpixFormRepeater = function() {};

IpixFormRepeater.init = function() {};

IpixUtil.onDOMContentLoaded(function() {
    IpixFormRepeater.init();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixFormRepeater;
}