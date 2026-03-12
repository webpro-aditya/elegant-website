@section('title', 'Edit Course Batch')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/batch/editBatch.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/batch/editBatch.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
    @endsection

    <form novalidate="novalidate" id="editBatchForm"
        class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework"
        action="{{ route('batch_update') }}" enctype="multipart/form-data" method="POST">
        @csrf

        <input type="hidden" name="id" value="{{ $batch->id }}">

        @if (isset($return) && $return != '')
            <input type="hidden" name="return" id="return" value="{{ $return }}">
        @endif

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush mb-6 mb-xl-9">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Batch Details</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-5 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Course</label>
                        <select class="form-select form-control-solid mb-2" name="course_id" data-kt-select2="true"
                            data-server="true" data-placeholder="Select Course"
                            data-option-url="{{ route('course_active_courses') }}" value="{{ old('course_id') }}">
                            @if (isset($old['course_id']) && $old['course_id'] != '')
                                <option value="{{ $old['course_id']->id }}">
                                    {{ $old['course_id']->title }}
                                </option>
                            @endif
                        </select>
                        @error('course_id')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Duration</label>
                        <input type="number" id="duration" name="duration" class="form-control mb-2"
                            placeholder="Duration" value="{{ old('duration', $batch->duration) }}">
                        @error('duration')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">Start Timing</label>
                        <div class="d-flex">
                            <input type="time" id="start_time" name="start_time" class="form-control me-2"
                                placeholder="Start Timing" value="{{ old('start_time', $batch->start_time) }}">
                            <select name="start_period" class="form-select form-control-solid mb-2"
                                data-kt-select2="true" data-server="false">
                                <option value="AM" {{ $batch->start_period == 'AM' ? 'selected' : '' }}>AM</option>
                                <option value="PM" {{ $batch->start_period == 'PM' ? 'selected' : '' }}>PM</option>
                            </select>
                        </div>
                        @error('start_time')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="required form-label">End Timing</label>
                        <div class="d-flex">
                            <input type="time" id="end_time" name="end_time" class="form-control me-2"
                                placeholder="End Timing" value="{{ old('end_time', $batch->end_time) }}">
                            <select name="end_period" class="form-select form-control-solid mb-2" data-kt-select2="true"
                                data-server="false">
                                <option value="AM" {{ $batch->end_period == 'AM' ? 'selected' : '' }}>AM</option>
                                <option value="PM" {{ $batch->end_period == 'PM' ? 'selected' : '' }}>PM</option>
                            </select>
                        </div>
                        @error('end_time')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label class="form-label">Days</label>
                        <input type="text" name="name" class="form-control mb-2" placeholder="Name"
                            value="{{ old('name', $batch->name) }}">
                        @error('name')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('batch_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary fv-button-submit">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-layout>
