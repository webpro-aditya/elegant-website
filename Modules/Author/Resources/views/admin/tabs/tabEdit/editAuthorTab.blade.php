<div class="tab-content py-3">
    @foreach ($languages as $id => $language)
        @php
            $languageCode = strtolower($language);
            $contentLocale = isset($contentsLocale[$languageCode]) ? $contentsLocale[$languageCode]->first() : null; // Check if data is available for the current language

        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}"
            role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
            <!-- Language-specific inputs -->
            <div class="mb-3 language-input" data-language="{{ $id }}">
                <label for="name_{{ $languageCode }}" class="form-label required">Name ({{ $language }})</label>
                <input type="text" class="form-control" id="name_{{ $languageCode }}" name="name[{{ $languageCode }}]"
                    required value="{{ old('name.' . $languageCode) ?? ($contentLocale->name ?? '') }}"
                    placeholder="Name ({{ $language }})">
            </div>
            <div class="mb-10 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class=" form-label">Short Description ({{ $language }})</label>
                <input type="text" name="short_desc[{{ $languageCode }}]" class="form-control mb-2"
                    placeholder="Short Description ({{ $language }})"
                    value="{{ old('short_desc.' . $languageCode) ?? ($contentLocale->short_description ?? '') }}"
                    id="short_desc_{{ $languageCode }}">
                @error('short_desc.' . $languageCode)
                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
    @endforeach
</div>
