"use strict";
require('../../../../../../resources/js/web');


var IpixDepartmentAdd = function() {
    var validateCourseDemoForm = function(e) {
        IpixJson.options.FormValidation.fields = {

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
                    }
                }
            },
        };
        IpixJson.validators['hiring-form'] = FormValidation.formValidation(document.getElementById('hiring-form'), IpixJson.options.FormValidation);
        return IpixJson.validators['hiring-form'].validate();
    }


    return {
        init: function() {
            // validateCourseForm();
            validateCourseDemoForm()
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixDepartmentAdd.init();
});