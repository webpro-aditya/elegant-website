"use strict";
require("../../../../../resources/js/web");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var IpixSolution = function () {

    const totalQuestions = $('.number').length;


    $('.number').on('click', function () {
        $('.number').removeClass('active');

        $(this).addClass('active');

        var questionId = $(this).data('q-id');

        var resourceId = $('.number').data('r-id');

        var baseUrl = $('#question-container').data('url');

         const questionIndex = $(this).text();

         // Update the question number display
         $('#question-number').text('Question ' + questionIndex + ' of ' + totalQuestions).removeClass('d-none');
         

        $.ajax({
            url: baseUrl,
            method: 'GET',
            data: {
                questionId: questionId,
                resourceId: resourceId
            },
            success: function (response) {

                $('#options-container').empty();
            
                const optionsArray = JSON.parse(response.options);
            
                optionsArray.forEach(function (option, index) {
                    const isActive = option === response.answer ? 'selected' : ''; // Change 'active' to 'selected' as per your HTML
                    
                    $('#options-container').append(
                        `<h5 class="answer-list bg-white position-relative rounded-1 ${isActive}">
                            <span>${index + 1}</span> ${option}
                        </h5>`
                    );
                });
            },
            
            error: function (xhr, status, error) {
                console.error('Error saving answer:', error);
            }
        });


        $('#selected-question-id').text('Selected Question ID: ' + questionId);

    });;

    $('.number').first().trigger('click');


    return {
        init: function () {

        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixSolution.init();
});
