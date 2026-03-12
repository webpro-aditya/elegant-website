"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');
require("../../../../../../resources/plugins/tinymce/tinymce.js");

var IpixListResourceContents = function() {


    var initAuthorList = function() {
        IpixJson.options.datatables.ajax = {
            "url": $("#listResourceContents").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.resource_id = $("#resource_id").val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "question", name: "question", orderable: false, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listResourceContents'] = $('#listResourceContents').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listResourceContents'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    };

    return {
        init: function() {
            initAuthorList();
        }
    };
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListResourceContents.init();
});
