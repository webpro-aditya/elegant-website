"use strict";

require("../../../../../../../resources/js/admin");
require("../../../../../../../resources/plugins/datatable/datatable");
require("../../../../../../../resources/plugins/tinymce/tinymce.js");

var IpixListTrainingCalendar = (function () {

    var initTrainingCalendarList = function () {
        IpixJson.options.datatables.ajax = {
            url: $("#listTrainingCalendars").data("url"),
            type: "POST",
            data: function (data) {
                data._token = _token;
                data.course_id = $("#course_id").val();
                data.status = $("#status").val();
            },
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "start_date", name: "start_date", orderable: true, searchable: true },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [[1, "asc"]];
        IpixJson.dataTables["listTrainingCalendars"] = $(
            "#listTrainingCalendars"
        ).DataTable(IpixJson.options.datatables);
        IpixJson.dataTables["listTrainingCalendars"].on("draw", function () {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    };

    var validateForm = function () {
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
    
        return isValid;
    };
    
    var initAddTrainingCalendar = function () {
        // Attach submit event handler only once
        $(document).off("submit", "#addTrainingCalendarForm").on("submit", "#addTrainingCalendarForm", function (e) {
            e.preventDefault();
    
            // Manual validation
            var isValidManual = validateForm();
    
            if (isValidManual) {
                // Form is manually valid, proceed with AJAX submission
                var formData = $(this).serialize();
                var drawerElement = document.querySelector("#kt_drawer_add_training_calendar");
                var drawer = IpixDrawer.getInstance(drawerElement);
    
                $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (!response.errors) {
                            drawer.hide();
                            $("#addTrainingCalendarForm")[0].reset();
                            updateTrainingCalendarList();
                            toastr.success("Training Calendar added successfully");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        var errors = JSON.parse(xhr.responseText);
                        $.each(errors, function (key, value) {
                            $("#" + key)
                                .closest(".fv-row")
                                .find(".fv-plugins-message-container")
                                .html(value);
                            $("#" + key)
                                .closest(".fv-row")
                                .addClass("has-danger");
                        });
                        drawer.show();
                    },
                });
            } else {
                console.log("Manual form validation failed.");
            }
        });
   
    };
    
    flatpickr("#start_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        minDate: "today",
        defaultDate: null,
    });

    flatpickr("#end_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        minDate: "today",
        defaultDate: null,
    });
    // Initialize the validation and form submission handling
    initAddTrainingCalendar();
    
    // Initialize the validation and form submission handling
    initAddTrainingCalendar();
    

    // Initialize the validation
    initAddTrainingCalendar();


    var updateTrainingCalendarList = function () {
        IpixJson.dataTables["listTrainingCalendars"].ajax.reload();
    };

    return {
        init: function () {
            initTrainingCalendarList();
            initAddTrainingCalendar();
            // IpixDrawer.initDrawers();
        },
    };
})();

IpixUtil.onDOMContentLoaded(function () {
    IpixListTrainingCalendar.init();
});
