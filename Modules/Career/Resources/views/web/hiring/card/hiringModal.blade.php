<form id="enquiry_form" action="{{ route('web_save_career_applicant') }}" method="POST" enctype="multipart/form-data"
    class="enquiry-form fv-plugins-bootstrap5 fv-plugins-framework">
    @csrf
    <input type="hidden" name="careerId" id="careerId" value="{{ $career->id }}">
    <input type="hidden" name="type" value="job_application">
    @php
        $profiles = json_decode($career->defaultLocale->job_profile);
    @endphp
     
    <div class="col-12 mb-4 fv-row">
        <label for="name" class="w-100 mb-2">  {{ app()->getLocale() == 'en' ? $translations['name']['value_en'] : $translations['name']['value_ar'] }}
          </label>
        <input type="text" name="name" placeholder="{{ app()->getLocale() == 'en' ? $translations['enter_your_name']['value_en'] : $translations['enter_your_name']['value_ar'] }} " id="name"
            class="form-control w-100" required>
        @error('name')
            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12 mb-4 fv-row">
        <label for="email" class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['email']['value_en'] : $translations['email']['value_ar'] }} </label>
        <input type="email" name="email" placeholder="{{ app()->getLocale() == 'en' ? $translations['enter_your_email']['value_en'] : $translations['enter_your_email']['value_ar'] }}  "
            class="form-control w-100" id="email" required>
        @error('email')
            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 mb-4 fv-row">
        <label for="number" class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['mobile_number']['value_en'] : $translations['mobile_number']['value_ar'] }} </label>
        <input type="number" name="number" placeholder="{{ app()->getLocale() == 'en' ? $translations['enter_your_mobile_number']['value_en'] : $translations['enter_your_mobile_number']['value_ar'] }} "
            id="number" class="form-control w-100" required>
        @error('number')
            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 mb-4">
        <label for="job_profile" class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['job_profile']['value_en'] : $translations['job_profile']['value_ar'] }} </label>
        <select name="job_profile" id="job_profile" class="form-select w-100" >
            @foreach ($profiles as $profile)
                <option class="form-select" value="{{ $profile->value }}">
                    {{ $profile->value }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12 mb-4">
        <label for="linkedin" class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['likedin_profile']['value_en'] : $translations['likedin_profile']['value_ar'] }}  </label>
        <input type="text" name="linkedin" placeholder="{{ app()->getLocale() == 'en' ? $translations['enter_linkedin_url']['value_en'] : $translations['enter_linkedin_url']['value_ar'] }}  "
            class="form-control w-100" id="linkedin">

    </div>

    <div class="col-12 mb-4 fv-row">
        <label for="resume" class="w-100 mb-2">{{ app()->getLocale() == 'en' ? $translations['upload_resume']['value_en'] : $translations['upload_resume']['value_ar'] }} </label>
        <input type="file" name="resume" class="form-control w-100" id="resume" required>
        @error('resume')
            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 text-center">
        <input type="submit" value="Submit" class="apply-now submit-btn fv-button-submit border-0 rounded-1 py-3 px-10">
    </div>
</form>
