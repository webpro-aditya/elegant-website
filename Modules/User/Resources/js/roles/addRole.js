"use strict";

var IpixRoleAdd = function() {
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
        const selectAllCheckbox = document.getElementById('fd_roles_select_all');

        selectAllCheckbox.addEventListener('change', () => {
            const isChecked = selectAllCheckbox.checked;
            const selectedValue = $('#gaurd_select').val();

            const visibleRows = document.querySelectorAll('tr.' + selectedValue + ':not(.select-all-row)');
            visibleRows.forEach(row => {
                const checkboxes = row.querySelectorAll('[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });
        });
    };

    var guardRollList = function() {
        var showHideRows = function(selectedValue) {
            $('tr').each(function() {
                if (!$(this).hasClass('select-all-row')) {
                    var permissionType = $(this).attr('class');
                    if (permissionType === selectedValue) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                }
            });
        };

        var selectedValue = $('#gaurd_select').val();
        showHideRows(selectedValue);

        $('#gaurd_select').change(function() {
            $('input[type="checkbox"]').prop('checked', false);
            var selectedValue = $(this).val();
            showHideRows(selectedValue);
        });
    }

    return {
        init: function() {
            $("#roleModal").modal();
            $("#roleModal").modal("show");
            $("#roleModal").removeAttr("tabindex");
            IpixScroll.createInstances();
            validateForm();
            guardRollList();
            handleSelectAll();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function() {
    IpixRoleAdd.init();
});
