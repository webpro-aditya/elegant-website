"use strict";
require('../../../../../resources/js/admin');
require('../../../../../resources/plugins/datatable/datatable');

var IpixRoleList = function() {

    var initUserList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#rolesUsersTable").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.role_id = $("#rolesUsersTable").data('role_id');
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name", name: "name", orderable: true, searchable: true },
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['rolesUsersTable'] = $('#rolesUsersTable').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['rolesUsersTable'].on('draw', function() {
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
    IpixRoleList.init();
});