@section('title', 'Mail Templates')

@push('style')
<link rel="stylesheet" href="{{ mix('css/settings/settings.css') }}">
@endpush

@push('script')
<script src="{{ mix('js/settings/settings.js') }}"></script>
@endpush

<x-layout>
    @section('toolbar')
<x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
@endsection
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Mail Templates</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="list-group">
                                @foreach ($emailTemplates as $template)
                                <div class="mb-0">
                                    <div class="menu-item p-0 m-0">
                                        <a href="{{route('mail_template_view',['id'=>$template->id])}}" class="@if($template->id==$activeTemplate->id) active btn btn-primary  @endif btn fw-bold w-100 mb-8">
                                            <span class="menu-title">{{$template->name}}</span>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            @include('settings::mailTemplate.editMailTemplate')
        </div>
    </div>
</x-layout>