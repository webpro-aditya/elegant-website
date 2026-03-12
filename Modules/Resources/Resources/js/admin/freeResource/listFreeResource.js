"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListFreeResources = function() {

    var initAuthorList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listFreeResource").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.type = $('#type').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name", name: "name", orderable: true, searchable: true },
            { data: "type", orderable: true, searchable: false },
            { data: "status", orderable: true, searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listFreeResource'] = $('#listFreeResource').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listFreeResource'].on('draw', function() {
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
    IpixListFreeResources.init();
});
