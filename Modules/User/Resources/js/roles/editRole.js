"use strict";

var IpixRoleEdit = function() {
    var validateForm = function(e) {
        IpixJson.options.FormValidation.fields = {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Name is required'
                    }
                }
            },
        };
        IpixJson.validators['roleForm'] = FormValidation.formValidation(document.getElementById('roleForm'), IpixJson.options.FormValidation);
    }

    // Select all handler
    const handleSelectAll = () => {
        const selectAll = document.getElementById('roleForm').querySelector('#fd_roles_select_all');
        const allCheckboxes = document.getElementById('roleForm').querySelectorAll('[type="checkbox"]');

        selectAll.addEventListener('change', e => {
            allCheckboxes.forEach(c => {
                c.checked = e.target.checked;
            });
        });
    }
    return {
        init: function() {
            $("#roleModal").modal();
            $("#roleModal").modal("show");
            $("#roleModal").removeAttr("tabindex");
            IpixScroll.createInstances();
            validateForm();
            IpixFormValidation.handleFormSubmit();

            handleSelectAll();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixRoleEdit.init();
});