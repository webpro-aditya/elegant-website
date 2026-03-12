@section('title', 'Social Configuration')

@push('style')
    <link rel="stylesheet" href="{{ mix('css/settings/socialSettings.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/settings/socialSettings.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
<x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
@endsection

    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" aria-expanded="true">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Social Configuration</h3>
            </div>
        </div>
        <div id="fd_account_settings_profile_details" class="collapse show">
            <form id="brandingForm" action="{{ route('settings_save_settings') }}" method="post" class="form" enctype="multipart/form-data">
                @csrf
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Facebook Url</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="facebook_url" class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Facebook Url" value="{{ old('facebook_url', $settings->get('facebook_url')->value) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Twitter Url</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="twitter_url" class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Twitter Url" value="{{ old('twitter_url', $settings->get('twitter_url')->value) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Youtube Url</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="youtube_url" class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Youtube Url" value="{{ old('youtube_url', $settings->get('youtube_url')->value) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Instagram Url</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="instagram_url" class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Instagram Url" value="{{ old('instagram_url', $settings->get('instagram_url')->value) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Linkedin Url</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="linkedin_url" class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Linkedin Url" value="{{ old('linkedin_url', $settings->get('linkedin_url')->value) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
