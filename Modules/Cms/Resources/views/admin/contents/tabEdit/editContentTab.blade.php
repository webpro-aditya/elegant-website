<div class="tab-content py-3">
    @foreach ($languages as $id => $language)
        @php
            $languageCode = strtolower($language);
            $contentLocale = isset($contentsLocale[$languageCode]) ? $contentsLocale[$languageCode]->first() : null; // Check if data is available for the current language
        
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}"
             role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
            <!-- Language-specific inputs -->
            @if (in_array('name', $fields) && $contentLocale)
                <div class="mb-3 language-input" data-language="{{ $id }}">
                    <label for="name_{{ $languageCode }}" class="form-label required">Name ({{ $language }})</label>
                    <input type="text" class="form-control" id="name_{{ $languageCode }}"
                           name="name[{{ $languageCode }}]" required
                           value="{{ old('name.' . $languageCode) ?? ($contentLocale->name ?? '') }}"
                            placeholder="Name ({{ $language }})">
                </div>
            @endif
            @if (in_array('short_desc', $fields))
                <div class="mb-10 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                    <label class=" form-label">Short Description ({{ $language }})</label>
                    <input type="text" name="short_desc[{{ $languageCode }}]" class="form-control mb-2"
                        
                        placeholder="Short Description ({{ $language }})"
                        value="{{ old('short_desc.'. $languageCode) ?? ($contentLocale->short_description ?? '') }}"
                        id="short_desc_{{ $languageCode }}">
                    @error('short_desc.' . $languageCode)
                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                    @enderror 
                </div>
            @endif
            @if (in_array('description', $fields))
                <div class="mb-10 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                    <label class=" form-label">Description ({{ $language }})</label>
                    <textarea id="description_{{ $languageCode }}" name="description[{{ $languageCode }}]" data-kt-tinymce-editor="true"
                        data-kt-initialized="false" class="form-control min-h-200px mb-2">{!! old('description.' . $languageCode) ?? ($contentLocale->description ?? '') !!}</textarea>
                    @error('description.' . $languageCode)
                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            @if (in_array('content', $fields))
                <div class="mb-10 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                    <label class=" form-label">Content ({{ $language }})</label>
                    <textarea id="content_{{ $languageCode }}" name="content[{{ $languageCode }}]" data-kt-tinymce-editor="true"
                        data-kt-initialized="false" class="form-control min-h-200px mb-2">{{ old('content.' . $languageCode) ?? ($contentLocale->content ?? '') }}</textarea>
                    @error('content.' . $languageCode)
                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            @if (in_array('location', $fields))
            <div class="mb-3 language-input" data-language="{{ $id }}">
                <label for="location_{{ $language }}" class="form-label ">Location
                    ({{ $language }})</label>
                <input type="text" class="form-control" 
                    id="location_{{ $language }}" name="location[{{ strtolower($language) }}]"
                    value="{{ old('location.' . $languageCode) ?? ($contentLocale->location ?? '') }}"

                    placeholder="Location ({{ $language }})">
                @error('location.' . strtolower($language))
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        @if (in_array('skill', $fields))
            <div class="mb-3 language-input" data-language="{{ $id }}">
                <label for="skill_{{ $language }}" class="form-label ">Skill
                    ({{ $language }})</label>
                <input type="text" class="form-control" 
                    id="skill_{{ $language }}" name="skill[{{ strtolower($language) }}]"
                    value="{{ old('skill.' . $languageCode) ?? ($contentLocale->skill ?? '') }}"

                    placeholder="Skill ({{ $language }})" data-kt-tagify-input="true">

                @error('skill.' . strtolower($language))
                    <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                @enderror
            </div>
        @endif

        @if (in_array('job_profile', $fields))
        <div class="mb-3 language-input" data-language="{{ $id }}">
            <label for="job_profile_{{ $language }}" class="form-label ">Job Profile
                ({{ $language }})</label>
            <input type="text" class="form-control" 
                id="job_profile_{{ $language }}" name="job_profile[{{ strtolower($language) }}]"
                value="{{ old('job_profile.' . $languageCode) ?? ($contentLocale->job_profile ?? '') }}"
                placeholder="Job Profile ({{ $language }})" data-kt-tagify-input="true">

            @error('job_profile.' . strtolower($language))
                <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
            @enderror
        </div>
    @endif
        </div>
    @endforeach

    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
        @if ($seo == null)
            @include('seo::admin.addTab.seoTab')
        @else
            @include('seo::admin.editTab.editSeoTab', compact('seo'))
        @endif
    </div>
</div>
