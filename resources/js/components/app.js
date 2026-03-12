"use strict";

// Class definition
var IpixApp = (function() {
    var initialized = false;
    var select2FocusFixInitialized = false;
    var countUpInitialized = false;

    var createBootstrapTooltip = function(el, options) {
        if (el.getAttribute("data-kt-initialized") === "1") {
            return;
        }

        var delay = {};

        // Handle delay options
        if (el.hasAttribute("data-bs-delay-hide")) {
            delay["hide"] = el.getAttribute("data-bs-delay-hide");
        }

        if (el.hasAttribute("data-bs-delay-show")) {
            delay["show"] = el.getAttribute("data-bs-delay-show");
        }

        if (delay) {
            options["delay"] = delay;
        }

        // Check dismiss options
        if (
            el.hasAttribute("data-bs-dismiss") &&
            el.getAttribute("data-bs-dismiss") == "click"
        ) {
            options["dismiss"] = "click";
        }

        // Initialize popover
        var tp = new bootstrap.Tooltip(el, options);

        // Handle dismiss
        if (options["dismiss"] && options["dismiss"] === "click") {
            // Hide popover on element click
            el.addEventListener("click", function(e) {
                tp.hide();
            });
        }

        el.setAttribute("data-kt-initialized", "1");

        return tp;
    };

    var createBootstrapTooltips = function() {
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );

        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            createBootstrapTooltip(tooltipTriggerEl, {});
        });
    };

    var createBootstrapPopover = function(el, options) {
        if (el.getAttribute("data-kt-initialized") === "1") {
            return;
        }

        var delay = {};

        // Handle delay options
        if (el.hasAttribute("data-bs-delay-hide")) {
            delay["hide"] = el.getAttribute("data-bs-delay-hide");
        }

        if (el.hasAttribute("data-bs-delay-show")) {
            delay["show"] = el.getAttribute("data-bs-delay-show");
        }

        if (delay) {
            options["delay"] = delay;
        }

        // Handle dismiss option
        if (el.getAttribute("data-bs-dismiss") == "true") {
            options["dismiss"] = true;
        }

        if (options["dismiss"] === true) {
            options["template"] =
                '<div class="popover" role="tooltip"><div class="popover-arrow"></div><span class="popover-dismiss btn btn-icon"></span><h3 class="popover-header"></h3><div class="popover-body"></div></div>';
        }

        // Initialize popover
        var popover = new bootstrap.Popover(el, options);

        // Handle dismiss click
        if (options["dismiss"] === true) {
            var dismissHandler = function(e) {
                popover.hide();
            };

            el.addEventListener("shown.bs.popover", function() {
                var dismissEl = document.getElementById(
                    el.getAttribute("aria-describedby")
                );
                dismissEl.addEventListener("click", dismissHandler);
            });

            el.addEventListener("hide.bs.popover", function() {
                var dismissEl = document.getElementById(
                    el.getAttribute("aria-describedby")
                );
                dismissEl.removeEventListener("click", dismissHandler);
            });
        }

        el.setAttribute("data-kt-initialized", "1");

        return popover;
    };

    var createBootstrapPopovers = function() {
        var popoverTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="popover"]')
        );

        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            createBootstrapPopover(popoverTriggerEl, {});
        });
    };

    var createBootstrapToasts = function() {
        var toastElList = [].slice.call(document.querySelectorAll(".toast"));
        var toastList = toastElList.map(function(toastEl) {
            if (toastEl.getAttribute("data-kt-initialized") === "1") {
                return;
            }

            toastEl.setAttribute("data-kt-initialized", "1");

            return new bootstrap.Toast(toastEl, {});
        });
    };

    var createButtons = function() {
        var buttonsGroup = [].slice.call(
            document.querySelectorAll('[data-kt-buttons="true"]')
        );

        buttonsGroup.map(function(group) {
            if (group.getAttribute("data-kt-initialized") === "1") {
                return;
            }

            var selector = group.hasAttribute("data-kt-buttons-target") ?
                group.getAttribute("data-kt-buttons-target") :
                ".btn";
            var activeButtons = [].slice.call(group.querySelectorAll(selector));

            // Toggle Handler
            IpixUtil.on(group, selector, "click", function(e) {
                activeButtons.map(function(button) {
                    button.classList.remove("active");
                });

                this.classList.add("active");
            });

            group.setAttribute("data-kt-initialized", "1");
        });
    };

    var createDateRangePickers = function() {
        // Check if jQuery included
        if (typeof jQuery == "undefined") {
            return;
        }

        // Check if daterangepicker included
        if (typeof $.fn.daterangepicker === "undefined") {
            return;
        }

        var elements = [].slice.call(
            document.querySelectorAll('[data-kt-daterangepicker="true"]')
        );
        var start = moment().subtract(29, "days");
        var end = moment();

        elements.map(function(element) {
            if (element.getAttribute("data-kt-initialized") === "1") {
                return;
            }

            var display = element.querySelector("div");
            var attrOpens = element.hasAttribute("data-kt-daterangepicker-opens") ?
                element.getAttribute("data-kt-daterangepicker-opens") :
                "left";
            var range = element.getAttribute("data-kt-daterangepicker-range");

            var cb = function(start, end) {
                var current = moment();

                if (display) {
                    if (current.isSame(start, "day") && current.isSame(end, "day")) {
                        display.innerHTML = start.format("D MMM YYYY");
                    } else {
                        display.innerHTML =
                            start.format("D MMM YYYY") + " - " + end.format("D MMM YYYY");
                    }
                }
            };

            if (range === "today") {
                start = moment();
                end = moment();
            }

            $(element).daterangepicker({
                    startDate: start,
                    endDate: end,
                    opens: attrOpens,
                    ranges: {
                        Today: [moment(), moment()],
                        Yesterday: [
                            moment().subtract(1, "days"),
                            moment().subtract(1, "days"),
                        ],
                        "Last 7 Days": [moment().subtract(6, "days"), moment()],
                        "Last 30 Days": [moment().subtract(29, "days"), moment()],
                        "This Month": [moment().startOf("month"), moment().endOf("month")],
                        "Last Month": [
                            moment().subtract(1, "month").startOf("month"),
                            moment().subtract(1, "month").endOf("month"),
                        ],
                    },
                },
                cb
            );

            cb(start, end);

            element.setAttribute("data-kt-initialized", "1");
        });
    };

    // Init tagify
    const createTagify = () => {
        const tagify = document.querySelector('[data-kt-tagify-input="true"]');

        // Break if element not found
        if (!tagify) {
            return;
        }

        // Init tagify --- more info: https://yaireo.github.io/tagify/
        new Tagify(tagify, IpixJson.options.tagify);
    };

    var createJstree = function() {
        // Check if jQuery included
        if (typeof jQuery == "undefined") {
            return;
        }

        // Check if jstree included
        if (typeof $.fn.jstree === "undefined") {
            return;
        }

        var jsTreeElements = [].slice.call(
            document.querySelectorAll('[kt-jstree-container="true"]')
        );
        jsTreeElements.map(function(element) {
            $(element)
                .bind("changed.jstree", function(e, data) {
                    if (data.node) {
                        if (data.node && data.node.state.selected) {
                            $("input.tree-checkbox." + data.node.id).prop("checked", true);
                        } else {
                            $("input.tree-checkbox." + data.node.id).prop("checked", false);
                        }
                    }
                })
                .bind("loaded.jstree", function() {
                    var selectedCategories = $("#categoryTree").data("selected");
                    for (var k in selectedCategories) {
                        $("#categoryTree").jstree(
                            "select_node",
                            "#category_" + selectedCategories[k],
                            true
                        );
                    }
                })
                .jstree(IpixJson.options.jsTree);
        });
        $(".searchCategory").keyup(function() {
            $("#categoryTree").jstree(true).search($(".searchCategory").val());
        });
    };

    var createAutosize = function() {
        if (typeof autosize === "undefined") {
            return;
        }

        var inputs = [].slice.call(
            document.querySelectorAll('[data-kt-autosize="true"]')
        );

        inputs.map(function(input) {
            if (input.getAttribute("data-kt-initialized") === "1") {
                return;
            }

            autosize(input);

            input.setAttribute("data-kt-initialized", "1");
        });
    };

    var createCountUp = function() {
        if (typeof countUp === "undefined") {
            return;
        }

        var elements = [].slice.call(
            document.querySelectorAll('[data-kt-countup="true"]:not(.counted)')
        );

        elements.map(function(element) {
            if (IpixUtil.isInViewport(element) && IpixUtil.visible(element)) {
                if (element.getAttribute("data-kt-initialized") === "1") {
                    return;
                }

                var options = {};

                var value = element.getAttribute("data-kt-countup-value");
                value = parseFloat(value.replace(/,/g, ""));

                if (element.hasAttribute("data-kt-countup-start-val")) {
                    options.startVal = parseFloat(
                        element.getAttribute("data-kt-countup-start-val")
                    );
                }

                if (element.hasAttribute("data-kt-countup-duration")) {
                    options.duration = parseInt(
                        element.getAttribute("data-kt-countup-duration")
                    );
                }

                if (element.hasAttribute("data-kt-countup-decimal-places")) {
                    options.decimalPlaces = parseInt(
                        element.getAttribute("data-kt-countup-decimal-places")
                    );
                }

                if (element.hasAttribute("data-kt-countup-prefix")) {
                    options.prefix = element.getAttribute("data-kt-countup-prefix");
                }

                if (element.hasAttribute("data-kt-countup-separator")) {
                    options.separator = element.getAttribute("data-kt-countup-separator");
                }

                if (element.hasAttribute("data-kt-countup-suffix")) {
                    options.suffix = element.getAttribute("data-kt-countup-suffix");
                }

                var count = new countUp.CountUp(element, value, options);

                count.start();

                element.classList.add("counted");

                element.setAttribute("data-kt-initialized", "1");
            }
        });
    };

    var createCountUpTabs = function() {
        if (typeof countUp === "undefined") {
            return;
        }

        if (countUpInitialized === false) {
            // Initial call
            createCountUp();

            // Window scroll event handler
            window.addEventListener("scroll", createCountUp);
        }

        // Tabs shown event handler
        var tabs = [].slice.call(
            document.querySelectorAll(
                '[data-kt-countup-tabs="true"][data-bs-toggle="tab"]'
            )
        );
        tabs.map(function(tab) {
            if (tab.getAttribute("data-kt-initialized") === "1") {
                return;
            }

            tab.addEventListener("shown.bs.tab", createCountUp);

            tab.setAttribute("data-kt-initialized", "1");
        });

        countUpInitialized = true;
    };

    var createTinySliders = function() {
        if (typeof tns === "undefined") {
            return;
        }

        // Sliders
        const elements = Array.prototype.slice.call(
            document.querySelectorAll('[data-tns="true"]'),
            0
        );

        if (!elements && elements.length === 0) {
            return;
        }

        elements.forEach(function(el) {
            if (el.getAttribute("data-kt-initialized") === "1") {
                return;
            }

            const obj = initTinySlider(el);
            IpixUtil.data(el).set("tns", tns);

            el.setAttribute("data-kt-initialized", "1");
        });
    };

    var initTinySlider = function(el) {
        if (!el) {
            return;
        }

        const tnsOptions = {};

        // Convert string boolean
        const checkBool = function(val) {
            if (val === "true") {
                return true;
            }
            if (val === "false") {
                return false;
            }
            return val;
        };

        // get extra options via data attributes
        el.getAttributeNames().forEach(function(attrName) {
            // more options; https://github.com/ganlanyuan/tiny-slider#options
            if (/^data-tns-.*/g.test(attrName)) {
                let optionName = attrName
                    .replace("data-tns-", "")
                    .toLowerCase()
                    .replace(/(?:[\s-])\w/g, function(match) {
                        return match.replace("-", "").toUpperCase();
                    });

                if (attrName === "data-tns-responsive") {
                    // fix string with a valid json
                    const jsonStr = el
                        .getAttribute(attrName)
                        .replace(/(\w+:)|(\w+ :)/g, function(matched) {
                            return '"' + matched.substring(0, matched.length - 1) + '":';
                        });
                    try {
                        // convert json string to object
                        tnsOptions[optionName] = JSON.parse(jsonStr);
                    } catch (e) {}
                } else {
                    tnsOptions[optionName] = checkBool(el.getAttribute(attrName));
                }
            }
        });

        const opt = Object.assign({}, {
                container: el,
                slideBy: "page",
                autoplay: true,
                center: true,
                autoplayButtonOutput: false,
            },
            tnsOptions
        );

        if (el.closest(".tns")) {
            IpixUtil.addClass(el.closest(".tns"), "tns-initiazlied");
        }

        return tns(opt);
    };

    var initSmoothScroll = function() {
        if (initialized === true) {
            return;
        }

        if (typeof SmoothScroll === "undefined") {
            return;
        }

        new SmoothScroll('a[data-kt-scroll-toggle][href*="#"]', {
            speed: 1000,
            speedAsDuration: true,
            offset: function(anchor, toggle) {
                // Integer or Function returning an integer. How far to offset the scrolling anchor location in pixels
                // This example is a function, but you could do something as simple as `offset: 25`

                // An example returning different values based on whether the clicked link was in the header nav or not
                if (anchor.hasAttribute("data-kt-scroll-offset")) {
                    var val = IpixUtil.getResponsiveValue(
                        anchor.getAttribute("data-kt-scroll-offset")
                    );

                    return val;
                } else {
                    return 0;
                }
            },
        });
    };

    var initCard = function() {
        // Toggle Handler
        IpixUtil.on(
            document.body,
            '[data-kt-card-action="remove"]',
            "click",
            function(e) {
                e.preventDefault();

                const card = this.closest(".card");

                if (!card) {
                    return;
                }

                const confirmMessage = this.getAttribute(
                    "data-kt-card-confirm-message"
                );
                const confirm = this.getAttribute("data-kt-card-confirm") === "true";

                if (confirm) {
                    // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: confirmMessage ? confirmMessage : "Are you sure to remove ?",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Confirm",
                        denyButtonText: "Cancel",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            denyButton: "btn btn-danger",
                        },
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            card.remove();
                        }
                    });
                } else {
                    card.remove();
                }
            }
        );
    };

    var initModal = function() {
        var elements = Array.prototype.slice.call(
            document.querySelectorAll("[data-bs-stacked-modal]")
        );

        if (elements && elements.length > 0) {
            elements.forEach((element) => {
                if (element.getAttribute("data-kt-initialized") === "1") {
                    return;
                }

                element.setAttribute("data-kt-initialized", "1");

                element.addEventListener("click", function(e) {
                    e.preventDefault();

                    const modalEl = document.querySelector(
                        this.getAttribute("data-bs-stacked-modal")
                    );

                    if (modalEl) {
                        const modal = new bootstrap.Modal(modalEl, { backdrop: false });
                        modal.show();
                    }
                });
            });
        }
    };

    var initCheck = function() {
        if (initialized === true) {
            return;
        }

        // Toggle Handler
        IpixUtil.on(
            document.body,
            '[data-kt-check="true"]',
            "change",
            function(e) {
                var check = this;
                var targets = document.querySelectorAll(
                    check.getAttribute("data-kt-check-target")
                );

                IpixUtil.each(targets, function(target) {
                    if (target.type == "checkbox") {
                        target.checked = check.checked;
                    } else {
                        target.classList.toggle("active");
                    }
                });
            }
        );
    };

    var initBootstrapCollapse = function() {
        if (initialized === true) {
            return;
        }

        IpixUtil.on(
            document.body,
            '.collapsible[data-bs-toggle="collapse"]',
            "click",
            function(e) {
                if (this.classList.contains("collapsed")) {
                    this.classList.remove("active");
                    this.blur();
                } else {
                    this.classList.add("active");
                }

                if (this.hasAttribute("data-kt-toggle-text")) {
                    var text = this.getAttribute("data-kt-toggle-text");
                    var target = this.querySelector(
                        '[data-kt-toggle-text-target="true"]'
                    );
                    var target = target ? target : this;

                    this.setAttribute("data-kt-toggle-text", target.innerText);
                    target.innerText = text;
                }
            }
        );
    };

    var initBootstrapRotate = function() {
        if (initialized === true) {
            return;
        }

        IpixUtil.on(
            document.body,
            '[data-kt-rotate="true"]',
            "click",
            function(e) {
                if (this.classList.contains("active")) {
                    this.classList.remove("active");
                    this.blur();
                } else {
                    this.classList.add("active");
                }
            }
        );
    };

    // Init noUIslider
    const initNoUIslider = () => {
        const sliderElements = [].slice.call(
            document.querySelectorAll('[data-kt-noUiSlider="true"]')
        );
        if (sliderElements && $(sliderElements).length) {
            sliderElements.map(function(element) {
                var elementParent = $(element).parents(".noUi-container");

                noUiSlider.create(element, {
                    start: [
                        $(elementParent).find('[data-kt-noUiSlider-value="true"]').val(),
                    ],
                    connect: true,
                    step: 1,
                    range: {
                        min: 0,
                        max: 100,
                    },
                });

                element.noUiSlider.on("update", function(values, handle) {
                    $(elementParent)
                        .find('[data-kt-noUiSlider-span="true"]')
                        .html(Math.round(values[handle]));
                    $(elementParent)
                        .find('[data-kt-noUiSlider-value="true"]')
                        .val(Math.round(values[handle]));
                });
            });
        }
    };

    var initAjaxLoader = () => {
        /** Loader starts */
        // $(document).ajaxStart(function() {
        //     IpixApp.showPageLoading();
        // });
        // $(document).ajaxStop(function() {
        //     IpixApp.hidePageLoading();
        // });
        /** loader End */
    };

    return {
        init: function() {
            initSmoothScroll();

            initCard();

            initModal();

            initCheck();

            initBootstrapCollapse();

            initBootstrapRotate();

            createBootstrapTooltips();

            createBootstrapPopovers();

            createBootstrapToasts();

            createDateRangePickers();

            createButtons();

            createTagify();

            createJstree();

            createCountUp();

            createCountUpTabs();

            createAutosize();

            createTinySliders();

            IpixApp.createSelect2();

            initNoUIslider();

            initAjaxLoader();

            IpixApp.initClickCopying();

            IpixApp.handleFileRemove();

            initialized = true;
        },

        showPageLoading: function() {
            showPageLoading();
        },

        hidePageLoading: function() {
            hidePageLoading();
        },

        createBootstrapPopover: function(el, options) {
            return createBootstrapPopover(el, options);
        },

        createBootstrapTooltip: function(el, options) {
            return createBootstrapTooltip(el, options);
        },
    };
})();

IpixApp.showPageLoading = function() {
    document.body.classList.add("page-loading");
    document.body.setAttribute("data-kt-app-page-loading", "on");
};

IpixApp.hidePageLoading = function() {
    // CSS3 Transitions only after page load(.page-loading or .app-page-loading class added to body tag and remove with JS on page load)
    document.body.classList.remove("page-loading");
    document.body.removeAttribute("data-kt-app-page-loading");
};

IpixApp.initClickCopying = function() {
    var buttons = [].slice.call(
        document.querySelectorAll("[data-share-link-button]")
    );
    buttons.map(function(button) {
        if (button.getAttribute("data-kt-initialized") === "1") {
            return;
        }
        var parentElement = button.parentElement;
        var input = parentElement.querySelector("[data-share-link-input]");
        var clipboard = new ClipboardJS(button);

        if (!clipboard) {
            return;
        }

        //  Copy text to clipboard. For more info check the plugin's documentation: https://clipboardjs.com/
        clipboard.on("success", function(e) {
            var buttonCaption = button.innerHTML;
            //Add bgcolor
            input.classList.add("bg-success");
            input.classList.add("text-inverse-success");

            button.innerHTML = "Copied!";

            setTimeout(function() {
                button.innerHTML = buttonCaption;

                // Remove bgcolor
                input.classList.remove("bg-success");
                input.classList.remove("text-inverse-success");
            }, 3000); // 3seconds

            e.clearSelection();
        });

        button.setAttribute("data-kt-initialized", "1");
    });
};

// Init page loader
window.addEventListener("load", function() {
    IpixApp.hidePageLoading();
});

IpixApp.createSelect2 = function() {
    // Check if jQuery included
    if (typeof jQuery == "undefined") {
        return;
    }

    // Check if select2 included
    if (typeof $.fn.select2 === "undefined") {
        return;
    }

    var elements = [].slice.call(
        document.querySelectorAll(
            '[data-control="select2"], [data-kt-select2="true"]'
        )
    );

    elements.map(function(element) {
        if (element.getAttribute("data-kt-initialized") === "1") {
            return;
        }

        var options = IpixJson.options.select2.normal;
        options.dropdownParent = $(element).parent();
        if ($(element).data("dropdown-parent")) {
            options.dropdownParent = $($(element).data("dropdown-parent"));
        }

        if ($(element).data("placeholder")) {
            options.placeholder = $(element).data("placeholder");
        }
        if ($(element).data("multiple") == "true") {
            $(element).attr("multiple", "multiple");
        }
        // if (element.getAttribute('data-image-select') == 'true') {
        //     options.templateResult = function(option) {
        //         if (!option.id) { return option.text; }
        //         return '<span ><img sytle="display: inline-block;" src="' + option.image + '" />' + option.text + '</span>'
        //     };
        //     options.templateSelection = function(option) {
        //         if (option.id.length > 0) {
        //             return '<span ><img sytle="display: inline-block;" src="' + option.image + '" />' + option.text + '</span>'
        //         } else {
        //             return option.text;
        //         }
        //     };
        // }

        if (element.getAttribute("data-server") == "true") {
            options = IpixJson.options.select2.server;
            options.ajax.url = $(element).data("option-url");
            options.ajax.data = function(params) {
                var query = {
                    search: params.term,
                    page: params.page || 1,
                };
                if (element.hasAttribute("data-select2-filter")) {
                    var filters = element.getAttribute("data-select2-filter");
                    if (filters !== "") {
                        filters = JSON.parse(filters);
                        $.each(filters, function(i, filter) {
                            if (filter.hasOwnProperty("selector")) {
                                if ($(filter.selector).length > 1) {
                                    var values = [];
                                    if ($(filter.selector).attr("type") == "checkbox") {
                                        $(filter.selector + ":checked").each(function() {
                                            values.push($(this).val());
                                        });
                                    } else {
                                        $(filter.selector).each(function() {
                                            values.push($(this).val());
                                        });
                                    }
                                    query[i] = values;
                                } else {
                                    query[i] = $(filter.selector).val();
                                }
                            } else if (filter.hasOwnProperty("value")) {
                                query[i] = filter.value;
                            }
                        });
                    }
                }
                return query;
            };
            options.ajax.processResults = function(data, params) {
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: data.length ? true : false,
                    },
                };
            };
        }

        if (element.getAttribute("data-hide-search") == "true") {
            options.minimumResultsForSearch = Infinity;
        } else {
            options.minimumResultsForSearch = 1;
        }

        $(element).select2(options);

        // Handle Select2's IpixMenu parent case
        if (
            element.hasAttribute("data-dropdown-parent") &&
            element.hasAttribute("multiple")
        ) {
            var parentEl = document.querySelector(
                element.getAttribute("data-dropdown-parent")
            );

            if (parentEl && parentEl.hasAttribute("data-kt-menu")) {
                var menu = IpixMenu.getInstance(parentEl);

                if (!menu) {
                    menu = new IpixMenu(parentEl);
                }

                if (menu) {
                    $(element).on("select2:unselect", function(e) {
                        element.setAttribute("data-multiple-unselect", "1");
                    });

                    menu.on("kt.menu.dropdown.hide", function(item) {
                        if (element.getAttribute("data-multiple-unselect") === "1") {
                            element.removeAttribute("data-multiple-unselect");
                            return false;
                        }
                    });
                }
            }
        }

        element.setAttribute("data-kt-initialized", "1");
    });

    /*
     * Hacky fix for a bug in select2 with jQuery 3.6.0's new nested-focus "protection"
     * see: https://github.com/select2/select2/issues/5993
     * see: https://github.com/jquery/jquery/issues/4382
     *
     * TODO: Recheck with the select2 GH issue and remove once this is fixed on their side
     */

    if (IpixApp.select2FocusFixInitialized === false) {
        IpixApp.select2FocusFixInitialized = true;

        $(document).on("select2:open", function(e) {
            var elements = document.querySelectorAll(
                ".select2-container--open .select2-search__field"
            );
            if (elements.length > 0) {
                elements[elements.length - 1].focus();
            }
        });
    }
};
IpixApp.handleFileRemove = function(e) {
    const removeButton = [].slice.call(
        document.querySelectorAll('[data-kt-file-input-action="remove"]')
    );
    if (removeButton && $(removeButton).length) {
        removeButton.map(function(element) {
            element.addEventListener("click", function() {
                var fileInputParent = $(element).parents(".file-input");
                $(element).parents(".file-container").remove();
                $(fileInputParent).find('[type="file"]').show();
                $(fileInputParent)
                    .find(
                        '[name="' +
                        $(fileInputParent).find('[type="file"]').attr("name") +
                        '_remove"]'
                    )
                    .val(1);
            });
        });
    }
};

// Declare IpixApp for Webpack support
if (typeof module !== "undefined" && typeof module.exports !== "undefined") {
    module.exports = IpixApp;
}