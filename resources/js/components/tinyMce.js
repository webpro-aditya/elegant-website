"use strict";

var IpixTinyMceInput = function() {};

IpixTinyMceInput.initEditor = () => {

    if ($('[data-kt-tinymce-editor="true"][data-kt-initialized="false"]').length) {
        IpixJson.options.tinyMce.selector = '[data-kt-tinymce-editor="true"][data-kt-initialized="false"]';
        tinymce.init(IpixJson.options.tinyMce);
    }
}

IpixUtil.onDOMContentLoaded(function() {
    IpixTinyMceInput.initEditor();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixTinyMceInput;
}