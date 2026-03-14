@if ($contents['about-us-1']->seo)
    @section('meta_tags', $contents['about-us-1']->seo->meta_contents)
    @section('meta_title', $contents['about-us-1']->seo->meta_title)
    @section('meta_description', $contents['about-us-1']->seo->meta_description)
@else
    @section('meta_title',  'About Elegant Training Center | Best Training Institute in Dubai')
    @section('meta_description', 'Learn about Elegant Training Center – a KHDA-approved professional training institute in Dubai offering certified courses in IT, Finance, Design, Languages, and more.')
@endif

@section('title', 'About US')

@section('canonical', url()->current())

@push('head_info')
{!! $contents['about-us-1']->seo->head_info ?? '' !!}
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/about/about.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/web/about/about.js') }}"></script>
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>{{ app()->getLocale() == 'en' ? $translations['global_workforce']['value_en'] : $translations['global_workforce']['value_ar'] }}
        </h1>
        <ul class="p-0 m-auto">
            <li><a href="#">{{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
                </a></li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['about_us']['value_en'] : $translations['about_us']['value_ar'] }}
            </li>
        </ul>
    </div>
    <section id="banner_title_contents_section" class="main-padding py-15">
        <div class="row">
            <div class="col-md-6 banner-title-area-col">
                <div class="banner-title-area">
                    <span class="subtitle"> {{ $contents['about-us-1']->defaultLocale->short_description }} </span>
                    <div class="h-title"><span> {{ $contents['about-us-1']->defaultLocale->name }} </span></div>
                    <p>{!! $contents['about-us-1']->defaultLocale->description !!}</p>
                </div>
            </div>
            <div class="col-md-6 banner-description-area-col position-relative">
                <div class="banner-description-area">
                    <img src="{{ Storage::disk('elegant')->url($contents['about-us-1']->thumbnail) }}"
                        alt="{{ $contents['about-us-1']->thumbnail_alt }}"
                        title="{{ $contents['about-us-1']->image_title }}" class="w-100 m-auto">
                </div>
            </div>
        </div>
    </section>
    <div class="ecosystem-section py-10 py-md-15">
        <div class="main-padding">
            <h2 class="text-center mb-5 mb-md-10">{{ $contents['ecosystem']->defaultLocale->name }}</h2>
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ Storage::disk('elegant')->url($contents['ecosystem']->thumbnail) }}"
                        alt="{{ $contents['ecosystem']->thumbnail_alt }}"
                        title="{{ $contents['ecosystem']->image_title }}" class="radius">
                </div>
                <div class="col-md-6 mt-5 mt-md-0">
                    {!! $contents['ecosystem']->defaultLocale->content !!}
                </div>
            </div>
        </div>
    </div>

    <section id="training_numbers_section">
        <img class="number-left" src="{{ asset('images/web/number-left.png') }}" alt="">
        <img class="number-right" src="{{ asset('images/web/number-right.png') }}" alt="">

        <div class="training-numbers-area main-padding">
            <div class="training-numbers-title text-center">
                <h3> {{ $contents['training-in-numbers']->defaultLocale->name }} </h3>
                <p>{{ $contents['training-in-numbers']->defaultLocale->short_description }} </p>
            </div>
            <div class="training-numbers-area">
                <div class="number-content-box">
                    <div class="count-number"> {{ $contents['elegant-number-1']->defaultLocale->short_description }} </div>
                    <p> {{ $contents['elegant-number-1']->defaultLocale->name }} </p>
                </div>
                <div class="number-content-box two-border">
                    <div class="count-number">{{ strip_tags($contents['elegant-number-1']->defaultLocale->description) }}</div>
                    <p>{!! $contents['elegant-number-1']->defaultLocale->content !!}</p>
                </div>
                <div class="number-content-box right-border">
                    <div class="count-number"> {{ $contents['elegant-number-2']->defaultLocale->short_description }} </div>
                    <p> {{ $contents['elegant-number-2']->defaultLocale->name }} </p>
                </div>
                <div class="number-content-box"> 
                    <div class="count-number">{{ strip_tags($contents['elegant-number-2']->defaultLocale->description) }}</div>
                    <p>{!! $contents['elegant-number-2']->defaultLocale->content !!}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="main-padding tech-learning-section pt-15">
        <h2 class="text-center mb-5">
            {{ app()->getLocale() == 'en' ? $translations['tech_learning']['value_en'] : $translations['tech_learning']['value_ar'] }}
        </h2>
        <div class="row">
            @foreach ($videos as $video)
                <div class="col-6 col-md-4 mb-3">
                    <div class="video-list position-relative">
                        <iframe width="340" height="195" src="{{ $video->link }}" frameborder="0" allowfullscreen
                            class="rounded-5 "></iframe>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ config('settings.social.youtube_url') }}" target="__blank" class="btn m-auto mt-5 visit-channel">
            {{ app()->getLocale() == 'en' ? $translations['visit_channel']['value_en'] : $translations['visit_channel']['value_ar'] }}
        </a>
    </div>

    <section id="learning_add_section" class="m-top main-padding">
        <div class="learning-add-area">
            <img class="img-fluid round-lg-image" src="{{ asset('images/web/round-lg-bg.png') }}" alt="">
            <img class="img-fluid round-sm-image" src="{{ asset('images/web/round-sm-bg.png') }}" alt="">
            <div class="row">
                <div class="col-lg-8 learning-add-contents-col">
                    <div class="learning-add-contents">
                        <p>{{ $contents['home-page-founder-card']->defaultLocale->short_description }}</p>
                        <h2>{{ $contents['home-page-founder-card']->defaultLocale->name }}</h2>
                        <h3>{{ strip_tags($contents['home-page-founder-card']->defaultLocale->content) }}</h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="learning-add-image">
                        <img class="img-fluid"
                            src="{{ Storage::disk('elegant')->url($contents['home-page-founder-card']->thumbnail) }}"
                            alt="{{ $contents['home-page-founder-card']->thumbnail_alt }}"
                            title="{{ $contents['home-page-founder-card']->image_title }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="main-padding pb-15">
        <h2 class="text-center mb-0 mb-md-10">
            {{ app()->getLocale() == 'en' ? $translations['major_milestones']['value_en'] : $translations['major_milestones']['value_ar'] }}
        </h2>
        <div class="position-relative py-md-5 milestone-container">
            <div class="line-contr"></div>
            @php $c = 1; @endphp
            @foreach ($milestones as $milestone)
                <div class="milestone milestone{{ $c }} position-relative shadow1 text-center p-7">
                    <h3>{{ $milestone->defaultLocale->name }}</h3>
                    <p class="m-0">{!! $milestone->defaultLocale->content !!}</p>
                    <div class="svg-div">
                        <svg width="17" height="22" viewBox="0 0 17 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.5 11.8663C-0.166666 11.4814 -0.166667 10.5191 0.5 10.1342L17 0.60797L17 21.3926L0.5 11.8663Z"
                                fill="#EB2125" />
                        </svg>
                    </div>
                    <div class="line-dot">
                        <img class="img-fluid" src="{{ asset('images/web/line-dot.png') }}" alt="">
                    </div>
                </div>
                @php
                    $c++;
                @endphp
            @endforeach

        </div>
    </div>
    <!-- @php
        if ($c == 5) {
            $c = 1;
        }
    @endphp -->
    <div class="main-padding wscube-section py-15">
        <h2 class="text-center mb-5">{{ $contents['life-at-image']->defaultLocale->name }}</h2>
        <div class="row">
            @foreach ($contents['life-at-image']->items as $item)
                <div class="col-6 py-3">
                    <div class="wsCube-list">
                        <img src="{{ Storage::disk('elegant')->url($item->image_path) }}" alt="{{ $item->title }}"
                            class="w-100 rounded-4">
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="join-us-section py-15">
        <div class="row m-0 main-padding">
            <div class="col-md-8">
                <h2> {{ $contents['join-us']->defaultLocale->name }} </h2>
                <p>{!! $contents['join-us']->defaultLocale->description !!} </p>
            </div>
            <div class="col-md-4 text-start text-md-end">
                <a href="{{ route('web_hiring') }}" class="position-btn btn rounded m-md-15 w-150px">
                    {{ app()->getLocale() == 'en' ? $translations['open_positions']['value_en'] : $translations['open_positions']['value_ar'] }}
                </a>
            </div>
        </div>
    </div>
</x-web-layout>
