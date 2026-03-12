"use strict";

// Class definition
var IpixToggle = function(element, options) {
    ////////////////////////////
    // ** Private variables  ** //
    ////////////////////////////
    var the = this;

    if (!element) {
        return;
    }

    // Default Options
    var defaultOptions = {
        saveState: true
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        if (IpixUtil.data(element).has('toggle') === true) {
            the = IpixUtil.data(element).get('toggle');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = IpixUtil.deepExtend({}, defaultOptions, options);
        the.uid = IpixUtil.getUniqueId('toggle');

        // Elements
        the.element = element;

        the.target = document.querySelector(the.element.getAttribute('data-kt-toggle-target')) ? document.querySelector(the.element.getAttribute('data-kt-toggle-target')) : the.element;
        the.state = the.element.hasAttribute('data-kt-toggle-state') ? the.element.getAttribute('data-kt-toggle-state') : '';
        the.mode = the.element.hasAttribute('data-kt-toggle-mode') ? the.element.getAttribute('data-kt-toggle-mode') : '';
        the.attribute = 'data-kt-' + the.element.getAttribute('data-kt-toggle-name');

        // Event Handlers
        _handlers();

        // Bind Instance
        IpixUtil.data(the.element).set('toggle', the);
    }

    var _handlers = function() {
        IpixUtil.addEvent(the.element, 'click', function(e) {
            e.preventDefault();

            if (the.mode !== '') {
                if (the.mode === 'off' && _isEnabled() === false) {
                    _toggle();
                } else if (the.mode === 'on' && _isEnabled() === true) {
                    _toggle();
                }
            } else {
                _toggle();
            }
        });
    }

    // Event handlers
    var _toggle = function() {
        // Trigger "after.toggle" event
        IpixEventHandler.trigger(the.element, 'kt.toggle.change', the);

        if (_isEnabled()) {
            _disable();
        } else {
            _enable();
        }

        // Trigger "before.toggle" event
        IpixEventHandler.trigger(the.element, 'kt.toggle.changed', the);

        return the;
    }

    var _enable = function() {
        if (_isEnabled() === true) {
            return;
        }

        IpixEventHandler.trigger(the.element, 'kt.toggle.enable', the);

        the.target.setAttribute(the.attribute, 'on');

        if (the.state.length > 0) {
            the.element.classList.add(the.state);
        }

        if (typeof IpixCookie !== 'undefined' && the.options.saveState === true) {
            IpixCookie.set(the.attribute, 'on');
        }

        IpixEventHandler.trigger(the.element, 'kt.toggle.enabled', the);

        return the;
    }

    var _disable = function() {
        if (_isEnabled() === false) {
            return;
        }

        IpixEventHandler.trigger(the.element, 'kt.toggle.disable', the);

        the.target.removeAttribute(the.attribute);

        if (the.state.length > 0) {
            the.element.classList.remove(the.state);
        }

        if (typeof IpixCookie !== 'undefined' && the.options.saveState === true) {
            IpixCookie.remove(the.attribute);
        }

        IpixEventHandler.trigger(the.element, 'kt.toggle.disabled', the);

        return the;
    }

    var _isEnabled = function() {
        return (String(the.target.getAttribute(the.attribute)).toLowerCase() === 'on');
    }

    var _destroy = function() {
        IpixUtil.data(the.element).remove('toggle');
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

    the.enable = function() {
        return _enable();
    }

    the.disable = function() {
        return _disable();
    }

    the.isEnabled = function() {
        return _isEnabled();
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
IpixToggle.getInstance = function(element) {
    if (element !== null && IpixUtil.data(element).has('toggle')) {
        return IpixUtil.data(element).get('toggle');
    } else {
        return null;
    }
}

// Create instances
IpixToggle.createInstances = function(selector = '[data-kt-toggle]') {
    // Get instances
    var elements = document.body.querySelectorAll(selector);

    if (elements && elements.length > 0) {
        for (var i = 0, len = elements.length; i < len; i++) {
            // Initialize instances
            new IpixToggle(elements[i]);
        }
    }
}

// Global initialization
IpixToggle.init = function() {
    IpixToggle.createInstances();
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixToggle;
}