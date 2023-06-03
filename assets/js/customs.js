import 'owl.carousel2'
import 'owl.carousel2/dist/assets/owl.carousel.css';

    $('.owl-carousel-slider-one-text').owlCarousel({

        margin: 40,
        responsiveClass: true,
        autoHeight: true,
        responsive: {
            0: {
                items: 1,
                autoWidth: false,
            },
            600: {
                items: 2,
                autoWidth: false,
            },
            775: {
                items: 3,
                autoWidth: false,
            },

            1000: {
                items: 4,
                autoWidth: false,
            },

            1200: {
                items: 6,
                autoWidth: false,
            },

            1450: {
                items: 8,
                autoWidth: true,
            }
        }
    });


$('.owl-carousel-one-img-subcategory').owlCarousel({


    autoplay: true,
    rewind: true, /* use rewind if you don't want loop */
    margin: 10,
    /*
   animateOut: 'fadeOut',
   animateIn: 'fadeIn',
   */
    responsiveClass: true,
    autoHeight: true,
    autoplayTimeout: 7000,
    smartSpeed: 800,
    nav: true,
    responsive: {
        0: {
            items: 1.1,
            autoWidth: false,
        },
        560: {
            items: 1.4,
            autoWidth: false,
        },
        600: {
            items: 2.2,
            autoWidth: false,
        },

        1000: {
            items: 3,
            autoWidth: false,
        },

        1372: {
            items: 4,
            autoWidth: false,
        },

        1450: {
            items: 5,
            autoWidth: true,
        }
    }
});
