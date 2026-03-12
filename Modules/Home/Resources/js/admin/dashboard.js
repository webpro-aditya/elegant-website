"use strict";

const IpixUtil = require('../../../../../resources/js/components/util');

require('../../../../../resources/js/admin');
require('../../../../../resources/plugins/apexcharts/apexcharts');
require('../../../../../resources/plugins/datatable/datatable');
window.am5 = require("@amcharts/amcharts5");
window.am5xy = require("@amcharts/amcharts5/xy");
window.am5percent = require("@amcharts/amcharts5/percent");
window.am5radar = require("@amcharts/amcharts5/radar");
window.am5themes_Animated = require("@amcharts/amcharts5/themes/Animated");
require('../../../../../resources/js/widgets/charts/widget-19');

var IpixDashboardHome = function() {

    var initPaymentTermList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listPaymentTerms").data('url'),
            "type": "POST",
            searching: false,
            "data": function(data) {
                data._token = _token;
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "payment_type", name: "payment_type", orderable: false, searchable: false },
            { data: "payment_date", name: "payment_date", orderable: false, searchable: false },
            { data: "amount", name: "amount", orderable: false, searchable: false },
        ];

        IpixJson.dataTables['listPaymentTerms'] = $('#listPaymentTerms').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listPaymentTerms'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }


    var initPropertyIncomeList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listPropertyIncome").data('url'),
            "type": "POST",
            searching: false,
            "data": function(data) {
                data._token = _token;
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "property", name: "property_id", orderable: false, searchable: false },
            { data: "location", name: "location", orderable: false, searchable: false },
            { data: "income", name: "income", orderable: false, searchable: false },
        ];
        IpixJson.dataTables['listPropertyIncome'] = $('#listPropertyIncome').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listPropertyIncome'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }

    var propertyChart = {
        self: null,
        rendered: false
    };

    var chart = {
        self: null,
        rendered: false
    };

    var initPropertyChart = function(propertyChart) {
        var element = document.getElementById("dashboardPropertychart");
        if (!element) {
            return;
        }
        $.ajax({
            url: $("#dashboardPropertychart").data("url"),
            type: 'post',
            data: {
                _token: _token,
                // year: $('#year').val(),
            },
            dataType: 'json',
            error: function(data, status, xhr, form) {},
            success: function(response) {
                var result = response.data;
                var months = result.labels;
                months = $.map(result.labels, function(value) {
                    return value;
                });
                var xAxisCategories = months;
                var yAxisData = result.values;

                var height = parseInt(IpixUtil.css(element, 'height'));
                var labelColor = IpixUtil.getCssVariableValue('--bs-gray-900');
                var borderColor = IpixUtil.getCssVariableValue('--bs-border-dashed-color');
                var options = {
                    series: [{
                        name: 'New Properties',
                        data: yAxisData // Use dynamically set y-axis data here
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['35%'],
                            borderRadius: 5,
                            dataLabels: {
                                position: "top" // top, center, bottom
                            },
                            startingShape: 'flat'
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: true,
                        offsetY: -28,
                        style: {
                            fontSize: '13px',
                            colors: [labelColor]
                        },
                        formatter: function(val) {
                            return val; // + "H";
                        }
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: xAxisCategories, // Use dynamically set x-axis categories here
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: IpixUtil.getCssVariableValue('--bs-gray-500'),
                                fontSize: '13px'
                            }
                        },
                        crosshairs: {
                            fill: {
                                gradient: {
                                    opacityFrom: 0,
                                    opacityTo: 0
                                }
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: IpixUtil.getCssVariableValue('--bs-gray-500'),
                                fontSize: '13px'
                            },
                            formatter: function(val) {
                                return val;
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return +val
                            }
                        }
                    },
                    colors: [IpixUtil.getCssVariableValue('--bs-primary'), IpixUtil.getCssVariableValue('--bs-primary-light')],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                propertyChart.self = new ApexCharts(element, options);

                setTimeout(function() {
                    propertyChart.self.render();
                    propertyChart.rendered = true;
                }, 200);
            }
        });

    }

    var initTenantChart = function(chart) {

        var element = document.getElementById("dashboardTenantchart");

        if (!element) {
            return;
        }

        $.ajax({
            url: $("#dashboardTenantchart").data("url"),
            type: 'post',
            data: {
                _token: _token,
                // year: $('#year').val(),
            },
            dataType: 'json',
            error: function(data, status, xhr, form) {},
            success: function(response) {
                var result = response.data;
                var months = result.labels;
                months = $.map(result.labels, function(value) {
                    return value;
                });
                console.log(months);
                var xAxisCategories = months;
                var yAxisData = result.values;
                var height = parseInt(IpixUtil.css(element, 'height'));
                var labelColor = IpixUtil.getCssVariableValue('--bs-gray-500');
                var borderColor = IpixUtil.getCssVariableValue('--bs-border-dashed-color');
                var baseColor = IpixUtil.getCssVariableValue('--bs-info');

                var options = {
                    series: [{
                        name: 'Tenants',
                        data: yAxisData // Use dynamically set y-axis data here
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'area',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0,
                            stops: [0, 80, 100]
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [baseColor]
                    },
                    xaxis: {
                        categories: xAxisCategories, // Use dynamically set x-axis categories here
                        axisBorder: {
                            show: false,
                        },
                        offsetX: 20,
                        axisTicks: {
                            show: false
                        },
                        tickAmount: 3,
                        labels: {
                            rotate: 0,
                            rotateAlways: false,
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        },
                        crosshairs: {
                            position: 'front',
                            stroke: {
                                color: baseColor,
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        tickAmount: 4,
                        max: Math.max(...yAxisData), // Dynamically set y-axis max value
                        min: Math.min(...yAxisData), // Dynamically set y-axis min value
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            },
                            formatter: function(val) {
                                return val
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return val
                            }
                        }
                    },
                    colors: [baseColor],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    markers: {
                        strokeColor: baseColor,
                        strokeWidth: 3
                    }
                };

                chart.self = new ApexCharts(element, options);

                setTimeout(function() {
                    chart.self.render();
                    chart.rendered = true;
                }, 200);
            }
        });

    }

    var initEnquiryList = function() {

        IpixJson.options.datatables.ajax = {
            "url": $("#listEnquiry").data('url'),
            "type": "POST",
            "data": function(data) {
                data._token = _token;
                data.type = $('#type').val();
                data.course_id = $('#course_id').val();
            }
        };
        IpixJson.options.datatables.columns = [
            { data: "DT_RowIndex", orderable: false, searchable: true },
            { data: "name", name: "name", orderable: true, searchable: false },
            { data: "email", name: "email", orderable: true, searchable: false },
            { data: "type", orderable: true, searchable: true },

        ];
        IpixJson.options.datatables.order = [
            [1, "asc"]
        ];
        IpixJson.dataTables['listEnquiry'] = $('#listEnquiry').DataTable(IpixJson.options.datatables);
        IpixJson.dataTables['listEnquiry'].on('draw', function() {
            IpixDatatable.handleDeleteRows();
            IpixMenu.createInstances();
        });
    }


    return {
        init: function() {
            initPaymentTermList();
            initPropertyIncomeList();
            initPropertyChart(propertyChart);
            initTenantChart(chart);
            initEnquiryList();
        }
    }

}();

// On document ready
IpixUtil.onDOMContentLoaded(function() {
    IpixDashboardHome.init();
});