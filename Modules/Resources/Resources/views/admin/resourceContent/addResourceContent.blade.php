<div id="kt_drawer_add_resource_content" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="resource_content"
    data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'500px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_add_resource_content_toggle"
    data-kt-drawer-close="#kt_drawer_add_resource_content_close">
    <div class="card shadow-none border-0 rounded-0 w-100">
        <div class="card-header" id="kt_drawer_add_resource_content_header">
            <h3 class="card-title fw-bold text-gray-900">Add Resource Content</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                    id="kt_drawer_add_resource_content_close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
        </div>
        <div class="card-body position-relative" id="kt_drawer_add_resource_content_body">
            <form novalidate="novalidate" id="addResourceContentForm" class="form"
                action="{{ route('free_resource_contents_create') }}" enctype="multipart/form-data" method="POST">
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

                                <div class="mb-10 fv-row fv-plugins-icon-container language-input"
                                    data-language="{{ $id }}">
                                    <label class="form-label">Answer ({{ $language }})</label>
                                    <textarea id="ans_{{ $language }}" name="answer[{{ strtolower($language) }}]" data-kt-tinymce-editor="true"
                                        data-kt-initialized="false" class="form-control min-h-200px mb-2">{{ old('answer.' . strtolower($language)) }}</textarea>
                                    @error('answer.' . strtolower($language))
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="form-label">Link</label>
                        <input type="text" name="link" class="form-control mb-2" placeholder="Link" value=""
                            id="link">
                        @error('link')
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
                        <button type="button" class="btn btn-light btn-active-light-primary me-2"  id="kt_drawer_add_resource_content_close">Back</button>
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
