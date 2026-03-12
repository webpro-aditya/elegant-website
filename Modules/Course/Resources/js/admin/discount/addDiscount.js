"use strict";
require('../../../../../../resources/js/admin.js');
window.IpixStepper = require('../../../../../../resources/js/components/stepper.js');

var IpixAddDiscount = function () {
    var validateForm = function (e) {
        IpixJson.options.FormValidation.fields = {
            'title': {
                validators: {
                    notEmpty: {
                        message: 'Title is required'
                    }
                }
            },
            'code': {
                validators: {
                    notEmpty: {
                        message: 'Discount Percentage is required'
                    }
                }
            },
            'valid_from': {
                validators: {
                    notEmpty: {
                        message: 'Valid From Date is required'
                    }
                }
            },
            'valid_to': {
                validators: {
                    notEmpty: {
                        message: 'Valid To Date is required'
                    }
                }
            },
            'attempt_per_user': {
                validators: {
                    notEmpty: {
                        message: 'Attempt Per User is required'
                    }
                }
            },

        };
        IpixJson.validators['discountForm'] = FormValidation.formValidation(document.getElementById('discountForm'), IpixJson.options.FormValidation);
        flatpickr("#valid_from", {
            enableTime: false,
            dateFormat: "Y-m-d",
            minDate: "today",
            defaultDate: null,
        });

        flatpickr("#valid_to", {
            enableTime: false,
            dateFormat: "Y-m-d",
            minDate: "today",
            defaultDate: null,
        });

    }
    var statusEvent = function(e) {
        const target = document.getElementById('discount_status');
        $("#discount_status_select").change(function(e) {
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
                    case "outdate":
                        {
                            target.classList.remove(...['bg-success', 'bg-warning', 'bg-danger']);
                            target.classList.add('bg-warning');
                            break;
                        }
                default:
                    break;
            }
        });
    }
    return {
        init: function () {
            validateForm();
            statusEvent();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixAddDiscount.init();
});
