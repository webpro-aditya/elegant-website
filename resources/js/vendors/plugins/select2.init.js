"use strict";

//
// Select2 Initialization
//

$.fn.select2.defaults.set("theme", "bootstrap5");
$.fn.select2.defaults.set("width", "100%");
$.fn.select2.defaults.set("selectionCssClass", ":all:");

IpixJson.lang.select2 = {
    placeholder: "Please select",
};

IpixJson.options.select2 = {
    normal: {
        dropdownAutoWidth: true,
        placeholder: IpixJson.lang.select2.placeholder,
        dir: document.body.getAttribute('direction'),
        width: "100%",
    },
    server: {
        dropdownAutoWidth: true,
        dir: document.body.getAttribute('direction'),
        width: "100%",
        ajax: {
            dataType: "json",
            delay: 250,
            type: "GET",
            quietMillis: 50,
            async: false,
            processResults: function(data) {
                return {
                    results: data,
                };
            },
            cache: true,
        },
        placeholder: IpixJson.lang.select2.placeholder,
        // minimumInputLength: 1,
    },
};