"use strict";
require('../../../../../../resources/js/admin');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
window.IpixStepper = require('../../../../../../resources/js/components/stepper.js');

var IpixCourseAddCourse = function () {

    var formValidation = function () {
        $('#addCourseForm').submit(function (event) {
            var isValid = true;

            // Reset all form validation state
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').hide();

            // Validate each title input within language tabs
            $('[id^="title_"]').each(function () {
                var titleInput = $(this);
                var titleValue = titleInput.val();

                if (!titleValue) {
                    isValid = false;
                    titleInput.addClass('is-invalid');
                    if (titleInput.next('.invalid-feedback').length === 0) {
                        titleInput.after('<div class="invalid-feedback">Title is required.</div>');
                    }
                    titleInput.next('.invalid-feedback').show();
                } else {
                    titleInput.addClass('is-valid');
                }
            });


            // Validate category_id select
            var categoryId = $('#category_id').val();
            if (!categoryId) {
                isValid = false;
                $('#category_id').addClass('is-invalid');
                if ($('#category_id').next('.invalid-feedback').length === 0) {
                    $('#category_id').after('<div class="invalid-feedback">Category ID is required.</div>');
                }
                $('#category_id').next('.invalid-feedback').show();
            } else {
                $('#category_id').removeClass('is-invalid');
                $('#category_id').addClass('is-valid');
            }

            // Prevent form submission if isValid is false
            if (!isValid) {
                event.preventDefault();
            }
        });
    }



    return {
        init: function () {
            formValidation();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixImageInput.init();
    IpixCourseAddCourse.init();
});

