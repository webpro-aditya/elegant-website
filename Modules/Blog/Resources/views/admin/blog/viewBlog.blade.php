@section('title', 'List Content')

@push('script')
    <script src="{{ mix('js/admin/blog/viewBlog.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin/blog/viewBlog.css') }}">
@endpush

<x-layout>
    @section('toolbar')
        <x-toolbar :breadcrumbs="$breadcrumbs">
        </x-toolbar>
    @endsection

    <div class="card mb-9">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <div
                    class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                    @if ($blog->thumbnail)
                        <img class="mw-50px mw-lg-75px" src="{{ Storage::disk('elegant')->url($blog->thumbnail) }}"
                            alt="image" />
                    @else
                        <img class="mw-50px mw-lg-75px" src="{{ asset('images/logos/logo_with_name.png') }}"
                            alt="image" />
                    @endif
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-1">
                                <a href="#"
                                    class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{ $englishName }}</a>
                                <span class="badge badge-light-success me-auto">{{ $blog->status }}</span>
                            </div>
                        </div>

                    </div>
                 
                </div>
            </div>
            <div class="separator"></div>

            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold px-5"
                role="tablist">
                @foreach ($languages as $id => $language)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6 {{ $loop->first ? 'active' : '' }}"
                            id="language-{{ $id }}-tab" data-bs-toggle="tab"
                            href="#language-{{ $id }}" role="tab"
                            aria-controls="language-{{ $id }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ $language->name }}
                        </a>
                    </li>
                @endforeach
                @if ($seo != null)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary py-5 me-6" id="seo-tab" data-bs-toggle="tab"
                            href="#seo" role="tab" aria-controls="seo" aria-selected="false">
                            SEO
                        </a>
                    </li>
                @endif

            </ul>
            <div class="card-body pt-4">
                @include('blog::admin.blog.tabView.blogInfo')
            </div>

        </div>
    </div>




</x-layout>
