"use strict";
require('../../../../../../resources/js/admin.js');
require('../../../../../../resources/plugins/datatable/datatable.js');
require("../../../../../../resources/plugins/tinymce/tinymce.js");

var IpixListQuizContents = function() {

    var initQuizList = function() {
        IpixJson.options.datatables.ajax = {
            "url": $("#listQuizContents").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.resource_id = $("#resource_id").val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "question", name: "question", orderable: true, searchable: true },
            { data: "status", orderable: false, searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listQuizContents'] = $('#listQuizContents').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listQuizContents'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    };

    return {
        init: function() {
            initQuizList();
        }
    };
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListQuizContents.init();
});
