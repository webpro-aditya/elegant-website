<div id="kt_drawer_add_quiz_content" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="quiz_content"
    data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'500px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_add_quiz_content_toggle"
    data-kt-drawer-close="#kt_drawer_add_quiz_content_close">
    <div class="card shadow-none border-0 rounded-0 w-100">
        <div class="card-header" id="kt_drawer_add_quiz_content_header">
            <h3 class="card-title fw-bold text-gray-900">Add Quiz Content</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                    id="kt_drawer_add_quiz_content_close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
        </div>
        <div class="card-body position-relative" id="kt_drawer_add_quiz_content_body">
            <form novalidate="novalidate" id="addQuizContentForm" class="form"
                action="{{ route('free_resource_quiz_save') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="resource_id" value="{{ $resource_id }}">
                <div class="d-flex flex-column flex-row-fluid">
                    <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
                        role="tablist" id="languageTabs">
                        @foreach ($languages as $id => $language)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                                    id="lang-{{ $id }}-tab" data-bs-toggle="tab"
                                    href="#lang-{{ $id }}" role="tab"
                                    aria-controls="lang-{{ $id }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ strtoupper($language) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content pt-6" id="content-tab">
                        @foreach ($languages as $id => $language)
                            @php
                                $languageCode = strtolower($language);
                            @endphp

                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="lang-{{ $id }}" role="tabpanel"
                                aria-labelledby="lang-{{ $id }}-tab">
                                <!-- Language-specific inputs -->

                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <label for="qus_{{ $language }}" class="form-label">Question
                                        ({{ $language }})</label>
                                    <input type="text" class="form-control" id="question_{{ $language }}"
                                        name="question[{{ strtolower($language) }}]"
                                        value="{{ old('question.' . strtolower($language)) }}"
                                        placeholder="Question ({{ $language }})">
                                    @error('question.' . strtolower($language))
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <label for="qus_{{ $language }}" class="form-label">Answer
                                        ({{ $language }})</label>
                                    <input type="text" class="form-control" id="answer_{{ $language }}"
                                        name="answer[{{ strtolower($language) }}]"
                                        value="{{ old('answer.' . strtolower($language)) }}"
                                        placeholder="answer ({{ $language }})">
                                    @error('answer.' . strtolower($language))
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Options Input -->
                                @foreach (range(1, 4) as $i)
                                    <div class="mb-3 language-input" data-language="{{ $id }}">
                                        <label for="option_{{ $i }}_{{ $language }}"
                                            class="form-label">Option {{ $i }}
                                            ({{ $language }})
                                        </label>
                                        <input type="text" class="form-control"
                                            id="option_{{ $i }}_{{ $language }}"
                                            name="options[{{ $languageCode }}][]"
                                            value="{{ old('options.' . $languageCode . '.' . ($i - 1)) }}"
                                            placeholder="Option {{ $i }} ({{ $language }})">
                                        @error('options.' . $languageCode . '.' . ($i - 1))
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="form-label">Value (weightage/score)</label>
                        <input type="integer" name="value" class="form-control mb-2" placeholder="Value"
                            id="value">
                        @error('value')
                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Status</label>
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                            data-placeholder="Select Status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light btn-active-light-primary me-2"
                            id="kt_drawer_add_quiz_content_close">Back</button>
                        <button type="submit" id="btnSubmit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
