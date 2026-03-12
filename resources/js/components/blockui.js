"use strict";

// Class definition
var IpixBlockUI = function(element, options) {
    //////////////////////////////
    // ** Private variables  ** //
    //////////////////////////////
    var the = this;

    if (typeof element === "undefined" || element === null) {
        return;
    }

    // Default options
    var defaultOptions = {
        zIndex: false,
        overlayClass: '',
        overflow: 'hidden',
        message: '<span class="spinner-border text-primary"></span>'
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        if (IpixUtil.data(element).has('blockui')) {
            the = IpixUtil.data(element).get('blockui');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = IpixUtil.deepExtend({}, defaultOptions, options);
        the.element = element;
        the.overlayElement = null;
        the.blocked = false;
        the.positionChanged = false;
        the.overflowChanged = false;

        // Bind Instance
        IpixUtil.data(the.element).set('blockui', the);
    }

    var _block = function() {
        if (IpixEventHandler.trigger(the.element, 'kt.blockui.block', the) === false) {
            return;
        }

        var isPage = (the.element.tagName === 'BODY');

        var position = IpixUtil.css(the.element, 'position');
        var overflow = IpixUtil.css(the.element, 'overflow');
        var zIndex = isPage ? 10000 : 1;

        if (the.options.zIndex > 0) {
            zIndex = the.options.zIndex;
        } else {
            if (IpixUtil.css(the.element, 'z-index') != 'auto') {
                zIndex = IpixUtil.css(the.element, 'z-index');
            }
        }

        the.element.classList.add('blockui');

        if (position === "absolute" || position === "relative" || position === "fixed") {
            IpixUtil.css(the.element, 'position', 'relative');
            the.positionChanged = true;
        }

        if (the.options.overflow === 'hidden' && overflow === 'visible') {
            IpixUtil.css(the.element, 'overflow', 'hidden');
            the.overflowChanged = true;
        }

        the.overlayElement = document.createElement('DIV');
        the.overlayElement.setAttribute('class', 'blockui-overlay ' + the.options.overlayClass);

        the.overlayElement.innerHTML = the.options.message;

        IpixUtil.css(the.overlayElement, 'z-index', zIndex);

        the.element.append(the.overlayElement);
        the.blocked = true;

        IpixEventHandler.trigger(the.element, 'kt.blockui.after.blocked', the)
    }

    var _release = function() {
        if (IpixEventHandler.trigger(the.element, 'kt.blockui.release', the) === false) {
            return;
        }

        the.element.classList.add('blockui');

        if (the.positionChanged) {
            IpixUtil.css(the.element, 'position', '');
        }

        if (the.overflowChanged) {
            IpixUtil.css(the.element, 'overflow', '');
        }

        if (the.overlayElement) {
            IpixUtil.remove(the.overlayElement);
        }

        the.blocked = false;

        IpixEventHandler.trigger(the.element, 'kt.blockui.released', the);
    }

    var _isBlocked = function() {
        return the.blocked;
    }

    var _destroy = function() {
        IpixUtil.data(the.element).remove('blockui');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.block = function() {
        _block();
    }

    the.release = function() {
        _release();
    }

    the.isBlocked = function() {
        return _isBlocked();
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
IpixBlockUI.getInstance = function(element) {
    if (element !== null && IpixUtil.data(element).has('blockui')) {
        return IpixUtil.data(element).get('blockui');
    } else {
        return null;
    }
}

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixBlockUI;
}