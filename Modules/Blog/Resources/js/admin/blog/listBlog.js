"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListBlog = function() {

    var initBlogList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listBlog").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.status = $('#author_id').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "title", name: "title", orderable: true, searchable: false },
            { data: "author", name: "author", orderable: true, searchable: false },
            { data: "category", name: "category", orderable: true, searchable: false },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listBlog'] = $('#listBlog').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listBlog'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initBlogList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListBlog.init();
});
