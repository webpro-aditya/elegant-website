@section('meta_title',  'Training Schedule – Upcoming Courses at Elegant Training Center Dubai')
@section('meta_description', 'Check our updated course calendar for IT, Finance, Management, and Design programs in Dubai. Weekday and weekend classes available.')
@section('title', 'Training Calendar')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/training-calender/training-calender.css') }}">
@endpush
@section('canonical', url()->current())

@push('script')
    <script src="{{ mix('js/web/training-calender/training-calender.js') }}"></script>
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>{{ app()->getLocale() == 'en' ? $translations['why_choose_elegant']['value_en'] : $translations['why_choose_elegant']['value_ar'] }}
        </h1>
        <ul class="p-0 m-auto">
            <li><a href="{{ route('web_home', ['locale' => app()->getLocale()]) }}">
                    {{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
                </a>
            </li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['training_calendar']['value_en'] : $translations['training_calendar']['value_ar'] }}
            </li>
        </ul>
    </div>
    <div class="main-padding calender-section my-10 my-md-15">
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th style="min-width:300px">
                            {{ app()->getLocale() == 'en' ? $translations['start']['value_en'] : $translations['start']['value_ar'] }}
                            -
                            {{ app()->getLocale() == 'en' ? $translations['end']['value_en'] : $translations['end']['value_ar'] }}
                        </th>
                        <th style="min-width:200px">
                            {{ app()->getLocale() == 'en' ? $translations['venue']['value_en'] : $translations['venue']['value_ar'] }}
                        </th>
                        <th style="min-width:200px">
                            {{ app()->getLocale() == 'en' ? $translations['course_name']['value_en'] : $translations['course_name']['value_ar'] }}
                        </th>
                        <th style="min-width:200px">
                            {{ app()->getLocale() == 'en' ? $translations['days']['value_en'] : $translations['days']['value_ar'] }}
                        </th>
                        <th style="min-width:170px">
                            {{ app()->getLocale() == 'en' ? $translations['course_time']['value_en'] : $translations['course_time']['value_ar'] }}
                        </th>
                        <th style="min-width:150px">
                            {{ app()->getLocale() == 'en' ? $translations['language']['value_en'] : $translations['language']['value_ar'] }}
                        </th>
                        <th style="min-width:170px">
                            {{ app()->getLocale() == 'en' ? $translations['contact']['value_en'] : $translations['contact']['value_ar'] }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $courseName => $courseTrainings)
                        @foreach ($courseTrainings as $course)
                            <tr>
                                <th>
                                    {{ \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($course->end_date)->format('d/m/Y') }}
                                </th>
                                <td>{{ $course->defaultLocale->venue }}</td>
                                <td>{{ isset($course->courses) ? ($course->courses->defaultLocale ? $course->courses->defaultLocale->title : '') : '' }}
                                </td>
                                @php
                                    $daysArray = json_decode($course->days);
                                @endphp
                                <td>
                                    @if (is_array($daysArray) && !empty($daysArray))
                                        @foreach ($daysArray as $day)
                                            {{ app()->getLocale() == 'en' ? $translations[strtolower($day)]['value_en'] : $translations[strtolower($day)]['value_ar'] }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif

                                </td>
                                <td> {{ $course->start_time }} – {{ $course->end_time }} </td>
                                <td> {{ $course->defaultLocale->language }} </td>
                                <td><a class="register-now-link btn rounded-1 py-2"
                                        data-course-id="{{ $course->id }}" data-bs-toggle="modal"
                                        data-bs-target="#couseEnquiryModal">{{ app()->getLocale() == 'en' ? $translations['register_now']['value_en'] : $translations['register_now']['value_ar'] }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Enquiry -->
    <div class="modal fade" id="couseEnquiryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ app()->getLocale() == 'en' ? $translations['enquire_now']['value_en'] : $translations['enquire_now']['value_ar'] }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="enquiryForm" action="{{ route('web_save_course_enquiry') }}" method="POST"
                        class="enquire-form ">
                        @csrf
                        @honeypot
                        <input type="hidden" name="courseId" id="courseId">
                        <input type="hidden" name="type" value="training_calender_enquiry">
                        <div class="col-12 mb-4">
                            <label for="name" class="w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['name']['value_en'] : $translations['name']['value_ar'] }}
                            </label>
                            <input type="text" name="name"
                                placeholder="  {{ app()->getLocale() == 'en' ? $translations['enter_your_name']['value_en'] : $translations['enter_your_name']['value_ar'] }}  "
                                id="name" class="form-control w-100" required>
                            @error('name')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-4">
                            <label for="email" class="w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['email']['value_en'] : $translations['email']['value_ar'] }}
                            </label>
                            <input type="email" name="email"
                                placeholder=" {{ app()->getLocale() == 'en' ? $translations['enter_your_email']['value_en'] : $translations['enter_your_email']['value_ar'] }}  "
                                class="form-control w-100" id="email" required>
                            @error('email')
                                <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row align-items-end mb-5 cn-code fv-row">
                            <label for="number" class="w-100 mb-2">{{ trans('home/home.mobile_number') }}</label>
                            <div class="d-flex">
                                <select name="country_code" id="country_code" autocomplete="off" class="form-control"
                                    style="width: 40%;">
                                    @foreach ($countries as $country)
                                        <option data-name="{{ $country->short_name }}"
                                            data-image="{{ asset('images/flags/' . $country->image) }}"
                                            value="{{ $country->country_code }}"
                                            @if (old('countryCode')) @if (old('countryCode') == $country->country_code)
                                        selected @endif
                                        @elseif($country->country_code == '971') selected @endif>
                                            +{{ $country->country_code }} {{ $country->short_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class=" w-100">
                                    <input type="number" name="number"
                                        placeholder="{{ trans('home/home.enter_your_mobile_number') }}" id="number"
                                        class="form-control w-100" required>
                                    @error('number')
                                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="message"
                                class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['message']['value_en'] : $translations['message']['value_ar'] }}
                            </label>
                            <textarea name="message" id="message" rows="4"
                                placeholder=" {{ app()->getLocale() == 'en' ? $translations['drop_your_thoughts']['value_en'] : $translations['drop_your_thoughts']['value_ar'] }}  "
                                class="form-control w-100"></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <input type="submit" value="Submit" class="submit-btn ">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
