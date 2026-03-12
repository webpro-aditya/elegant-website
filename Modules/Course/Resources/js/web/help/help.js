"use strict";
require('../../../../../../resources/js/web');
import Swal from 'sweetalert2';

var IpixEnquiryAdd = function () {
    var validateForm = function (e) {
        IpixJson.options.FormValidation.fields = {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
            'email': {
                validators: {
                    notEmpty: {
                        message: 'Email is required'
                    }
                }
            },
            'phone': {
                validators: {
                    notEmpty: {
                        message: 'Phone is required'
                    }
                }
            },
            'subject': {
                validators: {
                    notEmpty: {
                        message: 'Date is required'
                    }
                }
            }
        };
        IpixJson.validators['enquiryForm'] = FormValidation.formValidation(document.getElementById('enquiryForm'), IpixJson.options.FormValidation.fields);
    }


    return {
        init: function () {
            validateForm();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixEnquiryAdd.init();
});

$('#enquiryForm').submit(function (e) {
    e.preventDefault();
    var form = $(this);

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (response) {
            showSwalMessage("Success!", "Your enquiry has been successfully noted.", "success", true);
        },
        error: function (xhr, status, error) {
            showSwalMessage("An error occurred while processing your enquiry!", "Check if you entered all the necessary fields, or try again later.", "error");
        }
    });
});

function showSwalMessage(title, message, type, reload = false) {

    Swal.fire({
        title: title,
        text: message,
        icon: type,
        showConfirmButton: true, // Set to true to show the confirmation button
        confirmButtonText: "Ok, got it!", // Text for the confirmation button
        customClass: {
            confirmButton: "btn btn-primary", // Custom CSS class for the confirmation button
        },
    }).then((result) => {
        if (result.isConfirmed && reload) {
            location.reload();
        }
    });
}
