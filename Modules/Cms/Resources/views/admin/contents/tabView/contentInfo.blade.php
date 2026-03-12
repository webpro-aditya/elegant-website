<div class="tab-content py-3">
    @foreach ($languages as $id => $language)
    @php
        $languageCode = strtolower($language->code); // Assuming $language is an object with a 'code' attribute
        $isArabic = strtolower($language->name) === 'arabic';
        $localeContent = isset($contentsLocale[$languageCode]) ? $contentsLocale[$languageCode]->first() : null;
    @endphp
    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="language-{{ $id }}"
        role="tabpanel" aria-labelledby="language-{{ $id }}-tab">
        
        @if (!empty(old('name.' . $languageCode)) || !empty($localeContent->name ?? ''))
            <div class="mb-3 language-input" data-language="{{ $id }}">
                <label for="name" class="form-label fw-bold">Name:</label>
                <label for="name" class="form-control" @if($isArabic) dir="rtl" @endif>{{ old('name.' . $languageCode) ?? ($localeContent->name ?? '') }}</label>
            </div>
        @endif
        
        @if (!empty(old('title.' . $languageCode)) || !empty($localeContent->title ?? ''))
            <div class="mb-3 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class="form-label fw-bold">Title:</label>
                <label class="form-control" @if($isArabic) dir="rtl" @endif>{{ old('title.' . $languageCode) ??  ($localeContent->title ?? '') }}</label>
            </div>
        @endif
        
        @if (!empty(old('short_desc.' . $languageCode)) || !empty($localeContent->short_description ?? ''))
            <div class="mb-3 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class="form-label fw-bold">Short Description:</label>
                <label class="form-control" @if($isArabic) dir="rtl" @endif>{!! old('short_desc.' . $languageCode) ?? ($localeContent->short_description ?? '') !!}</label>
            </div>
        @endif
        
        @if (!empty(old('description.' . $languageCode)) || !empty($localeContent->description ?? ''))
            <div class="mb-3 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class="form-label fw-bold">Description:</label>
                <label class="form-control" @if($isArabic) dir="rtl" @endif>{!! old('description.' . $languageCode) ?? ($localeContent->description ?? '') !!}</label>
            </div>
        @endif
        
        @if (!empty(old('content.' . $languageCode)) || !empty($localeContent->content ?? ''))
            <div class="mb-3 fv-row fv-plugins-icon-container language-input" data-language="{{ $id }}">
                <label class="form-label fw-bold">Content:</label>
                <label class="form-control" @if($isArabic) dir="rtl" @endif>{!! old('content.' . $languageCode) ?? ($localeContent->content ?? '') !!}</label>
            </div>
        @endif
        
    </div>
@endforeach


    @if($seo)
    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
        <div class="mb-3 language-input">
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
