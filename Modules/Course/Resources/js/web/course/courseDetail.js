"use strict";
require('../../../../../../resources/js/web');
require("owl.carousel");

$(document).ready(function () {
    // ================== Carousels ==================
    $(".testimonial").owlCarousel({
        loop: true,
        margin: 10,
        items: 6,
        dots: false,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            500: { items: 2 },
            768: { items: 3 },
            1200: { items: 4 }
        },
    });

    $(".certificate-slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: true,
        nav: false,
        autoplay: true,
        autoplayTimeout: 7000,
        autoplayHoverPause: true,
    });

    // ================== Validators ==================
    // Common field rules
    const enquiryFields = {
        'name': {
            validators: {
                regexp: {
                    enabled: true,
                    regexp: /^[a-zA-Z\s]+$/,
                    message: 'Numbers not allowed',
                },
                notEmpty: {
                    enabled: true,
                    message: 'Name is required'
                },
            }
        },
        'email': {
            validators: {
                regexp: {
                    enabled: true,
                    regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                    message: 'The value is not a valid email address',
                },
                notEmpty: {
                    enabled: true,
                    message: 'Email Address is required'
                },
            }
        },
        'number': {
            validators: {
                notEmpty: {
                    message: 'Phone is required'
                },
                regexp: {
                    regexp: /^[0-9]+$/,
                    message: 'Only digits are allowed'
                }
            }
        },
        'message': {
            validators: {
                regexp: {
                    regexp: /^(?!.*<[^>]+>).*$/i,
                    message: 'Tags are not allowed'
                }
            }
        }
    };

    // Create validators ONCE
    IpixJson.options.FormValidation.fields = enquiryFields;

    IpixJson.validators['courseEnquiryForm'] = FormValidation.formValidation(
        document.getElementById('courseEnquiryForm'),
        IpixJson.options.FormValidation
    );

    IpixJson.validators['curriculmEnquiryForm'] = FormValidation.formValidation(
        document.getElementById('curriculmEnquiryForm'),
        IpixJson.options.FormValidation
    );

    IpixJson.validators['demoClassForm'] = FormValidation.formValidation(
        document.getElementById('demoClassForm'),
        IpixJson.options.FormValidation
    );

    // ================== Submit Handlers ==================
    $('#enquiry-submit').on('click', function () {
        IpixJson.validators['courseEnquiryForm'].validate();
    });

    $('#btnSubmit').on('click', function (event) {
        event.preventDefault();
        IpixJson.validators['curriculmEnquiryForm'].validate().then(function (status) {
            if (status === 'Valid') {
                Swal.fire({
                    icon: "success",
                    text: "Data submitted Successfully"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#curriculmModal').modal('hide');
                        setTimeout(() => location.reload(), 100);
                    }
                });
            }
        });
    });

    $('#demo-submit').on('click', function () {
        IpixJson.validators['demoClassForm'].validate();
    });

    // ================== Select2 inside modals ==================
    function formatOption(option) {
        if (!option.id) return option.text;
        return $(
            '<span><img src="' + $(option.element).data('image') +
            '" style="width: 20px; height: 15px; margin-right: 5px;" /> ' +
            option.text + '</span>'
        );
    }

    $('#curriculmModal').on('shown.bs.modal', function () {
        $('#curriculumCountryCode').select2({
            width: '100%',
            templateResult: formatOption,
            templateSelection: formatOption,
            dropdownParent: $("#curriculmModal"),
        });
    });

    $('#couseEnquiryModal').on('shown.bs.modal', function () {
        $('#enquiryCountryCode').select2({
            width: '100%',
            templateResult: formatOption,
            templateSelection: formatOption,
            dropdownParent: $("#couseEnquiryModal"),
        });
    });

    $('#couseDemoClassModal').on('shown.bs.modal', function () {
        $('#demoCountryCode').select2({
            width: '100%',
            templateResult: formatOption,
            templateSelection: formatOption,
            dropdownParent: $("#couseDemoClassModal"),
        });
    });

    $('#courseBrochureModal').on('shown.bs.modal', function () {
        $('#brochureCountryCode').select2({
            width: '100%',
            templateResult: formatOption,
            templateSelection: formatOption,
            dropdownParent: $("#courseBrochureModal"),
        });
    });

    // ================== Reset forms on modal close ==================
    $('#couseEnquiryModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('courseEnquiryForm');
        form.reset();
        IpixJson.validators['courseEnquiryForm'].resetForm(true);
    });

    $('#curriculmModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('curriculmEnquiryForm');
        form.reset();
        IpixJson.validators['curriculmEnquiryForm'].resetForm(true);
    });

    $('#couseDemoClassModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('demoClassForm');
        form.reset();
        IpixJson.validators['demoClassForm'].resetForm(true);
    });
});

// ================== Helper ==================
function showSwalMessage(title, message, icon) {
    Swal.fire({
        title: title,
        text: message,
        icon: icon
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
}