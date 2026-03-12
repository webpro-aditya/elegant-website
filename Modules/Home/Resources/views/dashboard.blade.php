@section('title', 'Dashboard')

@push('style')
    <link rel="stylesheet" href="{{ mix('css/admin/home/dashboard.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/home/dashboard.js') }}"></script>
@endpush

<x-layout>
    <x-toolbar :breadcrumbs="[]"></x-toolbar>

    <div class="row gy-3 g-xl-12">

        


        {{-- <div class="col-xl-5 mb-xl-10">
            <!--begin::Slider Widget 1-->
            <div id="kt_sliders_widget_1_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
                <!--begin::Header-->
                <div class="card-header px-5">
                    <!--begin::Title-->
                    <h4 class="card-title d-flex align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Purachase</span>
                    </h4>
                </div>

                <div class="card-body p-0">
                    <div class="carousel-inner mt-n5">
                        <!--begin::Item-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center mb-5">

                            <!--begin::Info-->
                            <div class="m-0">

                                <div class="d-flex d-grid gap-5">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-column flex-shrink-0">
                                        <span class="d-flex align-items-center text-gray-500 fw-bold fs-7 mb-2">
                                            <i class="ki-outline ki-right-square fs-6 text-gray-600 me-2"></i>Purchase
                                            Count
                                            : 100</span>

                                        <span class="d-flex align-items-center text-gray-500 fw-bold fs-7 mb-2">
                                            <i class="ki-outline ki-right-square fs-6 text-gray-600 me-2"></i>Purchase Successful
                                            : 92</span>
                                    </div>
                                    <div class="d-flex flex-column flex-shrink-0">
                                        <!--begin::Section-->
                                        <span class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-2">
                                            <i class="ki-outline ki-right-square fs-6 text-gray-600 me-2"></i>
                                            Purchase Pending : 2</span>
                                        <!--end::Section-->
                                        <!--begin::Section-->
                                        <span class="d-flex align-items-center text-gray-500 fw-bold fs-7">
                                            <i class="ki-outline ki-right-square fs-6 text-gray-600 me-2"></i>Purchase Failed
                                            : 6</span>

                                        <!--end::Section-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Items-->
                            </div>


                            <!--end::Action-->
                        </div>

                        <!--end::Item-->
                    </div>
                    <!--end::Carousel-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Slider Widget 1-->
        </div> --}}


                <div class="col-xl-4 mb-xl-5">
                    <div id="kt_sliders_widget_1_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="card-header px-5">
                            <h4 class="card-title d-flex align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Total Enquiries</span>
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center mb-5">
                                <div class="m-0">
                                    <div class="d-flex d-grid gap-5">
                                        <div class="d-flex flex-column flex-shrink-0">
                                        </div>
                                        <div class="d-flex flex-column flex-shrink-0">
                                            <div class="m-0">
                                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $enquiryCount }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-xl-4 mb-xl-5">
                    <div id="kt_sliders_widget_1_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="card-header px-5">
                            <h4 class="card-title d-flex align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Course Count</span>
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center mb-5">
                                <div class="m-0">
                                    <div class="d-flex d-grid gap-5">
                                        <div class="d-flex flex-column flex-shrink-0">
                                        </div>
                                        <div class="d-flex flex-column flex-shrink-0">
                                            <div class="m-0">
                                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $courseCount}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-xl-4 mb-xl-5">
                    <div id="kt_sliders_widget_1_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="card-header px-5">
                            <h4 class="card-title d-flex align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Subscribers Count</span>
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center mb-5">
                                <div class="m-0">
                                    <div class="d-flex d-grid gap-5">
                                        <div class="d-flex flex-column flex-shrink-0">
                                        </div>
                                        <div class="d-flex flex-column flex-shrink-0">
                                            <div class="m-0">
                                                <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $subscriberCount}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        <div class="row m-0 p-0">
            <div class="col-xl-12 mb-xl-10">
                <div class="card h-md-100 mb-5 mb-xl-5">
                    <div class="card-header px-5 align-items-center border-0">
                        <h3 class="fw-bold text-gray-900 m-0">Latest Enquiries</h3>
                    </div>

                    <div class="card-body pt-2">
                        <div class="tab-content">
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="listEnquiry" data-url="{{ route('enquiry_table',['no_limit' => 10]) }}">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th>#</th>
                                            <th class="min-w-125px">Name</th>
                                            <th class="min-w-125px">Email</th>
                                            <th class="min-w-125px">Type</th>
                                        </tr>
                                    </thead>

                                    <tbody class="fw-semibold text-gray-600">
                                    </tbody>
                                </table>
                                <a href="{{route('enquiry_list')}} " class="btn btn-primary btn-sm me-lg-n7 mt-5 float-end">All Enquiries</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>


    </div>

</x-layout>
