"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixListContents = function() {

    var initContentList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listContents").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.status = $('#status').val();
                data.contentSlug = $('#content_slug').val();
                data.categorySlug = $('#category_slug').val();
                data.course_id = $('#course_id').val();
            }
        };

        var columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "name", name: "name", orderable: true, searchable: true },
        ];
        
        // ✅ Add course column if testimonials
        if ($('#category_slug').val() === 'testimonials') {
            columns.push({ data: "course", name: "course", orderable: true, searchable: true });
        }
        
        columns.push(
            { data: "status", orderable: true, searchable: true },
            { data: "action", orderable: false, searchable: false }
        );
        
        IpixJson.options.datatables.columns = columns;

        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];

        // Initialize the DataTable and store the reference
        IpixJson.dataTables['listContents'] = $('#listContents').DataTable(IpixJson.options.datatables);

        // Ensure the DataTable is fully initialized before attaching event listeners
        IpixJson.dataTables['listContents'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    // Function to handle reset and refresh button clicks
    var resetBtnClick = function() {
        // Ensure the DataTable is initialized before using it
        if (IpixJson.dataTables['listContents']) {
            $('.reset').click(function(e) {
                e.preventDefault();
                $('#status').val(''); // Reset status filter
                
                IpixJson.dataTables['listContents'].ajax.reload();
            });
            document.querySelector('[data-kt-table-filter="refresh"]').addEventListener('click', function(e) {
                IpixJson.dataTables['listContents'].ajax.reload();
            });
        } else {
            console.error('DataTable listContents is not initialized.');
        }
    }

    return {
        init: function() {
            initContentList();   // Initialize the DataTable
            resetBtnClick();     // Attach event listeners after initialization
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixListContents.init();
});
