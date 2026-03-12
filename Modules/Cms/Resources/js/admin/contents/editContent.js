"use strict";
require('../../../../../../resources/js/admin.js');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
require('../../../../../../resources/plugins/dropzone/dropzone.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');

const { inArray } = require('jquery');

var IpixContentEditContents = function () {
    var validateForm = function (e) {
        $('#editContentForm').submit(function (event) {

            var isValid = true;

            var title = $('#title');
            if (!title.val()) {
                isValid = false;
                title.addClass('is-invalid');
                if (title.next('.invalid-feedback').length === 0) {
                    title.after('<div class="invalid-feedback">Title is required.</div>');
                }
                title.next('.invalid-feedback').show();
            } else {
                title.removeClass('is-invalid');
                title.addClass('is-valid');
                title.next('.invalid-feedback').hide();
            }

            // Validate name fields for each language
            $('[id^=name_]').each(function () {
                var nameField = $(this);
                if (!nameField.val().trim()) {
                    isValid = false;
                    nameField.addClass('is-invalid');
                    if (nameField.next('.invalid-feedback').length === 0) {
                        nameField.after('<div class="invalid-feedback">Name is required.</div>');
                    }
                    nameField.next('.invalid-feedback').show();
                } else {
                    nameField.addClass('is-valid');
                }
            });

            $('[id^=short_desc_]').each(function () {
                var shortDescField = $(this);
                if (shortDescField.val().length > 191) {
                    isValid = false;
                    shortDescField.addClass('is-invalid');
                    if (shortDescField.next('.invalid-feedback').length === 0) {
                        shortDescField.after('<div class="invalid-feedback">Short description cannot exceed 191 characters.</div>');
                    }
                    shortDescField.next('.invalid-feedback').show();
                } else {
                    shortDescField.removeClass('is-invalid');
                    shortDescField.addClass('is-valid');
                    shortDescField.next('.invalid-feedback').hide();
                }
            });
    


            if (!isValid) {
                event.preventDefault();
            }
        });


        const target = document.getElementById('contents_status');
        const select = document.getElementById('contents_status_select');
        const statusClasses = ['bg-success', 'bg-warning', 'bg-danger'];

        $(select).on('change', function (e) {
            const value = e.target.value;

            switch (value) {
                case "active":
                    {
                        target.classList.remove(...statusClasses);
                        target.classList.add('bg-success');
                        hideDatepicker();
                        break;
                    }

                case "inactive":
                    {
                        target.classList.remove(...statusClasses);
                        target.classList.add('bg-danger');
                        hideDatepicker();
                        break;
                    }

                default:
                    break;
            }
        });
    }

    function checkActiveTab() {
        if ($('#seo-tab').hasClass('active')) {
            $('#title-div').hide();
            $('#content-tab').hide();
        } else {
            $('#title-div').show();
            $('#content-tab').show();
        }
    }

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        checkActiveTab();
    });

    return {
        init: function () {
            validateForm();
            checkActiveTab();

        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixImageInput.init();
    IpixContentEditContents.init();
});