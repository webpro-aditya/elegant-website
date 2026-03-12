@section('title', 'View Free Resources')

@push('script')
    <script src="{{ mix('js/admin/freeResource/viewFreeResource.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/freeResource/viewFreeResource.css') }}">
@endpush

<x-layout>

    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
        </x-toolbar>
    @endsection
    <div class="card mb-9">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <div
                    class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                    @if ($resource->thumbnail)
                        <img class="mw-50px mw-lg-75px" src="{{ Storage::disk('elegant')->url($resource->thumbnail) }}"
                            alt="image" />
                    @else
                        <img class="mw-50px mw-lg-75px" src="{{ asset('images/web/course-1.png') }}" alt="image" />
                    @endif
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-1">
                                <a href="#"
                                    class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{ $resource->english_name }}</a>
                                <span class="badge badge-light-success me-auto">{{ $resource->status }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="separator"></div>
            <div class="container">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold"
                    id="resourceTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview"
                            role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                    @if ($resource->type == 'interview')
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="resources-tab" data-bs-toggle="tab" href="#resources" role="tab"
                                aria-controls="resources" aria-selected="false">Resources Contents</a>
                        </li>
                    @else
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="quiz-tab" data-bs-toggle="tab" href="#quiz" role="tab"
                                aria-controls="quiz" aria-selected="false">Quiz Contents</a>
                        </li>
                    @endif

                </ul>
                <div class="tab-content py-6 pt-6" id="resourceTabsContent">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel"
                        aria-labelledby="overview-tab">
                        @include('resources::admin.freeResources.tabView.resourceOverview')
                    </div>
                    @if ($resource->type == 'interview')
                        <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                            @include('resources::admin.freeResources.tabView.freeResourceTab')'
                        </div>
                    @else
                        <div class="tab-pane fade" id="quiz" role="tabpanel" aria-labelledby="quiz-tab">
                            @include('resources::admin.freeResources.tabView.quizTab')'
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-layout>
