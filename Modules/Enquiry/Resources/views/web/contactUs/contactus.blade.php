@if ($contents['contact-us']->seo)
    @section('meta_tags', $contents['contact-us']->seo->meta_contents)
    @section('meta_title', $contents['contact-us']->seo->meta_title)
    @section('meta_description', $contents['contact-us']->seo->meta_description)
@else
    @section('meta_title',  'Contact Elegant Training Center | Training Center in Al Barsha Dubai')
    @section('meta_description', "Get in touch with Elegant Training Center located in Al Barsha, Dubai. Call, email, or visit us for inquiries about training courses, schedules, and corporate services.")
@endif

@section('title', 'Contact Us')

@push('head_info')
{!! $contents['contact-us']->seo->head_info ?? '' !!}
@endpush

@push('script')
    <script src="{{ mix('js/web/contactus.js') }}"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('enquiryForm');
    if (!form) return;

    const submitBtn = document.getElementById('submitBtn'); // Target specific button by ID

    // Disable on button click to prevent double-click spam
    submitBtn.addEventListener('click', function(e) {
        if (this.dataset.submitting === 'true') {
            e.preventDefault(); // Block if already submitting
            return false;
        }
        this.dataset.submitting = 'true';
        disableButton();
    });

    // Also handle form submit (e.g., Enter key)
    form.addEventListener('submit', function(e) {
        if (submitBtn.dataset.submitting === 'true') {
            // Allow if already processing (validation passed)
            return true;
        }
        disableButton();
    });

    function disableButton() {
        submitBtn.disabled = true;
        submitBtn.value = 'Submitting...';
        submitBtn.classList.add('opacity-60', 'cursor-not-allowed');
    }
});
</script>
@endpush
@section('canonical', url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/contactus.css') }}">
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>{{ app()->getLocale() == 'en' ? $translations['were_here']['value_en'] : $translations['were_here']['value_ar'] }}
        </h1>
        <ul class="p-0 m-auto">
            <li><a href="#">{{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
                </a></li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['contact_us']['value_en'] : $translations['contact_us']['value_ar'] }}
            </li>
        </ul>
    </div>
    <div class="main-padding contact-form pt-15">
        <div class="text-center">
            <h2>{{ $contents['contact-us']->defaultLocale->name }}</h2>
            <p>{!! $contents['contact-us']->defaultLocale->description !!}</p>
        </div>
        <div class="row shadow1 mt-10 p-5 p-md-10">
            <div class="col-md-6">
                <form action="{{ route('web_save_course_enquiry') }}" method="POST" novalidate="novalidate"
                    class="form" id="enquiryForm">
                    @csrf
                    @honeypot
                    <input type="hidden" name="type" value="contact_form">
                    <div class="row">

                        <div class="col-md-6 mb-4  fv-row">
                            <label for="" class="w-100 mb-2">
                                {{ app()->getLocale() == 'en' ? $translations['name']['value_en'] : $translations['name']['value_ar'] }}
                            </label>

                            <input type="text" id="name" name="name" class="w-100" required>
                            <div class="fv-plugins-message-container invalid-feedback" id="error-name">
                                @error('name')
                                    <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-6 mb-4 fv-row country-code">
                            <label for="phone"
                                class="form-label mb-2">{{ app()->getLocale() == 'en' ? $translations['mobile_number']['value_en'] : $translations['mobile_number']['value_ar'] }}
                            </label>

                            <div class="d-flex">
                                {{-- <select class="form-select form-control-solid mb-2" name="country_code"
                                    data-kt-select2="true" id="country_code" data-server="true"
                                    data-placeholder="Select Code" data-option-url="{{ route('web_options_country_code') }}">
                                </select> --}}
                                <select name="country_code" id="countryCode" autocomplete="off" class="form-control"
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
                                <input type="number" name="number" id="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    class="form-control w-100 flex-grow-1" required>
                            </div>
                            <div class="fv-plugins-message-container invalid-feedback" id="error-name">
                                @error('number')
                                    <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4  fv-row">
                            <label for=""
                                class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['email']['value_en'] : $translations['email']['value_ar'] }}
                            </label>
                            <input type="text" name="email" id="email" class="w-100" required>
                            <div class="fv-plugins-message-container invalid-feedback" id="error-name">
                                @error('email')
                                    <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for=""
                                class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['purpose']['value_en'] : $translations['purpose']['value_ar'] }}
                            </label>
                            <select name="subject" id="subject" class="form-select form-control-solid ">
                                <option class="form-select form-control-solid" value="course">Course</option>
                                {{-- <option class="form-select form-control-solid" value="service">Service</option> --}}
                                <option class="form-select form-control-solid" value="job">Job</option>
                                {{-- <option class="form-select form-control-solid" value="media">Media</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-12 mb-4  fv-row">
                        <label for=""
                            class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['your_concern']['value_en'] : $translations['your_concern']['value_ar'] }}
                        </label>
                        <textarea name="message" id="message" rows="4" class="w-100"></textarea>
                        <div class="fv-plugins-message-container invalid-feedback" id="error-name">
                            @error('email')
                                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <input type="submit"
                            value="{{ app()->getLocale() == 'en' ? $translations['submit']['value_en'] : $translations['submit']['value_ar'] }}  "
                            class="fv-button-submit  submit-btn border-0">
                    </div>

                </form>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ Storage::disk('elegant')->url($contents['contact-us']->thumbnail) }}" alt="">
            </div>
        </div>
    </div>
    <div class="contact-information main-padding mt-10 mt-md-20 pt-10 pt-md-15 pb-10 pb-md-20">
        <h2 class="text-center mb-10">
            {{ app()->getLocale() == 'en' ? $translations['contact_info']['value_en'] : $translations['contact_info']['value_ar'] }}
        </h2>
        @foreach ($infos as $info)
            <div class="shadow1 p-5 py-10 p-md-10 py-md-15 bg-white mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <h3>{{ $info->defaultLocale->name }}</h3>
                        <p>{!! $info->defaultLocale->description !!}</p>
                        <h4>{{ app()->getLocale() == 'en' ? $translations['mobile_number']['value_en'] : $translations['mobile_number']['value_ar'] }}
                        </h4>
                        <p> {{ $info->phone_number }} </p>
                        <h4>{{ app()->getLocale() == 'en' ? $translations['email']['value_en'] : $translations['email']['value_ar'] }}
                        </h4>
                        <p>{{ $info->email }}</p>
                        <!-- Button to view map in a bigger format -->
                        <div class="elegant-training-contents-area-button">
                            <button type="button" class=" mt-3"
                            onclick="window.open('tel:{{ $info->phone_number }}', '_blank')">
                                {{ app()->getLocale() == 'en' ? $translations['contact']['value_en'] : $translations['contact']['value_ar'] }}
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <iframe src="{{ $info->link }}" width="100%" height="350" style="border:0;"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-web-layout>
