//
// 3rd-Party Plugins JavaScript Includes
//


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
////  Mandatory Plugins Includes(do not remove or change order!)  ////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

// Jquery - jQuery is a popular and feature-rich JavaScript library. Learn more: https://jquery.com/
window.jQuery = window.$ = require('jquery');

// Bootstrap - The most popular framework uses as the foundation. Learn more: http://getbootstrap.com
window.bootstrap = require('bootstrap');

// Popper.js - Tooltip & Popover Positioning Engine used by Bootstrap. Learn more: https://popper.js.org
window.Popper = require('@popperjs/core');

// Wnumb - Number & Money formatting. Learn more: https://refreshless.com/wnumb/
window.wNumb = require('wnumb');

// Moment - Parse, validate, manipulate, and display dates and times in JavaScript. Learn more: https://momentjs.com/
window.moment = require('moment');

// ES6-Shim - ECMAScript 6 compatibility shims for legacy JS engines.  Learn more: https://github.com/paulmillr/es6-shim
require("es6-shim/es6-shim.min.js");

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window._token = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
window.IpixJson = {};
window.IpixJson.lang = {};
window.IpixJson.options = {};

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
///  Optional Plugins Includes(you can remove or add)  ///////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

// FormValidation - Best premium validation library for JavaScript. Zero dependencies. Learn more: https://formvalidation.io/
window.FormValidation = require('../plugins/formvalidation/dist/js/FormValidation.full.min.js');
window.FormValidation.plugins.Bootstrap5 = require('../plugins/formvalidation/dist/amd/plugins/Bootstrap5.js').default;
// window.FormValidation.plugins.Declarative = require('../plugins/formvalidation/dist/amd/plugins/Declarative.js').default;
require('./vendors/plugins/FormValidation.init.js');

// Date Range Picker - A JavaScript component for choosing date ranges, dates and times: https://www.daterangepicker.com/
require('bootstrap-daterangepicker/daterangepicker.js');

// Bootstrap Maxlength - This plugin integrates by default with Twitter bootstrap using badges to display the maximum length of the field where the user is inserting text: https://github.com/mimo84/bootstrap-maxlength
require('bootstrap-maxlength/src/bootstrap-maxlength.js');

// Bootstrap Mmultiselectsplitter - Transforms a <select> containing one or more <optgroup> in two chained <select>: https://github.com/poolerMF/bootstrap-multiselectsplitter/
require('bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js');

// Select2 - Select2 is a jQuery based replacement for select boxes: https://select2.org/
require('select2/dist/js/select2.full.min.js');
require('./vendors/plugins/select2.init.js');

// Flatpickr - is a lightweight and powerful datetime picker.
require('flatpickr/dist/flatpickr.min.js');
require('./vendors/plugins/flatpickr.init.js');

// Inputmask - is a javascript library which creates an input mask: https://github.com/RobinHerbots/Inputmask
require('inputmask/dist/inputmask.js');
require('inputmask/dist/bindings/inputmask.binding.js');

// Toastr - is a Javascript library for non-blocking notifications. jQuery is required. The goal is to create a simple core library that can be customized and extended: https://github.com/CodeSeven/toastr
window.toastr = require('../plugins/toastr/build/toastr.min.js');
require('./vendors/plugins/toastr.init.js');

// ES6 Promise Polyfill - This is a polyfill of the ES6 Promise: https://github.com/lahmatiy/es6-promise-polyfill
require('es6-promise-polyfill/promise.min.js');

// Sweetalert2 - a beautiful, responsive, customizable and accessible (WAI-ARIA) replacement for JavaScript's popup boxes: https://sweetalert2.github.io/
window.Swal = window.swal = require('sweetalert2/dist/sweetalert2.min.js');
require('./vendors/plugins/sweetalert2.init.js');

// A lightweight script to animate scrolling to anchor links
window.SmoothScroll = require('smooth-scroll/dist/smooth-scroll.js');

// Clipboard - Copy text to the clipboard shouldn't be hard. It shouldn't require dozens of steps to configure or hundreds of KBs to load: https://clipboardjs.com/
window.ClipboardJS = require('clipboard/dist/clipboard.min.js');

var defaultThemeMode = "light";
var themeMode;
if (document.documentElement) {
    if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
    } else {
        if (localStorage.getItem("data-bs-theme") !== null) {
            themeMode = localStorage.getItem("data-bs-theme");
        } else { themeMode = defaultThemeMode; }
    }
    if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    }
    document.documentElement.setAttribute("data-bs-theme", themeMode);
}

// Ipixthemes' plugins
window.IpixComponents = require('./components/_init.js');
window.IpixUtil = require('./components/util.js');
window.IpixApp = require('./components/app.js');
window.IpixFormValidation = require('./components/formValidation.js');
window.IpixEventHandler = require('./components/event-handler.js');
window.IpixBlockUI = require('./components/blockui.js');
window.IpixFlatPicker = require('./components/flatPicker.js');
window.IpixCookie = require('./components/cookie.js');
window.IpixDialer = require('./components/dialer.js');
window.IpixDrawer = require('./components/drawer.js');
window.IpixFeedback = require('./components/feedback.js');
window.IpixMenu = require('./components/menu.js');
window.IpixModal = require('./components/modal.js');
window.IpixForm = require('./components/form.js');
window.IpixPasswordMeter = require('./components/password-meter.js');
window.IpixScroll = require('./components/scroll.js');
window.IpixSticky = require('./components/sticky.js');
window.IpixSwapper = require('./components/swapper.js');
window.IpixToggle = require('./components/toggle.js');


// Layout base js
window.IpixThemeMode = require('./layout/theme-mode.js');
window.IpixThemeModeUser = require('./layout/theme-mode-user.js');
window.IpixAppSidebar = require('./layout/sidebar.js');