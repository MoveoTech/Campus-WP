jQuery(document).ready(function () {

    //reload new courses
    jQuery('.courses-stripe').on('afterChange', function() {
        const slickTrack = document.querySelector('.slick-track');
        const trackLength = parseInt(slickTrack.lastChild.getAttribute('data-slick-index'))
        const coursesIDs = JSON.parse(jQuery('#courses-ids').attr('value'))
        let currentIndex = jQuery('.slick-active').attr("data-slick-index");

        let newCoursesArray = coursesIDs.slice(trackLength + 1, (trackLength + 11))

        let url =  get_courses_ajax.ajaxurl;
        let data = {
                'action': 'get_courses',
                'coursesIDs': newCoursesArray,
            }
        if (trackLength - currentIndex <= 8) {
            jQuery.post(url, data, function(response){
                console.log(response)
            })
        }
    });

    //courses slick
    jQuery('.courses-stripe').slick({
        lazyLoad: 'ondemand',
        slidesToShow: 4,
        slidesToScroll: 3,
        rtl: is_rtl,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        height: '253px',
        speed: 1000,
        infinite:false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    arrows: false,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: false,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 2,
                    arrows: false,
                    infinite: false,
                    centerMode: true,

                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    slidesToShow: 2.15,
                    slidesToScroll: 2,
                    infinite: true,
                }
            }
            //     // You can unslick at a given breakpoint now by adding:
            //     // settings: "unslick"
            //     // instead of a settings object
        ]

    })

    jQuery('#academic-institution-slider').slick({
        slidesToShow: 7,
        accessibility: false,
        slidesToScroll: 7,
        rtl: is_rtl,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 4,
                    arrows: false,
                    dots: true,
                    centerMode: true,
                    focusOnSelect: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 4,
                    arrows: false,
                    dots: true,
                    centerMode: true,
                    focusOnSelect: false,
                }
            }
        ]
    });

    jQuery('#testimonials-slider-slick').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        rtl: is_rtl,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        infinite: true,
        dots: true,
        height: '250px',
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    centerMode: true,

                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    centerMode: true,
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]

    })
})