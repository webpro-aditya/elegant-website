"use strict";
require('../../../../../resources/js/admin');
require('../../../../../resources/plugins/datatable/datatable');

var IpixUsersListUser = function() {

    var initUserList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listUsers").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.role_id = $('#roleId').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name", name: "name", orderable: true, searchable: true },
            { data: "role", name: "role", orderable: false, searchable: false },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listUsers'] = $('#listUsers').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listUsers'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initUserList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixUsersListUser.init();
});