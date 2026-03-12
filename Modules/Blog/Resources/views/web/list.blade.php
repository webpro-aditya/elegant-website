@section('meta_title',  'Training & Career Development Blog | Elegant Training Center Dubai')
@section('meta_description', 'Explore expert tips, course updates, industry insights, and career advice from Elegant Training Center Dubai. Stay informed and grow your professional skills.')
@section('title', 'List Blog')

@push('script')
    <script src="{{ mix('js/web/blog/list.js') }}"></script>
@endpush
@section('canonical', url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/blog/list.css') }}">
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>{{ app()->getLocale() == 'en' ? $translations['latest_blog_posts']['value_en'] : $translations['latest_blog_posts']['value_ar'] }}
         </h1>
        <ul class="p-0 m-auto">
            <li><a href="{{ route('web_home', ['locale' => 'en']) }}">{{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
            </a></li>
            <li>/</li>
            <li> {{ app()->getLocale() == 'en' ? $translations['blog']['value_en'] : $translations['blog']['value_ar'] }}
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
                                        <img src="{{ Storage::disk('elegant')->url($blog->thumbnail) }}" alt="{{$blog->thumbnail_alt}}"
                                        title="{{$blog->image_title}}" class="w-100 blog-img mb-3">
                                    @else
                                        <img src="{{ asset('images/web/bloglist.png') }}" alt=""
                                            class="w-100 blog-img mb-3">
                                    @endif
                                    <span>{{ $blog->localizedCategoryName }}</span>
                                    <h2 class="my-2">{{ $blog->defaultLocale->name }} </h2>
                                    <div class="d-flex justify-content-between mt-4 border-top pt-4">
                                        <p class="mb-0 d-flex">
                                             
                                            @if (isset($blog->author)  && $blog->author->thumbnail)
                                                <img src="{{ Storage::disk('elegant')->url($blog->author->thumbnail) }}"
                                                     alt="{{$blog->author->thumbnail_alt}}" class="man1 mx-1">
                                            @else
                                                <img src="{{ asset('images/web/man1.png') }}" alt=""
                                                    class="man1 mx-1">
                                            @endif
                                            {{ Str::limit($blog->author->defaultLocale->name, 8) }}
                                        </p>
                                        <p class="mb-0 d-flex"><img src="{{ asset('images/web/clock.png') }}"
                                                alt=""
                                                class="clock mx-1">{{ $blog->created_at->format('F j, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-5 blog-sidebar ps-lg-15">
                <h2 class="mb-5"> {{ app()->getLocale() == 'en' ? $translations['career_guidance']['value_en'] : $translations['career_guidance']['value_ar'] }}
                 </h2>
                <div class="career-guidance mb-5">
                    @foreach ($careers as $career)
                        <a href="{{ route('web_blog_detail', ['blog' => $career->slug]) }}">
                            <div class="guidance-list position-relative">
                                @if ($career->thumbnail)
                                    <img src="{{ Storage::disk('elegant')->url($career->thumbnail) }}" alt="">
                                @else
                                    <img src="{{ asset('images/web/bloglist.png') }}" alt="">
                                @endif
                                <p>{{ $career->defaultLocale->name }}</p>
                                <p>{{ \Illuminate\Support\Str::limit($career->defaultLocale->short_description, 100) }}</p>

                            </div>
                        </a>
                    @endforeach
                </div>

                <h2 class="mb-5"> {{ app()->getLocale() == 'en' ? $translations['categories']['value_en'] : $translations['categories']['value_ar'] }} </h2>
                <ul class="p-0 mb-5">
                    @foreach ($categories as $category)
                        <li><a
                                href="{{ route('web_blog_category', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>

                <h2 class="mb-5">{{ app()->getLocale() == 'en' ? $translations['popular']['value_en'] : $translations['popular']['value_ar'] }} </h2>
                <div class="popular-container">
                    @foreach ($populars as $popular)
                    <a href="{{ route('web_blog_detail', ['blog' => $popular->slug]) }}">
                        <div class="popular-list position-relative">
                            @if ($popular->thumbnail)
                                <img src="{{ Storage::disk('elegant')->url($popular->thumbnail) }}" alt="">
                            @else
                                <img src="{{ asset('images/web/bloglist.png') }}" alt="">
                            @endif
                            <p>{{ $popular->defaultLocale->name }}</p>
                            <p>{{ \Illuminate\Support\Str::limit($career->defaultLocale->short_description, 100) }}</p>

                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    <div class="blog-category py-10 py-md-15">
        <div class="main-padding">
            @foreach ($featured as $feature)
                <div class="d-flex justify-content-between">
                    <h2>{{ $feature->name }}</h2>
                    <a href="{{ route('web_blog_category', ['category' => $feature->slug]) }}"
                        class="view-all">{{ app()->getLocale() == 'en' ? $translations['view_all']['value_en'] : $translations['view_all']['value_ar'] }}  </a>
                </div>
                <div class="row">
                    <div class="owl-carousel owl-theme category">
                        @foreach ($feature->blogs as $blog)
                                <div class="item">
                                    <a href="{{ route('web_blog_detail', ['blog' => $blog->slug]) }}">
                                        <div class="blog-list p-5 shadow1">
                                            @if ($blog->thumbnail)
                                                <img src="{{ Storage::disk('elegant')->url($blog->thumbnail) }}" alt=""
                                                    class="w-100 blog-img mb-3">
                                            @else
                                                <img src="{{ asset('images/web/bloglist.png') }}" alt=""
                                                    class="w-100 blog-img mb-3">
                                            @endif
                                            <span>{{ $feature->name }}</span>
                                            <h2 class="my-2">{{ $blog->defaultLocale->name }}</h2>
                                            <div class="d-flex justify-content-between mt-4 border-top pt-4">
                                                <p class="mb-0 d-flex"><img src="{{ asset('images/web/man1.png') }}"
                                                        alt="" class="man1 mx-1">
                                                        {{ Str::limit($blog->author->defaultLocale->name, 7) }}</p>
                                                <p class="mb-0 d-flex"><img src="{{ asset('images/web/clock.png') }}"
                                                        alt="" class="clock mx-1">
                                                    {{ $blog->created_at->format('F j, Y') }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-web-layout>
