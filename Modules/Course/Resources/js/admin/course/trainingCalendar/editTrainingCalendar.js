"use strict";
require("../../../../../../../resources/js/admin");
require("../../../../../../../resources/plugins/tinymce/tinymce.js");


var IpixTrainingCalendarEditTrainingCalendar = function () {
    var validateForm = function (e) {

        $('#editTrainingCalendarForm').submit(function (event) {
            var isValid = true;

            // Validate venue fields
            $('input[id^="venue_"]').each(function () {
                var venue = $(this);
                if (!venue.val()) {
                    isValid = false;
                    venue.addClass('is-invalid');
                    if (venue.next('.invalid-feedback').length === 0) {
                        venue.after('<div class="invalid-feedback">Venue is required.</div>');
                    }
                    venue.next('.invalid-feedback').show();
                } else {
                    venue.removeClass('is-invalid');
                    venue.addClass('is-valid');
                    venue.next('.invalid-feedback').hide();
                }
            });


            // Validate language fields
            $('input[id^="language_"]').each(function () {
                var language = $(this);
                if (!language.val()) {
                    isValid = false;
                    language.addClass('is-invalid');
                    if (language.next('.invalid-feedback').length === 0) {
                        language.after('<div class="invalid-feedback">Language is required.</div>');
                    }
                    language.next('.invalid-feedback').show();
                } else {
                    language.removeClass('is-invalid');
                    language.addClass('is-valid');
                    language.next('.invalid-feedback').hide();
                }
            });

            // Validate start_time
            var start_time = $('#start_time');
            if (!start_time.val()) {
                isValid = false;
                start_time.addClass('is-invalid');
                if (start_time.next('.invalid-feedback').length === 0) {
                    start_time.after('<div class="invalid-feedback">Start Time is required.</div>');
                }
                start_time.next('.invalid-feedback').show();
            } else {
                start_time.removeClass('is-invalid');
                start_time.addClass('is-valid');
                start_time.next('.invalid-feedback').hide();
            }

            // Validate end_time
            var end_time = $('#end_time');
            if (!end_time.val()) {
                isValid = false;
                end_time.addClass('is-invalid');
                if (end_time.next('.invalid-feedback').length === 0) {
                    end_time.after('<div class="invalid-feedback">End Time is required.</div>');
                }
                end_time.next('.invalid-feedback').show();
            } else {
                end_time.removeClass('is-invalid');
                end_time.addClass('is-valid');
                end_time.next('.invalid-feedback').hide();
            }


            if (!isValid) {
                event.preventDefault();
            }


        });
    }
    return {
        init: function () {
            validateForm();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixTrainingCalendarEditTrainingCalendar.init();
});
