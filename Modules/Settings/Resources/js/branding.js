"use strict";
require('../../../../resources/js/admin');
window.autosize = require('autosize/dist/autosize.min.js');
window.IpixImageInput = require('../../../../resources/js/components/image-input.js');

var IpixSettingsBranding = function() {
    return {
        init: function() {}
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixImageInput.init();
    IpixSettingsBranding.init();
});