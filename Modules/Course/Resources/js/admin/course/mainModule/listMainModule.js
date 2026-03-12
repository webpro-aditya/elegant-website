"use strict";

require("../../../../../../../resources/js/admin");
require("../../../../../../../resources/plugins/datatable/datatable");
require("../../../../../../../resources/plugins/tinymce/tinymce.js");

var IpixMainModulesListMainModules = (function() {

    var selectBox = function() {
        $(document).ready(function() {
            $('.title-select').select2({
                tags: true,
                allowClear: true
            });
        });
    }
    var initMainModuleList = function() {
        IpixJson.options.datatables.ajax = {
            url: $("#listMainModules").data("url"),
            type: "POST",
            data: function(data) {
                data._token = _token;
                data.course_id = $("#course_id").val();
                data.status = $("#status").val();
            },
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "title", name: "title", orderable: true, searchable: true },
            {
                data: "heading",
                name: "heading",
                orderable: true,
                searchable: true,
            },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables["listMainModules"] = $(
            "#listMainModules"
        ).DataTable(IpixJson.options.datatables);
        IpixJson.dataTables["listMainModules"].on("draw", function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
            IpixDrawer.initDrawers();
            IpixDrawer.createInstances();
        });
    };

    // var validateForm = function() {
    //     var isValid = true;

    //     // Reset all form validation state
    //     $('.is-invalid').removeClass('is-invalid');
    //     $('.invalid-feedback').hide();

    //     // Validate each title input within language tabs
    //     $('[id^="title_"]').each(function() {
    //         var titleInput = $(this);
    //         var titleValue = titleInput.val();

    //         if (!titleValue) {
    //             isValid = false;
    //             titleInput.addClass('is-invalid');
    //             if (titleInput.next('.invalid-feedback').length === 0) {
    //                 titleInput.after('<div class="invalid-feedback">Title is required.</div>');
    //             }
    //             titleInput.next('.invalid-feedback').show();
    //         } else {
    //             titleInput.addClass('is-valid');
    //         }
    //     });

    //     // Validate each heading input within language tabs
    //     $('[id^="heading_"]').each(function() {
    //         var headingInput = $(this);
    //         var headingValue = headingInput.val();

    //         if (!headingValue) {
    //             isValid = false;
    //             headingInput.addClass('is-invalid');
    //             if (headingInput.next('.invalid-feedback').length === 0) {
    //                 headingInput.after('<div class="invalid-feedback">Heading is required.</div>');
    //             }
    //             headingInput.next('.invalid-feedback').show();
    //         } else {
    //             headingInput.addClass('is-valid');
    //         }
    //     });

    //     return isValid;
    // };

    // var initAddMainModule = function() {
    //     $(document).on("submit", "#addMainModuleForm", function(e) {
    //         e.preventDefault();

    //         // Validate the form
    //         var isValid = validateForm();

    //         if (isValid) {
    //             // Form validation passed, proceed with AJAX
    //             var formData = $(this).serialize();
    //             var drawerElement = document.querySelector("#kt_drawer_add_main_module");
    //             var drawer = IpixDrawer.getInstance(drawerElement);

    //             $.ajax({
    //                 url: $(this).attr("action"),
    //                 type: "POST",
    //                 data: formData,
    //                 success: function(response) {
    //                     if (!response.errors) {
    //                         drawer.hide();
    //                         $("#addMainModuleForm")[0].reset();
    //                         location.reload();
    //                         toastr.success("Main Module added successfully");
    //                     }
    //                 },
    //                 error: function(xhr, status, error) {
    //                     console.error(xhr.responseText);
    //                     var errors = JSON.parse(xhr.responseText);
    //                     $.each(errors, function(key, value) {
    //                         $("#" + key)
    //                             .closest(".fv-row")
    //                             .find(".fv-plugins-message-container")
    //                             .html(value);
    //                         $("#" + key)
    //                             .closest(".fv-row")
    //                             .addClass("has-danger");
    //                     });
    //                     drawer.show();
    //                 },
    //             });
    //         } else {
    //             console.log("Form validation failed.");
    //         }
    //     });
    // };



    var updateMainModuleList = function() {
        IpixJson.dataTables["listMainModules"].ajax.reload();
    };

    return {
        init: function() {
            initMainModuleList();
            // initAddMainModule();
            selectBox();
            // IpixDrawer.initDrawers();
        },
    };
})();

IpixUtil.onDOMContentLoaded(function() {
    IpixMainModulesListMainModules.init();
});
