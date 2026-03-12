window.jQuery = window.$ = require("jquery"), window.bootstrap = require("bootstrap"), window.Popper = require("@popperjs/core"), window.wNumb = require("wnumb"), window.moment = require("moment"), require("es6-shim/es6-shim.min.js");
let token = document.head.querySelector('meta[name="csrf-token"]');
token ? window._token = token.content : console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"), window.IpixJson = {}, window.IpixJson.lang = {}, window.IpixJson.options = {}, window.FormValidation = require("../plugins/formvalidation/dist/js/FormValidation.full.min.js"), window.FormValidation.plugins.Bootstrap5 = require("../plugins/formvalidation/dist/amd/plugins/Bootstrap5.js").default, require("./vendors/plugins/FormValidation.init.js"), require("bootstrap-maxlength/src/bootstrap-maxlength.js"), require("bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js"), require("select2/dist/js/select2.full.min.js"), require("./vendors/plugins/select2.init.js"), require("flatpickr/dist/flatpickr.min.js"), require("./vendors/plugins/flatpickr.init.js"), require("inputmask/dist/inputmask.js"), require("inputmask/dist/bindings/inputmask.binding.js"), window.toastr = require("../plugins/toastr/build/toastr.min.js"), require("./vendors/plugins/toastr.init.js"), require("es6-promise-polyfill/promise.min.js"), window.Swal = window.swal = require("sweetalert2/dist/sweetalert2.min.js"), require("./vendors/plugins/sweetalert2.init.js"), window.SmoothScroll = require("smooth-scroll/dist/smooth-scroll.js"), window.IpixComponents = require("./components/_init.js"), window.IpixUtil = require("./components/util.js"), window.IpixApp = require("./components/app.js"), window.IpixFormValidation = require("./components/formValidation.js"), window.IpixEventHandler = require("./components/event-handler.js"), window.IpixBlockUI = require("./components/blockui.js"), window.IpixFlatPicker = require("./components/flatPicker.js"), window.IpixCookie = require("./components/cookie.js"), window.IpixDialer = require("./components/dialer.js"), window.IpixDrawer = require("./components/drawer.js"), window.IpixFeedback = require("./components/feedback.js"), window.IpixMenu = require("./components/menu.js"), window.IpixModal = require("./components/modal.js"), window.IpixForm = require("./components/form.js"), window.IpixPasswordMeter = require("./components/password-meter.js"), window.IpixScroll = require("./components/scroll.js"), window.IpixSticky = require("./components/sticky.js"), window.IpixSwapper = require("./components/swapper.js"), window.IpixToggle = require("./components/toggle.js");
var IpixNewsletter = { init: function() { IpixJson.options.FormValidation.fields = { email: { validators: { regexp: { enabled: !0, regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, message: "The value is not a valid email address" }, notEmpty: { message: "Email is required" } } } }, IpixJson.validators.SubscribeForm = FormValidation.formValidation(document.getElementById("SubscribeForm"), IpixJson.options.FormValidation) } },
    IpixCourseFinder = function() {
        var e = function(e) {
            $(document).on("input", "#search_text", (function(e) {
                const i = $("#search_text").val();
                "" == $(this).val().trim() && $(".search-result").hide();
                const o = document.getElementById("suggestionsContainer"),
                    n = document.getElementById("suggestionsList");
                "" != i ? $.ajax({
                    url: $("#search_text").data("url"),
                    type: "get",
                    data: { text: i },
                    success: function(e) {
                        ! function(e) {
                            if (n.innerHTML = "", Object.keys(e).length > 0) {
                                for (const i in e) {
                                    const o = e[i];
                                    if (Object.prototype.hasOwnProperty.call(e, i)) {
                                        const e = document.createElement("li");
                                        e.addEventListener("click", (function() { window.location.href = o.link }));
                                        const i = document.createElement("a");
                                        i.textContent = o.title, i.href = o.link, e.appendChild(i), n.appendChild(e)
                                    }
                                }
                                $(".search-result").show()
                            } else $(".search-result").hide()
                        }(e)
                    }
                }) : (n.innerHTML = "", o.style.display = "none")
            }))
        };
        return { init: function() { e() } }
    }();
IpixUtil.onDOMContentLoaded((function() { IpixNewsletter.init(), IpixCourseFinder.init() })), require("./web/common.js");