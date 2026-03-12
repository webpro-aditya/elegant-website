"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListCareer = function() {

    var initCareerList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listCareer").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.category_id = $('#category_id').val();

            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "title", name: "title", orderable: true, searchable: true },
            { data: "category", name: "category", orderable: true, searchable: false },
            { data: "status", orderable: true, searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listCareer'] = $('#listCareer').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listCareer'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initCareerList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListCareer.init();
});