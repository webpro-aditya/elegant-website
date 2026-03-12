"use strict";
require("../../../../../../resources/js/admin");
require("../../../../../../resources/plugins/datatable/datatable");

var IpixCalendar = (function () {
    var initCalendarList = function () {
        IpixJson.options.datatables.ajax = {
            url: $("#listCalendar").data("url"),
            type: "POST",
            data: function (data) {
                data._token = _token;
                data.status = $("#status").val();
            },
        };

        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "title", name: "title", orderable: true, searchable: true },
            { data: "course", name: "course", orderable: true, searchable: true },
            { data: "batch", name: "batch", orderable: true, searchable: true },
            { data: "start_date", name: "start_date", orderable: true, searchable: true },
            { data: "end_date", name: "end_date", orderable: true, searchable: true },
            { data: "status", orderable: true, searchable: true },
        ];
        IpixJson.options.datatables.order = [[1, "asc"]];
        IpixJson.dataTables["listCalendar"] = $("#listCalendar").DataTable(
            IpixJson.options.datatables
        );
        IpixJson.dataTables["listCalendar"].on("draw", function () {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    };

    return {
        init: function () {
            initCalendarList();
        },
    };
})();

IpixUtil.onDOMContentLoaded(function () {
    IpixCalendar.init();

    if (typeof excludedRows !== 'undefined' && excludedRows.length > 0) {
        Swal.fire({
            title: 'Excluded Rows',
            html: '<ul>' + excludedRows.map(row => `<li>${JSON.stringify(row)}</li>`).join('') + '</ul>',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    }
});

