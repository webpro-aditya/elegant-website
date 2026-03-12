"use strict";
require("../../../../../resources/js/web");
require("owl.carousel");



$('.category').owlCarousel({
    loop: true,
    nav: true,
    margin: 0,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1
        },
        576: {
            items: 2
        },
        992: {
            items: 3
        },
        1200: {
            items: 4
        }
    }
})