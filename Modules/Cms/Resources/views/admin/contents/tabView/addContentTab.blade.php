<div class="tab-content">
    <div id="content-tab">
        @foreach ($languages as $id => $language)
        
            @php
                $languageCode = strtolower($language);
            @endphp
            <div class="tab-pane nav-tabs fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}"
                role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
                <!-- Language-specific inputs -->

                @if (in_array('name', $fields))
                    <div class="mb-3 language-input" data-language="{{ $id }}">
                        <label for="name_{{ $language }}" class="form-label ">Name ({{ $language }})</label>
                        <input type="text" class="form-control" 
                            id="name_{{ $language }}" name="name[{{ strtolower($language) }}]"
                            value="{{ old('name.' . strtolower($language)) }}"
                            placeholder="Title ({{ $language }})">
                            @error('name.' . strtolower($language))
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif

                @if (in_array('short_desc', $fields))
                    <div class="mb-10 fv-row fv-plugins-icon-container language-input"
                        data-language="{{ $id }}">
                        <label class="form-label">Short Description ({{ $language }})</label>
                        <input type="text" name="short_desc[{{ strtolower($language) }}]" class="form-control mb-2"
                            placeholder="Short Description ({{ $language }})"
                            
                            value="{{ old('short_desc.' . strtolower($language)) }}"
                            id="short_desc_{{ $language }}">
                    </div>
                @endif

                @if (in_array('description', $fields))
                    <div class="mb-10 fv-row fv-plugins-icon-container language-input"
                        data-language="{{ $id }}">
                        <label class="form-label">Description ({{ $language }})</label>
                        <textarea id="description_{{ $language }}" name="description[{{ strtolower($language) }}]"
                            data-kt-tinymce-editor="true" data-kt-initialized="false" class="form-control min-h-200px mb-2"
                            >{{ old('description.' . strtolower($language)) }}</textarea>
                    </div>
                @endif

                @if (in_array('content', $fields))
                    <div class="mb-10 fv-row fv-plugins-icon-container language-input"
                        data-language="{{ $id }}">
                        <label class="form-label">Content ({{ $language }})</label>
                        <textarea id="content_{{ $language }}" name="content[{{ strtolower($language) }}]" data-kt-tinymce-editor="true"
                            data-kt-initialized="false" class="form-control min-h-200px mb-2"
                            >{{ old('content.' . strtolower($language)) }}</textarea>
                    </div>
                @endif

                @if (in_array('location', $fields))
                    <div class="mb-3 language-input" data-language="{{ $id }}">
                        <label for="location_{{ $language }}" class="form-label ">Location
                            ({{ $language }})
                        </label>
                        <input type="text" class="form-control" 
                            id="location_{{ $language }}" name="location[{{ strtolower($language) }}]"
                            value="{{ old('location.' . strtolower($language)) }}"
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
                        placeholder="Job Profile ({{ $language }})" data-kt-tagify-input="true">

                    @error('job_profile.' . strtolower($language))
                        <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
            @endif

            </div>
        @endforeach
    </div>
    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
        @include('seo::admin.addTab.seoTab')
    </div>
</div>
