

@if ($contents['terms-and-conditions']->seo)
    @section('meta_tags', $contents['terms-and-conditions']->seo->meta_contents)
    @section('meta_title', $contents['terms-and-conditions']->seo->meta_title)
    @section('meta_description', $contents['terms-and-conditions']->seo->meta_description)
@else
    @section('meta_title',  'Terms & Conditions | Elegant Training Center Dubai')
    @section('meta_description', "Understand the terms and conditions of using Elegant Training Center’s website and services. This includes user responsibilities, course enrollment policies, and more.")
@endif

@section('title', 'Terms and Conditions')

@push('script')
    <script src="{{ mix('js/web/privacy/termsAndConditions.js') }}"></script>
@endpush
@section('canonical', url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/privacy/termsAndConditions.css') }}">
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>  {{$contents['terms-and-conditions']->defaultLocale->title }}
        </h1>
    </div>
    <div class="contact-information main-padding mt-10 mt-md-20 pt-10 pt-md-15 pb-10 pb-md-20">
        <h2 class="text-center mb-10">
            {{$contents['terms-and-conditions']->defaultLocale->name }}
        </h2>
        <div class="shadow1 p-5 py-10 p-md-10 py-md-15 bg-white mb-5">
            <div class="row">
                <div class="col-md-12 mb-6">
                    {!! $contents['terms-and-conditions']->defaultLocale->description !!}
                </div>
            </div>
        </div>
    </div>
</x-web-layout>