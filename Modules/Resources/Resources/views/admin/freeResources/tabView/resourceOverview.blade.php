<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold " role="tablist">
    @foreach ($languages as $id => $language)
        <li class="nav-item" role="presentation">
            <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                id="language-{{ $id }}-tab" data-bs-toggle="tab" href="#language-{{ $id }}"
                role="tab" aria-controls="language-{{ $id }}"
                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                {{ $language->name }}
            </a>
        </li>
    @endforeach


</ul>
<div class="tab-content py-3">
    @foreach ($languages as $id => $language)
        @php
            $languageCode = strtolower($language->code); // Assuming $language is an object with a 'code' attribute
            $isArabic = strtolower($language->name) === 'ar';
            $localeContent = isset($contentsLocale[$languageCode]) ? $contentsLocale[$languageCode]->first() : null;
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}"
            role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
            <!-- Language-specific inputs -->
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

            <div class="mb-3 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class="form-label fw-bold"> Description:</label>
                <label class="form-control"
                    @if ($isArabic) dir="rtl" @endif>{!! old('description.' . $languageCode) ?? ($localeContent->description ?? '') !!}</label>
            </div>

        </div>
    @endforeach

</div>
