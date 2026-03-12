@section('title', 'Add SEO')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/seo/addSeo.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/seo/addSeo.js') }}"></script>
@endpush

<x-layout>
 @include('seo::admin.addTab.seoTab')
 <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
    <button type="submit" id="btnSubmit" class="btn btn-primary fv-button-submit">
        <span class="indicator-label">Save Changes</span>
        <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
    </button>
</div>
</x-layout>
