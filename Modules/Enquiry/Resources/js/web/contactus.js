"use strict";
require("../../../../../resources/js/web");

var IpixDepartmentAdd = function () {

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
            'number': {
                validators: {
                    notEmpty: {
                        message: 'Number is required'
                    }
                }
            },
            'message': {
                validators: {
                    notEmpty: {
                        message: 'Message is required'
                    },
                    regexp: {
                        // Disallow any HTML tag
                        regexp: /^(?!.*<[^>]+>).*$/i,
                        message: 'Tags are not allowed'
                    }
                }
            }


        };
        IpixJson.validators['enquiryForm'] = FormValidation.formValidation(document.getElementById('enquiryForm'), IpixJson.options.FormValidation);
    }

    return {
        init: function () {
            validateForm();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixDepartmentAdd.init();
});


$(document).ready(function () {
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

    // Initialize Select2 with configuration
    $('#countryCode').select2({
        width: '100%',
        templateResult: formatOption, // Use custom formatOption function for dropdown options
        templateSelection: formatOption // Use custom formatOption function for selected option
    });
});