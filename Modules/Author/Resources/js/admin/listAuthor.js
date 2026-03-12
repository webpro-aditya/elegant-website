"use strict";
require('../../../../../resources/js/admin');
require('../../../../../resources/plugins/datatable/datatable');

var IpixListAuthor = function() {

    var initAuthorList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listAuthor").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name", name: "name", orderable: true, searchable: true },
            { data: "status", orderable: false , searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listAuthor'] = $('#listAuthor').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listAuthor'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initAuthorList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListAuthor.init();
});
