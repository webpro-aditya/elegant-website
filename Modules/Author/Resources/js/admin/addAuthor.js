"use strict";
require('../../../../../resources/js/admin.js');
window.IpixImageInput = require('../../../../../resources/js/components/image-input.js');
require('../../../../../resources/plugins/tinymce/tinymce.js');

var IpixUsersAddBlog = function() {

    var formValidation = function () {
        $('#authorForm').submit(function (event) {
            var isValid = true;

            // Reset validation states
            $('.is-invalid').removeClass('is-invalid');
            $('.is-valid').removeClass('is-valid');
            $('.invalid-feedback').hide();

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
                var descField = $(this);
                var wordCount = descField.val().trim().split(/\s+/).length;
                if (!descField.val().trim() || wordCount > 60) {
                    isValid = false;
                    descField.addClass('is-invalid');
                    if (descField.next('.invalid-feedback').length === 0) {
                        descField.after('<div class="invalid-feedback">Description is required and should not exceed 60 words.</div>');
                    }
                    descField.next('.invalid-feedback').show();
                } else {
                    descField.addClass('is-valid');
                }
            });

            if (!isValid) {
                event.preventDefault();
            }
        });
    }


    var statusEvent = function(e) {
        const target = document.getElementById('author_status');
        $("#author_status_select").change(function(e) {
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

    var languageInput = function () {
        // Hide all language-specific input fields initially
        $('.language-input').hide();

        // Show the input fields for the first language by default
        $('.language-input[data-language="1"]').show();

        // Handle tab click event
        $('.nav-link').on('click', function () {
            var languageId = $(this).attr('href').split('-')[1];

            // Hide all language-specific input fields
            $('.language-input').hide();

            // Show the selected language-specific input fields
            $('.language-input[data-language="' + languageId + '"]').show();
        });

        // Trigger click on the first tab to set the correct initial state
        $('.nav-link.active').trigger('click');
        $('#title-div').show();
        $('#content-tab').show();
    }


    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        checkActiveTab();
    });
    return {
        init: function() {
            formValidation();
            statusEvent();
            checkActiveTab();
            languageInput();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixImageInput.init();
    IpixUsersAddBlog.init();
});
