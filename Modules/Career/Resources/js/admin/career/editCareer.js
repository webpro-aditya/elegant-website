"use strict";
require('../../../../../../resources/js/admin.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');
require('../../../../../../resources/plugins/tagify/tagify.js');

var IpixEditCareer = function() {

    var formValidation = function () {
        $('#editContentForm').submit(function (event) {
            var isValid = true;

            // Reset validation states
            $('.is-invalid').removeClass('is-invalid');
            $('.is-valid').removeClass('is-valid');
            $('.invalid-feedback').hide();

            // Validate title field
            var title = $('#title');
            if (!title.val().trim()) {
                isValid = false;
                title.addClass('is-invalid');
                if (title.next('.invalid-feedback').length === 0) {
                    title.after('<div class="invalid-feedback">Title is required.</div>');
                }
                title.next('.invalid-feedback').show();
            } else {
                title.addClass('is-valid');
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

            var categoryId = $('#category_id');
            if (!categoryId.val()) { // Check if no option is selected
                isValid = false;
                categoryId.addClass('is-invalid');
                if (categoryId.next('.invalid-feedback').length === 0) {
                    categoryId.after('<div class="invalid-feedback">Category is required.</div>');
                }
                categoryId.next('.invalid-feedback').show();
            } else {
                categoryId.addClass('is-valid');
            }

            // Prevent form submission if not valid
            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    var statusEvent = function(e) {
        const target = document.getElementById('career_status');
        $("#career_status_select").change(function(e) {
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

    var initializeTagify = function() {
        document.querySelectorAll('input[data-kt-tagify-input="true"]').forEach(function(input) {
            new Tagify(input);
        });
    };  
    
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
        init: function() {
            formValidation();
            initializeTagify();
            statusEvent();
            checkActiveTab();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixEditCareer.init();


});
