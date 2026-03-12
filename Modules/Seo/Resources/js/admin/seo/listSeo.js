"use strict";

require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable')

var IpixListSeo = function () {

    var initSeoList = function() {
        IpixJson.options.datatables.ajax = {
            "url": $("#listSeo").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.model = $("#model").val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "meta_title", name: "meta_title", orderable: true, searchable: true },
            { data: "model", name: "model", orderable: false, searchable: false },
            { data: "name", name: "name", orderable: false, searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listSeo'] = $('#listSeo').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listSeo'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }
    
    return {
        init: function () {
            initSeoList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixListSeo.init();
});
