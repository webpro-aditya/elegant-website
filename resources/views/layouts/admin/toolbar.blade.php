<div id="kt_app_toolbar" class="app-toolbar mb-5">
    <div id="kt_app_toolbar_container" class="app-container p-0 container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">@yield('title')</h1>
                @if (isset($breadcrumbs) && $breadcrumbs)
                    <span class="h-20px border-gray-200 border-start mx-3 d-none"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item @if (isset($breadcrumb['link']) && $breadcrumb['link']) text-muted @endif">
                                @if (
                                    (!isset($breadcrumb['permission']) ||
                                        ((is_array($breadcrumb['permission']) &&
                                            auth()->user()->canany($breadcrumb['permission'])) ||
                                            auth()->user()->can($breadcrumb['permission']))) &&
                                        isset($breadcrumb['link']) &&
                                        $breadcrumb['link'] !== 'javascript:void(0)')
                                    <a href="{{ route($breadcrumb['link']) }}" class="text-muted text-hover-primary">
                                        {{ $breadcrumb['name'] }}
                                    </a>
                                @else
                                    {{ $breadcrumb['name'] }}
                                @endif
                            </li>
                            @if ($breadcrumb != end($breadcrumbs))
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="d-flex align-items-center flex-wrap">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
