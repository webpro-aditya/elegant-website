var primaryColor = IpixUtil.getCssVariableValue('--kt-primary');
var dangerColor = IpixUtil.getCssVariableValue('--kt-danger');
var successColor = IpixUtil.getCssVariableValue('--kt-success');
var warningColor = IpixUtil.getCssVariableValue('--kt-warning');
var infoColor = IpixUtil.getCssVariableValue('--kt-info');

// Define fonts
var fontFamily = IpixUtil.getCssVariableValue('--bs-font-sans-serif');

// Chart config
IpixJson.options.chartjs = {
    type: 'pie',
    data: {
        datasets: [{
            backgroundColor: [primaryColor, dangerColor, infoColor, warningColor, successColor],
        }]
    },
    options: {
        plugins: {
            title: {
                display: false,
            }
        },
        responsive: true,
    },
    defaults: {
        global: {
            defaultFont: fontFamily
        }
    }
};
