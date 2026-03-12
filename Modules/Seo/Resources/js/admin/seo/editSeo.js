"use strict";
require('../../../../../../resources/js/admin.js');
require('../../../../../../resources/plugins/tinymce/tinymce.js');



var IpixAddContent = function () {
    var validateForm = function() {
        IpixJson.options.FormValidation.fields = {
            'meta_title': {
                validators: {
                    notEmpty: {
                        message: 'Meta title is required'
                    }
                }
            },
            // Add other fields and their validation rules here
        };
        IpixJson.validators['seoForm'] = FormValidation.formValidation(
            document.getElementById('seoForm'),
            IpixJson.options.FormValidation
        );
    };

    return {
        init: function () {
            validateForm();

            // Attach submit event handler
            document.getElementById('btnSubmit').addEventListener('click', function(e) {
                e.preventDefault();
                
                IpixJson.validators['seoForm'].validate().then(function(status) {
                    if (status === 'Valid') {
                        document.getElementById('seoForm').submit();
                    } else {
                        // Handle the case where the form is invalid
                        console.log('Form validation failed');
                    }
                });
            });
        }
    };
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixAddContent.init();
});