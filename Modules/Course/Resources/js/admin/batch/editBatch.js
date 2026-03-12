"use strict";
require('../../../../../../resources/js/admin');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');

var IpixCourseEditBatch = function () {
    var validateForm = function (e) {
        IpixJson.options.FormValidation.fields = {
            'course_id': {
                validators: {
                    notEmpty: {
                        message: 'Course is required'
                    }
                }
            },
            'duration': {
                validators: {
                    notEmpty: {
                        message: 'Duration is required'
                    }
                }
            },
            'start_time': {
                validators: {
                    notEmpty: {
                        message: 'Start Time is required'
                    }
                }
            },
            'end_time': {
                validators: {
                    notEmpty: {
                        message: 'End Time is required'
                    }
                }
            },
        };
        IpixJson.validators['editBatchForm'] = FormValidation.formValidation(document.getElementById('editBatchForm'), IpixJson.options.FormValidation);
    }

    return {
        init: function () {
            validateForm();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixCourseEditBatch.init();
});
