@section('title', 'Add Discount')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/discount/editDiscount.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/discount/editDiscount.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="editDiscountForm"
        class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
        action="{{ route('discount_update') }}"
        enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $discount->id }}">

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        <div class="rounded-circle bg-success w-15px h-15px" id="discount_status"></div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="discount_status_select">
                        <option value="active" @if ($discount->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($discount->status == 'inactive') selected @endif>Inactive</option>
                        <option value="outdate" @if ($discount->status == 'outdate') selected @endif>Outdate</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Discount Details</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Coupon Title</label>
                        <input type="text" name="title" class="form-control mb-2" placeholder="Coupon Title"
                            id="title" value="{{ old('title', $discount->title) }}">
                        @error('title')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Coupon Code</label>
                        <input type="text" name="code" class="form-control mb-2" placeholder="Coupon Code"
                            id="code" value="{{ old('code', $discount->code) }}">
                        @error('code')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Discount Percentage</label>
                        <input type="number" name="percentage" class="form-control mb-2" id="percentage"
                            placeholder="Discount Percentage %"  value="{{ old('percentage', $discount->discount_percentage) }}" />
                        @error('percentage')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Valid From</label>
                        <input type="text" class="form-control form-control-solid flatpickr-input"
                            name="valid_from" id="valid_from" value="{{ old('valid_from', $discount->valid_from) }}" />
                        @error('valid_from')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Valid To</label>
                        <input type="text" class="form-control form-control-solid flatpickr-input"
                            name="valid_to" id="valid_to" value="{{ old('valid_to', $discount->valid_to) }}" />
                        @error('valid_to')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Attempt Per User</label>
                        <input type="number" name="attempt_per_user" class="form-control mb-2" id="attempt_per_user"
                            placeholder="Attempt Per User" value="{{ old('attempt_per_user', $discount->attempt_per_user) }}">
                        @error('attempt_per_user')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button"
                    class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
                <button type="submit" id="btnSubmit" class="btn btn-primary fv-button-submit">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-layout>
