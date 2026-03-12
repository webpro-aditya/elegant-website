"use strict";
require('../../../../../../resources/js/admin.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');

var IpixAddResources = (function() {
    var formValidation = function () {
        $('#addQuizContentForm').on('submit', function (event) {
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

    var drawerClose = function(){
        var drawerElement = document.querySelector("#kt_drawer_add_quiz_content");
        var drawer = IpixDrawer.getInstance(drawerElement);

        $('#backButton').on('click', function () {
            drawer.hide();
        });

        $('#kt_drawer_add_quiz_content_close').on('click', function () {
            drawer.hide();
        });
    }

  
    return {
        init: function() {
            formValidation();
            drawerClose();
        }
    }
})();

IpixUtil.onDOMContentLoaded(function() {
    IpixAddResources.init();
});



