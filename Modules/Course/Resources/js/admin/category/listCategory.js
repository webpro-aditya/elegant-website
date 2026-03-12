"use strict";
require('../../../../../../resources/js/admin');
require('../../../../../../resources/plugins/datatable/datatable');

var IpixCategoryListCategory = function () {
    function toggleParentCategoryFilter(show) {
        if (show) {
            $('#parentCategoryFilter').show();
        } else {
            $('#parentCategoryFilter').hide();
        }
    }
    toggleParentCategoryFilter(false);

    $('#category-tab').on('click', function (event) {
        event.preventDefault();
        $('#categoryTabContent').show();
        $('#subcategoryTabContent').hide();
        $('#category-tab').addClass('active');
        $('#subcategory-tab').removeClass('active');
        toggleParentCategoryFilter(false);

    });

    $('#subcategory-tab').on('click', function (event) {
        event.preventDefault();
        $('#categoryTabContent').hide();
        $('#subcategoryTabContent').show();
        $('#category-tab').removeClass('active');
        $('#subcategory-tab').addClass('active');
        toggleParentCategoryFilter(true);

    });
    // let type;
    // document.addEventListener('DOMContentLoaded', function() {
    //     const navLinks = document.querySelectorAll('.nav-link');


    //     function checkActiveTab() {
    //         navLinks.forEach(function(link) {
    //             if (link.classList.contains('active')) {
    //                 console.log('Active Tab:', link.id);
    //                 if (link.id === "category-tab") {
    //                     type = "category";
    //                 } else if (link.id === "subcategory-tab") {
    //                     type = "sub_category";
    //                 }
    //             }
    //         });
    //     }

    //     // Initial check for the active tab
    //     checkActiveTab();

    //     navLinks.forEach(function(link) {
    //         link.addEventListener('click', function() {
    //             navLinks.forEach(function(navLink) {
    //                 navLink.classList.remove('active');
    //             });
    //             this.classList.add('active');
    //             checkActiveTab();
    //         });
    //     });
    // });

    // var initCategoryList = function() {

    //     IpixJson.options.datatables.ajax = {
    //         "url": $("#listCategory").data('url'),
    //         "type": "POST",
    //         "data": function(data) {
    //             data._token = _token;
    //             data.status = $('#status').val();
    //             data.type = type;
    //         }
    //     };
    //     IpixJson.options.datatables.columns = [
    //         { data: "DT_RowIndex", orderable: false, searchable: false },
    //         { data: "name", name: "name", orderable: true, searchable: true },
    //         { data: "status", orderable: true, searchable: true },
    //         { data: "action", orderable: false, searchable: false },
    //     ];
    //     IpixJson.options.datatables.order = [
    //         [1, "asc"]
    //     ];
    //     IpixJson.dataTables['listCategory'] = $('#listCategory').DataTable(IpixJson.options.datatables);
    //     IpixJson.dataTables['listCategory'].on('draw', function() {
    //         IpixDatatable.handleDeleteRows();
    //         IpixMenu.createInstances();
    //     });
    // }

    // var initSubCategoryList = function() {

    //     IpixJson.options.datatables.ajax = {
    //         "url": $("#listSubCategory").data('url'),
    //         "type": "POST",
    //         "data": function(data) {
    //             data._token = _token;
    //             data.status = $('#status').val();
    //             data.parent_id = $('#parent_id').val();
    //             data.type = type;
    //         }
    //     };
    //     IpixJson.options.datatables.columns = [
    //         { data: "DT_RowIndex", orderable: false, searchable: false },
    //         { data: "name", name: "name", orderable: true, searchable: true },
    //         { data: "parent_category", name: "parent_category", orderable: true, searchable: true },
    //         { data: "status", orderable: true, searchable: true },
    //         { data: "action", orderable: false, searchable: false },
    //     ];
    //     IpixJson.options.datatables.order = [
    //         [1, "asc"]
    //     ];
    //     IpixJson.dataTables['listSubCategory'] = $('#listSubCategory').DataTable(IpixJson.options.datatables);
    //     IpixJson.dataTables['listSubCategory'].on('draw', function() {
    //         IpixDatatable.handleDeleteRows();
    //         IpixMenu.createInstances();
    //     });
    // }

    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-link');
        let activeTab = 'category'; // Default active tab
    
        function updateActiveTab(clickedLink) {
            // Remove the active class from the current active tab
            const activeLink = document.querySelector('.nav-link.active');
            if (activeLink) {
                activeLink.classList.remove('active');
            }
    
            // Add the active class to the clicked tab
            clickedLink.classList.add('active');
    
            // Update the active tab identifier and toggle content display
            if (clickedLink.id === 'category-tab') {
                activeTab = 'category';
                document.getElementById('categoryTabContent').style.display = 'block';
                document.getElementById('subcategoryTabContent').style.display = 'none';
            } else if (clickedLink.id === 'subcategory-tab') {
                activeTab = 'subcategory';
                document.getElementById('categoryTabContent').style.display = 'none';
                document.getElementById('subcategoryTabContent').style.display = 'block';
            }
    
            // Bind search input for the active tab
            bindSearchInput();
        }
    
        function initCategoryList() {
            IpixJson.options.datatables.ajax = {
                "url": $("#listCategory").data('url'),
                "type": "POST",
                "data": function (data) {
                    data._token = _token;
                    data.status = $('#status').val();
                    data.type = 'category';
                }
            };
    
            IpixJson.options.datatables.columns = [
                { data: "DT_RowIndex", orderable: false, searchable: false },
                { data: "title", name: "title", orderable: true, searchable: true },
                { data: "status", orderable: true, searchable: true },
                { data: "action", orderable: false, searchable: false },
            ];
    
            IpixJson.options.datatables.order = [
                [1, "asc"]
            ];
    
            IpixJson.dataTables['listCategory'] = $('#listCategory').DataTable(IpixJson.options.datatables);
    
            IpixJson.dataTables['listCategory'].on('draw', function () {
                IpixDatatable.handleDeleteRows();
                IpixMenu.createInstances();
            });
        }
    
        function initSubCategoryList() {
            IpixJson.options.datatables.ajax = {
                "url": $("#listSubCategory").data('url'),
                "type": "POST",
                "data": function (data) {
                    data._token = _token;
                    data.status = $('#status').val();
                    data.parent_id = $('#parent_id').val();
                    data.type = 'subcategory';
                }
            };
    
            IpixJson.options.datatables.columns = [
                { data: "DT_RowIndex", orderable: false, searchable: false },
                { data: "title", name: "title", orderable: true, searchable: true },
                { data: "parent_category", name: "parent_category", orderable: true, searchable: true },
                { data: "status", orderable: true, searchable: true },
                { data: "action", orderable: false, searchable: false },
            ];
    
            IpixJson.options.datatables.order = [
                [1, "asc"]
            ];
    
            IpixJson.dataTables['listSubCategory'] = $('#listSubCategory').DataTable(IpixJson.options.datatables);
    
            IpixJson.dataTables['listSubCategory'].on('draw', function () {
                IpixDatatable.handleDeleteRows();
                IpixMenu.createInstances();
            });
        }
    
        function reloadActiveTable() {
            if (activeTab === 'category') {
                IpixJson.dataTables['listCategory'].ajax.reload();
            } else if (activeTab === 'subcategory') {
                IpixJson.dataTables['listSubCategory'].ajax.reload();
            }
        }
    
        function bindSearchInput() {
            // Remove existing search event listeners if any
            const searchInputs = document.querySelectorAll('[data-kt-table-filter="search"]');
            searchInputs.forEach(input => input.removeEventListener('keyup', handleSearchInput));
    
            // Add search event listener for the active tab
            if (activeTab === 'category') {
                const searchInput = document.querySelector('#categoryTabContent [data-kt-table-filter="search"]');
                if (searchInput) {
                    searchInput.addEventListener('keyup', handleSearchInput);
                }
            } else if (activeTab === 'subcategory') {
                const searchInput = document.querySelector('#subcategoryTabContent [data-kt-table-filter="search"]');
                if (searchInput) {
                    searchInput.addEventListener('keyup', handleSearchInput);
                }
            }
        }
    
        function handleSearchInput(e) {
            const tableId = activeTab === 'category' ? 'listCategory' : 'listSubCategory';
            if (IpixJson.dataTables[tableId]) {
                IpixJson.dataTables[tableId].search(e.target.value).draw();
            }
        }
    
        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                updateActiveTab(this);
                reloadActiveTable();
            });
        });
    
        // Initialize both DataTables
        initCategoryList();
        initSubCategoryList();
    
        // Reload the current active table when the status filter is changed
        document.querySelector('[data-kt-table-filter="filter"]').addEventListener('click', function () {
            reloadActiveTable();
        });
    
        // Add click event listener to the refresh button
        document.querySelector('[data-kt-table-filter="refresh"]').addEventListener('click', function () {
            reloadActiveTable();
        });
    
        // Set the initial active tab and content display
        updateActiveTab(document.querySelector('.nav-link.active'));
    });
    


    return {
        init: function () {
            // initCategoryList();
            // initSubCategoryList();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixCategoryListCategory.init();
});