"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListCareerApplicant = function() {

    var initCareerList = function() {
        IpixJson.options.datatables.ajax = {
            "url": $("#listCareerApplicant").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.career_id = $('#career_id').val();
            }

        };

        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "name", name: "name", orderable: true, searchable: true },
            { data: "career", name: "career", orderable: true, searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listCareerApplicant'] = $('#listCareerApplicant').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listCareerApplicant'].on('draw', function() {
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
    IpixListCareerApplicant.init();
});