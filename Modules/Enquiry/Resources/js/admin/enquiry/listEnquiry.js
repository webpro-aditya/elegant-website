"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListEnquiry = function () {

    var initEnquiryList = function () {

        IpixJson.options.datatables.ajax = {
            "url": $("#listEnquiry").data('url'),
            "type": "POST",
            "data": function (data) {
                data._token = _token;
                data.type = $('#type').val();
                data.course_id = $('#course_id').val();
                data.start_date = $('#start_date').val();
                data.end_date = $('#end_date').val();
            }
        };
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            onChange: function (selectedDates, dateStr) {
                if (selectedDates.length === 2) {
                    let start = selectedDates[0].toISOString().split('T')[0];
                    let end = selectedDates[1].toISOString().split('T')[0];
                    $('#start_date').val(start);
                    $('#end_date').val(end);
                }
            }
        });
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "name", name: "name", orderable: true, searchable: false },
            { data: "email", name: "email", orderable: true, searchable: false },
            { data: "type", orderable: true, searchable: true },
            { data: "created_at", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false, className: "export-none" },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listEnquiry'] = $('#listEnquiry').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listEnquiry'].on('draw', function () {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function () {
            initEnquiryList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixListEnquiry.init();
});
