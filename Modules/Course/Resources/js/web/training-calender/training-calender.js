"use strict";
require('../../../../../../resources/js/web');

var IpixDepartmentAdd = function () {
    var validateForm = function () {
        $('#enquiryForm').on('submit', function (event) {
            event.preventDefault();
            var isValid = true;

            // Clear previous error messages
            $('.invalid-feedback').html('');

            // Name validation
            var name = $('#name').val();
            if (!name) {
                $('#name').siblings('.invalid-feedback').html('Name is required');
                isValid = false;
            }

            // Email validation
            var email = $('#email').val();
            if (!email) {
                $('#email').siblings('.invalid-feedback').html('Email is required');
                isValid = false;
            }

            // Phone validation
            var phone = $('#number').val();
            if (!phone) {
                $('#number').siblings('.invalid-feedback').html('Phone is required');
                isValid = false;
            }

            if (isValid) {
                var form = $(this);
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            showSwalMessage("Success!", response.message, "success", response.redirectUrl);
                            if (response.redirectUrl) {
                                window.location.href = response.redirectUrl;
                            }
                        } else {
                            showSwalMessage("An error occurred!", response.message, "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        showSwalMessage("An error occurred while processing your enquiry!", "Check if you entered all the necessary fields, or try again later.", "error");
                    }
                });
            }
        });
    }

    function showSwalMessage(title, message, icon, redirectUrl) {
        Swal.fire({
            title: title,
            text: message,
            icon: icon
        }).then((result) => {
            if (result.isConfirmed && redirectUrl) {
                window.location.href = redirectUrl;
            }
        });
    }

    return {
        init: function () {
            validateForm();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixDepartmentAdd.init();

    $('.register-now-link').on('click', function () {
        var courseId = $(this).data('course-id');
        $('#courseId').val(courseId);
    });
});
$(document).ready(function() {
    // Define the formatOption function
    function formatOption(option) {
        if (!option.id) {
            return option.text;
        }
        var $option = $(
            '<span><img src="' + $(option.element).data('image') + '" style="width: 20px; height: 15px; margin-right: 5px;" /> ' + option.text + '</span>'
        );
        return $option;
    }

    $('#couseEnquiryModal').on('shown.bs.modal', function () {
        $('#country_code').select2({
            width: '100%',
            templateResult: formatOption,
            templateSelection: formatOption,
            dropdownParent: $("#couseEnquiryModal"),
        });
    });

});

