"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListDiscount = function() {

    var initDiscountList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listDiscounts").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "title", name: "title", orderable: true, searchable: false },
            { data: "code", name: "code", orderable: false, searchable: false },
            { data: "discount_percentage", name: "discount_percentage", orderable: false, searchable: false },
            { data: "valid_from", name: "valid_from", orderable: false, searchable: false },
            { data: "valid_to", name: "valid_to", orderable: false, searchable: false },
            { data: "attempt_per_user", name: "attempt_per_user", orderable: false, searchable: false },
            { data: "status", orderable: false, searchable: false },
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listDiscounts'] = $('#listDiscounts').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listDiscounts'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    return {
        init: function() {
            initDiscountList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListDiscount.init();
});
