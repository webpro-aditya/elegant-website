"use strict";

var IpixTagifyInput = function() {};

IpixTagifyInput.init = () => {
    if ($('[data-kt-tagify-editor="true"][data-kt-initialized="false"]').length) {
        var tagifyInput = document.querySelector('[data-kt-tagify-editor="true"][data-kt-initialized="false"]');
        new Tagify(tagifyInput, IpixJson.options.tagify);
    }
}

IpixUtil.onDOMContentLoaded(function() {
    IpixTagifyInput.init();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixTagifyInput;
}