<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="ThemeSelect">
        <meta name="currency-symbol" content="{{ config('app.currency.symbol') }}">
        <title>@yield('title', 'Blank') | {{ config('settings.store.company_name', 'Elegant') }}</title>
        <link rel="apple-touch-icon" href="{{ Storage::disk('elegant')->url(config('settings.store.fav_icon')) }}">
        <link rel="shortcut icon" type="image/x-icon"
            href="{{ Storage::disk('elegant')->url(config('settings.store.fav_icon')) }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

        <link href="{{ mix('css/layouts/plugins.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ mix('css/layouts/app.css') }}" rel="stylesheet" type="text/css" />
        @stack('style')
    </head>

    <body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
        data-kt-app-header-stacked="true" data-kt-app-header-primary-enabled="true"
        data-kt-app-header-secondary-enabled="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true"
        data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">

        <div class="page-loader flex-column">
            <span class="spinner-border text-primary" role="status"></span>
        </div>
        <div class="d-flex flex-column flex-root app-root" id="fas_app_root">
            <!--begin::Page-->
            <div class="app-page flex-column flex-column-fluid" id="fas_app_page">
                @include('layouts.admin.topbar')
                <div class="app-wrapper flex-column flex-row-fluid" id="fas_app_wrapper">
                    <!--begin::Sidebar-->
                    @include('layouts.admin.navigation')
                    <div class="app-main flex-column flex-row-fluid" id="fas_app_main">
                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">
                            <!--begin::Content-->
                            @yield('toolbar')
                            <div id="fas_app_content" class="app-content">
                                <!--begin::Content container-->
                                <div id="fas_app_content_container" class="app-container container-fluid">
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                        @include('layouts.admin.footer')
                    </div>
                </div>
            </div>
        </div>

        <div class="general-notification d-none col-md-6">
            @if (session('success'))
                <div id="sessionSuccess" class="hide">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div id="sessionError" class="hide">{{ session('error') }}</div>
            @endif
        </div>

        <div id="model-area"></div>
        <div id="drawer-area"></div>

        @stack('script')
        @livewireScripts
    </body>

</html>
