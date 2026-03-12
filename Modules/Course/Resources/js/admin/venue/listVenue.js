"use strict";
require("../../../../../../resources/js/admin");
require("../../../../../../resources/plugins/datatable/datatable");

var IpixVenueListVenue = (function () {

    var initVenueList = function () {
        IpixJson.options.datatables.ajax = {
            url: $("#listVenue").data("url"),
            type: "POST",
            data: function (data) {
                data._token = _token;
                data.status = $("#status").val();
            },
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "title", name: "title", orderable: true, searchable: true },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [[1, "asc"]];
        IpixJson.dataTables["listVenue"] = $("#listVenue").DataTable(
            IpixJson.options.datatables
        );
        IpixJson.dataTables["listVenue"].on("draw", function () {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    };

    $(".modal").on("click", '[data-dismiss="modal"]', function () {
        $(this).closest(".modal").modal("hide");
    });

    return {
        init: function () {
            initVenueList();
            $("#editVenueModal").modal();
            $("#editVenueModal").modal("show");
        },
    };
})();

IpixUtil.onDOMContentLoaded(function () {
    IpixVenueListVenue.init();
});
