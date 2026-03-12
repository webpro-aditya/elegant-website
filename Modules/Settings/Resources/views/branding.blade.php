@section('title', 'Branding')

@push('style')
    <link rel="stylesheet" href="{{ mix('css/settings/branding.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/settings/branding.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
    @endsection

    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" aria-expanded="true">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Branding Details</h3>
            </div>
        </div>
        <div id="fd_account_settings_profile_details" class="collapse show">
            <form id="brandingForm" action="{{ route('settings_save_settings') }}" method="post" class="form"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body border-top ">
                    <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mb-4" role="tablist" id="languageTabs">
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
                    
                    <div class="tab-content">
                        @foreach ($languages as $id => $language)
                        <div id="language-{{ $id }}"
                            class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                            role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
                            <div id="content-tab">
                                @php
                                $languageCode = strtolower($language);
                                @endphp
                    
                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Name
                                            ({{ $language }})
                                        </label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" name="company_name_{{ $languageCode }}"
                                                        class="form-control form-control-lg mb-3 mb-lg-0"
                                                        placeholder="Name - {{ $language }}"
                                                        value="{{ old("company_name_[$languageCode]", config("settings.store.company_name_$languageCode") ?? '') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">City
                                            ({{ $language }})
                                        </label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" class="form-control"
                                                        name="company_city_{{ $languageCode }}"
                                                        id="company_city_{{ $languageCode }}"
                                                        placeholder="City - {{ $language }}"

                                                        value="{{ old("company_city_[$languageCode]", config("settings.store.company_city_$languageCode") ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Address Line 1
                                            ({{ $language }})
                                        </label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text"
                                                        name="company_address_line1_{{ $languageCode }}"
                                                        class="form-control form-control-lg mb-3 mb-lg-0"
                                                        placeholder="Address Line 1 - {{ $language }}"
                                                        value="{{ old("company_address_line1_[$languageCode]", config("settings.store.company_address_line1_$languageCode") ?? '') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Address Line 2
                                            ({{ $language }})
                                        </label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text"
                                                        name="company_address_line2_{{ $languageCode }}"
                                                        class="form-control form-control-lg mb-3 mb-lg-0"
                                                        placeholder="Address Line 2 - {{ $language }}"
                                                        value="{{ old("company_address_line2_[$languageCode]", config("settings.store.company_address_line2_$languageCode") ?? '') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Description
                                            ({{ $language }})
                                        </label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <textarea name="company_description_{{ $languageCode }}"
                                                        class="form-control form-control"
                                                        placeholder="Description - {{ $language }}"
                                                        data-kt-autosize="true">{{ old("company_description_[$languageCode]", config("settings.store.company_description_$languageCode") ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Fav Icon</label>
                        <div class="col-lg-8">
                            <div class="image-input image-input-outline image-input-empty image-input-placeholder"
                                data-kt-image-input="true">
                                <div class="image-input-wrapper w-125px h-125px"
                                    @if ($settings->get('fav_icon')->value && Storage::disk('elegant')->exists($settings->get('fav_icon')->value)) style="background-image:
                                    url({{ Storage::disk('elegant')->url($settings->get('fav_icon')->value) }})" @endif>
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="fav_icon" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="fav_icon_remove" />
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                @if ($settings->get('fav_icon')->value && Storage::disk('elegant')->exists($settings->get('fav_icon')->value))
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Logo</label>
                        <div class="col-lg-8">
                            <div class="image-input image-input-outline image-input-empty image-input-placeholder"
                                data-kt-image-input="true">
                                <div class="image-input-wrapper w-125px h-125px"
                                    @if ($settings->get('logo_dark')->value && Storage::disk('elegant')->exists($settings->get('fav_icon')->value)) style="background-image:
                                    url({{ Storage::disk('elegant')->url($settings->get('logo_dark')->value) }})" @endif>
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="logo_dark" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="logo_dark_remove" />
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                @if ($settings->get('logo_dark')->value && Storage::disk('elegant')->exists($settings->get('logo_dark')->value))
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        </div>
                    </div>
                    {{-- <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Light Logo</label>
                        <div class="col-lg-8">
                            <div class="image-input image-input-outline image-input-empty image-input-placeholder"
                                data-kt-image-input="true">
                                <div class="image-input-wrapper w-125px h-125px"
                                    @if ($settings->get('logo_light')->value && Storage::disk('elegant')->exists($settings->get('fav_icon')->value)) style="background-image:
                                    url({{ Storage::disk('elegant')->url($settings->get('logo_light')->value) }})" @endif>
                                </div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="logo_light" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="logo_light_remove" />
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                @if ($settings->get('logo_light')->value && Storage::disk('elegant')->exists($settings->get('logo_light')->value))
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        </div>
                    </div> --}}
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Meta Tags</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="meta_tags" class="form-control form-control" placeholder="Meta Tags" data-kt-autosize="true"></textarea>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Email</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="email"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Email"
                                        value="{{ old('email', $settings->get('email')->value) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Phone</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="phone"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Phone"
                                        value="{{ old('phone', $settings->get('phone')->value) }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Country</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <select id="company_country_id" name="company_country_id" class="form-select"
                                        data-kt-select2="true" data-server="true" data-placeholder="Select Country"
                                        data-option-url="{{ route('options_countries') }}"
                                        value="{{ old('company_country_id') }}">
                                        @if (isset($old['company_country_id']) && $old['company_country_id'] != '')
                                            <option value="{{ $old['company_country_id']->id }}">
                                                {{ $old['company_country_id']->short_name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">State</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <select id="company_state_id" name="company_state_id" class="form-select"
                                        data-select2-filter=@json(['country_id' => ['selector' => '#company_country_id']]) data-kt-select2="true"
                                        data-server="true" data-placeholder="Select State"
                                        data-option-url="{{ route('options_states') }}">
                                        @if (config('settings.store.company_state_id'))
                                            <option value="  {{ $old['company_state_id']->id }}">
                                                {{ $old['company_state_id']->name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Postal Code</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" class="form-control" name="company_postel_code"
                                        id="company_postel_code"
                                        value="{{ config('settings.store.company_postel_code') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">LMS Link</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" class="form-control" name="lms_link"
                                        id="lms_link"
                                        value="{{ config('settings.store.lms_link') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">WhatsApp Number</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="tel" class="form-control" name="whatsapp_number"
                                        id="whatsapp_number"
                                        value="{{ config('settings.store.whatsapp_number') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Years of Experience</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="number" class="form-control" name="experience"
                                        id="experience"
                                        value="{{ config('settings.store.experience') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Languages Chosen</label>
                        <div class="col-lg-8">
                            <div class="row mt-2">
                                <div class="col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language[]"
                                            value="ar" id="arabic"
                                            @if ($settings['ar']->value != '') checked @endif>
                                        <label class="form-check-label" for="arabic">
                                            Arabic
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language[]"
                                            value="sp" id="spanish"
                                            @if ($settings['sp']->value != '') checked @endif>
                                        <label class="form-check-label" for="spanish">
                                            Spanish
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language[]"
                                            value="fr" id="french"
                                            @if ($settings['fr']->value != '') checked @endif>
                                        <label class="form-check-label" for="french">
                                            French
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button"
                        class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button> <button
                        type="submit" id="btnSubmit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
