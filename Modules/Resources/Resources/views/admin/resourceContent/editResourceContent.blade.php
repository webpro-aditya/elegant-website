@section('title', 'Edit Free Resource')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/resourceContent/editResourceContent.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/resourceContent/editResourceContent.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="editResourceForm" class="form d-flex flex-column flex-lg-row "
        action="{{ route('free_resource_contents_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $resource->id }}">
        <input type="hidden" name="resource_id" value="{{ $resource->resource_id }}">

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        @if ($resource->status == 'active')
                            <div class="rounded-circle bg-success w-15px h-15px" id="resource_status"></div>
                        @else
                            <div class="rounded-circle bg-danger w-15px h-15px" id="resource_status"></div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="resource_status_select">
                        <option value="active" @if ($resource->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($resource->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the resource status.</div>
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
                <div class="tab-content px-6 pt-6" id="content-tab">
                    @foreach ($languages as $id => $language)
                        @php
                            $languageCode = strtolower($language);
                            $contentLocale = isset($contentsLocale[$languageCode])
                                ? $contentsLocale[$languageCode]->first()
                                : null;
                        @endphp
                        <input type="hidden" name="content_id" id="content_id"
                            value="{{ $contentLocale->content_id }}">

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

                            <div class="mb-10  fv-plugins-icon-container language-input"
                                data-language="{{ $id }}">
                                <label class="form-label">Answer ({{ $language }})</label>
                                <textarea id="answer_{{ $language }}" name="answer[{{ strtolower($language) }}]" data-kt-tinymce-editor="true"
                                    data-kt-initialized="false" class="form-control min-h-200px mb-2">{!! old('answer.' . $languageCode) ?? ($contentLocale->answer ?? '') !!}</textarea>
                                @error('answer.' . strtolower($language))
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3 px-6">
                    <label for="link" class="form-label">Link
                    </label>
                    <input type="text" class="form-control" id="link" name="link"
                        value="{{ $resource->link }}" placeholder="Link">
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
