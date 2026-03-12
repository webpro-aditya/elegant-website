"use strict";
require('../../../../../resources/js/admin');

var IpixlAuthLogin = function() {

    var validateForm = function(e) {
        IpixJson.options.FormValidation.fields = {
            'email': {
                validators: {
                    regexp: {
                        regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                        message: 'The value is not a valid email address',
                    },
                    notEmpty: {
                        message: 'Email address is required'
                    },
                    remote: {
                        type: 'POST',
                        url: $('#email').data('url'),
                        message: 'This email address not exist',
                        delay: 2000
                    }
                }
            },
            'password': {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    },
                    remote: {
                        type: 'POST',
                        url: $('#password').data('url'),
                        data: function(validator) {
                            return {
                                email: $('#email').val(),
                                password: $('#password').val()
                            };
                        },
                        message: 'Incorrect password',
                        delay: 2000
                    }
                }
            }
        };
        IpixJson.validators['loginForm'] = FormValidation.formValidation(document.getElementById('loginForm'), IpixJson.options.FormValidation);
    }
    return {
        init: function() {
            validateForm();
        }
    };
}();

// On document ready
IpixUtil.onDOMContentLoaded(function() {
    IpixlAuthLogin.init();
});