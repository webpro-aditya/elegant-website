@section('meta_title',  'Privacy Policy | Elegant Training Center Dubai')
@section('meta_description', "Review the privacy practices of Elegant Training Center. Learn how we handle user data, cookies, and personal information submitted through our website.")
@section('title', 'Privacy Policy')

@push('script')
    <script src="{{ mix('js/web/privacy/privacyPolicy.js') }}"></script>
@endpush
@section('canonical', url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/privacy/privacyPolicy.css') }}">
@endpush
<x-web-layout>
    <div class="breadcrumb-container text-center py-10">
        <h1>  {{$contents['privacy-policy']->defaultLocale->title }}
        </h1>
    </div>
    <div class="contact-information main-padding mt-10 mt-md-20 pt-10 pt-md-15 pb-10 pb-md-20">
        <h2 class="text-center mb-10">
            {{$contents['privacy-policy']->defaultLocale->name }}
        </h2>
        <div class="shadow1 p-5 py-10 p-md-10 py-md-15 bg-white mb-5">
            <div class="row">
                <div class="col-md-12 mb-6">
                    {!! $contents['privacy-policy']->defaultLocale->description !!}
                </div>
            </div>
        </div>
    </div>
</x-web-layout>
