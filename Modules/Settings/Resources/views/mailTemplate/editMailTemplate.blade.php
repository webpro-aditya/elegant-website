<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h2 class="card-title m-0">Compose Mail</h2>
        <a href="#" class="btn btn-sm btn-icon btn-color-primary btn-light btn-active-light-primary d-lg-none" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Toggle inbox menu" id="kt_inbox_aside_toggle">
            <i class="ki-outline ki-burger-menu-2 fs-3 m-0"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <form action="{{route('mail_template_update')}}" method="post">
            <input type="hidden" name="id" value="{{$activeTemplate->id}}">
            @csrf
            <div class="d-block">
                <div class="form-group">
                    <input class="form-control form-control-transparent border-0 px-8 min-h-45px" value="Subject: {{old('subject',$activeTemplate->subject)}}" id="subject" name="subject" placeholder="Subject" />
                </div>
            </div>
            <div class="form-group">
                <textarea id="message" name="message" data-kt-tinymce-editor="false" data-kt-initialized="false" class="form-control min-h-200px mb-2">{{old('message',$activeTemplate->html_template)}}</textarea>
                @error('message')<small class="form-text text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-sm btn-primary">SAVE</button>
            </div>
        </form>
    </div>
</div>