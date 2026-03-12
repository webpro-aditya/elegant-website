@section('title', 'Quiz')

@push('script')
    <script src="{{ mix('js/web/quiz.js') }}"></script>
@endpush
@section('canonical', url()->current())

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/web/quiz.css') }}">
@endpush
<x-web-layout>
    <input type="hidden" name="id" id="id" value="{{ $quiz->id }}">
    <input type="hidden" name="count" id="count" value="{{ $quiz->quizzes->count() }}">

    <div class="timer-container py-15">
        <div class="main-padding">
            <div class="d-flex justify-content-between">
                <div class="quiz-number">{{ $quiz->name }}</div>
                <div class="timer"><span id="hours"></span>:<span id="minutes"></span>:<span
                        id="seconds"></span>
                </div>
                <div>
                    <button type="button" class="btn submit-btn" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_quiz_form">

                        {{ app()->getLocale() == 'en' ? $translations['submit_quiz']['value_en'] : $translations['submit_quiz']['value_ar'] }}
                    </button>
                </div>

                {{-- <div><a href="#" class="btn submit-btn">Submit Quiz</a></div> --}}
            </div>
        </div>
    </div>
    <div id="question" data-url="{{ route('web_quiz_get_question') }}">

    </div>
    <div class="main-padding my-10">
        <div class="d-flex justify-content-between mt-5">
            <div>
                <a href="#" class="btn btn-style"><svg width="12" height="23" viewBox="0 0 12 23"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.1492 6.305L8.13241 5.28917L2.5942 10.8255C2.50493 10.9142 2.43408 11.0197 2.38574 11.1359C2.33739 11.2521 2.3125 11.3767 2.3125 11.5025C2.3125 11.6284 2.33739 11.753 2.38574 11.8692C2.43408 11.9854 2.50493 12.0909 2.5942 12.1796L8.13241 17.7188L9.14824 16.7029L3.95024 11.504L9.1492 6.305Z"
                            fill="#2D79BC" />
                    </svg>
                    {{ app()->getLocale() == 'en' ? $translations['previous']['value_en'] : $translations['previous']['value_ar'] }}
                </a>
            </div>
            <div class="pagination"></div>
            <div>
                <a href="#" class="btn btn-style">
                    {{ app()->getLocale() == 'en' ? $translations['next']['value_en'] : $translations['next']['value_ar'] }}
                    <svg width="12" height="23" viewBox="0 0 12 23" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2.3508 6.305L3.36759 5.28917L8.9058 10.8255C8.99507 10.9142 9.06592 11.0197 9.11426 11.1359C9.16261 11.2521 9.1875 11.3767 9.1875 11.5025C9.1875 11.6284 9.16261 11.753 9.11426 11.8692C9.06592 11.9854 8.99507 12.0909 8.9058 12.1796L3.36759 17.7188L2.35176 16.7029L7.54976 11.504L2.3508 6.305Z"
                            fill="#2D79BC" />
                    </svg></a>
            </div>
        </div>
    </div>


    <!-- Modal Structure -->
    <div class="modal fade" id="kt_modal_quiz_form" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content p-5">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ app()->getLocale() == 'en' ? $translations['submit_quiz']['value_en'] : $translations['submit_quiz']['value_ar'] }}
                    </h5>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div class="modal-body ">
                    <form id="roleForm" class="form" method="POST"
                        action="{{ route('web_free_resource_form_submit') }}">
                        @csrf

                        <input type="hidden" name="quiz_time" id="quiz_time">


                        <div class="">
                            <div class="mb-6">
                                <label class="form-label">
                                    {{ app()->getLocale() == 'en' ? $translations['name']['value_en'] : $translations['name']['value_ar'] }}
                                </label>
                                <input type="text" name="name" class="form-control mb-2 w-100" placeholder="Name"
                                    id="name" required>
                            </div>
                            <div class="mb-6">
                                <label class="form-label"> {{ app()->getLocale() == 'en' ? $translations['email']['value_en'] : $translations['email']['value_ar'] }}
                                </label></label>
                                <input type="text" name="email" class="form-control mb-2 w-100" placeholder="Email"
                                    id="email" required>
                            </div>
                        </div>
                        <div class="text-center pt-15">
                            <button type="button"
                                class="btn btn-light btn-active-light-primary me-2 fv-button-back">Back</button> <button
                                type="submit" class="btn btn-primary " data-kt-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</x-web-layout>
