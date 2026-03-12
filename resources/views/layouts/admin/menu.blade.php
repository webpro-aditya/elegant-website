<div class="menu-sidebar menu menu-fit menu-column menu-rounded menu-title-gray-700 menu-icon-gray-700 menu-arrow-gray-700 fw-semibold fs-6 align-items-stretch flex-grow-1" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="true">
    <div class="menu-item @if (routeMatch(['dashboard_home'])) here show @endif py-1">
        <a class="menu-link" href="{{ route('dashboard_home') }}">
            <span class="menu-icon">
                <i class="ki-outline ki-home fs-4 me-2"></i>
            </span>
            <span class="menu-title">Dashboard</span>
        </a>
    </div>
    {!! sideMenu() !!}
</div>
