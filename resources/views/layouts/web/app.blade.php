<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>@yield('meta_title', config('settings.company_name', 'Elegant'))</title>
    <meta name="title" content="@yield('meta_title', config('settings.company_name', 'Elegant'))">
    <meta name="description" content="@yield('meta_description')">
    @yield('meta_contents')
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta name="google-site-verification" content="QLxCi1Vr-IbPo2sDtrGm4RM5h7xUSom8-dBFatPHi8k" />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="ThemeSelect">
    <meta name="currency-symbol" content="{{ config('app.currency.symbol') }}">
    <link rel="apple-touch-icon" href="{{ Storage::disk('elegant')->url(config('settings.store.fav_icon')) }}">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ Storage::disk('elegant')->url(config('settings.store.fav_icon')) }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    <link href="{{ mix('css/layouts/web/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ mix('css/layouts/web/app.css') }}" rel="stylesheet" type="text/css" />

    @stack('head_info')
    @stack('style')
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5a785ff74b401e45400caec1/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    <!-- Google Tag Manager -->
    {!! config('settings.store.google_analytics_head') !!}
    <!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    {!! config('settings.store.google_analytics_body') !!}
    <!-- End Google Tag Manager (noscript) -->
    @include('layouts.web.header')

    {{ $slot }}
    @include('layouts.web.footer')


    <div class="general-notification d-none col-md-6">
        @if (session('success'))
            <div id="sessionSuccess" class="hide">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div id="sessionError" class="hide">{{ session('error') }}</div>
        @endif
    </div>

    @stack('script')
</body>

</html>