@section('title', 'Key Settings')

@push('style')
<link rel="stylesheet" href="{{ mix('css/settings/socialSettings.css') }}">
@endpush

@push('script')
<script src="{{ mix('js/settings/socialSettings.js') }}"></script>
@endpush

<x-layout>


@section('toolbar')
<x-toolbar :breadcrumbs="$breadcrumbs"></x-toolbar>
@endsection



<div class="card mb-5 mb-xxl-8">
        <div class="card-body pt-9 pb-0">
        <form id="brandingForm" action="{{ route('settings_save_settings') }}" method="post" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data">
            @csrf

            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_smtp">SMTP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_sms">SMS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_aws">AWS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_payment">Payment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_seo">SEO</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="kt_smtp" role="tab-panel">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <div class="card card-flush py-4">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>SMTP Settings</h2>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Mailer</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('mail_mailer', $settings->get('mail_mailer')->value) }}" name="mail_mailer" id="mail_mailer" class="form-control" placeholder="Mail Mailer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Host</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('mail_host', $settings->get('mail_host')->value) }}" name="mail_host" id="mail_host" class="form-control" placeholder="Mail Host">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Port</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('mail_port', $settings->get('mail_port')->value) }}" name="mail_port" id="mail_port" class="form-control" placeholder="Mail Port">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Username</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('mail_username', $settings->get('mail_username')->value) }}" name="mail_username" id="mail_username" class="form-control" placeholder="Mail Username">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Password</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('mail_password', $settings->get('mail_password')->value) }}" name="mail_password" id="mail_password" class="form-control" placeholder="Mail Password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail From Address</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('mail_from_address', $settings->get('mail_from_address')->value) }}" name="mail_from_address" id="mail_from_address" class="form-control" placeholder="@lang('Mail From Address')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail From Name</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('mail_from_name', $settings->get('mail_from_name')->value) }}" name="mail_from_name" id="mail_from_name" class="form-control" placeholder="Mail From Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Encryption</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('mail_encryption', $settings->get('mail_encryption')->value) }}" name="mail_encryption" id="mail_encryption" class="form-control" placeholder="Mail Encryption">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_sms" role="tab-panel">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <div class="card card-flush py-4">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>SMS Settings</h2>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Twilio account SID</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('twilio_account_sid', $settings->get('twilio_account_sid')->value) }}" name="twilio_account_sid" id="twilio_account_sid" class="form-control" placeholder="Twilio account SID">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Twilio Auth Token</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('twilio_auth_token', $settings->get('twilio_auth_token')->value) }}" name="twilio_auth_token" id="twilio_auth_token" class="form-control" placeholder="Twilio Auth Token">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Twilio Phone No.</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('twilio_phone_no', $settings->get('twilio_phone_no')->value) }}" name="twilio_phone_no" id="twilio_phone_no" class="form-control" placeholder="Twilio Phone No.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_aws" role="tab-panel">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <div class="card card-flush py-4">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>AWS Settings</h2>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">AWS Access Key ID</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('aws_access_key_id', $settings->get('aws_access_key_id')->value) }}" name="aws_access_key_id" id="aws_access_key_id" class="form-control" placeholder="AWS Access Key ID">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">AWS Secret Access Key</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('aws_secret_access_key', $settings->get('aws_secret_access_key')->value) }}" name="aws_secret_access_key" id="aws_secret_access_key" class="form-control" placeholder="AWS Secret Access Key">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">AWS Default Region</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('aws_default_region', $settings->get('aws_default_region')->value) }}" name="aws_default_region" id="aws_default_region" class="form-control" placeholder="AWS Default Region">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">AWS Bucket</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('aws_bucket', $settings->get('aws_bucket')->value) }}" name="aws_bucket" id="aws_bucket" class="form-control" placeholder="AWS Bucket">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">AWS Use Path Style Endpoint</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('aws_use_path_style_endpoint', $settings->get('aws_use_path_style_endpoint')->value) }}" name="aws_use_path_style_endpoint" id="aws_use_path_style_endpoint" class="form-control" placeholder="AWS Use Path Style Endpoint">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_payment" role="tab-panel">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <div class="card card-flush py-4">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Payment Settings</h2>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">RazorPay API Key</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('razorpay_api_key', $settings->get('razorpay_api_key')->value) }}" name="razorpay_api_key" id="razorpay_api_key" class="form-control" placeholder="RazorPay API Key">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Razorpay API Secret</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('razorpay_api_secret', $settings->get('razorpay_api_secret')->value) }}" name="razorpay_api_secret" id="razorpay_api_secret" class="form-control" placeholder="RazorPay API Secret">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_seo" role="tab-panel">
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <div class="card card-flush py-4">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>SEO Settings</h2>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">SEO Title</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <input type="text" value="{{ old('seo_title', $settings->get('seo_title')->value) }}" name="seo_title" id="seo_title" class="form-control" placeholder="SEO Title">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Google Analytics Head</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <textarea name="google_analytics_head" id="google_analytics_head" cols="30" rows="10" class="form-control">{{ old('google_analytics_head', $settings->get('google_analytics_head')->value) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Google Analytics Body</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <textarea name="google_analytics_body" id="google_analytics_body" cols="30" rows="10" class="form-control">{{ old('google_analytics_body', $settings->get('google_analytics_body')->value) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button>
                    <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </form>
        </div>
</div>

</x-layout>