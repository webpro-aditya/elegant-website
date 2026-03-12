"use strict";
require("../../../../../../resources/js/admin");
require("../../../../../../resources/plugins/datatable/datatable");

var IpixEnrollmentListEnrollment = (function () {

    var initEnrollmentList = function () {
        IpixJson.options.datatables.ajax = {
            url: $("#listEnrollment").data("url"),
            type: "POST",
            data: function (data) {
                data._token = _token;
                data.status = $('#status').val();
            },
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "course", name: "course.title", orderable: true, searchable: true },
            { data: "user", name: "user.name", orderable: true, searchable: true },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        // IpixJson.options.datatables.order = [[1, "asc"]];
        IpixJson.dataTables["listEnrollment"] = $("#listEnrollment").DataTable(
            IpixJson.options.datatables
        );
        IpixJson.dataTables["listEnrollment"].on("draw", function () {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    };

    return {
        init: function () {
            initEnrollmentList();
        },
    };
})();

IpixUtil.onDOMContentLoaded(function () {
    IpixEnrollmentListEnrollment.init();
});
