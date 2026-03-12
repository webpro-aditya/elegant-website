"use strict";
require('../../../../../../../resources/js/web');
require("owl.carousel");


$(document).ready(function () {
    $(".testimonial").owlCarousel({
        loop: true,
        margin: 10,
        items:6,
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
