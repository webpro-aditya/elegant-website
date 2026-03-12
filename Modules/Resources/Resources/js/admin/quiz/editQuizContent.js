"use strict";
require('../../../../../../resources/js/admin.js');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');

var IpixEditFreeResources = function () {
    var formValidation = function () {
        $('#editQuizForm').on('submit', function (event) {
            var isValid = true;
    
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

            $('[id^=answer_]').each(function () {
                var qusField = $(this);
                if (!qusField.val().trim()) {
                    isValid = false;
                    qusField.addClass('is-invalid');
                    if (qusField.next('.invalid-feedback').length === 0) {
                        qusField.after('<div class="invalid-feedback">Answer is required.</div>');
                    }
                    qusField.next('.invalid-feedback').show();
                } else {
                    qusField.addClass('is-valid');
                }
            });

            $('[id^=option_]').each(function () {
                var optionField = $(this);
                if (!optionField.val().trim()) {
                    isValid = false;
                    optionField.addClass('is-invalid');
                    if (optionField.next('.invalid-feedback').length === 0) {
                        optionField.after('<div class="invalid-feedback">Option is required.</div>');
                    }
                    optionField.next('.invalid-feedback').show();
                } else {
                    optionField.addClass('is-valid');
                }
            });

            $('[id^=value]').each(function () {
                var valueField = $(this);
                if (!valueField.val().trim()) {
                    isValid = false;
                    valueField.addClass('is-invalid');
                    if (valueField.next('.invalid-feedback').length === 0) {
                        valueField.after('<div class="invalid-feedback">Value is required.</div>');
                    }
                    valueField.next('.invalid-feedback').show();
                } else {
                    valueField.addClass('is-valid');
                }
            });


            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    var statusEvent = function(e) {
        const target = document.getElementById('quiz_status');
        $("#quiz_status_select").change(function(e) {
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
