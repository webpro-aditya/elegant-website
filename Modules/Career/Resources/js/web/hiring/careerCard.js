"use strict";
var IpixCareerCard = (function () {
alert('asdsa')
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
            'resume': {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        message: 'Please upload a PDF file'
                    }
                }
            }
        };

            IpixJson.validators["enquiry-form"] = FormValidation.formValidation(
                document.getElementById("enquiry-form"),
                IpixJson.options.FormValidation
            );
    }

    

    return {
        init: function () {
            IpixFormValidation.handleFormSubmit();
            validateForm();
        }
    };
})();

IpixUtil.onDOMContentLoaded(function () {
    IpixCareerCard.init();
});