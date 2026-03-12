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

    var validateForm = function (e) {
        IpixJson.options.FormValidation.fields = {
            title: {
                validators: {
                    notEmpty: {
                        message: "Title is required",
                    },
                },
            },
            heading: {
                validators: {
                    notEmpty: {
                        message: "Heading is required",
                    },
                },
            },
            description: {
                validators: {
                    notEmpty: {
                        message: "Description is required",
                    },
                },
            },
            sortt_order: {
                validators: {
                    notEmpty: {
                        message: "Sort Order is required",
                    },
                },
            },
        };
        IpixJson.validators['editMainModuleForm'] = FormValidation.formValidation(document.getElementById('editMainModuleForm'), IpixJson.options.FormValidation);
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
            validateForm();
            selectBox();
            initTinyMCE();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixMainModuleEditMainModule.init();
});
