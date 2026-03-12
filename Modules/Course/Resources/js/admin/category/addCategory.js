"use strict";
require('../../../../../../resources/js/admin');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');
require('../../../../../../resources/plugins/dropzone/dropzone.js');

var IpixCoursesAddCourse = function() {
    var validateForm = function() {
        $('#addCategoryForm').submit(function(event) {
            var isValid = true;

            // Reset validation states
            $('.is-invalid').removeClass('is-invalid');
            $('.is-valid').removeClass('is-valid');
            $('.invalid-feedback').hide();

            // Validate title fields for each language
            $('[id^=title_]').each(function() {
                var titleField = $(this);
                if (!titleField.val().trim()) {
                    isValid = false;
                    titleField.addClass('is-invalid');
                    if (titleField.next('.invalid-feedback').length === 0) {
                        titleField.after('<div class="invalid-feedback">Title is required.</div>');
                    }
                    titleField.next('.invalid-feedback').show();
                } else {
                    titleField.addClass('is-valid');
                }
            });

            // Prevent form submission if not valid
            if (!isValid) {
                event.preventDefault();
            }
        });
    };

    return {
        init: function() {
            validateForm();
        }
    };
}();

// Initialize scripts when DOM content is loaded
IpixUtil.onDOMContentLoaded(function() {
    IpixImageInput.init(); // Assuming IpixImageInput is defined and initialized correctly
    IpixCoursesAddCourse.init();
});