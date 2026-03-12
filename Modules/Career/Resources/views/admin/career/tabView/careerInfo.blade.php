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
                <label class="form-label fw-bold">Location:</label>
                <label class="form-control"
                    @if ($isArabic) dir="rtl" @endif>{!! old('location.' . $languageCode) ?? ($localeContent->location ?? '') !!}</label>
            </div>

            <div class="mb-3 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class="form-label fw-bold">Skills:</label>
                @if ($localeContent->skill)
                    <ul>
                        @foreach (json_decode($localeContent->skill) as $item)
                            <li>{{ $item->value }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="mb-3 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class="form-label fw-bold">Job Profile:</label>
                @if ($localeContent->job_profile)
                    <ul>
                        @foreach (json_decode($localeContent->job_profile) as $item)
                            <li>{{ $item->value }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endforeach

    @if ($seo != null)
        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
            <div class="mb-3 language-input"">
                <label for="name" class="form-label fw-bold">Meta title:</label>
                <label for="name" class="form-control">{{ $seo->meta_title }}</label>
            </div>

            <div class="mb-3 fv-row fv-plugins-icon-container language-input"">
                <label class="form-label fw-bold">Meta Description:</label>
                <label class="form-control">{!! $seo->meta_description !!}</label>
            </div>
        </div>
    @endif
</div>
