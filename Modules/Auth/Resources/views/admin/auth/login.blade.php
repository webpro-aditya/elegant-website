@section('title', 'Login')

@push('style')
    <link rel="stylesheet" href="{{ mix('css/auth/admin/login.css') }}">
@endpush

@push('script')
    <script src="{{ mix('js/auth/admin/login.js') }}"></script>
@endpush

<x-guest-layout>
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <div class="d-flex flex-stack py-2">
                    <img alt="Logo" src="{{ asset('images/logos/logo_with_name.png') }}" class="img-fluid" />
                </div>
                <div class="py-20">
                    <form novalidate="novalidate" class="form w-100" id="loginForm" method="post" action="{{ route('admin_login') }}">
                        @csrf
                        <div class="card-body">
                            <div class="text-start mb-10">
                                <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="sign-in-title">Sign In</h1>
                            </div>
                            <div class="fv-row mb-8">
                                <input type="text" class="form-control bg-transparent" id="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus data-url="{{ route('admin_check_email') }}" />
                                @error('email')
                                    <span class="invalid-feedback fv-plugins-message-container" role="alert"> <strong>{{ $message }}</strong> </span>
                                @enderror
                            </div>
                            <div class="fv-row mb-8" data-kt-password-meter="true">

                                <div class="mb-1">
                                    <div class="position-relative mb-3">
                                        <input class="form-control bg-transparent" type="password" id="password"placeholder="Password" name="password" autocomplete="off" data-url="{{ route('admin_check_password') }}" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                            <i class="ki-outline ki-eye-slash fs-1"></i>
                                            <i class="ki-outline ki-eye d-none fs-1"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback fv-plugins-message-container" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            {{-- <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
                                <div></div>
                                <a href="" class="link-primary" data-kt-translate="sign-in-forgot-password">Forgot Password ?</a>
                            </div> --}}
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div>
                                    <label class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked />
                                        <span class="fw-semibold ps-2 fs-6 form-check-label">
                                            Remember Me
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex flex-stack">
                                <button id="fas_sign_in_submit" class="btn btn-primary me-2 flex-shrink-0">
                                    <span class="indicator-label">Sign In</span>
                                    <span class="indicator-progress">
                                        <span data-kt-translate="general-progress">Please wait...</span>
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="d-flex flex-stack py-2"></div>
            </div>
        </div>
        <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat login-bg"></div>
    </div>
</x-guest-layout>
