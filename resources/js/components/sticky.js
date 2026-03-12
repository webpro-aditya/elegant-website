"use strict";

var IpixStickyHandlersInitialized = false;

// Class definition
var IpixSticky = function(element, options) {
    ////////////////////////////
    // ** Private Variables  ** //
    ////////////////////////////
    var the = this;

    if (typeof element === "undefined" || element === null) {
        return;
    }

    // Default Options
    var defaultOptions = {
        offset: 200,
        reverse: false,
        animation: true,
        animationSpeed: '0.3s',
        animationClass: 'animation-slide-in-down'
    };
    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var _construct = function() {
        if (IpixUtil.data(element).has('sticky') === true) {
            the = IpixUtil.data(element).get('sticky');
        } else {
            _init();
        }
    }

    var _init = function() {
        the.element = element;
        the.options = IpixUtil.deepExtend({}, defaultOptions, options);
        the.uid = IpixUtil.getUniqueId('sticky');
        the.name = the.element.getAttribute('data-kt-sticky-name');
        the.attributeName = 'data-kt-sticky-' + the.name;
        the.attributeName2 = 'data-kt-' + the.name;
        the.eventTriggerState = true;
        the.lastScrollTop = 0;
        the.scrollHandler;

        // Set initialized
        the.element.setAttribute('data-kt-sticky', 'true');

        // Event Handlers
        window.addEventListener('scroll', _scroll);

        // Initial Launch
        _scroll();

        // Bind Instance
        IpixUtil.data(the.element).set('sticky', the);
    }

    var _scroll = function(e) {
        var offset = _getOption('offset');
        var releaseOffset = _getOption('release-offset');
        var reverse = _getOption('reverse');
        var st;
        var attrName;
        var diff;

        // Exit if false
        if (offset === false) {
            return;
        }

        offset = parseInt(offset);
        releaseOffset = releaseOffset ? parseInt(releaseOffset) : 0;
        st = IpixUtil.getScrollTop();
        diff = document.documentElement.scrollHeight - window.innerHeight - IpixUtil.getScrollTop();

        if (reverse === true) { // Release on reverse scroll mode
            if (st > offset && (releaseOffset === 0 || releaseOffset < diff)) {
                if (document.body.hasAttribute(the.attributeName) === false) {

                    if (_enable() === false) {
                        return;
                    }

                    document.body.setAttribute(the.attributeName, 'on');
                    document.body.setAttribute(the.attributeName2, 'on');
                }

                if (the.eventTriggerState === true) {
                    IpixEventHandler.trigger(the.element, 'kt.sticky.on', the);
                    IpixEventHandler.trigger(the.element, 'kt.sticky.change', the);

                    the.eventTriggerState = false;
                }
            } else { // Back scroll mode
                if (document.body.hasAttribute(the.attributeName) === true) {
                    _disable();
                    document.body.removeAttribute(the.attributeName);
                    document.body.removeAttribute(the.attributeName2);
                }

                if (the.eventTriggerState === false) {
                    IpixEventHandler.trigger(the.element, 'kt.sticky.off', the);
                    IpixEventHandler.trigger(the.element, 'kt.sticky.change', the);
                    the.eventTriggerState = true;
                }
            }

            the.lastScrollTop = st;
        } else { // Classic scroll mode
            if (st > offset && (releaseOffset === 0 || releaseOffset < diff)) {
                if (document.body.hasAttribute(the.attributeName) === false) {

                    if (_enable() === false) {
                        return;
                    }

                    document.body.setAttribute(the.attributeName, 'on');
                    document.body.setAttribute(the.attributeName2, 'on');
                }

                if (the.eventTriggerState === true) {
                    IpixEventHandler.trigger(the.element, 'kt.sticky.on', the);
                    IpixEventHandler.trigger(the.element, 'kt.sticky.change', the);
                    the.eventTriggerState = false;
                }
            } else { // back scroll mode
                if (document.body.hasAttribute(the.attributeName) === true) {
                    _disable();
                    document.body.removeAttribute(the.attributeName);
                    document.body.removeAttribute(the.attributeName2);
                }

                if (the.eventTriggerState === false) {
                    IpixEventHandler.trigger(the.element, 'kt.sticky.off', the);
                    IpixEventHandler.trigger(the.element, 'kt.sticky.change', the);
                    the.eventTriggerState = true;
                }
            }
        }

        if (releaseOffset > 0) {
            if (diff < releaseOffset) {
                the.element.setAttribute('data-kt-sticky-released', 'true');
            } else {
                the.element.removeAttribute('data-kt-sticky-released');
            }
        }
    }

    var _enable = function(update) {
        var top = _getOption('top');
        top = top ? parseInt(top) : 0;

        var left = _getOption('left');
        var right = _getOption('right');
        var width = _getOption('width');
        var zindex = _getOption('zindex');
        var dependencies = _getOption('dependencies');
        var classes = _getOption('class');

        var height = _calculateHeight();
        var heightOffset = _getOption('height-offset');
        heightOffset = heightOffset ? parseInt(heightOffset) : 0;

        if (height + heightOffset + top > IpixUtil.getViewPort().height) {
            return false;
        }

        if (update !== true && _getOption('animation') === true) {
            IpixUtil.css(the.element, 'animationDuration', _getOption('animationSpeed'));
            IpixUtil.animateClass(the.element, 'animation ' + _getOption('animationClass'));
        }

        if (classes !== null) {
            IpixUtil.addClass(the.element, classes);
        }

        if (zindex !== null) {
            IpixUtil.css(the.element, 'z-index', zindex);
            IpixUtil.css(the.element, 'position', 'fixed');
        }

        if (top >= 0) {
            IpixUtil.css(the.element, 'top', String(top) + 'px');
        }

        if (width !== null) {
            if (width['target']) {
                var targetElement = document.querySelector(width['target']);
                if (targetElement) {
                    width = IpixUtil.css(targetElement, 'width');
                }
            }

            IpixUtil.css(the.element, 'width', width);
        }

        if (left !== null) {
            if (String(left).toLowerCase() === 'auto') {
                var offsetLeft = IpixUtil.offset(the.element).left;

                if (offsetLeft >= 0) {
                    IpixUtil.css(the.element, 'left', String(offsetLeft) + 'px');
                }
            } else {
                IpixUtil.css(the.element, 'left', left);
            }
        }

        if (right !== null) {
            IpixUtil.css(the.element, 'right', right);
        }

        // Height dependencies
        if (dependencies !== null) {
            var dependencyElements = document.querySelectorAll(dependencies);

            if (dependencyElements && dependencyElements.length > 0) {
                for (var i = 0, len = dependencyElements.length; i < len; i++) {
                    IpixUtil.css(dependencyElements[i], 'padding-top', String(height) + 'px');
                }
            }
        }
    }

    var _disable = function() {
        IpixUtil.css(the.element, 'top', '');
        IpixUtil.css(the.element, 'width', '');
        IpixUtil.css(the.element, 'left', '');
        IpixUtil.css(the.element, 'right', '');
        IpixUtil.css(the.element, 'z-index', '');
        IpixUtil.css(the.element, 'position', '');

        var dependencies = _getOption('dependencies');
        var classes = _getOption('class');

        if (classes !== null) {
            IpixUtil.removeClass(the.element, classes);
        }

        // Height dependencies
        if (dependencies !== null) {
            var dependencyElements = document.querySelectorAll(dependencies);

            if (dependencyElements && dependencyElements.length > 0) {
                for (var i = 0, len = dependencyElements.length; i < len; i++) {
                    IpixUtil.css(dependencyElements[i], 'padding-top', '');
                }
            }
        }
    }

    var _check = function() {

    }

    var _calculateHeight = function() {
        var height = parseFloat(IpixUtil.css(the.element, 'height'));

        height = height + parseFloat(IpixUtil.css(the.element, 'margin-top'));
        height = height + parseFloat(IpixUtil.css(the.element, 'margin-bottom'));

        if (IpixUtil.css(element, 'border-top')) {
            height = height + parseFloat(IpixUtil.css(the.element, 'border-top'));
        }

        if (IpixUtil.css(element, 'border-bottom')) {
            height = height + parseFloat(IpixUtil.css(the.element, 'border-bottom'));
        }

        return height;
    }

    var _getOption = function(name) {
        if (the.element.hasAttribute('data-kt-sticky-' + name) === true) {
            var attr = the.element.getAttribute('data-kt-sticky-' + name);
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

    var _destroy = function() {
        window.removeEventListener('scroll', _scroll);
        IpixUtil.data(the.element).remove('sticky');
    }

    // Construct Class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Methods
    the.update = function() {
        if (document.body.hasAttribute(the.attributeName) === true) {
            _disable();
            document.body.removeAttribute(the.attributeName);
            document.body.removeAttribute(the.attributeName2);
            _enable(true);
            document.body.setAttribute(the.attributeName, 'on');
            document.body.setAttribute(the.attributeName2, 'on');
        }
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
IpixSticky.getInstance = function(element) {
    if (element !== null && IpixUtil.data(element).has('sticky')) {
        return IpixUtil.data(element).get('sticky');
    } else {
        return null;
    }
}

// Create instances
IpixSticky.createInstances = function(selector = '[data-kt-sticky="true"]') {
    // Initialize Menus
    var elements = document.body.querySelectorAll(selector);
    var sticky;

    if (elements && elements.length > 0) {
        for (var i = 0, len = elements.length; i < len; i++) {
            sticky = new IpixSticky(elements[i]);
        }
    }
}

// Window resize handler
IpixSticky.handleResize = function() {
    window.addEventListener('resize', function() {
        var timer;

        IpixUtil.throttle(timer, function() {
            // Locate and update Offcanvas instances on window resize
            var elements = document.body.querySelectorAll('[data-kt-sticky="true"]');

            if (elements && elements.length > 0) {
                for (var i = 0, len = elements.length; i < len; i++) {
                    var sticky = IpixSticky.getInstance(elements[i]);
                    if (sticky) {
                        sticky.update();
                    }
                }
            }
        }, 200);
    });
}

// Global initialization
IpixSticky.init = function() {
    IpixSticky.createInstances();

    if (IpixStickyHandlersInitialized === false) {
        IpixSticky.handleResize();
        IpixStickyHandlersInitialized = true;
    }
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixSticky;
}