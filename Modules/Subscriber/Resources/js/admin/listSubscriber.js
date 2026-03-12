"use strict";
require('../../../../../resources/js/admin');
require('../../../../../resources/plugins/datatable/datatable');

var IpixListSubscriber = function() {

    var initGalleryList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listSubscriber").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.email = $('#email').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "email", name: "email", orderable: true, searchable: true },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listSubscriber'] = $('#listSubscriber').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listSubscriber'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initGalleryList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListSubscriber.init();
});