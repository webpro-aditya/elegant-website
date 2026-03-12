@section('title', 'Translation')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/translation/viewTranslation.css') }}">

@endpush

@push('script')
    <script src="{{ mix('js/admin/translation/viewTranslation.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
    @endsection

    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" aria-expanded="true">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Translation Details</h3>
            </div>
        </div>
        <div id="fd_account_settings_profile_details" class="collapse show">
            <form id="translationForm" action="{{ route('translation_save_translation') }}" method="post" class="form"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body border-top ">
                
                @foreach ($translations as $translation)
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">{{ ucwords(str_replace('_', ' ', $translation['key'])) }}</label>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6 fv-row">
                               
                                <input type="text" name="translations[{{ $translation['key'] }}][value_en]" class="form-control form-control-lg mb-3 mb-lg-0" value="{{ $translation['value_en'] }}" required/>
                            </div>
                            <div class="col-lg-6 fv-row">
                                
                                <input type="text" name="translations[{{ $translation['key'] }}][value_ar]" class="form-control form-control-lg mb-3 mb-lg-0" value="{{ $translation['value_ar'] }}" required/>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach                 

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button"
                        class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button> <button
                        type="submit" id="btnSubmit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
