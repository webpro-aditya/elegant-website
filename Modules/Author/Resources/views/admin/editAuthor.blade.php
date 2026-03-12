@section('title', 'Edit Author')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/editAuthor.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/editAuthor.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="editAuthorForm"
        class="form d-flex flex-column flex-lg-row "
        action="{{ route('author_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Thumbnail</h2>
                    </div>
                </div>
                <input type="hidden" name="author_id" id="author_id" value="{{ $author->id }}">

                <div class="card-body text-center pt-0">
                    <div class="fv-row fv-plugins-icon-container">
                        <div class="image-input @if (!$author->thumbnail || !Storage::disk('elegant')->exists($author->thumbnail)) image-input-empty @endif image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"
                                @if ($author->thumbnail && Storage::disk('elegant')->exists($author->thumbnail)) style="background-image:
                                url({{ Storage::disk('elegant')->url($author->thumbnail) }})" @endif>
                            </div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change"
                                data-kt-initialized="1">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <input type="file" name="thumbnail" accept=".png,.jpg,.jpeg">
                                <input type="hidden" name="thumbnail_remove">
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel"
                                data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove"
                                data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                        </div>
                        <div class="text-muted fs-7">Set the profile picture. Only .png, .jpg and *.jpeg image files
                            are
                            accepted</div>
                        @error('thumbnail')
                            <div class="invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Thumbnail Alt Text</h2>
                    </div>
                    
                </div>
                <div class="card-body pt-0">
                    <input type="text" name="thumbnail_alt" class="form-control mb-2" placeholder="Thumbnail Alt Text"
                    id="thumbnail_alt" value="{{$author->thumbnail_alt}}">
                </div>
            </div>


            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        @if ($author->status == 'active')
                            <div class="rounded-circle bg-success w-15px h-15px" id="author_status"></div>
                        @else
                            <div class="rounded-circle bg-danger w-15px h-15px" id="author_status"></div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="author_status_select">
                        <option value="active" @if ($author->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($author->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the author status.</div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <h2> Details</h2>
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
                <div class="card-body">
                    @include('author::admin.tabs.tabEdit.editAuthorTab')
                </div>
                <div id="title-div">
                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Facebook</label>
                        <input type="text" name="facebook" class="form-control mb-2"
                            placeholder="Enter Facebook Account" value="{{ $author->facebook }}" id="facebook">
                        @error('facebook')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Instagram</label>
                        <input type="text" name="instagram" class="form-control mb-2"
                            placeholder="Enter Instagram Account" value="{{ $author->instagram }}" id="instagram">
                        @error('instagram')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Twitter</label>
                        <input type="text" name="twitter" class="form-control mb-2"
                            placeholder="Enter Twitter Account" value="{{ $author->twitter }}" id="twitter">
                        @error('twitter')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                </div>
               
            </div>
            <div class="d-flex justify-content-end">

                <a href="{{ route('author_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>

        </div>
    </form>
    </x-admin-layout>
