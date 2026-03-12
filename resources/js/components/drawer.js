"use strict";

var IpixDrawerHandlersInitialized = false;

// Class definition
var IpixDrawer = function(element, options) {
    //////////////////////////////
    // ** Private variables  ** //
    //////////////////////////////
    var the = this;

    if (typeof element === "undefined" || element === null) {
        return;
    }

    // Default options
    var defaultOptions = {
        overlay: true,
        direction: 'end',
        baseClass: 'drawer',
        overlayClass: 'drawer-overlay'
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        if (IpixUtil.data(element).has('drawer')) {
            the = IpixUtil.data(element).get('drawer');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = IpixUtil.deepExtend({}, defaultOptions, options);
        the.uid = IpixUtil.getUniqueId('drawer');
        the.element = element;
        the.overlayElement = null;
        the.name = the.element.getAttribute('data-kt-drawer-name');
        the.shown = false;
        the.lastWidth;
        the.lastHeight;
        the.toggleElement = null;

        // Set initialized
        the.element.setAttribute('data-kt-drawer', 'true');

        // Event Handlers
        _handlers();

        // Update Instance
        _update();

        // Bind Instance
        IpixUtil.data(the.element).set('drawer', the);
    }

    var _handlers = function() {
        var togglers = _getOption('toggle');
        var closers = _getOption('close');

        if (togglers !== null && togglers.length > 0) {
            IpixUtil.on(document.body, togglers, 'click', function(e) {
                e.preventDefault();

                the.toggleElement = this;
                _toggle();
            });
        }

        if (closers !== null && closers.length > 0) {
            IpixUtil.on(document.body, closers, 'click', function(e) {
                e.preventDefault();

                the.closeElement = this;
                _hide();
            });
        }
    }

    var _toggle = function() {
        if (IpixEventHandler.trigger(the.element, 'kt.drawer.toggle', the) === false) {
            return;
        }

        if (the.shown === true) {
            _hide();
        } else {
            _show();
        }

        IpixEventHandler.trigger(the.element, 'kt.drawer.toggled', the);
    }

    var _hide = function() {
        if (IpixEventHandler.trigger(the.element, 'kt.drawer.hide', the) === false) {
            return;
        }

        the.shown = false;

        _deleteOverlay();

        document.body.removeAttribute('data-kt-drawer-' + the.name, 'on');
        document.body.removeAttribute('data-kt-drawer');

        IpixUtil.removeClass(the.element, the.options.baseClass + '-on');

        if (the.toggleElement !== null) {
            IpixUtil.removeClass(the.toggleElement, 'active');
        }

        IpixEventHandler.trigger(the.element, 'kt.drawer.after.hidden', the) === false
    }

    var _show = function() {
        if (IpixEventHandler.trigger(the.element, 'kt.drawer.show', the) === false) {
            return;
        }

        the.shown = true;

        _createOverlay();
        document.body.setAttribute('data-kt-drawer-' + the.name, 'on');
        document.body.setAttribute('data-kt-drawer', 'on');

        IpixUtil.addClass(the.element, the.options.baseClass + '-on');

        if (the.toggleElement !== null) {
            IpixUtil.addClass(the.toggleElement, 'active');
        }

        IpixEventHandler.trigger(the.element, 'kt.drawer.shown', the);
    }

    var _update = function() {
        var width = _getWidth();
        var height = _getHeight();
        var direction = _getOption('direction');

        var top = _getOption('top');
        var bottom = _getOption('bottom');
        var start = _getOption('start');
        var end = _getOption('end');

        // Reset state
        if (IpixUtil.hasClass(the.element, the.options.baseClass + '-on') === true && String(document.body.getAttribute('data-kt-drawer-' + the.name + '-')) === 'on') {
            the.shown = true;
        } else {
            the.shown = false;
        }

        // Activate/deactivate
        if (_getOption('activate') === true) {
            IpixUtil.addClass(the.element, the.options.baseClass);
            IpixUtil.addClass(the.element, the.options.baseClass + '-' + direction);

            if (width) {
                IpixUtil.css(the.element, 'width', width, true);
                the.lastWidth = width;
            }

            if (height) {
                IpixUtil.css(the.element, 'height', height, true);
                the.lastHeight = height;
            }

            if (top) {
                IpixUtil.css(the.element, 'top', top);
            }

            if (bottom) {
                IpixUtil.css(the.element, 'bottom', bottom);
            }

            if (start) {
                if (IpixUtil.isRTL()) {
                    IpixUtil.css(the.element, 'right', start);
                } else {
                    IpixUtil.css(the.element, 'left', start);
                }
            }

            if (end) {
                if (IpixUtil.isRTL()) {
                    IpixUtil.css(the.element, 'left', end);
                } else {
                    IpixUtil.css(the.element, 'right', end);
                }
            }
        } else {
            IpixUtil.removeClass(the.element, the.options.baseClass);
            IpixUtil.removeClass(the.element, the.options.baseClass + '-' + direction);

            IpixUtil.css(the.element, 'width', '');
            IpixUtil.css(the.element, 'height', '');

            if (top) {
                IpixUtil.css(the.element, 'top', '');
            }

            if (bottom) {
                IpixUtil.css(the.element, 'bottom', '');
            }

            if (start) {
                if (IpixUtil.isRTL()) {
                    IpixUtil.css(the.element, 'right', '');
                } else {
                    IpixUtil.css(the.element, 'left', '');
                }
            }

            if (end) {
                if (IpixUtil.isRTL()) {
                    IpixUtil.css(the.element, 'left', '');
                } else {
                    IpixUtil.css(the.element, 'right', '');
                }
            }

            _hide();
        }
    }

    var _createOverlay = function() {
        if (_getOption('overlay') === true) {
            the.overlayElement = document.createElement('DIV');

            IpixUtil.css(the.overlayElement, 'z-index', IpixUtil.css(the.element, 'z-index') - 1); // update

            document.body.append(the.overlayElement);

            IpixUtil.addClass(the.overlayElement, _getOption('overlay-class'));

            IpixUtil.addEvent(the.overlayElement, 'click', function(e) {
                e.preventDefault();

                if (_getOption('permanent') !== true) {
                    _hide();
                }
            });
        }
    }

    var _deleteOverlay = function() {
        if (the.overlayElement !== null) {
            IpixUtil.remove(the.overlayElement);
        }
    }

    var _getOption = function(name) {
        if (the.element.hasAttribute('data-kt-drawer-' + name) === true) {
            var attr = the.element.getAttribute('data-kt-drawer-' + name);
            var value = IpixUtil.getResponsiveValue(attr);

            if (value !== null && String(value) === 'true') {
                value = true;
            } else if (value !== null && String(value) === 'false') {
                value = false;
            }

            return value;
        } else {
            var optionName = IpixUtil.snakeToCamel(name);

            if (the.options[optionName]) {
                return IpixUtil.getResponsiveValue(the.options[optionName]);
            } else {
                return null;
            }
        }
    }

    var _getWidth = function() {
        var width = _getOption('width');

        if (width === 'auto') {
            width = IpixUtil.css(the.element, 'width');
        }

        return width;
    }

    var _getHeight = function() {
        var height = _getOption('height');

        if (height === 'auto') {
            height = IpixUtil.css(the.element, 'height');
        }

        return height;
    }

    var _destroy = function() {
        IpixUtil.data(the.element).remove('drawer');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.toggle = function() {
        return _toggle();
    }

    the.show = function() {
        return _show();
    }

    the.hide = function() {
        return _hide();
    }

    the.isShown = function() {
        return the.shown;
    }

    the.update = function() {
        _update();
    }

    the.goElement = function() {
        return the.element;
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return IpixEventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return IpixEventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return IpixEventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return IpixEventHandler.trigger(the.element, name, event, the, event);
    }
};

// Static methods
IpixDrawer.getInstance = function(element) {
    if (element !== null && IpixUtil.data(element).has('drawer')) {
        return IpixUtil.data(element).get('drawer');
    } else {
        return null;
    }
}

// Hide all drawers and skip one if provided
IpixDrawer.hideAll = function(skip = null, selector = '[data-kt-drawer="true"]') {
    var items = document.querySelectorAll(selector);

    if (items && items.length > 0) {
        for (var i = 0, len = items.length; i < len; i++) {
            var item = items[i];
            var drawer = IpixDrawer.getInstance(item);

            if (!drawer) {
                continue;
            }

            if (skip) {
                if (item !== skip) {
                    drawer.hide();
                }
            } else {
                drawer.hide();
            }
        }
    }
}

// Update all drawers
IpixDrawer.updateAll = function(selector = '[data-kt-drawer="true"]') {
    var items = document.querySelectorAll(selector);

    if (items && items.length > 0) {
        for (var i = 0, len = items.length; i < len; i++) {
            var drawer = IpixDrawer.getInstance(items[i]);

            if (drawer) {
                drawer.update();
            }
        }
    }
}

// Create instances
IpixDrawer.createInstances = function(selector = '[data-kt-drawer="true"]') {
    // Initialize Menus
    var elements = document.querySelectorAll(selector);

    if (elements && elements.length > 0) {
        for (var i = 0, len = elements.length; i < len; i++) {
            new IpixDrawer(elements[i]);
        }
    }
}

// Create instances
IpixDrawer.initDrawers = function(selector = '[data-kt-load-drawer="true"]') {
    // Initialize Menus
    var elements = document.querySelectorAll(selector);

    if (elements && elements.length > 0) {

        elements.forEach(function(el) {
            if (el.getAttribute("data-kt-initialized") === "1") {
                return;
            }
            el.setAttribute("data-kt-initialized", "1");
            el.addEventListener('click', function() {
                var preValdationStatus = 'Valid';
                if (IpixJson.validators['drawerPreValidation']) {
                    IpixJson.validators['drawerPreValidation'].validate().then(function(status) {
                        preValdationStatus = status;
                        if (status != 'Valid') {
                            $("a.nav-link[href='#" + $(".fv-plugins-bootstrap5-row-invalid:first").parents(".tab-pane").attr("id") + "']").addClass('tab-pane-error');
                        } else {
                            IpixDrawer.showDrawer(el);
                        }
                    });
                } else {
                    IpixDrawer.showDrawer(el);
                }
            });
        });
    }
}

IpixDrawer.showDrawer = function(el) {
    var drawerParametrs = {};
    if (el.hasAttribute('data-drawer-parameters')) {
        var parameters = el.getAttribute('data-drawer-parameters');
        if (parameters !== "") {
            parameters = JSON.parse(parameters);
            $.each(parameters, function(i, parameter) {
                if (parameter.hasOwnProperty('selector')) {
                    drawerParametrs[i] = $(parameter.selector).val();
                } else if (parameter.hasOwnProperty('value')) {
                    drawerParametrs[i] = parameter.value;
                }
            });
        }
    }
    $.ajax({
        method: "GET",
        url: $(el).data('url'),
        data: drawerParametrs,
        success: function(data) {
            $("#drawer-area").html(data.html);
            IpixDrawer.createInstances();
            IpixForm.autoCompleteDisable();
            $.each(data.scripts, function(key, script) {
                $.getScript(script);
            });
            var drawerElement = document.querySelector('#drawer-area [data-kt-drawer="true"]');
            IpixDrawer.getInstance(drawerElement).show();
            IpixDrawer.handleDismiss();
        },
    });
}

// Toggle instances
IpixDrawer.handleShow = function() {
    // External drawer toggle handler
    IpixUtil.on(document.body, '[data-kt-drawer-show="true"][data-kt-drawer-target]', 'click', function(e) {
        e.preventDefault();

        var element = document.querySelector(this.getAttribute('data-kt-drawer-target'));

        if (element) {
            IpixDrawer.getInstance(element).show();
        }
    });
}

// Handle escape key press
IpixDrawer.handleEscapeKey = function() {
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            //if esc key was not pressed in combination with ctrl or alt or shift
            const isNotCombinedKey = !(event.ctrlKey || event.altKey || event.shiftKey);
            if (isNotCombinedKey) {
                var elements = document.querySelectorAll('.drawer-on[data-kt-drawer="true"]:not([data-kt-drawer-escape="false"])');
                var drawer;

                if (elements && elements.length > 0) {
                    for (var i = 0, len = elements.length; i < len; i++) {
                        drawer = IpixDrawer.getInstance(elements[i]);
                        if (drawer.isShown()) {
                            drawer.hide();
                        }
                    }
                }
            }
        }
    });
}

// Dismiss instances
IpixDrawer.handleDismiss = function() {
    // External drawer toggle handler
    IpixUtil.on(document.body, '[data-kt-drawer-dismiss="true"]', 'click', function(e) {
        var element = this.closest('[data-kt-drawer="true"]');

        if (element) {
            var drawer = IpixDrawer.getInstance(element);
            if (drawer.isShown()) {
                drawer.hide();
            }
        }
    });
}

// Handle resize
IpixDrawer.handleResize = function() {
    // Window resize Handling
    window.addEventListener('resize', function() {
        var timer;

        IpixUtil.throttle(timer, function() {
            // Locate and update drawer instances on window resize
            var elements = document.querySelectorAll('[data-kt-drawer="true"]');

            if (elements && elements.length > 0) {
                for (var i = 0, len = elements.length; i < len; i++) {
                    var drawer = IpixDrawer.getInstance(elements[i]);
                    if (drawer) {
                        drawer.update();
                    }
                }
            }
        }, 200);
    });
}




// Global initialization
IpixDrawer.init = function() {
    IpixDrawer.initDrawers();
    IpixDrawer.createInstances();

    if (IpixDrawerHandlersInitialized === false) {
        IpixDrawer.handleResize();
        IpixDrawer.handleShow();
        IpixDrawer.handleDismiss();
        IpixDrawer.handleEscapeKey();

        IpixDrawerHandlersInitialized = true;
    }
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixDrawer;
}