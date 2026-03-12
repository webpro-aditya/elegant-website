"use strict";
require('../../../../../../resources/js/admin.js');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');
require('../../../../../../resources/plugins/dropzone/dropzone.js');

var IpixCoursesEditCourse = function() {
    var validateForm = function(e) {
        IpixJson.options.FormValidation.fields = {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            }
        };
        IpixJson.validators['editCategoryForm'] = FormValidation.formValidation(document.getElementById('editCategoryForm'), IpixJson.options.FormValidation);
    }
    return {
        init: function() {
            validateForm();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixImageInput.init();
    IpixCoursesEditCourse.init();
});
