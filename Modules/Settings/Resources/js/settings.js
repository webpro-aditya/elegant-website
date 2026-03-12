"use strict";
require('../../../../resources/js/admin');
window.autosize = require('autosize/dist/autosize.min.js');
window.IpixImageInput = require('../../../../resources/js/components/image-input.js');
require('../../../../resources/plugins/tinymce/tinymce.js');

var IpixSettingsStore = function() {
    return {
        init: function() {}
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixImageInput.init();
    IpixSettingsStore.init();
});