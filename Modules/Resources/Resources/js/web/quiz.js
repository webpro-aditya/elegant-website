"use strict";
require("../../../../../resources/js/web");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var IpixEditFreeResources = function () {
    var timerInterval; // Variable to store the interval ID
    var sec = -1; // Initialize seconds counter globally
    
    // Move pad function to global scope
    function pad(val) {
        return val > 9 ? val : "0" + val;
    }
    
    function startTimer() {
        timerInterval = setInterval(function () {
            $("#seconds").html(pad(++sec % 60));
            $("#minutes").html(pad(parseInt(sec / 60, 10) % 60));
            $("#hours").html(pad(parseInt(sec / 3600, 10)));
        }, 1000);
    }
    
    // Stop the timer and save quiz time when the modal is shown
    $('#kt_modal_quiz_form').on('show.bs.modal', function () {
        clearInterval(timerInterval); // Stop the timer
    
        let hours = Math.floor(sec / 3600);
        let minutes = Math.floor((sec % 3600) / 60);
        let seconds = sec % 60;
    
        let quizTime = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
        
        $('#quiz_time').val(quizTime);
    });
    
    // Resume the timer when the modal is closed
    $('#kt_modal_quiz_form').on('hidden.bs.modal', function () {
        startTimer(); // Resume the timer
    });

    let currentQuestionNumber = 1;
    let quizId = $('#id').val();

    function loadQuestion(currentQuestionNumber) {
        var baseUrl = $('#question').data('url');
    
        $.ajax({
            url: baseUrl,
            data: {
                number: currentQuestionNumber,
                quizId: quizId
            },
            method: 'GET',
            success: function (data) {
                $('#question').html(data.html);
            }
        });
    }
    

    // Event listeners for Next and Previous buttons
    $('.btn-style').on('click', function (e) {
        e.preventDefault();
        const questionCount = parseInt($('#count').val(), 10);

        const action = $(this).text().trim().toLowerCase();
        if (action === 'next') {
            currentQuestionNumber++;
        } else if (action === 'previous' && currentQuestionNumber > 1) {
            currentQuestionNumber--;
        }
        loadQuestion(currentQuestionNumber);

        if (currentQuestionNumber === questionCount) {
            $('.btn-style:contains("Next")').hide();
        } else {
            $('.btn-style:contains("Next")').show(); // Show the button if not the last question
        }

        // Optional: Hide the "Previous" button on the first question
        if (currentQuestionNumber === 1) {
            $('.btn-style:contains("Previous")').hide();
        } else {
            $('.btn-style:contains("Previous")').show();
        }
    });

     // Initial check to hide "Previous" button on the first question
     if (currentQuestionNumber === 1) {
        $('.btn-style:contains("Previous")').hide();
    }

    $(document).on('click', '.select-option', function () {
        var optionIndex = $(this).data('index');
        var quizId = $('#id').val();
    
        var questionId = currentQuestionNumber;
        var baseUrl = $('#question-container').data('url');

        $('.select-option').removeClass('selected');
        $(this).addClass('selected');
        console.log(questionId, optionIndex, quizId)
        $.ajax({
            url: baseUrl, 
            method: 'POST',
            data: {
                questionId: questionId,
                optionIndex: optionIndex,
                quizId : quizId
            },
            success: function (response) {

                console.log('Answer saved successfully', response);
            },
            error: function (xhr, status, error) {
                console.error('Error saving answer:', error);
            }
        });
    });
    


    return {
        init: function () {
            startTimer();
            loadQuestion(currentQuestionNumber);
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixEditFreeResources.init();
});