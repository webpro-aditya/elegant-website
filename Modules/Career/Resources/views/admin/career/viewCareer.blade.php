@section('title', 'List Career')

@push('script')
    <script src="{{ mix('js/admin/career/viewCareer.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/career/viewCareer.css') }}">
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
        </x-toolbar>
    @endsection

    <div class="card mb-9">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-1">
                                <a href="#"
                                    class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{ $career->title }}</a>
                                <span class="badge badge-light-success me-auto">{{ $career->status }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex flex-wrap justify-content-start">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-4 fw-bold">{{ $career->category->name_en }}</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-500">Category</div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-4 fw-bold">{{ $career->vaccancy }}</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-500">Vaccancy</div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-4 fw-bold">{{ $career->experience }}</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-500">Experience</div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-4 fw-bold">
                                        @if ($career->employment == 'full_time')
                                            Full Time
                                        @elseif ($career->employment == 'part_time')
                                            Part Time
                                        @else
                                            Contract
                                        @endif
                                    </div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-500">Employment</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="separator"></div>

            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
                role="tablist">
                @foreach ($languages as $id => $language)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                            id="language-{{ $id }}-tab" data-bs-toggle="tab"
                            href="#language-{{ $id }}" role="tab"
                            aria-controls="language-{{ $id }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ strtoupper($language->name) }}
                        </a>
                    </li>
                @endforeach
                @if ($seo != null)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6" id="seo-tab" data-bs-toggle="tab"
                            href="#seo" role="tab" aria-controls="seo" aria-selected="false">
                            SEO
                        </a>
                    </li>
                @endif
            </ul>
            <div class="card-body pt-4">
                @include('career::admin.career.tabView.careerInfo')
            </div>

        </div>
    </div>




</x-layout>
