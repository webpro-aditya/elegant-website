<div id="kt_app_header" class="app-header">
    <div class="app-header-primary">
        <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_primary_container">
            <div class="d-flex flex-stack flex-grow-1">
                <div class="d-flex">
                    <div class="app-header-logo d-flex flex-center gap-2 me-lg-15">
                        <button class="btn btn-icon btn-sm btn-custom d-flex d-lg-none ms-n2" id="kt_app_header_menu_toggle">
                            <i class="ki-outline ki-abstract-14 fs-2"></i>
                        </button>
                        <a href="{{ route('dashboard_home') }}">
                            <img alt="Logo" src="{{ asset('images/logos/logo_with_name.png') }}" class="mh-35px" />
                        </a>
                    </div>
                    <div class="d-flex align-items-stretch" id="kt_app_header_menu_wrapper">
                        <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="false" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="false" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_menu_wrapper'}">
                            <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-gray-900 menu-icon-gray-500 menu-arrow-gray-500 menu-state-icon-primary menu-state-bullet-primary fw-semibold fs-6 align-items-stretch my-5 my-lg-0 px-2 px-lg-0" id="#kt_app_header_menu" data-kt-menu="true">
                                <div class="menu-item @if (routeMatch(['dashboard_home'])) here show @endif menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                    <a href="{{ route('dashboard_home') }}" class="menu-link">
                                        <span class="menu-title">Dashboard</span>
                                    </a>
                                </div>
                                {{-- @can('course_read')
                                <div class="menu-item @if (routeMatch(['course_list'])) here show @endif menu-lg-down-accordion me-0 me-lg-2">
                                    <a href="{{ route('course_list') }}" class="menu-link">
                                        <span class="menu-title">Courses</span>
                                        <span class="menu-arrow d-lg-none"></span></a>
                                </div>
                                @endcan --}}

                                @can('user_read')
                                <div class="menu-item @if (routeMatch(['user_list'])) here show @endif menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <a href="{{ route('user_list') }}" class="menu-link">
                                        <span class="menu-title">Users</span>
                                        <span class="menu-arrow d-lg-none"></span></a>
                                </div>
                                @endcan

                                @can('course_read')
                                <div class="menu-item @if (routeMatch(['course_list'])) here show @endif menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <a href="{{ route('course_list') }}" class="menu-link">
                                        <span class="menu-title">Course</span>
                                        <span class="menu-arrow d-lg-none"></span></a>
                                </div>
                                @endcan


                                <div class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <a href="{{ route('web_home', ['locale' => app()->getLocale()]) }}" target="_blank" class="menu-link">
                                        <span class="menu-title">Go to Website</span>
                                        <span class="menu-arrow d-lg-none"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-navbar flex-shrink-0 gap-2">
                    <div class="app-navbar-item ms-1">
                        <div class="cursor-pointer symbol position-relative symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <img src="{{ auth()->user() && auth()->user()->profile_picture && Storage::disk('elegant')->exists(auth()->user()->profile_picture) ? Storage::disk('elegant')->url(auth()->user()->profile_picture) : asset('images/avatars/blank.png') }}" alt="user" />
                        </div>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="{{ auth()->user() && auth()->user()->profile_picture && Storage::disk('elegant')->exists(auth()->user()->profile_picture) ? Storage::disk('elegant')->url(auth()->user()->profile_picture) : asset('images/avatars/blank.png') }}" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold d-flex align-items-center fs-5">
                                            {{ auth()->user()->name }}
                                        </div>
                                        <a href="javascript:void" class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-2"></div>
                            
                            <div class="menu-item px-5">
                                <a href="javascript:void(0);" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="menu-link px-5">Sign Out</a>
                                <form id="logout-form" action="{{ route('admin_logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="app-navbar-item d-lg-none" title="Show header menu">
                        <button class="btn btn-sm btn-icon btn-custom h-35px w-35px" id="kt_header_secondary_mobile_toggle">
                            <i class="ki-outline ki-element-4 fs-2"></i>
                        </button>
                    </div>
                    <div class="app-navbar-item d-lg-none me-n3" title="Show header menu">
                        <button class="btn btn-sm btn-icon btn-custom h-35px w-35px" id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-outline ki-setting-3 fs-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="app-header-secondary app-header-mobile-drawer" data-kt-drawer="false" data-kt-drawer-name="app-header-secondary" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="50px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#fas_header_secondary_mobile_toggle" data-kt-swapper="false" data-kt-swapper-mode="{default: 'append', lg: 'append'}" data-kt-swapper-parent="{default: '#fas_app_body', lg: '#fas_app_header'}">
        <div class="d-flex flex-column flex-grow-1 overflow-hidden">
            @can('pages_read')
            <div class="app-header-secondary-menu-main d-flex flex-grow-lg-1 align-items-end pt-3 pt-lg-2 px-3 px-lg-0 w-auto overflow-auto flex-nowrap">
                <div class="app-container container-fluid">
                    <div class="menu menu-rounded menu-nowrap flex-shrink-0 menu-row menu-active-bg menu-title-gray-700 menu-state-gray-900 menu-icon-gray-500 menu-arrow-gray-500 menu-state-icon-primary menu-state-bullet-primary fw-semibold fs-base align-items-stretch" id="#kt_app_header_secondary_menu" data-kt-menu="true">
                        <!-- <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here show">
                            <a href="{{ route('pages_list') }}" class="menu-link">
                                <span class="menu-title">Pages</span>
                            </a>
                        </div> -->
                        <div class="menu-item">
                            <a href="{{ route('dashboard_home') }}"
                                class="menu-link @if (routeMatch(['dashboard_home'])) active @endif">
                                <span class="menu-icon me-0">
                                    <i class="ki-outline ki-home fs-4 me-2"></i>
                                </span>
                            </a>
                        </div>
                        <div class="menu-item @if (routeMatch(['pages_list' ])) here show @endif">
                            <a class="menu-link" href="{{ route('pages_list') }}">
                                <span class="menu-title">Pages</span>
                            </a>
                        </div>
                       
                        <div class="menu-item">
                            <div class="menu-content">
                                <div class="menu-separator"></div>
                            </div>
                        </div>
                        {{-- <div class="menu-item @if (routeMatch(['contents_view', 'contents_add', 'contents_edit', 'contents_delete'], ['category' => 'testimonial'])) here show @endif">
                            <a class="menu-link" href="{{ route('contents_view', ['category' => 'testimonial']) }}">
                                <span class="menu-title">Testimonials</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <div class="menu-content">
                                <div class="menu-separator"></div>
                            </div>
                        </div>
                        <div class="menu-item @if (routeMatch(['contents_view', 'contents_add', 'contents_edit', 'contents_delete'], ['category' => 'clients'])) here show @endif">
                            <a class="menu-link" href="{{ route('contents_view', ['category' => 'clients']) }}">
                                <span class="menu-title">Clients</span>
                            </a>
                        </div>
                        <div class="menu-item @if (routeMatch(['contents_view', 'contents_add', 'contents_edit', 'contents_delete'], ['category' => 'features'])) here show @endif">
                            <a class="menu-link" href="{{ route('contents_view', ['category' => 'features']) }}">
                                <span class="menu-title">Features</span>
                            </a>
                        </div> --}}
                        <div class="menu-item">
                            <div class="menu-content">
                                <div class="menu-separator"></div>
                            </div>
                        </div>
                        <!-- <div class="menu-item">
                            <a class="menu-link" href="apps/customers/list.html">
                                <span class="menu-title">user</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <div class="menu-content">
                                <div class="menu-separator"></div>
                            </div>
                        </div> -->
                        {{-- <div class="menu-item">
                            <a class="menu-link" href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-plus fs-3"></i>
                                </span>
                                <span class="menu-title">Add New</span>
                            </a>
                        </div> --}}
                        <div class="menu-item flex-grow-1"></div>
                        <div class="menu-item">
                            <div class="menu-content">
                                <div class="menu-separator d-block d-lg-none"></div>
                            </div>
                        </div>
                        {{-- <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-plus fs-3"></i>
                                </span>
                                <span class="menu-title">Extensions</span>
                            </a>
                        </div> --}}
                        <div class="menu-item">
                            <div class="menu-content">
                                <div class="menu-separator"></div>
                            </div>
                        </div>
                        {{-- <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end" class="menu-item">
                            <span class="menu-link">
                                <span class="menu-title">Tools</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-dropdown px-lg-2 py-lg-4 w-150px w-lg-175px">
                                <div class="menu-item">
                                    <a class="menu-link" href="https://preview.keenthemes.com/metronic8/demo60/layout-builder.html">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-chart-simple fs-3"></i>
                                        </span>
                                        <span class="menu-title">Layout Builder</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="https://preview.keenthemes.com/html/metronic/docs/getting-started/changelog">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-code fs-3"></i>
                                        </span>
                                        <span class="menu-title">Changelog</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="https://preview.keenthemes.com/html/metronic/docs">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-abstract-26 fs-3"></i>
                                        </span>
                                        <span class="menu-title">Docs</span>
                                    </a>
                                </div>
                            </div> 
                        </div> --}}
                    </div>
                </div>
            </div>
            @endcan

           {{-- @can('settings_read')
            <div class="app-header-secondary-menu-sub d-flex align-items-stretch flex-grow-1">
                <div class="app-container d-flex flex-column flex-lg-row align-items-stretch justify-content-lg-between container-fluid">
                    <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-gray-900 menu-icon-gray-500 menu-arrow-gray-500 menu-state-icon-primary menu-state-bullet-primary fw-semibold fs-base align-items-stretch my-2 my-lg-0 px-2 px-lg-0" id="#kt_app_header_tertiary_menu" data-kt-menu="true">
                        <div class="menu-item">
                            <a class="menu-link active" href="{{ route('settings_branding_view') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-abstract-41 fs-4 me-2 text-primary"></i>
                                </span>
                                <span class="menu-title">Branding</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link active" href="{{ route('settings_social_view') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-picture fs-4 text-info"></i>
                                </span>
                                <span class="menu-title">Social</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link active" href="{{ route('settings_config_view') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-element-11 fs-4 text-success"></i>
                                </span>
                                <span class="menu-title">Website</span>
                            </a>
                        </div>
                         
                        <div class="menu-item">
                            <a class="menu-link active" href="{{ route('settings_keys_view') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-abstract-44 fs-4 text-danger"></i>
                                </span>
                                <span class="menu-title">Key Settings</span>
                            </a>   
                        </div>
                        <div class="menu-item">
                            <a class="menu-link active" href="{{ route('seo_list') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-frame fs-4 text-primary "></i>
                                </span>
                                <span class="menu-title">SEO</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link active" href="{{ route('faq_list') }}">
                                <span class="menu-icon">
                                    <i class="fas fa-question  fs-4 text-warning"></i>
                                </span>
                                <span class="menu-title">FAQ</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link active" href="{{ route('enquiry_list') }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-comments fs-4 text-success"></i>
                                </span>
                                <span class="menu-title">Enquiry</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link active" href="{{ route('course_curriculum_list') }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-comments fs-4 text-success"></i>
                                </span>
                                <span class="menu-title">Curriculum</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link active" href="{{ route('contents_view', ['category' => 'contact-information']) }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-map-location fs-4 text-primary"></i>
                                </span>
                                <span class="menu-title">Contact Information</span>
                            </a>
                        </div> 
                    </div>
                     <div id="kt_header_search" class="header-search d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
                        <div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
                            <div class="btn btn-icon btn-active-color-primary ms-1">
                                <i class="ki-outline ki-magnifier fs-3"></i>
                            </div>
                        </div>
                        <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
                            <div data-kt-search-element="wrapper">
                                <form data-kt-search-element="form" class="w-100 position-relative mb-3" autocomplete="off">
                                    <i class="ki-outline ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-0"></i>
                                    <input type="text" class="search-input form-control form-control-flush ps-10" name="search" value="" placeholder="Search..." data-kt-search-element="input" />
                                    <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1" data-kt-search-element="spinner">
                                        <span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
                                    </span>
                                    <span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none" data-kt-search-element="clear">
                                        <i class="ki-outline ki-cross fs-2 fs-lg-1 me-0"></i>
                                    </span>
                                    <div class="position-absolute top-50 end-0 translate-middle-y" data-kt-search-element="toolbar">
                                        <div data-kt-search-element="preferences-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-1" data-bs-toggle="tooltip" title="Show search preferences">
                                            <i class="ki-outline ki-setting-2 fs-2"></i>
                                        </div>
                                        <div data-kt-search-element="advanced-options-form-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary" data-bs-toggle="tooltip" title="Show more search options">
                                            <i class="ki-outline ki-down fs-2"></i>
                                        </div>
                                    </div>
                                </form>
                                <div class="separator border-gray-200 mb-6"></div>
                                <div data-kt-search-element="results" class="d-none">
                                    <div class="scroll-y mh-200px mh-lg-350px">
                                        <h3 class="fs-5 text-muted m-0 pb-5" data-kt-search-element="category-title">Users</h3>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <img src="{{ asset('images/avatars/300-6.jpg') }}" alt="" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">Karina Clark</span>
                                                <span class="fs-7 fw-semibold text-muted">Marketing Manager</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <img src="{{ asset('images/avatars/300-2.jpg') }}" alt="" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">Olivia Bold</span>
                                                <span class="fs-7 fw-semibold text-muted">Software Engineer</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <img src="{{ asset('images/avatars/300-9.jpg') }}" alt="" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">Ana Clark</span>
                                                <span class="fs-7 fw-semibold text-muted">UI/UX Designer</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <img src="{{ asset('images/avatars/300-14.jpg') }}" alt="" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">Nick Pitola</span>
                                                <span class="fs-7 fw-semibold text-muted">Art Director</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <img src="{{ asset('images/avatars/300-11.jpg') }}" alt="" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">Edward Kulnic</span>
                                                <span class="fs-7 fw-semibold text-muted">System Administrator</span>
                                            </div>
                                        </a>
                                        <h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Customers</h3>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <img class="w-20px h-20px" src="{{ asset('images/svg/brand-logos/volicity-9.svg') }}" alt="" />
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">Company Rbranding</span>
                                                <span class="fs-7 fw-semibold text-muted">UI Design</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <img class="w-20px h-20px" src="{{ asset('images/svg/brand-logos/tvit.svg') }}" alt="" />
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">Company Re-branding</span>
                                                <span class="fs-7 fw-semibold text-muted">Web Development</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <img class="w-20px h-20px" src="{{ asset('images/svg/misc/infography.svg') }}" alt="" />
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">Business Analytics App</span>
                                                <span class="fs-7 fw-semibold text-muted">Administration</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <img class="w-20px h-20px" src="{{ asset('images/svg/brand-logos/leaf.svg') }}" alt="" />
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">EcoLeaf App Launch</span>
                                                <span class="fs-7 fw-semibold text-muted">Marketing</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <img class="w-20px h-20px" src="{{ asset('images/svg/brand-logos/tower.svg') }}" alt="" />
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column justify-content-start fw-semibold">
                                                <span class="fs-6 fw-semibold">Tower Group Website</span>
                                                <span class="fs-7 fw-semibold text-muted">Google Adwords</span>
                                            </div>
                                        </a>
                                        <h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Projects</h3>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-notepad fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fs-6 fw-semibold">Si-Fi Project by AU Themes</span>
                                                <span class="fs-7 fw-semibold text-muted">#45670</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-frame fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fs-6 fw-semibold">Shopix Mobile App Planning</span>
                                                <span class="fs-7 fw-semibold text-muted">#45690</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-message-text-2 fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fs-6 fw-semibold">Finance Monitoring SAAS Discussion</span>
                                                <span class="fs-7 fw-semibold text-muted">#21090</span>
                                            </div>
                                        </a>
                                        <a href="#" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-profile-circle fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fs-6 fw-semibold">Dashboard Analitics Launch</span>
                                                <span class="fs-7 fw-semibold text-muted">#34560</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="mb-5" data-kt-search-element="main">
                                    <div class="d-flex flex-stack fw-semibold mb-4">
                                        <span class="text-muted fs-6 me-2">Recently Searched:</span>
                                    </div>
                                    <div class="scroll-y mh-200px mh-lg-325px">
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-laptop fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">BoomApp by Keenthemes</a>
                                                <span class="fs-7 text-muted fw-semibold">#45789</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-chart-simple fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Kept API Project Meeting</a>
                                                <span class="fs-7 text-muted fw-semibold">#84050</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-chart fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"KPI Monitoring App Launch</a>
                                                <span class="fs-7 text-muted fw-semibold">#84250</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-chart-line-down fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">Project Reference FAQ</a>
                                                <span class="fs-7 text-muted fw-semibold">#67945</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-sms fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"FitPro App Development</a>
                                                <span class="fs-7 text-muted fw-semibold">#84250</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-bank fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">Shopix Mobile App</a>
                                                <span class="fs-7 text-muted fw-semibold">#45690</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="symbol symbol-40px me-4">
                                                <span class="symbol-label bg-light">
                                                    <i class="ki-outline ki-chart-line-down fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold">"Landing UI Design" Launch</a>
                                                <span class="fs-7 text-muted fw-semibold">#24005</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div data-kt-search-element="empty" class="text-center d-none">
                                    <div class="pt-10 pb-10">
                                        <i class="ki-outline ki-search-list fs-4x opacity-50"></i>
                                    </div>
                                    <div class="pb-15 fw-semibold">
                                        <h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
                                        <div class="text-muted fs-7">Please try again with a different query</div>
                                    </div>
                                </div>
                            </div>
                            <form data-kt-search-element="advanced-options-form" class="pt-1 d-none">
                                <h3 class="fw-semibold text-gray-900 mb-7">Advanced Search</h3>
                                <div class="mb-5">
                                    <input type="text" class="form-control form-control-sm form-control-solid" placeholder="Contains the word" name="query" />
                                </div>
                                <div class="mb-5">
                                    <div class="nav-group nav-group-fluid">
                                        <label>
                                            <input type="radio" class="btn-check" name="type" value="has" checked="checked" />
                                            <span class="btn btn-sm btn-color-muted btn-active btn-active-primary">All</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="btn-check" name="type" value="users" />
                                            <span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Users</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="btn-check" name="type" value="orders" />
                                            <span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Orders</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="btn-check" name="type" value="projects" />
                                            <span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Projects</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <input type="text" name="assignedto" class="form-control form-control-sm form-control-solid" placeholder="Assigned to" value="" />
                                </div>
                                <div class="mb-5">
                                    <input type="text" name="collaborators" class="form-control form-control-sm form-control-solid" placeholder="Collaborators" value="" />
                                </div>
                                <div class="mb-5">
                                    <div class="nav-group nav-group-fluid">
                                        <label>
                                            <input type="radio" class="btn-check" name="attachment" value="has" checked="checked" />
                                            <span class="btn btn-sm btn-color-muted btn-active btn-active-primary">Has attachment</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="btn-check" name="attachment" value="any" />
                                            <span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Any</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <select name="timezone" aria-label="Select a Timezone" data-control="select2" data-dropdown-parent="#kt_header_search" data-placeholder="date_period" class="form-select form-select-sm form-select-solid">
                                        <option value="next">Within the next</option>
                                        <option value="last">Within the last</option>
                                        <option value="between">Between</option>
                                        <option value="on">On</option>
                                    </select>
                                </div>
                                <div class="row mb-8">
                                    <div class="col-6">
                                        <input type="number" name="date_number" class="form-control form-control-sm form-control-solid" placeholder="Lenght" value="" />
                                    </div>
                                    <div class="col-6">
                                        <select name="date_typer" aria-label="Select a Timezone" data-control="select2" data-dropdown-parent="#kt_header_search" data-placeholder="Period" class="form-select form-select-sm form-select-solid">
                                            <option value="days">Days</option>
                                            <option value="weeks">Weeks</option>
                                            <option value="months">Months</option>
                                            <option value="years">Years</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2" data-kt-search-element="advanced-options-form-cancel">Cancel</button>
                                    <a href="utilities/search/horizontal.html" class="btn btn-sm fw-bold btn-primary" data-kt-search-element="advanced-options-form-search">Search</a>
                                </div>
                            </form>
                            <form data-kt-search-element="preferences" class="pt-1 d-none">
                                <h3 class="fw-semibold text-gray-900 mb-7">Search Preferences</h3>
                                <div class="pb-4 border-bottom">
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                        <span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Projects</span>
                                        <input class="form-check-input" type="checkbox" value="1" checked="checked" />
                                    </label>
                                </div>
                                <div class="py-4 border-bottom">
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                        <span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Targets</span>
                                        <input class="form-check-input" type="checkbox" value="1" checked="checked" />
                                    </label>
                                </div>
                                <div class="py-4 border-bottom">
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                        <span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Affiliate Programs</span>
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </label>
                                </div>
                                <div class="py-4 border-bottom">
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                        <span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Referrals</span>
                                        <input class="form-check-input" type="checkbox" value="1" checked="checked" />
                                    </label>
                                </div>
                                <div class="py-4 border-bottom">
                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                        <span class="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">Users</span>
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </label>
                                </div>
                                <div class="d-flex justify-content-end pt-7">
                                    <button type="reset" class="btn btn-sm btn-light fw-bold btn-active-light-primary me-2" data-kt-search-element="preferences-dismiss">Cancel</button>
                                    <button type="submit" class="btn btn-sm fw-bold btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div> 
                </div>
            </div>
            @endcan--}}
        </div>
    </div>
</div>