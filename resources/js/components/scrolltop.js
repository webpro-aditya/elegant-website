"use strict";

// Class definition
var IpixScrolltop = function(element, options) {
    ////////////////////////////
    // ** Private variables  ** //
    ////////////////////////////
    var the = this;

    if (typeof element === "undefined" || element === null) {
        return;
    }

    // Default options
    var defaultOptions = {
        offset: 300,
        speed: 600
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        if (IpixUtil.data(element).has('scrolltop')) {
            the = IpixUtil.data(element).get('scrolltop');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = IpixUtil.deepExtend({}, defaultOptions, options);
        the.uid = IpixUtil.getUniqueId('scrolltop');
        the.element = element;

        // Set initialized
        the.element.setAttribute('data-kt-scrolltop', 'true');

        // Event Handlers
        _handlers();

        // Bind Instance
        IpixUtil.data(the.element).set('scrolltop', the);
    }

    var _handlers = function() {
        var timer;

        window.addEventListener('scroll', function() {
            IpixUtil.throttle(timer, function() {
                _scroll();
            }, 200);
        });

        IpixUtil.addEvent(the.element, 'click', function(e) {
            e.preventDefault();

            _go();
        });
    }

    var _scroll = function() {
        var offset = parseInt(_getOption('offset'));

        var pos = IpixUtil.getScrollTop(); // current vertical position

        if (pos > offset) {
            if (document.body.hasAttribute('data-kt-scrolltop') === false) {
                document.body.setAttribute('data-kt-scrolltop', 'on');
            }
        } else {
            if (document.body.hasAttribute('data-kt-scrolltop') === true) {
                document.body.removeAttribute('data-kt-scrolltop');
            }
        }
    }

    var _go = function() {
        var speed = parseInt(_getOption('speed'));

        window.scrollTo({ top: 0, behavior: 'smooth' });
        //IpixUtil.scrollTop(0, speed);
    }

    var _getOption = function(name) {
        if (the.element.hasAttribute('data-kt-scrolltop-' + name) === true) {
            var attr = the.element.getAttribute('data-kt-scrolltop-' + name);
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
        IpixUtil.data(the.element).remove('scrolltop');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.go = function() {
        return _go();
    }

    the.getElement = function() {
        return the.element;
    }

    the.destroy = function() {
        return _destroy();
    }
};

// Static methods
IpixScrolltop.getInstance = function(element) {
    if (element && IpixUtil.data(element).has('scrolltop')) {
        return IpixUtil.data(element).get('scrolltop');
    } else {
        return null;
    }
}

// Create instances
IpixScrolltop.createInstances = function(selector = '[data-kt-scrolltop="true"]') {
    // Initialize Menus
    var elements = document.body.querySelectorAll(selector);

    if (elements && elements.length > 0) {
        for (var i = 0, len = elements.length; i < len; i++) {
            new IpixScrolltop(elements[i]);
        }
    }
}

// Global initialization
IpixScrolltop.init = function() {
    IpixScrolltop.createInstances();
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixScrolltop;
}