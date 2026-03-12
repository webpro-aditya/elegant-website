@section('title', 'Detail Blog')

@if ($blog->seo)
    @section('meta_title', $blog->seo->meta_title)
    @section('meta_description', $blog->seo->meta_description)
    @section('meta_tags', $blog->seo->meta_contents)
@section('canonical', url()->current())
    
@endif

@push('script')
    <script src="{{ mix('js/web/blog/detail.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/blog/detail.css') }}">
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>{{ $blog->defaultLocale->name }}</h1>
        <ul class="p-0 m-auto">
            <li><a href="{{ route('web_home', ['locale' => 'en']) }}">{{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
                </a></li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['blog_details']['value_en'] : $translations['blog_details']['value_ar'] }}
            </li>
        </ul>
    </div>
    <div class="main-padding pt-10 pb-10">
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    @if ($blog->thumbnail)
                        <img src="{{ Storage::disk('elegant')->url($blog->thumbnail) }}"
                            title="{{ $blog->image_title }}" alt="{{ $blog->thumbnail_alt }}"
                            class="w-100 blog-img mb-3">
                    @else
                        <img src="{{ asset('images/web/bloglist.png') }}" alt="" class="w-100 blog-img mb-3">
                    @endif
                    <p class="mb-0 d-flex">
                        <a href="{{ route('web_blog_author_list', ['id' => $blog->author->id]) }}">

                            @if ($blog->author->thumbnail)
                                <img src="{{ Storage::disk('elegant')->url($blog->author->thumbnail) }}"
                                    style="width:50px" alt="{{ $blog->author->thumbnail_alt }}" class="man1 me-2">
                            @else
                                <img src="{{ asset('images/web/man1.png') }}" alt="" class="man1 me-2">
                            @endif
                            {{ Str::limit($blog->author->defaultLocale->name, 8) }}

                        </a>
                    </p>
                    <p>{!! $blog->defaultLocale->content !!}</p>
                </div>
            </div>
            <div class="col-lg-5 blog-sidebar ps-lg-15">
                <h2 class="mb-5">
                    {{ app()->getLocale() == 'en' ? $translations['categories']['value_en'] : $translations['categories']['value_ar'] }}
                </h2>
                <ul class="p-0 mb-5">
                    @foreach ($categories as $category)
                        <li><a
                                href="{{ route('web_blog_category', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach

                </ul>
                <h2 class="mb-5">
                    {{ app()->getLocale() == 'en' ? $translations['popular']['value_en'] : $translations['popular']['value_ar'] }}
                </h2>
                <div class="popular-container">
                    @foreach ($populars as $popular)
                        <a href="{{ route('web_blog_detail', ['blog' => $popular->slug]) }}">
                            <div class="popular-list position-relative">
                                @if ($popular->thumbnail)
                                    <img src="{{ Storage::disk('elegant')->url($popular->thumbnail) }}"
                                        alt="{{ $popular->thumbnail_alt }}">
                                @else
                                    <img src="{{ asset('images/web/bloglist.png') }}" alt="">
                                @endif
                                <p>{{ $popular->defaultLocale->name }}</p>
                            <p>{{ \Illuminate\Support\Str::limit($popular->defaultLocale->short_description, 100) }}</p>

                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
