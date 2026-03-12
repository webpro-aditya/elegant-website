<div class="tab-content" id="content-tab">
    @foreach ($languages as $id => $language)
        @php
            $languageCode = strtolower($language);
        @endphp

        <div class="tab-pane nav-tabs fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}"
            role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
            <!-- Language-specific inputs -->

            <div class="mb-3 language-input" data-language="{{ $id }}">
                <label for="name_{{ $language }}" class="form-label ">Name ({{ $language }})</label>
                <input type="text" class="form-control" id="name_{{ $language }}"
                    name="name[{{ strtolower($language) }}]" value="{{ old('name.' . strtolower($language)) }}"
                    placeholder="Name ({{ $language }})">
                @error('name.' . strtolower($language))
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-10 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class="form-label">Short Description ({{ $language }})</label>
                <input type="text" name="short_desc[{{ strtolower($language) }}]" class="form-control mb-2"
                    placeholder="Short Description ({{ $language }})"
                    value="{{ old('short_desc.' . strtolower($language)) }}" id="short_desc_{{ $language }}">
                @error('short_desc.' . strtolower($language))
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    @endforeach
</div>
