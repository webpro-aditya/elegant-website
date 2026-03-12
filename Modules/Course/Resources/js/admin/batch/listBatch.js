"use strict";
require("../../../../../../resources/js/admin");
require("../../../../../../resources/plugins/datatable/datatable");

var IpixBatchListBatch = (function () {
  var initBatchList = function () {
    IpixJson.options.datatables.ajax = {
      url: $("#listBatch").data("url"),
      type: "POST",
      data: function (data) {
        data._token = _token;
        data.status = $("#status").val();
        data.course_id = $("#course_id").val();
      },
    };
    IpixJson.options.datatables.columns = [
      { data: "DT_RowIndex", orderable: false, searchable: false },
      { data: "name", name: "name", orderable: true, searchable: true },
      { data: "duration", name: "duration", orderable: true, searchable: true },
      { data: "status", orderable: true, searchable: true },
      { data: "action", orderable: false, searchable: false },
    ];
    IpixJson.options.datatables.order = [[1, "asc"]];
    IpixJson.dataTables["listBatch"] = $("#listBatch").DataTable(
      IpixJson.options.datatables
    );
    IpixJson.dataTables["listBatch"].on("draw", function () {
      IpixDatatable.handleDeleteRows();
      IpixMenu.createInstances();
    });
  };

  var validateAddBatchForm = function (e) {
    IpixJson.options.FormValidation.fields = {
      course_id: {
        validators: {
          notEmpty: {
            message: "Course is required",
          },
        },
      },
      duration: {
        validators: {
          notEmpty: {
            message: "Duration is required",
          },
        },
      },
      start_time: {
        validators: {
          notEmpty: {
            message: "Start Time is required",
          },
        },
      },
      end_time: {
        validators: {
          notEmpty: {
            message: "End Time is required",
          },
        },
      },
    };
    IpixJson.validators["addBatchForm"] = FormValidation.formValidation(
      document.getElementById("addBatchForm"),
      IpixJson.options.FormValidation
    );
  };

  var initAddBatch = function () {
    $(document).on("submit", "#addBatchForm", function (e) {
      e.preventDefault();
      var $submitButton = $(this).find('button[type="submit"]');
      var validator = IpixJson.validators["addBatchForm"];
      validator.validate().then((result) => {
        var isValid = result === "Valid" ? true : false;

        if (isValid) {
          var formData = $(this).serialize();
          var drawerElement = document.querySelector("#kt_drawer_add_batch");
          var drawer = IpixDrawer.getInstance(drawerElement);

          $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            data: formData,
            success: function (response) {
              if (!response.errors) {
                drawer.hide();
                $("#addBatchForm")[0].reset();
                updateBatchList();
              }
            },
            error: function (xhr, status, error) {
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
            complete: function () {
              // Reset the submit button state
              $submitButton.prop("disabled", false).text("Submit");
            },
          });
        } else {
          console.log("Form validation failed.");
        }
      });
    });
  };

  var updateBatchList = function () {
    IpixJson.dataTables["listBatch"].ajax.reload();
  };

  return {
    init: function () {
      initAddBatch();
      initBatchList();
      validateAddBatchForm();
      updateBatchList();
    },
  };
})();

IpixUtil.onDOMContentLoaded(function () {
  IpixBatchListBatch.init();
});
