jQuery(document).ready(function () {
    let is_rtl = !(jQuery('html[lang = "en-US"]').length > 0);
    let prevSlick = '<button type="button" class="slick-prev slick-button" tabindex="-1" aria-label="' + global_vars.prev_btn_text + '"></button>';
    let nexSlick = '<button type="button" id="slick-next" class="slick-next slick-button" tabindex="-1" aria-label="' + global_vars.next_btn_text + '"></button>';
    //reload new courses
    jQuery('.courses-stripe').on('afterChange', function (event) {
        const id = event.target.id
        const slickTrack = jQuery(`#${id} .slick-track`)[0]
        const trackLength = parseInt(slickTrack.lastChild.getAttribute('data-slick-index'))
        const coursesIDs = JSON.parse(jQuery(`#${id}courses`).attr('value'))
        let currentIndex = jQuery(`#${id} .slick-track .slick-active`).attr("data-slick-index");

        // Checking if have courses in admin side more then what displaying
        // Checking if the current course is close to the end of the carousel
        if (coursesIDs.length > 10  && coursesIDs.length > trackLength + 1 && trackLength - currentIndex <= 8) {
            let newCoursesArray = coursesIDs.slice(trackLength + 1, (trackLength + 11))

            let data = {
                'action': 'stripe_data',
                'type' : 'courses',
                'lang' : getCookie('openedx-language-preference'),
                'idsArray': newCoursesArray,
            }
            jQuery.post(stripe_data_ajax.ajaxurl, data, function(response){
                if(response.success){
                    const data = JSON.parse(response.data);
                    console.log(data)
                    apppendCourses(data, id);
                }
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
        infinite: false,
        responsive: [
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 1250,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2,
                    speed: 500,
                    arrows: false,
                }
            },
            {
                breakpoint: 710,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    arrows: false,
                }
            },
            {
                breakpoint: 650,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    arrows: false,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 2,
                    arrows: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    speed: 500,
                    slidesToShow: 2.15,
                    slidesToScroll: 2,
                    arrows: false,
                }
            },
            //     // You can unslick at a given breakpoint now by adding:
            //     // settings: "unslick"
            //     // instead of a settings object
        ]

    })

    //academic-institution slick (OLD)
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

    //testimonials slick
    jQuery('#testimonials-slider-slick').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        rtl: is_rtl,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        arrows: false,
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

    //institutions slick
    jQuery('.institutions-slider').slick({
        slidesToShow: 7,
        slidesToScroll: 7,
        rtl: is_rtl,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        arrows: false,
        infinite: true,
        dots: true,
        speed: 1000,
        responsive: [
            {
                breakpoint: 1390,
                settings: {
                    slidesToShow: 6,
                    slidesToScroll: 6,
                }
            },
            {
                breakpoint: 1100,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    speed: 500,
                    slidesToShow: 2,
                    slidesToScroll:2,
                }
            }
        ]

    })

})

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


function apppendCourses(coursesData, id) {

    coursesData.forEach(item =>{

        let tags = '';
        for (let i = 0; i < item.tags.length; ++i) {
            if (i > 1){
                tags = tags + '<span className="extra-tags">+</span>';
                break;
            }
            tags = tags + '<span>'+item.tags[i]+'</span>';
        }
        let temp = document.createElement("div");
        temp.className = 'course-stripe-item';
        temp.innerHTML =
            '<div class="course-img" style="background-image: url('+item.image+');"></div>'+
            '<div class="item-content"">'+
            '<h3 ><a href="">'+item.name+'</a></h3>'+
            '<p >'+item.academic_institution+'</p>'+
            ' </div>'+
            '<div class=" tags-div">'+tags+ '</div>';

        jQuery(`#${id}`).slick('slickAdd',temp);

    });


}

