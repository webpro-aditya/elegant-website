@push('script')
<script src="{{ mix('js/admin/topic/editTopic.js') }}"></script>
@endpush

<div class="modal fade" id="editTopicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="editTopicForm" class="form" action="{{ route('topic_update') }}" method="POST">
                @csrf

                <input type="hidden" name="id" id="editVenueId" value="{{ $topic->id }}">

                <div class="modal-header" id="topic_header">
                    <h2 class="fw-bold">Update Topic</h2>

                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>

                <div class="modal-body py-10 px-lg-17">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#topic_header" data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                            <label class="required fs-6 fw-semibold mb-2">Title</label>
                            <input type="text" class="form-control form-control-solid" placeholder="" name="title" value="{{ $topic->title }}" />
                        </div>
                        <div class="fv-row mb-15">
                            <label class="required fs-6 fw-semibold mb-2">Course Category</label>
                            <select name="category_id" aria-label="Select a Category" data-control="select2" data-placeholder="Select a Category..." class="form-select form-select-solid" data-dropdown-parent="#editTopicModal">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($category->id == $topic->category_id) selected @endif>
                                    {{ $category->name }}
                                </option>
                                @endforeach
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
