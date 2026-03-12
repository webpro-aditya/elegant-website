"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListPages = function() {

    var initPageList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listPages").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;

            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "title", name: "title", orderable: true, searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listPages'] = $('#listPages').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listPages'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initPageList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListPages.init();
});
