"use strict";
require("../../../../../../resources/js/web");
require("owl.carousel");



$('.category').owlCarousel({
    loop: true,
    nav: true,
    margin: 10,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 4
        }
    }
})