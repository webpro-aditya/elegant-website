"use strict";
require('../../../../../resources/js/admin');
require('../../../../../resources/plugins/datatable/datatable');

var IpixListFaq = function() {

    var initFaqList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listFaq").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.course_id = $('#course_id').val();

            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "question", name: "question", orderable: true, searchable: true },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listFaq'] = $('#listFaq').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listFaq'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initFaqList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListFaq.init();
});