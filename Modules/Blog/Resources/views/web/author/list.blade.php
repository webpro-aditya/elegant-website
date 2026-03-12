@section('title', 'List Blog')

@push('script')
    <script src="{{ mix('js/web/author/list.js') }}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/author/list.css') }}">
@endpush
<x-web-layout>
     
    <div class="breadcrumb-container text-center py-10">
        <h1>{{ app()->getLocale() == 'en' ? $translations['more_from']['value_en'] : $translations['more_from']['value_ar'] }} 
          {{ $author->defaultLocale->name }}</h1>
        <ul class="p-0 m-auto">
            <li><a href="#">{{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }} </a></li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['author']['value_en'] : $translations['author']['value_ar'] }} </li>
        </ul>
    </div> 
    <div class="main-padding pt-10 pb-10">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-6 mt-5 mb-5">
                            <a href="{{ route('web_blog_detail', ['blog' => $blog->slug]) }}">
                                <div class="blog-list p-5 shadow1">
                                    <img src="{{ Storage::disk('elegant')->url($blog->thumbnail) }}" alt=""
                                        class="w-100 blog-img mb-3">
                                    <span>{{ $blog->defaultLocale->name }}</span>
                                    <h2 class="my-2">{{ $blog->defaultLocale->short_description }} </h2>
                                    <div class="d-flex justify-content-between mt-4 border-top pt-4">
                                        <p class="mb-0 d-flex"><img src="{{ asset('images/web/man1.png') }}"
                                                alt="" class="man1 me-2"> {{ $author->defaultLocale->name }}</p>
                                        <p class="mb-0 d-flex"><img src="{{ asset('images/web/clock.png') }}"
                                                alt="" class="clock me-2">
                                            {{ $blog->created_at->format('F j, Y') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-web-layout>
