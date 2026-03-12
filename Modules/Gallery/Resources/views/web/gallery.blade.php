@section('meta_title',  'Gallery | Elegant Training Center Dubai – Student & Certificate Highlights')
@section('meta_description', 'Explore our training gallery featuring classroom sessions, student projects, expert instructors, and hands-on workshops. Discover how Elegant Training Center in Dubai empowers learners.')
@section('title', 'Gallery') 

@push('style')
<link rel="stylesheet" type="text/css" href="{{ mix('css/web/gallery/gallery.css') }}">
@endpush
@section('canonical', url()->current())

@push('script')
    <script src="{{ mix('js/web/gallery/gallery.js') }}"></script>
@endpush
<x-web-layout>

    <div class="breadcrumb-container text-center py-10">
        <h1>
            {{ app()->getLocale() == 'en' ? $translations['gallery']['value_en'] : $translations['gallery']['value_ar'] }}
        </h1>
        <ul class="p-0 m-auto">
            <li><a href="{{ route('web_home', ['locale' => 'en']) }}">{{ app()->getLocale() == 'en' ? $translations['home']['value_en'] : $translations['home']['value_ar'] }}
                </a></li>
            <li>/</li>
            <li>{{ app()->getLocale() == 'en' ? $translations['gallery']['value_en'] : $translations['gallery']['value_ar'] }}
            </li>
        </ul>
    </div>
    
    <section id="gallery-section" class="inner-page-padding">
        <div class="grid-wrapper">
            @foreach ($galleries as $gallery)
            <div class="container">
                <div class="gallery-heading">{{ $gallery->name_en }}</div>
    
                <div class="gallery-items">
                    @foreach ($gallery->items as $item)
                        <img src="{{ Storage::disk('elegant')->url($item->image_path) }}" alt="{{$item->title}}" title="{{$item->title}}">
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </section>
    
</x-web-layout>
