"use strict";

// Class definition
var IpixImageInput = function(element, options) {
    ////////////////////////////
    // ** Private Variables  ** //
    ////////////////////////////
    var the = this;

    if (typeof element === "undefined" || element === null) {
        return;
    }

    // Default Options
    var defaultOptions = {

    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var _construct = function() {
        if (IpixUtil.data(element).has('image-input') === true) {
            the = IpixUtil.data(element).get('image-input');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = IpixUtil.deepExtend({}, defaultOptions, options);
        the.uid = IpixUtil.getUniqueId('image-input');

        // Elements
        the.element = element;
        the.formElement = element.closest(".form");
        the.inputElement = IpixUtil.find(element, 'input[type="file"]');
        the.wrapperElement = IpixUtil.find(element, '.image-input-wrapper');
        the.cancelElement = IpixUtil.find(element, '[data-kt-image-input-action="cancel"]');
        the.removeElement = IpixUtil.find(element, '[data-kt-image-input-action="remove"]');
        the.resetElement = IpixUtil.find(the.formElement, '[type="reset"]');
        the.hiddenElement = IpixUtil.find(element, 'input[type="hidden"]');
        the.src = IpixUtil.css(the.wrapperElement, 'backgroundImage');

        // Set initialized
        the.element.setAttribute('data-kt-image-input', 'true');

        // Event Handlers
        _handlers();

        // Bind Instance
        IpixUtil.data(the.element).set('image-input', the);
    }

    // Init Event Handlers
    var _handlers = function() {
        IpixUtil.addEvent(the.inputElement, 'change', _change);
        IpixUtil.addEvent(the.cancelElement, 'click', _cancel);
        IpixUtil.addEvent(the.removeElement, 'click', _remove);
        IpixUtil.addEvent(the.resetElement, 'click', _reset);
    }

    // Event Handlers
    var _change = function(e) {
        e.preventDefault();

        if (the.inputElement !== null && the.inputElement.files && the.inputElement.files[0]) {

            if (the.inputElement.getAttribute('data-thumbnailsize') === "true") {
                const maxWidth = the.inputElement.getAttribute('data-thumbnailwidth'); // Set your maximum width here
                const maxHeight = the.inputElement.getAttribute('data-thumbnailheight'); // Set your maximum height here
                if (the.inputElement.files[0]) {
                    const img = new Image();
                    img.src = URL.createObjectURL(the.inputElement.files[0]);

                    img.onload = function(e) {
                        if (img.width != maxWidth && img.height != maxHeight) {
                            $('.thumnailDiamentionError').html('Maximum dimensions allowed are ' + maxWidth + 'x' + maxHeight + '.');
                            _remove(e);
                            the.inputElement.value = "";
                            return;

                        }
                    };
                }
            }
            if (the.inputElement.getAttribute('data-configuration-thumbnailsize') === "true") {
                const maxWidth = the.inputElement.getAttribute('data-configuration-thumbnailwidth');
                const maxHeight = the.inputElement.getAttribute('data-configuration-thumbnailheight');
                var keyCount = the.inputElement.getAttribute('data-configuration-keyCount');
                if (the.inputElement.files[0]) {
                    const img = new Image();
                    img.src = URL.createObjectURL(the.inputElement.files[0]);
                    img.onload = function(e) {
                        if (img.width != maxWidth && img.height != maxHeight) {
                            $('.configurationThumnailDiamentionError' + keyCount).html('Maximum dimensions allowed are ' + maxWidth + 'x' + maxHeight + '.');
                            _remove(e);
                            the.inputElement.value = "";
                            return;

                        } else {
                            $('.configurationThumnailDiamentionError' + keyCount).html('');
                        }
                    };
                }
            }

            // Fire change event
            if (IpixEventHandler.trigger(the.element, 'kt.imageinput.change', the) === false) {
                return;
            }

            var reader = new FileReader();

            reader.onload = function(e) {
                IpixUtil.css(the.wrapperElement, 'background-image', 'url(' + e.target.result + ')');
                $('.thumnailDiamentionError').html('');
            }

            reader.readAsDataURL(the.inputElement.files[0]);

            the.element.classList.add('image-input-changed');
            the.element.classList.remove('image-input-empty');

            // Fire removed event
            IpixEventHandler.trigger(the.element, 'kt.imageinput.changed', the);
        }
    }

    var _cancel = function(e) {
        e.preventDefault();

        // Fire cancel event
        if (IpixEventHandler.trigger(the.element, 'kt.imageinput.cancel', the) === false) {
            return;
        }

        the.element.classList.remove('image-input-changed');
        the.element.classList.remove('image-input-empty');

        if (the.src === 'none') {
            IpixUtil.css(the.wrapperElement, 'background-image', '');
            the.element.classList.add('image-input-empty');
        } else {
            IpixUtil.css(the.wrapperElement, 'background-image', the.src);
        }

        the.inputElement.value = "";

        if (the.hiddenElement !== null) {
            the.hiddenElement.value = "0";
        }

        // Fire canceled event
        IpixEventHandler.trigger(the.element, 'kt.imageinput.canceled', the);
    }

    var _remove = function(e) {
        e.preventDefault();

        // Fire remove event
        if (IpixEventHandler.trigger(the.element, 'kt.imageinput.remove', the) === false) {
            return;
        }

        the.element.classList.remove('image-input-changed');
        the.element.classList.add('image-input-empty');

        IpixUtil.css(the.wrapperElement, 'background-image', "none");
        the.inputElement.value = "";

        if (the.hiddenElement !== null) {
            the.hiddenElement.value = "1";
        }

        // Fire removed event
        IpixEventHandler.trigger(the.element, 'kt.imageinput.removed', the);
    }

    var _reset = function(e) {
        if (the.element.classList.contains('image-input-changed')) {
            // Fire remove event
            if (IpixEventHandler.trigger(the.element, 'kt.imageinput.reset', the) === false) {
                return;
            }

            var oldImage = the.wrapperElement.getAttribute('data-image');
            if (oldImage) {
                IpixUtil.css(the.wrapperElement, 'background-image', 'url(' + oldImage + ')');
            } else {
                the.element.classList.add('image-input-empty');
                the.element.classList.remove('image-input-changed');
                IpixUtil.css(the.wrapperElement, 'background-image', "none");

                if (the.hiddenElement !== null) {
                    the.hiddenElement.value = "1";
                }
            }

            the.inputElement.value = "";

            // Fire removed event
            IpixEventHandler.trigger(the.element, 'kt.imageinput.reseted', the);
        }
    }

    var _destroy = function() {
        IpixUtil.data(the.element).remove('image-input');
    }

    // Construct Class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.getInputElement = function() {
        return the.inputElement;
    }

    the.getElement = function() {
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
IpixImageInput.getInstance = function(element) {
    if (element !== null && IpixUtil.data(element).has('image-input')) {
        return IpixUtil.data(element).get('image-input');
    } else {
        return null;
    }
}

// Create instances
IpixImageInput.createInstances = function(selector = '[data-kt-image-input]') {
    // Initialize Menus
    var elements = document.querySelectorAll(selector);

    if (elements && elements.length > 0) {
        for (var i = 0, len = elements.length; i < len; i++) {
            new IpixImageInput(elements[i]);
        }
    }
}

// Global initialization
IpixImageInput.init = function() {
    IpixImageInput.createInstances();
};

// Webpack Support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = IpixImageInput;
}