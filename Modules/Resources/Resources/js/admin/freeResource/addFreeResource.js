"use strict";
require('../../../../../../resources/js/admin.js');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');

var IpixAddFreeResources = function() {

    $('#time').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // Display format (24-hour)
        time_24hr: true,
        minuteIncrement: 1,
        onChange: function(selectedDates, dateStr, instance) {
            // Process input to mm:ss format for your controller
            if (dateStr) {
                var timeParts = dateStr.split(':');
                var minutes = timeParts[0];
                var seconds = timeParts[1];

                // Ensure minutes and seconds are always two digits
                var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);
                
                // Set the input back to formatted value (MM:SS)
                $('#time').val(formattedTime);
            }
        }
    });

    $('#type-select').change(function() {
        var selectedType = $(this).val();
        
        if (selectedType === 'interview') {
            $('#type-container').removeClass('col-6').addClass('col-12');
            $('#time-container').hide(); // Hide time input for interview
        } else if (selectedType === 'quiz') {
            $('#type-container').removeClass('col-12').addClass('col-6');
            $('#time-container').show(); // Show time input for quiz
        }
    });

    var formValidation = function () {
        $('#resourceForm').submit(function (event) {
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

        var selectedType = $('#type-select').val();
        if (selectedType === 'quiz') {
            var timeField = $('#time');
            if (!timeField.val().trim()) {
                isValid = false;
                timeField.addClass('is-invalid');
                if (timeField.next('.invalid-feedback').length === 0) {
                    timeField.after('<div class="invalid-feedback">Time is required for quizzes.</div>');
                }
                timeField.next('.invalid-feedback').show();
            } else {
                timeField.addClass('is-valid');
            }
        }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }
    
    var statusEvent = function(e) {
        const target = document.getElementById('resource_status');
        $("#resource_status_select").change(function(e) {
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
            formValidation();
            statusEvent();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixImageInput.init();
    IpixAddFreeResources.init();
});
