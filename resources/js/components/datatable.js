"use strict";

// Class definition
var IpixDatatable = function() {};

IpixDatatable.exportButtons = function() {
    const exportMenuButton = document.querySelector('[ data-kt-export-menu="true"]');
    if (exportMenuButton && $(exportMenuButton).length) {
        exportMenuButton.addEventListener('click', function() {
            if (exportMenuButton.getAttribute("data-kt-export-initialized") !== "true") {
                var table = $(exportMenuButton).closest(".card").find("table");
                exportMenuButton.setAttribute("data-kt-export-initialized", "true");
                const exportButtonCon = document.querySelector('[data-dt-buttons="true"]');
                const documentTitle = $(exportButtonCon).data('title');
                var buttons = new $.fn.dataTable.Buttons(table, {
                    buttons: [{
                            extend: 'copyHtml5',
                            title: documentTitle,
                            exportOptions: {
                                columns: ":not(.export-none)"
                            }
                        },
                        {
                            extend: 'excel',
                            title: documentTitle,
                            exportOptions: {
                                columns: ":not(.export-none)"
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            title: documentTitle,
                            exportOptions: {
                                columns: ":not(.export-none)"
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            title: documentTitle,
                            exportOptions: {
                                columns: ":not(.export-none)"
                            }
                        }
                    ]
                }).container().appendTo($(exportButtonCon));

                const exButtons = document.querySelectorAll('#datatable_example_export_menu [data-kt-export]');
                exButtons.forEach(exButton => {
                    exButton.addEventListener('click', e => {
                        e.preventDefault();
                        const exportValue = e.target.getAttribute('data-kt-export');
                        const target = document.querySelector('.dt-buttons .buttons-' + exportValue);
                        target.click();
                    });
                });
            }
        });
    }
}

IpixDatatable.handleResetForm = function() {
    const resetButtons = document.querySelectorAll('[data-kt-table-filter="reset"]');
    resetButtons.forEach(function(resetButton) {
        resetButton.addEventListener('click', function() {

            const parentKtToolbarFilter = $(resetButton).closest('.kt-toolbar-filter');
            parentKtToolbarFilter.find("input, textarea, select").val("").change();
            IpixJson.dataTables[parentKtToolbarFilter.closest(".card").find("table").attr("id")].draw();
        });
    });

}
IpixDatatable.invokePageInput = function() {
    var pageInputs = document.querySelectorAll('[data-kt-table-filter="page"]');

    pageInputs.forEach(function(pageInput) {
        if (pageInput.getAttribute("data-kt-initialized") === "true") {
            return;
        }
        if (pageInput && $(pageInput).length) {
            pageInput.addEventListener('keyup', function() {
                let page = pageInput.value <= 0 ? 1 : pageInput.value;
                IpixJson.dataTables[$(pageInput).closest(".dataTables_wrapper").find("table").attr("id")].page(page - 1).draw('page');
            });
        }
        pageInput.setAttribute("data-kt-initialized", "true");
    });
}
IpixDatatable.handleFilterDatatable = function() {
    const filterButtons = document.querySelectorAll('[data-kt-table-filter="filter"]');
    filterButtons.forEach(function(filterButton) {
        filterButton.addEventListener('click', function() {
            IpixJson.dataTables[$(filterButton).closest(".card").find("table").attr("id")].draw();
        });
    });
}
IpixDatatable.handleSearchDatatable = function() {
    const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
    if (filterSearch && $(filterSearch).length) {
        filterSearch.addEventListener('keyup', function(e) {
            IpixJson.dataTables[$(filterSearch).closest(".card").find("table").attr("id")].search(e.target.value).draw();
        });
    }
}
IpixDatatable.handleRefreshDatatable = function() {
    const refresh = document.querySelector('[data-kt-table-filter="refresh"]');
    if (refresh && $(refresh).length) {
        refresh.addEventListener('click', function(e) {
            //refresh fileds in filter
            const resetButton = document.querySelectorAll('[data-kt-table-filter="reset"]');
            const parentKtToolbarFilter = $(resetButton).closest('.kt-toolbar-filter');
            parentKtToolbarFilter.find("input, textarea, select").val("").change();
            IpixJson.dataTables[parentKtToolbarFilter.closest(".card").find("table").attr("id")].draw();
            IpixJson.dataTables[$(refresh).closest(".card").find("table").attr("id")].draw();
        });
    }
}
IpixDatatable.handleDeleteRows = function() {
    const deleteButtons = document.querySelectorAll('[data-kt-table-delete="delete_row"]');
    if (deleteButtons && $(deleteButtons).length) {
        deleteButtons.forEach(d => {
            d.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    text: "Are you sure you want to delete ?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    },
                    inputPlaceholder: "Write something"
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: $(d).data("url"),
                            type: "delete",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            dataType: "json",
                            success: function(data) {
                                if (data.status == 1) {
                                    IpixJson.dataTables[$(d).parents("table").attr("id")].draw();
                                    toastr.success(data.message);
                                } else {
                                    toastr.error(data.message);
                                }
                            }
                        });
                    }
                });
            })
        });
    }
}

IpixDatatable.init = function() {
    IpixDatatable.invokePageInput();
    IpixDatatable.handleResetForm();
    IpixDatatable.handleFilterDatatable();
    IpixDatatable.handleSearchDatatable();
    IpixDatatable.exportButtons();
    IpixDatatable.handleRefreshDatatable();
};

IpixUtil.onDOMContentLoaded(function() {
    IpixDatatable.init();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixDatatable;
}