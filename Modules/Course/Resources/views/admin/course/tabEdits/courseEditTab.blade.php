<div class="tab-content py-3">
    @foreach ($languages as $id => $language)
        @php
            $languageCode = strtolower($language);
            $courseLocale = isset($coursesLocale[$languageCode]) ? $coursesLocale[$languageCode]->first() : null; // Check if data is available for the current language
        @endphp

        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}" role="tabpanel"
            aria-labelledby="language-{{ $id }}-tab">
            <!-- Language-specific inputs -->
            <div class="mb-3 language-input" data-language="{{ $id }}">
                <label for="title_{{ $languageCode }}" class="form-label required">Title ({{ $language }})</label>
                <input type="text" class="form-control" id="title_{{ $languageCode }}" name="title[{{ $languageCode }}]"
                    required value="{{ old('title.' . $languageCode) ?? ($courseLocale->title ?? '') }}"
                    placeholder="Title ({{ $language }})">
                @error('title.' . strtolower($language))
                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-10 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class=" form-label">Short Description ({{ $language }})</label>
                <input type="text" name="short_desc[{{ $languageCode }}]" class="form-control mb-2"
                    placeholder="Short Description ({{ $language }})"
                    value="{{ old('short_desc.' . $languageCode) ?? ($courseLocale->short_description ?? '') }}"
                    id="short_desc_{{ $languageCode }}">
                @error('short_desc.' . $languageCode)
                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-10 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class=" form-label">Description ({{ $language }})</label>
                <textarea id="description_{{ $languageCode }}" name="description[{{ $languageCode }}]"
                    data-kt-tinymce-editor="true" data-kt-initialized="false"
                    class="form-control min-h-200px mb-2">{!! old('description.' . $languageCode) ?? ($courseLocale->description ?? '') !!}</textarea>
                @error('description.' . $languageCode)
                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
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