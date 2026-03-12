"use strict";
require('../../../../../../resources/js/admin.js');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');

var IpixUsersAddBlog = function () {
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

             // Validate short description fields for each language
             $('[id^=short_desc_]').each(function () {
                var descField = $(this);
                var wordCount = descField.val().split(/\s+/).filter(function (word) {
                    return word.length > 0;
                }).length;

                if (wordCount > maxWords) {
                    isValid = false;
                    descField.addClass('is-invalid');
                    if (descField.next('.invalid-feedback').length === 0) {
                        descField.after('<div class="invalid-feedback">Short Description must not exceed ' + maxWords + ' words. Current word count: ' + wordCount + '.</div>');
                    }
                    descField.next('.invalid-feedback').show();
                } else if (!descField.val().trim()) {
                    isValid = false;
                    descField.addClass('is-invalid');
                    if (descField.next('.invalid-feedback').length === 0) {
                        descField.after('<div class="invalid-feedback">Short Description is required.</div>');
                    }
                    descField.next('.invalid-feedback').show();
                } else {
                    descField.addClass('is-valid');
                    descField.next('.invalid-feedback').hide();
                }
            });

               // Validate category_id field
               var categoryId = $('#category_id');
               if (!categoryId.val()) {
                   isValid = false;
                   categoryId.addClass('is-invalid');
                   if (categoryId.next('.invalid-feedback').length === 0) {
                       categoryId.after('<div class="invalid-feedback">Blog Category is required.</div>');
                   }
                   categoryId.next('.invalid-feedback').show();
               } else {
                   categoryId.addClass('is-valid');
               }
   
               // Validate author_id field
               var authorId = $('#author_id');
               if (!authorId.val()) {
                   isValid = false;
                   authorId.addClass('is-invalid');
                   if (authorId.next('.invalid-feedback').length === 0) {
                       authorId.after('<div class="invalid-feedback">Author is required.</div>');
                   }
                   authorId.next('.invalid-feedback').show();
               } else {
                   authorId.addClass('is-valid');
               }

            // Prevent form submission if not valid
            if (!isValid) {
                event.preventDefault();
            }
        });
    }
    var statusEvent = function (e) {
        const target = document.getElementById('blog_status');
        $("#blog_status_select").change(function (e) {
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
            formValidation();
            statusEvent();
            checkActiveTab();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixUsersAddBlog.init();
    IpixImageInput.init();
});
