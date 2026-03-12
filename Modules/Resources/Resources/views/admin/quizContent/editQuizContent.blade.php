@section('title', 'Edit Quiz')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/quiz/editQuizContent.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/quiz/editQuizContent.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="editQuizForm" class="form d-flex flex-column flex-lg-row "
        action="{{ route('free_resource_quiz_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $quiz->id }}">

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        @if ($quiz->status == 'active')
                            <div class="rounded-circle bg-success w-15px h-15px" id="quiz_status"></div>
                        @else
                            <div class="rounded-circle bg-danger w-15px h-15px" id="quiz_status"></div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="quiz_status_select">
                        <option value="active" @if ($quiz->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($quiz->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the quiz status.</div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Value (weightage/score)</h2>
                    </div>

                </div>
                <div class="card-body pt-0">
                    <input type="integer" name="value" class="form-control mb-2" placeholder="Value" id="value"
                        value="{{ $quiz->value }}">
                    @error('value')
                        <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <h2>Resource Contents Details</h2>
                    </div>
                </div>
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
                    role="tablist">

                    @foreach ($languages as $id => $language)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                                id="language-{{ $id }}-tab" data-bs-toggle="tab"
                                href="#language-{{ $id }}" role="tab"
                                aria-controls="language-{{ $id }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ strtoupper($language) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class=" px-6 pt-6">
                    <div class="tab-content" id="content-tab">
                        @foreach ($languages as $id => $language)
                            @php
                                $languageCode = strtolower($language);
                                $contentLocale = isset($contentsLocale[$languageCode])
                                    ? $contentsLocale[$languageCode]->first()
                                    : null;
                                $options = $contentLocale ? json_decode($contentLocale->options, true) : [];

                            @endphp

                            <div class="tab-pane nav-tabs fade {{ $loop->first ? 'show active' : '' }}"
                                id="language-{{ $id }}" role="tabpanel"
                                aria-labelledby="language-{{ $id }}-tab">

                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <label for="question_{{ $language }}" class="form-label">Question
                                        ({{ $language }})
                                    </label>
                                    <input type="text" class="form-control" id="question_{{ $language }}"
                                        name="question[{{ strtolower($language) }}]"
                                        value="{{ old('question.' . $languageCode) ?? ($contentLocale->question ?? '') }}"
                                        placeholder="Question ({{ $language }})">
                                    @error('question.' . strtolower($language))
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3 language-input" data-language="{{ $id }}">
                                    <label for="answer_{{ $language }}" class="form-label">Answer
                                        ({{ $language }})
                                    </label>
                                    <input type="text" class="form-control" id="answer_{{ $language }}"
                                        name="answer[{{ strtolower($language) }}]"
                                        value="{{ old('answer.' . $languageCode) ?? ($contentLocale->answer ?? '') }}"
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
                                            value="{{ old('options.' . $languageCode . '.' . ($i - 1)) ?? ($options[$i - 1] ?? '') }}"
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

                </div>
            </div>
            <div class="d-flex justify-content-end">

                <a href="{{ route('free_resource_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>

        </div>
    </form>
    </x-admin-layout>
