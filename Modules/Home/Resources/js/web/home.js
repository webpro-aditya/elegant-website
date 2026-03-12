"use strict";
require("../../../../../resources/js/web");
require("owl.carousel");

$(document).ready(function() {
    $(".testimonial").owlCarousel({
        loop: true,
        margin: 10,
        items: 6,
        dots: false,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            650: {
                items: 2,
            },
            900: {
                items: 3,
            },
            1200: {
                items: 4,
            }
        },
    });
});

$(document).ready(function() {
    $(".explore").owlCarousel({
        loop: true,
        margin: 50,
        items: 6,
        dots: false,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            650: {
                items: 2,
            },
            1000: {
                items: 3,
            }
        },
    });
});

$(document).ready(function() {
    $(".working").owlCarousel({
        loop: true,
        margin: 50,
        items: 6,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2,
            },
            500: {
                items: 3,
            },
            767: {
                items: 4,
            },
            1000: {
                items: 5,
            },
            1440: {
                items: 6,
            }
        },
    });
});

$(document).ready(function() {
    $(".banner").owlCarousel({
        loop: true,
        margin: 15,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        animateOut: "fadeOut",
        responsive: {
            0: {
                items: 1.2,
            },
            600: {
                items: 1.5,
            },
            1000: {
                items: 2.5,
            }
        },
    });
});