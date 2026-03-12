"use strict";
require('../../../../../resources/js/admin.js');
require('../../../../../resources/plugins/tinymce/tinymce.js');

var IpixUsersAddBlog = function () {
    var formValidation = function () {
        $('#editFaqForm').submit(function (event) {
            var isValid = true;

            // Validate question fields
            $('.language-input input[type="text"]').each(function () {
                var question = $(this);
                if (!question.val()) {
                    isValid = false;
                    question.addClass('is-invalid');
                    if (question.next('.invalid-feedback').length === 0) {
                        question.after('<div class="invalid-feedback">Question is required.</div>');
                    }
                    question.next('.invalid-feedback').show();
                } else {
                    question.removeClass('is-invalid');
                    question.addClass('is-valid');
                    question.next('.invalid-feedback').hide();
                }
            });

            // Validate answer fields
            $('.language-input textarea').each(function () {
                var answer = $(this);
                if (!answer.val()) {
                    isValid = false;
                    answer.addClass('is-invalid');
                    if (answer.next('.invalid-feedback').length === 0) {
                        answer.after('<div class="invalid-feedback">Answer is required.</div>');
                    }
                    answer.next('.invalid-feedback').show();
                } else {
                    answer.removeClass('is-invalid');
                    answer.addClass('is-valid');
                    answer.next('.invalid-feedback').hide();
                }
            });

            if (!isValid) {
                event.preventDefault();
            }
        });
    }
    $(document).ready(function () {
        $('#category_id').change(function () {

            var categoryId = $(this).val();

            var filterOptions = {
                category_id: {
                    value: categoryId
                }
            };
            $('#course_id').attr('data-select2-filter', JSON.stringify(filterOptions)).trigger('change');
        });
    });
    var statusEvent = function (e) {
        const target = document.getElementById('faq_status');
        $("#faq_status_select").change(function (e) {
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
    IpixUsersAddBlog.init();
    IpixImageInput.init();
});
