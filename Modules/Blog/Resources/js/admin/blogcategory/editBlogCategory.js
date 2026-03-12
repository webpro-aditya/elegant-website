"use strict";
require('../../../../../../resources/js/admin.js');
window.IpixImageInput = require('../../../../../../resources/js/components/image-input.js');

var IpixEditCategory = function() {
    var validateForm = function(e) {
        IpixJson.options.FormValidation.fields = {

            'name_en': {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
        };
        IpixJson.validators['categoryForm'] = FormValidation.formValidation(document.getElementById('categoryForm'), IpixJson.options.FormValidation);
    }

    var statusEvent = function(e) {
        const target = document.getElementById('category_status');
        $("#category_status_select").change(function(e) {
            switch (e.target.value) {
                case "active":
                    {
                        target.classList.remove(...['bg-success', 'bg-warning', 'bg-danger']);
                        target.classList.add('bg-success');
                        break;
                    }
                case "inactive":
                    {
                        target.classList.remove(...['bg-success', 'bg-warning', 'bg-danger']);
                        target.classList.add('bg-danger');
                        break;
                    }
                default:
                    break;
            }
        });
    }
    return {
        init: function() {
            validateForm();
            statusEvent();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixEditCategory.init();
    IpixImageInput.init();
});
