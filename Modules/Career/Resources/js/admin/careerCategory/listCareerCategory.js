"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListCareerCategory = function() {

    var initCareerCategoryList = function() {
        IpixJson.options.datatables.ajax = {
            "url": $("#listCareerCategory").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name_en", name: "name_en", orderable: true, searchable: true },
            { data: "status", orderable: true, searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listCareerCategory'] = $('#listCareerCategory').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listCareerCategory'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initCareerCategoryList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListCareerCategory.init();
});