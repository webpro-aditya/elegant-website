@section('title', 'Edit Training Calendar')

@push('script')
    <script src="{{ mix('js/admin/course/trainingCalendar/editTrainingCalendar.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
        </x-toolbar>
    @endsection


    <div class="card">
        <div class="card-header">
            <div class="card-title fs-3 fw-bold">{{ $trainingCalendar->title }}</div>
        </div>
        <div class="card-body pt-0">
            <div class="card shadow-none border-0 rounded-0">
                <div class="card-body position-relative">
                    <form novalidate="novalidate" id="editTrainingCalendarForm"
                        action="{{ route('course_training_calendar_update') }}" method="POST"
                        class="form ">
                        @csrf
                        <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="id" value="{{ $trainingCalendar->id }}">
                        <div class="row">

                            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5" role="tablist">
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
                            
                            <div class="tab-content row py-3">
                                @foreach ($languages as $id => $language)
                                    @php
                                        $languageCode = strtolower($language);
                                        $local = isset($calenderLocale[$languageCode]) ? $calenderLocale[$languageCode]->first() : null; // Check if data is available for the current language
                                    @endphp
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}" role="tabpanel"
                                        aria-labelledby="language-{{ $id }}-tab">
                                        <div class="row">
                                            <!-- Language-specific inputs -->
                                            <div class="col-md-6 language-input" data-language="{{ $id }}">
                                                <label for="venue_{{ $languageCode }}" class="form-label required">Venue ({{ $language }})</label>
                                                <input type="text" class="form-control" id="venue_{{ $languageCode }}"
                                                    name="venue[{{ $languageCode }}]" required
                                                    value="{{ old('venue.' . $languageCode) ?? ($local->venue ?? '') }}"
                                                    placeholder="Venue ({{ $language }})">
                                            </div>
                            
                                            <div class="col-md-6 language-input" data-language="{{ $id }}">
                                                <label for="language_{{ $languageCode }}" class="form-label required">Language ({{ $language }})</label>
                                                <input type="text" class="form-control" id="language_{{ $languageCode }}"
                                                    name="language[{{ $languageCode }}]" required
                                                    value="{{ old('language.' . $languageCode) ?? ($local->language ?? '') }}"
                                                    placeholder="Language ({{ $language }})">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex flex-column mb-12 fv-row">
                                <label class="required fw-semibold fs-6 mb-2">Days</label>
                                <div class="d-flex flex-wrap justify-content-between">
                                    @foreach ($days as $day)
                                        <div class="form-check mb-2 me-3  ">
                                            <input type="checkbox" class="form-check-input"
                                                id="days-{{ $day }}" name="days[]"
                                                value="{{ $day }}"
                                                @if (in_array($day, $selectedDays)) checked @endif>
                                            <label class="form-check-label" for="days-{{ $day }}">
                                                {{ $day }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('days')
                                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6 mb-6">
                                <label class="fw-semibold fs-6 mb-2">Start Time</label>
                                <input type="time" class="form-control form-control-solid flatpickr-input"
                                    name="start_time" id="start_time"
                                    value="{{ old('start_time', $trainingCalendar->start_time) }}" />
                                @error('start_time')
                                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="fw-semibold fs-6 mb-2">End Time</label>
                                <input type="time" class="form-control form-control-solid flatpickr-input"
                                    name="end_time" id="end_time"
                                    value="{{ old('end_time', $trainingCalendar->end_time) }}" />
                                @error('end_time')
                                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6">
                                <div class="d-flex flex-column mb-12 fv-row">
                                    <label class="fw-semibold fs-6 mb-2">Start Date</label>
                                    <input type="date" class="form-control form-control-solid flatpickr-input"
                                        name="start_date" id="start_date"
                                        value="{{ old('start_date', $trainingCalendar->start_date) }}" />
                                    @error('start_date')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-column mb-12 fv-row">
                                    <label class="fw-semibold fs-6 mb-2">End Date</label>
                                    <input type="date" class="form-control form-control-solid flatpickr-input"
                                        name="end_date" id="end_date"
                                        value="{{ old('end_date', $trainingCalendar->end_date) }}" />
                                    @error('end_date')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="fs-6 fw-semibold mb-2">Status</label>
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Select Status" name="status">
                                        <option>Select Status</option>
                                        <option value="active"
                                            {{ old('status', $trainingCalendar->status) == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ old('status', $trainingCalendar->status) == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="outdate"
                                            {{ old('status', $trainingCalendar->status) == 'outdate' ? 'selected' : '' }}>
                                            Outdate</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-10">
                            <a href="{{ route('course_training_calendar_list', ['id' => $course->id]) }}"
                                class="btn btn-light me-5">Cancel</a>
                            <button type="submit" class="btn btn-primary" >Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
