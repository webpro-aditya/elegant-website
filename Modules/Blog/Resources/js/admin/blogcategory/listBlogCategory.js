"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListBlogCategory = function() {

    var initBlogCategoryList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listBlogCategory").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "name_en", name: "name_en", orderable: true, searchable: true },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listBlogCategory'] = $('#listBlogCategory').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listBlogCategory'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initBlogCategoryList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListBlogCategory.init();
});