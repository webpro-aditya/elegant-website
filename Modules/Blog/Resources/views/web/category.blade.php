@section('title', 'List Blog Category')
@section('canonical', url()->current())

@push('script')
    <script src="{{ mix('js/web/blog/category.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/blog/category.css') }}">
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>{{ $category->name }}</h1>
        <ul class="p-0 m-auto">
            <li><a href="{{ route('web_home', ['locale' => 'en']) }}"> 
            {{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
             </a></li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['blog_category']['value_en'] : $translations['blog_category']['value_ar'] }}
             </li>
        </ul>
    </div>
    <div class="main-padding pt-5 pb-5 pt-md-10 pb-md-10">
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-12 col-sm-6 mt-5 mb-5">
                            <a href="{{ route('web_blog_detail', ['blog' => $blog->slug]) }}">
                                <div class="blog-list p-3 p-xl-5 shadow1">
                                    @if ($blog->thumbnail)
                                        <img src="{{ Storage::disk('elegant')->url($blog->thumbnail) }}" title="{{$blog->image_title}}" alt="{{ $blog->thumbnail_alt }}"
                                            class="w-100 blog-img mb-3">
                                    @else
                                        <img src="{{ asset('images/web/bloglist.png') }}" alt=""
                                            class="w-100 blog-img mb-3">
                                    @endif
                                    <span>{{ $blog->localizedCategoryName }}</span>
                                    <h2 class="my-2">{{ $blog->defaultLocale->name }} </h2>
                                    <div class="d-flex justify-content-between mt-4 border-top pt-4">
                                        <p class="mb-0 d-flex">
                                            <img src="{{Storage::disk('elegant')->url($blog->author->thumbnail) }}"
                                                alt="{{$blog->author->thumbnail_alt}}" class="man1 mx-2">    {{ Str::limit($blog->author->defaultLocale->name, 8) }}</p>
                                        <p class="mb-0 d-flex"><img src="{{ asset('images/web/clock.png') }}"
                                                alt=""
                                                class="clock mx-2">{{ $blog->created_at->format('F j, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 blog-sidebar ps-lg-15">
                <h2 class="mb-5"> {{ app()->getLocale() == 'en' ? $translations['categories']['value_en'] : $translations['categories']['value_ar'] }}
                </h2>
                <ul class="p-0 mb-5">
                    @foreach ($categories as $category)
                        <li><a
                                href="{{ route('web_blog_category', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-web-layout>
