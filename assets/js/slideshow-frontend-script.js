/*
 * This JS file is loaded for the frontend area.
 */

jQuery(document).ready(function($) {

    // Slick slider.
    $(".custom_slideshow_section").slick({
        infinite: true,
        dots: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
              breakpoint: 1020,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              },
            },
            {
              breakpoint: 720,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              },
            }
        ],
    });

});