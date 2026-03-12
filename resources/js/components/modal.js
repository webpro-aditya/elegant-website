"use strict";

var IpixModal = function() {};

IpixModal.initModal = () => {
    const closeButton = document.querySelector('[data-kt-modal-action="close"]');
    if (closeButton && $(closeButton).length) {
        closeButton.addEventListener('click', e => {
            e.preventDefault();
            $(closeButton).parents(".modal").modal("hide");
        });
    }

    const cancelButton = document.querySelector('[data-kt-modal-action="cancel"]');
    if (cancelButton && $(cancelButton).length) {
        cancelButton.addEventListener('click', e => {
            e.preventDefault();
            $(cancelButton).parents(".modal").modal("hide");
        });
    }
    IpixApp.hidePageLoading();
}

IpixModal.handleLoadRemoteHtml = function() {
    const loadButtons = document.querySelectorAll('[kt-load-remote-html="true"][kt-load-remote-init="false"]');
    if (loadButtons && $(loadButtons).length) {
        loadButtons.forEach(function(el) {
            el.setAttribute('kt-load-remote-init', 'true');
            el.addEventListener('click', function() {
                IpixApp.showPageLoading();
                IpixModal.loadRemoteHtml(el);
            });
        });
    }
}

IpixModal.loadRemoteHtml = function(el, data = {}) {
    $.ajax({
        method: "GET",
        Accept: "application/json",
        url: $(el).data('url'),
        data: data,
        success: function(data) {
            $("#model-area").html(data.html);
            $.each(data.scripts, function(key, script) {
                $.getScript(script);
            });
            IpixApp.createSelect2();
            IpixForm.autoCompleteDisable();
            IpixModal.initModal();
            IpixMenu.createInstances();
        },
    });
}

IpixModal.init = function() {
    IpixModal.handleLoadRemoteHtml();
};

IpixUtil.onDOMContentLoaded(function() {
    IpixModal.init();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixModal;
}