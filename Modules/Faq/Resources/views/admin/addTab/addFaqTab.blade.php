<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
    <div class="card card-flush py-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title">
                <h2>FAQ Details</h2>
            </div>
        </div>
        <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
            role="tablist" id="languageTabs">
            @foreach ($languages as $id => $language)
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                        id="language-{{ $id }}-tab" data-bs-toggle="tab" href="#language-{{ $id }}"
                        role="tab" aria-controls="language-{{ $id }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ strtoupper($language) }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="card-body">
        <!-- Course Category -->
        <label class="form-label">Course Category</label>
        <select class="form-select form-control-solid mb-2" name="category_id" id="category_id"
            data-kt-select2="true" data-server="true" data-placeholder="Select Category"
            data-option-url="{{ route('course_all_categories') }}">
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

         <!-- Course -->
        <label class="form-label">Course</label>
        <select class="form-select form-control-solid mb-2" name="course_id" data-kt-select2="true"
            id="course_id" data-server="true" data-placeholder="Select Course"
            data-option-url="{{ route('course_active_courses') }}"
            data-select2-filter='@json(["category_id" => ["value" => ""]])'>
        </select>
        @error('course_id')
            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
        @enderror
            <input type="hidden" name="model" id="model" value="Modules\Faq\Entities\Faq">
            <div class="tab-content">
                @foreach ($languages as $id => $language)
                    @php
                        $languageCode = strtolower($language);
                        $isArabic = strtolower($language) === 'arabic';
                    @endphp
                    <div class="tab-pane nav-tabs fade {{ $loop->first ? 'show active' : '' }}"
                        id="language-{{ $id }}" role="tabpanel"
                        aria-labelledby="language-{{ $id }}-tab">
                        <!-- Language-specific inputs -->
                        <div class="mb-3 language-input" data-language="{{ $id }}">
                            <label for="question_{{ $language }}" class="form-label ">Question
                                ({{ strtoupper($language) }})
                            </label>
                            <input type="text" class="form-control"
                                @if ($isArabic) dir="rtl" @endif id="question_{{ $language }}"
                                name="question[{{ strtolower($language) }}]"
                                value="{{ old('question.' . strtolower($language)) }}"
                                placeholder="Question ({{ strtoupper($language) }})">
                            @error('question.' . strtolower($language))
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-10 fv-row fv-plugins-icon-container language-input"
                            data-language="{{ $id }}">
                            <label class=" form-label">Answer ({{ $language }})</label>
                            <textarea id="answer_{{ $language }}" name="answer[{{ strtolower($language) }}]" data-kt-tinymce-editor="true"
                                data-kt-initialized="false" class="form-control min-h-200px mb-2"dir="rtl">{{ old('answer.' . strtolower($language)) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
       
    </div>
