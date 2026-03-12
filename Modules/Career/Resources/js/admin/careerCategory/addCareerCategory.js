"use strict";
require('../../../../../../resources/js/admin.js');

var IpixAddCareerCategory = function() {
    var validateForm = function () {
        $('#categoryForm').submit(function (event) {

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

            // Prevent form submission if not valid
            if (!isValid) {
                event.preventDefault();
            }
        });

    }
    var statusEvent = function(e) {
        const target = document.getElementById('career_category_status');
        $("#career_category_status_select").change(function(e) {
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
        init: function() {
            validateForm();
            statusEvent();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixAddCareerCategory.init();
});
