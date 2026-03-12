@if ($contents['hiring']->seo)
    @section('meta_tags', $contents['hiring']->seo->meta_contents)
    @section('meta_title', $contents['hiring']->seo->meta_title)
    @section('meta_description', $contents['hiring']->seo->meta_description)
@else
    @section('meta_title',  'Careers at Elegant Training Center | Join Our Team in Dubai')
    @section('meta_description', "Explore exciting job opportunities at Elegant Training Center in Dubai. We're hiring passionate and skilled professionals to join our growing education team.")
@endif

    @section('title', app()->getLocale() == 'en' ? $translations['we_are_hiring']['value_en'] : $translations['we_are_hiring']['value_ar'])
    @section('canonical', url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/hiring/hiring.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/web/hiring/hiring.js') }}"></script>
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>{{ app()->getLocale() == 'en' ? $translations['we_are_hiring']['value_en'] : $translations['we_are_hiring']['value_ar'] }} 
         !</h1>
        <ul class="p-0 m-auto">
            <li><a href="#">{{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
            </a></li>
            <li>/</li>
            <li> {{ app()->getLocale() == 'en' ? $translations['we_are_hiring']['value_en'] : $translations['we_are_hiring']['value_ar'] }}  </li>
        </ul>
    </div>
    <div class="main-padding pt-10 pb-10 pt-md-15 pb-md-15">
        <div class="px-md-20">
            <img src="{{ Storage::disk('elegant')->url($contents['hiring']->thumbnail) }}" alt=""
                class="rounded w-100">
        </div>
    </div>
    <div class="team-members py-7 py-md-15">
        <div class="main-padding">
            <div class="text-center mb-15">
                <h2 class="mb-5">{{ $contents['hiring']->defaultLocale->name }}</h2>
                <p> {!! $contents['hiring']->defaultLocale->description !!} </p>
            </div>

            <form id="category-form" action="{{ route('web_hiring_list') }}" method="POST">
                @csrf
                <ul class="nav nav-tabs d-none d-lg-flex mb-5 p-0" id="myTab" role="tablist">
                    <li class="nav-item m-0" role="presentation">
                        <button class="nav-link bg-white rounded-2 me-3 active" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true">{{ app()->getLocale() == 'en' ? $translations['all']['value_en'] : $translations['all']['value_ar'] }}
                            </button>
                    </li>
                    @foreach ($categories as $item)
                    <li class="nav-item m-0" role="presentation">
                        <button class="nav-link bg-white rounded-2 me-3" id="tab-{{ $item->id }}"
                            data-bs-toggle="tab" data-bs-target="#tab-pane-{{ $item->id }}" type="button"
                            role="tab" aria-controls="tab-pane-{{ $item->id }}" aria-selected="false">
                            {{ $item->name }}
                        </button>
                    </li>
                    @endforeach
                </ul>
            </form>

            <div class="row m-0 learning-section" id="career-list-div">
            </div>

            {{-- @include('career::web.hiring.card.careerCard') --}}


        </div>
    </div>
</x-web-layout>
