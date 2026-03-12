"use strict";
require("../../../../../../resources/js/admin");
require("../../../../../../resources/plugins/datatable/datatable");
require("../../../../../../resources/plugins/tinymce/tinymce.js");

var IpixCourseListCourse = (function () {
  var initCourseList = function () {
    IpixJson.options.datatables.ajax = {
      url: $("#listCourse").data("url"),
      type: "POST",
      data: function (data) {
        data._token = _token;
        data.status = $("#status").val();
        data.category_id = $("#category_id").val();
      },
    };
    IpixJson.options.datatables.columns = [
      { data: "DT_RowIndex", orderable: false, searchable: false },
      { data: "title", name: "title", orderable: true, searchable: true },
      { data: "start_date", name: "start_date", orderable: true, searchable: true },
      { data: "status", orderable: true, searchable: true },
      { data: "action", orderable: false, searchable: false },
    ];
    IpixJson.dataTables["listCourse"] = $("#listCourse").DataTable(
      IpixJson.options.datatables
    );
    IpixJson.dataTables["listCourse"].on("draw", function () {
      IpixDatatable.handleDeleteRows();
      IpixMenu.createInstances();
    });
  };

  flatpickr("#start_date", {
    enableTime: false,
    dateFormat: "Y-m-d",
    minDate: "today",
    defaultDate: null,
  });

  $("[data-duration-type]").on("click", function () {
    $("[data-duration-type]").removeClass("active");
    $(this).addClass("active");
    $("#duration_type").val($(this).data("duration-type"));
  });

  // Function to handle pricing format change
  function handlePricingFormatChange() {
    if ($("#pricing_format").val() === "free") {
      $("#feeRow").hide();
      $("#fee").val("");
    } else {
      $("#feeRow").show();
    }
  }
  $("[data-pricing-format]").on("click", function () {
    $("[data-pricing-format]").removeClass("active");
    $(this).addClass("active");
    $("#pricing_format").val($(this).data("pricing-format"));
    handlePricingFormatChange();
  });

  return {
    init: function () {
      initCourseList();
      handlePricingFormatChange();
    },
  };
})();

var overview = function () {
  $("#overview-span").trigger("click");
};

IpixUtil.onDOMContentLoaded(function () {
  overview();
  IpixCourseListCourse.init();
});
