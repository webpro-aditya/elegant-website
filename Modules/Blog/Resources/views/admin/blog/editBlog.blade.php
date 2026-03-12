@section('title', 'Edit Blog')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/blog/editBlog.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/admin/blog/editBlog.js') }}"></script>
@endpush

<x-layout>
    <form novalidate="novalidate" id="editContentForm"
        class="form d-flex flex-column flex-lg-row "
        action="{{ route('blog_update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Thumbnail</h2>
                    </div>
                </div>
                <input type="hidden" name="blog_id" id="blog_id" value="{{ $blog->id }}">

                <div class="card-body text-center pt-0">
                    <div class="fv-row fv-plugins-icon-container">
                        <div class="image-input @if (!$blog->thumbnail || !Storage::disk('elegant')->exists($blog->thumbnail)) image-input-empty @endif image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"
                                @if ($blog->thumbnail && Storage::disk('elegant')->exists($blog->thumbnail)) style="background-image:
                                url({{ Storage::disk('elegant')->url($blog->thumbnail) }})" @endif>
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
                    id="thumbnail_alt" value="{{$blog->thumbnail_alt}}">
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Image Title</h2>
                    </div>
                    
                </div>
                <div class="card-body pt-0">
                    <input type="text" name="image_title" class="form-control mb-2" placeholder="Image Title"
                    id="image_title" value="{{$blog->image_title}}">
                </div>
            </div>


            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <div class="card-toolbar">
                        @if ($blog->status == 'active')
                            <div class="rounded-circle bg-success w-15px h-15px" id="blog_status"></div>
                        @else
                            <div class="rounded-circle bg-danger w-15px h-15px" id="blog_status"></div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="blog_status_select">
                        <option value="active" @if ($blog->status == 'active') selected @endif>Active</option>
                        <option value="inactive" @if ($blog->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="text-muted fs-7">Set the blog status.</div>
                </div>
            </div>
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Is Popular</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="is_popular" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="is_popular">
                        <option value="no" @if ($blog->is_popular == 'no') selected @endif>No</option>
                        <option value="yes" @if ($blog->is_popular == 'yes') selected @endif>Yes</option>
                    </select>
                    <div class="text-muted fs-7">Set the blog status.</div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Is Career Guidance?</h2>
                    </div>

                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" name="career_guidance" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="career_guidance">
                        <option value="no"  @if ($blog->career_guidance == 'no') selected @endif>No</option>
                        <option value="yes"  @if ($blog->career_guidance == 'yes') selected @endif>Yes</option>
                    </select>
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
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6" id="seo-tab" data-bs-toggle="tab"
                            href="#seo" role="tab" aria-controls="seo" aria-selected="false">
                            SEO
                        </a>
                    </li>
                </ul>
                <div id="title-div">
                    <div class=" fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Title</label>
                        <input type="text" name="title" class="form-control mb-2" placeholder="Title"
                            value="{{ $title }}" id="title">
                        @error('title')
                            <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
                    <div class="fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Blog Category</label>
                        <select class="form-select form-control-solid mb-2" name="category_id" data-kt-select2="true"
                            id="category_id" data-server="true" data-placeholder="Select Blog Category"
                            data-option-url="{{ route('blog_category_options') }}" value="{{ old('category_id') }}">
                            @if (isset($old['category_id']) && $old['category_id'] != '')
                                <option value="{{ $old['category_id']->id }}">
                                    {{ $old['category_id']->name_en }}
                                </option>
                            @endif
                        </select>
                    </div>
                    <div class="fv-row fv-plugins-icon-container px-8 pt-6">
                        <label class=" form-label">Author</label>
                        <select class="form-select form-control-solid mb-2" name="author_id" data-kt-select2="true"
                            id="author_id" data-server="true" data-placeholder=""
                            data-option-url="{{ route('author_options') }}" ">
                            @if (isset($old['author_id']) && $old['author_id'] != '')
                                <option value="{{ $old['author_id']->id }}">
                                    {{ $old['author_id']->english_name }}
                                </option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <input type="hidden" name="model" id="model" value="Modules\Blog\Entities\Blog">

                    @include('cms::admin.contents.tabEdit.editContentTab')
                </div>
            </div>
            <div class="d-flex justify-content-end">

                <a href="{{ route('blog_list') }}" class="btn btn-light me-5">Cancel</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>

        </div>
    </form>
    </x-admin-layout>
