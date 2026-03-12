"use strict";
require('../../../../../resources/js/admin');
require('../../../../../resources/plugins/datatable/datatable');

var IpixListGallery = function() {

    var initGalleryList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listGallery").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "name", name: "name", orderable: true, searchable: false },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listGallery'] = $('#listGallery').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listGallery'].on('draw', function() {
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
    IpixListGallery.init();
});
