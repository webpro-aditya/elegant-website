<div class="tab-content py-3">
    @foreach ($languages as $id => $language)
        @php
            $languageCode = strtolower($language->code); // Assuming $language is an object with a 'code' attribute
            $isArabic = strtolower($language->name) === 'arabic';
            $localeContent = isset($contentsLocale[$languageCode]) ? $contentsLocale[$languageCode]->first() : null;
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}"
            role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
            <div class="mb-3 language-input" data-language="{{ $id }}">
                <label for="name" class="form-label fw-bold">Name:</label>
                <label for="name" class="form-control"
                    @if ($isArabic) dir="rtl" @endif>{{ old('name.' . $languageCode) ?? ($localeContent->name ?? '') }}</label>
            </div>

            <div class="mb-3 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class="form-label fw-bold">Short Description:</label>
                <label class="form-control"
                    @if ($isArabic) dir="rtl" @endif>{!! old('short_desc.' . $languageCode) ?? ($localeContent->short_description ?? '') !!}</label>
            </div>
        </div>
    @endforeach
</div>
