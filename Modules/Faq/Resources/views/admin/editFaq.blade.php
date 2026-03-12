@section('title', 'Edit FAQ')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/editFaq.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/editFaq.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="editFaqForm" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data"
    action="{{ route('faq_update') }}" method="POST">
    @csrf
    <input type="hidden" name="faq_id" id="faq_id" value="{{$faq->id}}">
    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Status</h2>
                </div>
                <div class="card-toolbar">
                    @if ($faq->status == 'active')
                    <div class="rounded-circle bg-success w-15px h-15px" id="faq_status"></div>
                @else
                    <div class="rounded-circle bg-danger w-15px h-15px" id="faq_status"></div>
                @endif                </div>
            </div>
            <div class="card-body pt-0">
                <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                    data-placeholder="Select an option" id="faq_status_select">
                    <option value="active" @if ($faq->status == 'active') selected @endif>Active</option>
                    <option value="inactive" @if ($faq->status == 'inactive') selected @endif>Inactive</option>
                </select>
                <div class="text-muted fs-7">Set the faq status.</div>
            </div>
        </div>
    </div>

       @include('faq::admin.editTab.editFaqTab')
       <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
        <button type="submit" id="btnSubmit" class="btn btn-primary">
            <span class="indicator-label">Save Changes</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
</form>

</x-layout>