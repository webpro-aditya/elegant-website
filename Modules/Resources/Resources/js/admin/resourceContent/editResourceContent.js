"use strict";
require('../../../../../../resources/js/admin.js');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');

var IpixEditFreeResources = function () {
    var formValidation = function () {
        $('#editResourceForm').on('submit', function (event) {
            var isValid = true;
    
            $('.is-invalid').removeClass('is-invalid');
            $('.is-valid').removeClass('is-valid');
            $('.invalid-feedback').hide();
    
            $('[id^=question_]').each(function () {
                var questionField = $(this);
                if (!questionField.val().trim()) {
                    isValid = false;
                    questionField.addClass('is-invalid');
                    if (questionField.next('.invalid-feedback').length === 0) {
                        questionField.after('<div class="invalid-feedback">Question is required.</div>');
                    }
                    questionField.next('.invalid-feedback').show();
                } else {
                    questionField.addClass('is-valid');
                }
            });
            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    var statusEvent = function () {
        const target = document.getElementById('resource_status');
        $("#resource_status_select").change(function (e) {
            switch (e.target.value) {
                case "active":
                    {
                        target.classList.remove(...['bg-success', 'bg-warning', 'bg-danger']);
                        target.classList.add('bg-success');
                        break;
                    }
                case "inactive":
                    {
                        target.classList.remove(...['bg-success', 'bg-warning', 'bg-danger']);
                        target.classList.add('bg-danger');
                        break;
                    }
                default:
                    break;
            }
        });
    }

    return {
        init: function () {
            formValidation();
            statusEvent();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixImageInput.init();
    IpixEditFreeResources.init();
});
