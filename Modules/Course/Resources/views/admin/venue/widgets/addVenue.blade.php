@push('script')
<script src="{{ mix('js/admin/venue/addVenue.js') }}"></script>
@endpush

<div class="modal fade" id="venueModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content rounded">
            <div class="modal-header">
                <h2 class="fw-bold">Add Venue</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <form id="addVenueForm" action="{{ route('venue_create') }}" method="POST">
                    @csrf
                    <div class="mb-13 text-center">
                    </div>
                    @if (isset($yes))
                    <input type="hidden" name="editCourse" value="{{ $yes }}">
                @endif
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="required fw-semibold fs-6 mb-2">Title</label>
                        <input type="text" name="title" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Title" value="" required />
                    </div>
                    <div class="row g-9 mb-8">
                        <div class="col-md-12 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Select Status</label>
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select an option " name="status" id="venue_status_select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
