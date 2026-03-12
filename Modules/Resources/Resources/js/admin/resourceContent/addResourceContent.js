"use strict";
require('../../../../../../resources/js/admin.js');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');

var IpixAddResources = (function() {
    var formValidation = function () {
        $('#addResourceContentForm').on('submit', function (event) {
            var isValid = true;

            // Reset validation states
            $('.is-invalid').removeClass('is-invalid');
            $('.is-valid').removeClass('is-valid');
            $('.invalid-feedback').hide();

            // Validate name fields for each language
                $('[id^=question_]').each(function () {
                    var qusField = $(this);
                    if (!qusField.val().trim()) {
                        isValid = false;
                        qusField.addClass('is-invalid');
                        if (qusField.next('.invalid-feedback').length === 0) {
                            qusField.after('<div class="invalid-feedback">Question is required.</div>');
                        }
                        qusField.next('.invalid-feedback').show();
                    } else {
                        qusField.addClass('is-valid');
                    }
                });

            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    var statusEvent = function() {
        var target = $('#author_status');
        $("#author_status_select").change(function(e) {
            switch (e.target.value) {
                case "active":
                    target.removeClass('bg-warning bg-danger').addClass('bg-success');
                    break;
                case "inactive":
                    target.removeClass('bg-success bg-warning').addClass('bg-danger');
                    break;
                default:
                    break;
            }
        });
    }


    var drawerClose = function(){
        var drawerElement = document.querySelector("#kt_drawer_add_training_calendar");
        var drawer = IpixDrawer.getInstance(drawerElement);

        $('#backButton').on('click', function () {
            drawer.hide();
        });

        $('#kt_drawer_add_resource_content_close').on('click', function () {
            drawer.hide();
        });
    }

    return {
        init: function() {
            formValidation();
            statusEvent();
            drawerClose();
        }
    }
})();

IpixUtil.onDOMContentLoaded(function() {
    IpixImageInput.init();
    IpixAddResources.init();
});



