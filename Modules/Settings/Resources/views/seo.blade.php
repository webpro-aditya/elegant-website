@section('title', 'Social Configuration')

@push('style')
    <link rel="stylesheet" href="{{ mix('css/settings/seo.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/settings/seo.js') }}"></script>
@endpush

<x-layout :breadcrumbs="$breadcrumbs">

    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" aria-expanded="true">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">SEO</h3>
            </div>
        </div>
        <div id="kt_account_settings_profile_details" class="collapse show">
            <form id="brandingForm" action="{{ route('settings_save_settings') }}" method="post"
                class="form" enctype="multipart/form-data">
                @csrf
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">SEO Title</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="seo_title" id="seo_title"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        placeholder="SEO Title"
                                        value="{{ old('seo_title', $settings->get('seo_title')->value) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Google Analytics (Head Section)</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <textarea id="google_analytics_head" name="google_analytics_head" data-kt-tinymce-editor="true"
                                        data-kt-initialized="false" class="form-control min-h-200px mb-2">{!! old('google_analytics_head', $settings->get('google_analytics_head')->value) !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Google Analytics (Body Section)</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <textarea id="google_analytics_body" name="google_analytics_body" data-kt-tinymce-editor="true"
                                        data-kt-initialized="false" class="form-control min-h-200px mb-2">{!! old('google_analytics_body', $settings->get('google_analytics_body')->value) !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
