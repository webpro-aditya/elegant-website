"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListBrochure = function() {

    var initBrochureList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listBrochure").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.type = $('#type').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "name", name: "name", orderable: true, searchable: false },
            { data: "email", name: "email", orderable: true, searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listBrochure'] = $('#listBrochure').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listBrochure'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initBrochureList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListBrochure.init();
});
