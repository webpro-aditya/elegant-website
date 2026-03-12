@section('title', 'View Course')

@push('script')
    <script src="{{ mix('js/admin/course/trainingCalendar/listTrainingCalendar.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
        </x-toolbar>
    @endsection

    @include('course::admin.course.courseInfo', ['activeMenu' => 'training-calender', 'course' => $course])

    <div class="card">
        <div class="card-header">
            <div class="card-title fs-3 fw-bold">Training Calendar</div>
        </div>
        <div class="card-header border-0 pt-6">
            <x-dt-toolbar>
                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px kt-toolbar-filter" data-kt-menu="true"
                    id="kt-toolbar-filter">
                    <div class="px-5 py-3">
                        <div class="fs-4 text-dark fw-bold">Filter Options</div>
                    </div>
                    <div class="separator border-gray-200"></div>
                    <div class="px-5 py-3">
                        <div class="mb-5">
                            <label class="form-label fs-5 fw-semibold mb-3">Status:</label>
                            <select id="status" class="form-select" data-kt-select2="true"
                                data-placeholder="Select status" data-allow-clear="true"
                                data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="outdate">Outdate</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true" data-kt-table-filter="reset">Reset</button>
                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                data-kt-table-filter="filter">Apply</button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-bg-success btn-active-color-primary me-3 text-inverse-dark"
                    data-kt-drawer-show="true" data-kt-drawer-target="#kt_drawer_add_training_calendar">Add Training
                    Calendar <i class="ki-outline ki-plus fs-3 text-inverse-dark"></i></button>

            </x-dt-toolbar>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="listTrainingCalendars"
                data-url="{{ route('course_training_calendar_table', ['course_id' => $course->id]) }}">

                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Title</th>
                        <th class="min-w-125px">Status</th>
                        <th class="min-w-70px">Actions</th>
                    </tr>
                </thead>

                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>

    <div id="kt_drawer_add_training_calendar" class="bg-body" data-kt-drawer="true"
        data-kt-drawer-name="training_calendar" data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'500px'}" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_drawer_add_training_calendar_toggle"
        data-kt-drawer-close="#kt_drawer_add_training_calendar_close">
        <div class="card shadow-none border-0 rounded-0 w-100">
            <div class="card-header" id="kt_drawer_add_training_calendar_header">
                <h3 class="card-title fw-bold text-gray-900">Add Training Calendar</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                        id="kt_drawer_add_training_calendar_close">
                        <i class="ki-outline ki-cross fs-1"></i> </button>
                </div>
            </div>
            <div class="card-body position-relative" id="kt_drawer_add_training_calendar_body">
                <form novalidate="novalidate" id="addTrainingCalendarForm"
                    action="{{ route('course_training_calendar_create') }}" method="POST"
                    class="form fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">

                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
                        role="tablist">
                        @foreach ($languages as $id => $language)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                                    id="language-{{ $id }}-tab" data-bs-toggle="tab"
                                    href="#language-{{ $id }}" role="tab"
                                    aria-controls="language-{{ $id }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ strtoupper($language) }}
                                </a>
                            </li>
                        @endforeach

                    </ul>

                    <div class="tab-content py-3">
                        @foreach ($languages as $id => $language)
                            @php
                                $languageCode = strtolower($language);
                            @endphp
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="language-{{ $id }}" role="tabpanel"
                                aria-labelledby="language-{{ $id }}-tab">
                                <!-- Language-specific inputs -->
                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <label for="venue_{{ $languageCode }}" class="form-label required">Venue
                                        ({{ $language }})
                                    </label>
                                    <input type="text" class="form-control" id="venue_{{ $languageCode }}"
                                        name="venue[{{ $languageCode }}]" required
                                        placeholder="Venue ({{ $language }})">
                                </div>

                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <label for="language_{{ $languageCode }}" class="form-label required">Language
                                        ({{ $language }})</label>
                                    <input type="text" class="form-control" id="language_{{ $languageCode }}"
                                        name="language[{{ $languageCode }}]" required
                                        placeholder="Language ({{ $language }})">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex flex-column mb-12 fv-row">
                        <label class="required fw-semibold fs-6 mb-2">Days</label>
                        @foreach ($days as $day)
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="days-{{ $day }}"
                                    name="days[]" value="{{ $day }}">
                                <label class="form-check-label" for="days-{{ $day }}">
                                    {{ $day }}
                                </label>
                            </div>
                        @endforeach
                        @error('days')
                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column mb-12 fv-row">
                        <label class="fw-semibold fs-6 mb-2">Start Time</label>
                        <input type="time" class="form-control form-control-solid flatpickr-input"
                            name="start_time" id="start_time" value="{{ old('start_time') }}" />
                        @error('start_time')
                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column mb-12 fv-row">
                        <label class="fw-semibold fs-6 mb-2">End Time</label>
                        <input type="time" class="form-control form-control-solid flatpickr-input" name="end_time"
                            id="end_time" value="{{ old('end_time') }}" />
                        @error('end_time')
                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column mb-12 fv-row">
                        <label class="fw-semibold fs-6 mb-2">Start Date</label>
                        <input type="text" class="form-control form-control-solid flatpickr-input"
                            name="start_date" id="start_date" value="{{ old('start_date') }}" />
                        @error('start_date')
                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column mb-12 fv-row">
                        <label class="fw-semibold fs-6 mb-2">End Date</label>
                        <input type="text" class="form-control form-control-solid flatpickr-input" name="end_date"
                            id="end_date" value="{{ old('end_date') }}" />
                        @error('end_date')
                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Status</label>
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                            data-placeholder="Select Status " name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="outdate">Outdate</option>
                        </select>
                    </div>
                    <div class="text-center pt-10">
                        <button type="button" class="btn btn-primary"
                            id="kt_drawer_add_training_calendar_close">Discard </button>
                        <button type="submit" class="btn btn-primary"
                            data-kt-users-modal-action="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
