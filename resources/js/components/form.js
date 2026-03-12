"use strict";

var IpixFormHandlersInitialized = false;

// Class definition
var IpixForm = function(element, options) {};

IpixForm.autoCompleteDisable = function(selector = 'input') {
    var elements = $(selector);
    if (elements && elements.length > 0) {
        elements.attr('autocomplete', 'off');
    }
}

IpixForm.init = function() {
    IpixForm.autoCompleteDisable();
};

if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixForm;
}
