@push('script')
<script src="{{ mix('js/admin/venue/editVenue.js') }}"></script>
@endpush

<div class="modal fade" id="editVenueModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="editVenueForm" class="form" action="{{ route('venue_update') }}" method="POST">
                @csrf

                <input type="hidden" name="id" id="editVenueId" value="{{ $venue->id }}">

                <div class="modal-header" id="venue_header">
                    <h2 class="fw-bold">Update Venue</h2>

                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>

                <div class="modal-body py-10 px-lg-17">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#venue_header" data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                            <label class="required fs-6 fw-semibold mb-2">Title</label>
                            <input type="text" class="form-control form-control-solid" placeholder="" name="title" value="{{ $venue->title }}" />
                        </div>
                        <div class="fv-row mb-15">
                            <label class="required fs-6 fw-semibold mb-2">Status</label>
                            <select name="status" aria-label="Select status" data-control="select2" data-placeholder="Select Status..." class="form-select form-select-solid" data-dropdown-parent="#editVenueModal">
                            <option value="active" {{ $venue->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $venue->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-center">
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
