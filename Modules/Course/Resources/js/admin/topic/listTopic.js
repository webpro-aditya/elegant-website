"use strict";
require("../../../../../../resources/js/admin");
require("../../../../../../resources/plugins/datatable/datatable");

var IpixTopicListTopic = (function () {

    var initTopicList = function () {
        IpixJson.options.datatables.ajax = {
            url: $("#listTopic").data("url"),
            type: "POST",
            data: function (data) {
                data._token = _token;
                data.category_id = $("#category_id").val();
            },
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "code", name: "code", orderable: true, searchable: true },
            { data: "title", name: "title", orderable: true, searchable: true },
            { data: "category", name: "category", orderable: true, searchable: true},
            { data: "action", orderable: false, searchable: false },
        ];
        IpixJson.options.datatables.order = [[1, "asc"]];
        IpixJson.dataTables["listTopic"] = $("#listTopic").DataTable(
            IpixJson.options.datatables
        );
        IpixJson.dataTables["listTopic"].on("draw", function () {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    };

    $(".modal").on("click", '[data-dismiss="modal"]', function () {
        $(this).closest(".modal").modal("hide");
    });

    return {
        init: function () {
            initTopicList();
            $("#editTopicModal").modal();
            $("#editTopicModal").modal("show");
        },
    };
})();

IpixUtil.onDOMContentLoaded(function () {
    IpixTopicListTopic.init();
});
