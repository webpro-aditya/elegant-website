"use strict";

var IpixFlatPicker = function() {};

IpixFlatPicker.initFlatPicker = function() {
    // Check if jQuery included
    if (typeof jQuery == 'undefined') {
        return;
    }

    // Check if flatpickr included
    if (typeof $.fn.flatpickr === 'undefined') {
        return;
    }

    var dateElements = [].slice.call(document.querySelectorAll('[data-kt-date-input="true"][data-kt-initialized="false"]'));
    dateElements.map(function(element) {
        IpixJson.options.flatpicker.minDate = null;
        IpixJson.options.flatpicker.maxDate = null;
        IpixJson.options.flatpicker.enableTime = false;
        IpixJson.options.flatpicker.dateFormat = $(element).data("format");
        if ($(element).data("kt-time-enabled") == true) {
            IpixJson.options.flatpicker.enableTime = true;
        }
        if ($(element).data("mindate")) {
            IpixJson.options.flatpicker.minDate = $(element).data("mindate");
        }
        if ($(element).data("maxdate")) {
            IpixJson.options.flatpicker.maxDate = $(element).data("maxdate");
        }
        element.flatpickr(IpixJson.options.flatpicker);
        element.setAttribute("data-kt-initialized", "true");
    });
}

IpixUtil.onDOMContentLoaded(function() {
    IpixFlatPicker.initFlatPicker();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixFlatPicker;
}