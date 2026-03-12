"use strict";
require('../../../../../resources/js/admin');
window.IpixImageInput = require('../../../../../resources/js/components/image-input.js');

var IpixUsersEditUser = function() {
    var validateForm = function(e) {
        IpixJson.options.FormValidation.fields = {
            // 'profile_picture': {
            //     validators: {
            //         notEmpty: {
            //             extension: 'jpeg,jpg,png,',
            //             message: 'Profile picture is not valid'
            //         }
            //     }
            // },
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
            'role_id': {
                validators: {
                    notEmpty: {
                        message: 'Role is required'
                    }
                }
            },
            'email': {
                validators: {
                    regexp: {
                        regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                        message: 'The value is not a valid email address',
                    },
                    notEmpty: {
                        message: 'Email address is required'
                    }
                }
            },
            'current_password': {
                validators: {
                    stringLength: {
                        min: 6,
                        message: 'The password length minimum of  6 characters'
                    }
                }
            },
            'password': {
                validators: {
                    stringLength: {
                        min: 6,
                        message: 'The password length minimum of  6 characters'
                    }
                }
            },
            'password_confirm': {
                validators: {
                    identical: {
                        compare: function() {
                            return $('[name="password"]').val();
                        },
                        message: 'The password and its confirm are not the same'
                    }
                }
            }
        };
        IpixJson.validators['userForm'] = FormValidation.formValidation(document.getElementById('userForm'), IpixJson.options.FormValidation);
    }
    return {
        init: function() {
            validateForm();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixImageInput.init();
    IpixUsersEditUser.init();
});