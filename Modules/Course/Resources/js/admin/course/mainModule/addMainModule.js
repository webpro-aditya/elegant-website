"use strict";
require("../../../../../../../resources/js/admin.js");
require("../../../../../../../resources/plugins/tinymce/tinymce.js");


var IpixMainModuleEditMainModule = function () {

    var selectBox = function () {
        $(document).ready(function () {
            $('.title-select').select2({
                tags: true,
                allowClear: true
            });
        });
    }


    // var selectBox = function () {
    //         $('.title-select').select2({
    //             tags: true,
    //             allowClear: true
    //         });
    // }

    var formValidation = function () {
        $('#addMainModuleForm').submit(function (event) {
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

            // Validate each title input within language tabs
            $('[id^="heading_"]').each(function () {
                var headingInput = $(this);
                var headingValue = headingInput.val();

                if (!headingValue) {
                    isValid = false;
                    headingInput.addClass('is-invalid');
                    if (headingInput.next('.invalid-feedback').length === 0) {
                        headingInput.after('<div class="invalid-feedback">Heading is required.</div>');
                    }
                    headingInput.next('.invalid-feedback').show();
                } else {
                    headingInput.addClass('is-valid');
                }
            });

            // ✅ Validate sort_order
            var sortOrderInput = $('#sort_order');
            var sortOrderValue = sortOrderInput.val();

            if (!sortOrderValue || isNaN(sortOrderValue) || parseInt(sortOrderValue) <= 0) {
                isValid = false;
                sortOrderInput.addClass('is-invalid');
                if (sortOrderInput.next('.invalid-feedback').length === 0) {
                    sortOrderInput.after('<div class="invalid-feedback">Sort Order must be a positive number.</div>');
                }
                sortOrderInput.next('.invalid-feedback').show();
            } else {
                sortOrderInput.addClass('is-valid');
            }

            // Prevent form submission if isValid is false
            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    var initTinyMCE = function () {
        $('[data-kt-tinymce-editor="true"]').each(function () {
            if ($(this).data('kt-initialized') === false) {
                tinymce.init({
                    selector: `#${$(this).attr('id')}`,
                    plugins: 'lists link image table',
                    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                    setup: function (editor) {
                        editor.on('change', function (e) {
                            tinymce.triggerSave();
                        });
                    }
                });
                $(this).data('kt-initialized', true);
            }
        });
    }



    return {
        init: function () {
            selectBox();
            // selectBox();
            formValidation();
            initTinyMCE();
            // IpixFormValidation.handleFormSubmit();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixMainModuleEditMainModule.init();
});
