@if ($questionNumber == null && $question == null && $options == null)
    FOrm


@else
    <div class="main-padding mt-10" id="question-container" data-url="{{ route('web_quiz_result') }}">
        <div class="question-container p-5 py-10">
            <p>Question {{ $questionNumber }}</p>
            <h4 class="mb-0">{{ $question }}</h4>
        </div>
    </div>
    <div class="main-padding my-10">
        <div class="answer-container p-5 py-10">
            @foreach ($options as $index => $option)
                <h5 class="answer-list select-option bg-white position-relative rounded-1"
                    data-answer="{{ $option }}" data-index="{{ $index + 1 }}">
                    <span>{{ $index + 1 }}</span> {{ $option }}
                </h5>
            @endforeach

        </div>
    </div>
@endif
