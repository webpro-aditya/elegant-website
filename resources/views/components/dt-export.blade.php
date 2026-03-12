<div class="export">
    <button type="button" class="btn btn-light-primary me-3" data-kt-export-menu="true" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
        <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>
        Export
    </button>
    <div id="datatable_example_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
        {{-- <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-export="copy"> Copy to clipboard </a>
        </div> --}}
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-export="excel"> Export as Excel </a>
        </div>
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-export="csv"> Export as CSV </a>
        </div>
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-export="pdf"> Export as PDF </a>
        </div>
    </div>
    <div data-dt-buttons="true" class="d-none" data-title="@yield('title')"></div>
</div>
