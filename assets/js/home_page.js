jQuery(document).ready(function () {
    let is_rtl = !(jQuery('html[lang = "en-US"]').length > 0);
    let prevSlick = '<button type="button" class="slick-prev slick-button" tabindex="-1" aria-label="' + global_vars.prev_btn_text + '"></button>';
    let nexSlick = '<button type="button" id="slick-next" class="slick-next slick-button " tabindex="-1" aria-label="' + global_vars.next_btn_text + '"></button>';

    //Get My Courses
    getMyCourses()

    //Course Card
    mouseHoverOnCourse()

    clickOnCourseInfoButton()

    //reload new courses
    jQuery('.courses-stripe').on('beforeChange', function (event) {
        jQuery(`.course-stripe-item`).unbind('mouseenter');
    })
    jQuery('.courses-stripe').on('afterChange', function (event) {
        const id = event.target.id
        mouseHoverOnCourse()
        getCoursesAjax(id)
        let width = jQuery(document).width();
        if(width <= 768) return;
        changeArrowClass(id)
    });

    jQuery('.goals-slider').on('afterChange', function (event) {
        let width = jQuery(document).width();
        if(width <= 768) return;
        const id = event.target.id
        changeArrowClass(id)
    })

    jQuery('#myCoursesStripeId').on('afterChange', function (event) {
        let width = jQuery(document).width();
        if(width <= 768) return;
        const id = event.target.id
        changeArrowClass(id)
    })

    jQuery('.testimonials-slider').on('afterChange', function (event) {
        let width = jQuery(document).width();
        if(width < 650) return;
        const id = event.target.id
        changeArrowClass(id, 'testimonials');
    })

    //courses slick
    jQuery('.courses-stripe').slick({
        lazyLoad: 'ondemand',
        slidesToShow: 4,
        slidesToScroll: 3,
        rtl: is_rtl,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        speed: 1000,
        infinite: false,
        responsive: [
            {
                breakpoint: 993,
                settings: {
                    speed: 500,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
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
                    speed: 100,
                    slidesToShow: 2.15,
                    slidesToScroll: 2,
                    arrows: false,
                }
            },
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
                    speed: 500,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    speed: 500,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
        ]

    })

    //goals slick
    jQuery('.goals-slider').slick({
        lazyLoad: 'ondemand',
        slidesToShow: 4,
        slidesToScroll: 4,
        rtl: is_rtl,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        speed: 1000,
        infinite: false,
        responsive: [
            {
                breakpoint: 1251,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 851,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    speed: 500,
                    arrows: false,
                }
            },
            {
                breakpoint: 710,
                settings: {
                    speed: 500,
                    slidesToShow: 2.6,
                    slidesToScroll: 2,
                    arrows: false,
                }
            },
            {
                breakpoint: 650,
                settings: {
                    speed: 500,
                    slidesToShow: 2.4,
                    slidesToScroll: 2,
                    arrows: false,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    speed: 500,
                    slidesToShow: 2.2,
                    slidesToScroll: 2,
                    arrows: false,
                }
            },
            {
                breakpoint: 550,
                settings: {
                    speed: 500,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    speed: 500,
                    slidesToShow: 1.75,
                    slidesToScroll: 1,
                    arrows: false,
                }
            },
            {
                breakpoint: 400,
                settings: {
                    speed: 300,
                    slidesToShow: 1.50,
                    slidesToScroll: 1,
                    arrows: false,
                }
            },
            {
                breakpoint: 389,
                settings: {
                    speed: 300,
                    slidesToShow: 1.36,
                    slidesToScroll: 1,
                    arrows: false,
                }
            }
        ]

    })

    //my courses slick
    jQuery('#myCoursesStripeId').slick({
        lazyLoad: 'ondemand',
        slidesToShow: 4,
        slidesToScroll: 3,
        rtl: is_rtl,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        speed: 1000,
        infinite: false,
        responsive: [
            {
                breakpoint: 993,
                settings: {
                    speed: 500,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
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
        ]
    })

    //testimonials slick
    jQuery('.testimonials-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        rtl: is_rtl,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        arrows: true,
        infinite: false,
        dots: false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 650,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false,
                }
            },
        ]
    })

    //Youtube popup
    jQuery('body').on('click', '.open-iframe', function (e) {
        e.preventDefault();
        var url = jQuery(this).data('url');
        jQuery('#youtube-popup #popup').attr('aria-hidden', 'false');
        jQuery('#popup div.iframe').html('<iframe width="560" height="315" src="' + url + '" frameborder="0" allowfullscreen></iframe>');
        jQuery("#youtube-popup").addClass('active');
    })
    jQuery(".close-popup-button").on("click", function (e) {
        e.preventDefault();
        jQuery("#popup_overlay").click();
    });
    jQuery('.close-popup-iframe').on("click", function () {
        setTimeout(function () {
            jQuery('#popup_overlay #popup').attr('aria-hidden', 'true');
            jQuery("#youtube-popup").removeClass('active');
            jQuery("#login-register-popup").removeClass('active');
        }, 100);
    });
    jQuery('#youtube-popup').on('click', function () {
        setTimeout(function () {
            jQuery('#popup_overlay #popup').attr('aria-hidden', 'true');
            jQuery("#youtube-popup").removeClass('active');
        }, 100);
    })

    //Course popup overlay
    jQuery('.bg-overlay').on('click', function() {
        let array = document.querySelectorAll('body .course-popup-modal')
        let arrayLength = array.length
        let openCourse = array[arrayLength - 1]
        if(openCourse.getAttribute('style')) {
            let courseClassName = openCourse.classList[openCourse.classList.length - 1]
            let courseId = courseClassName.slice(19)
            let element = jQuery(`.mobile-course-popup${courseId}`)
            element.hide()
            element.appendTo(jQuery(`#${courseId}`));
            jQuery(".bg-overlay").removeClass('active');
            jQuery('body').css('overflow-y', 'unset');
            jQuery('body').remove(element);
        }
    })

    // Login Iframe
    //appending the iframe
    jQuery('.login-item').on('click', function(e) {
        e.preventDefault();
        jQuery("#login-iframe").append("<iframe id='login-register-iframe' src='https://courses.stage.campus.gov.il/login?next=/dashboard' height='300px' width='300px' title='Login page'></iframe>")
        jQuery('#login-register-popup .popup').attr('aria-hidden', 'false');
        jQuery("#login-register-popup").addClass('active');
    })
    //removing the iframe
    jQuery('#login-register-popup').on('click', function () {
        console.log("testt")
        setTimeout(function () {
            jQuery("#login-iframe").empty();
            jQuery('#login-register-popup .popup').attr('aria-hidden', 'true');
            jQuery("#login-register-popup").removeClass('active');
        }, 100);
    })

    // Register Iframe
    //appending the iframe
    jQuery('.register-item').on('click', function(e) {
        e.preventDefault();
        jQuery("#register-iframe").append("<iframe id='register-iframe' src='https://courses.stage.campus.gov.il/login?next=/dashboard' height='300px' width='300px' title='Register page'></iframe>")
        jQuery('#register-popup .popup').attr('aria-hidden', 'false');
        jQuery("#register-popup").addClass('active');
    })
    //removing the iframe
    jQuery('#register-popup').on('click', function () {
        setTimeout(function () {
            jQuery("#register-iframe").empty();
            jQuery('#register-popup .popup').attr('aria-hidden', 'true');
            jQuery("#register-popup").removeClass('active');
        }, 0);
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

function getCoursesAjax(id) {
    const slickTrack = jQuery(`#${id} .slick-track`)[0]
    const trackLength = parseInt(slickTrack.lastChild.getAttribute('data-slick-index'))
    const coursesIDs = JSON.parse(jQuery(`#${id}courses`).attr('value'))
    let currentIndex = jQuery(`#${id} .slick-track .slick-active`).attr("data-slick-index");

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
                apppendCourses(data, id);
            }
        })
    }
}

function apppendCourses(coursesData, id) {

    coursesData.forEach(item =>{
        let permalink = item.permalink ? item.permalink : '';
        let url = 'course/' + permalink;
        console.log(url)
        let tags = getDesktopTags(item.tags);
        let hoverTags = getHoverTags(item.tags);

        let academicInstitution = item.academic_institution ? item.academic_institution : '';

        let temp = document.createElement("div");
        temp.id = item.id + id;
        temp.classList.add('course-stripe-item');
        temp.innerHTML =
            '<div class="course-img" style="background-image: url('+item.image+');">'+
            '<a href="'+ url +'"></a>'+
            '<span class="info-button"></span></div>'+
            '<div class="item-content"">'+
            '<h3 ><a href="'+ url +'">'+item.name+'</a></h3>'+
            '<p >'+academicInstitution+'</p>'+
            ' </div>'+
            '<div class=" tags-div">'+tags+ '</div>'+
            '<div class="course-item-hover '+ item.id + id +'">'+
                '<a href="'+ url +'">'+
                    '<div class="course-img" style="background-image: url('+item.image+');"></div>'+
                    '<div class="item-content"">'+
                        '<h3 >'+item.name+'</h3>'+
                        '<p >'+academicInstitution+'</p>'+
                    '</div>'+
                    '<div class=" tags-div">'+ hoverTags +'</div>'+
                    '<div class="course-details">'+
                        '<span>'+ item.duration +'</span>'+
                    '</div>'+
                '</a>'+
            '</div>'+
            '<div class="course-popup-modal mobile-course-popup'+ item.id + id +'">'+
                '<div class="popup-header">'+
                    '<span class="course-popup-close'+ item.id + id +' close">&times;</span>'+
                '</div>'+
                '<div class="course-content">'+
                    '<div class="course-img" style="background-image: url('+item.image+');"></div>'+
                    '<div class="course-details">'+
                        '<div class="course-header"">'+
                            '<h3 ><a href="'+ url +'">'+item.name+'</a></h3>'+
                            '<p >'+academicInstitution+'</p>'+
                        '</div>'+
                        '<div class="tags-div">'+ hoverTags +'</div>'+
                        '<div class="details">'+
                            '<span>'+ item.duration +'</span>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="popup-footer">'+
                    '<a href="'+ url +'"><span>'+ item.button_text +'</span></a>'+
                '</div>'+
            '</div>';

        jQuery(`#${id}`).slick('slickAdd',temp);
        mouseHoverOnCourse()
    });
    changeArrowClass(id)
    clickOnCourseInfoButton()
}

function closePopupIfOpen(id) {
    let array = document.querySelectorAll('body .course-popup-modal')
    let arrayLength = array.length
    let openCourse = array[arrayLength - 1]
    if(openCourse.getAttribute('style')) {
        let courseClassName = openCourse.classList[openCourse.classList.length - 1]
        let courseId = courseClassName.slice(19)
        if(courseId == id) return;
        let element = jQuery(`.mobile-course-popup${courseId}`)
        element.hide()
        element.appendTo( jQuery(`#${courseId}`));
    }
}

function getMyCourses() {
    // let data = {
    //     'action': 'stripe_data',
    //     'type' : 'courses',
    //     'lang' : getCookie('openedx-language-preference'),
    //     'idsArray': newCoursesArray,
    // }
    // jQuery.post(stripe_data_ajax.ajaxurl, data, function(response){
    //     if(response.success){
    //         const data = JSON.parse(response.data);
    //         console.log(data)
    //         apppendCourses(data, id);
    //     }
    // })

    const mockData = [
        {
            "created":"2018-05-25T06:08:27.508362Z",
            "mode":"audit",
            "is_active":true,
            "course_details":{
                "course_id":"course-v1:edX+DemoX+Demo_Course",
                "course_name":"edX DemoX",
                "enrollment_start":null,
                "enrollment_end":null,
                "course_start":"2017-01-01T00:00:00Z",
                "course_end":null,
                "invite_only":false,
                "academic_institution": 'אוניברסית אריאל בשומרון',
                'image': "http://127.0.0.1/app/uploads/2021/05/תמונת_קורס.jpg",
                "course_modes":[
                    {
                        "slug":"audit",
                        "name":"audit",
                        "min_price":0,
                        "suggested_prices":"",
                        "currency":"usd",
                        "expiration_datetime":null,
                        "description":null,
                        "sku":null,
                        "bulk_sku":null
                    }
                ]
            },
            "user":"honor"
        },
        {
            "created":"2018-05-25T06:08:27.508362Z",
            "mode":"audit",
            "is_active":true,
            "course_details":{
                "course_id":"course-v1:edX+DemoX+Demo_Course",
                "course_name":"edX DemoX",
                "enrollment_start":null,
                "enrollment_end":null,
                "course_start":"2017-01-01T00:00:00Z",
                "course_end":null,
                "invite_only":false,
                "academic_institution": 'אוניברסית אריאל בשומרון',
                "progress": 'בואו נתחיל את הקורס >>',
                'image': "http://127.0.0.1/app/uploads/2021/12/מבני-נתונים-תמונת-בקורס.jpg",
                "course_modes":[
                    {
                        "slug":"audit",
                        "name":"audit",
                        "min_price":0,
                        "suggested_prices":"",
                        "currency":"usd",
                        "expiration_datetime":null,
                        "description":null,
                        "sku":null,
                        "bulk_sku":null
                    }
                ]
            },
            "user":"honor"
        },
        {
            "created":"2018-05-25T06:08:27.508362Z",
            "mode":"audit",
            "is_active":true,
            "course_details":{
                "course_id":"course-v1:edX+DemoX+Demo_Course",
                "course_name":"edX DemoX",
                "enrollment_start":null,
                "enrollment_end":null,
                "course_start":"2017-01-01T00:00:00Z",
                "course_end":null,
                "invite_only":false,
                "academic_institution": 'אוניברסית אריאל בשומרון',
                "progress": 'בואו נתחיל את הקורס >>',
                'image': "http://127.0.0.1/app/uploads/2021/10/course_image_500X225_v3.jpg",
                "course_modes":[
                    {
                        "slug":"audit",
                        "name":"audit",
                        "min_price":0,
                        "suggested_prices":"",
                        "currency":"usd",
                        "expiration_datetime":null,
                        "description":null,
                        "sku":null,
                        "bulk_sku":null
                    }
                ]
            },
            "user":"honor"
        },
        {
            "created":"2018-05-25T06:08:27.508362Z",
            "mode":"audit",
            "is_active":true,
            "course_details":{
                "course_id":"course-v1:edX+DemoX+Demo_Course",
                "course_name":"edX DemoX",
                "enrollment_start":null,
                "enrollment_end":null,
                "course_start":"2017-01-01T00:00:00Z",
                "course_end":null,
                "invite_only":false,
                "academic_institution": 'אוניברסית אריאל בשומרון',
                "progress": 'בואו נתחיל את הקורס >>',
                'image': "http://127.0.0.1/app/uploads/2021/11/course-image_500x225.jpg",
                "course_modes":[
                    {
                        "slug":"audit",
                        "name":"audit",
                        "min_price":0,
                        "suggested_prices":"",
                        "currency":"usd",
                        "expiration_datetime":null,
                        "description":null,
                        "sku":null,
                        "bulk_sku":null
                    }
                ]
            },
            "user":"honor"
        },
        {
            "created":"2018-05-25T06:08:27.508362Z",
            "mode":"audit",
            "is_active":true,
            "course_details":{
                "course_id":"course-v1:edX+DemoX+Demo_Course",
                "course_name":"edX DemoX",
                "enrollment_start":null,
                "enrollment_end":null,
                "course_start":"2017-01-01T00:00:00Z",
                "course_end":null,
                "invite_only":false,
                "academic_institution": 'אוניברסית אריאל בשומרון',
                "progress": 'בואו נתחיל את הקורס >>',
                'image': "http://127.0.0.1/app/uploads/2021/05/תמונת_קורס.jpg",
                "course_modes":[
                    {
                        "slug":"audit",
                        "name":"audit",
                        "min_price":0,
                        "suggested_prices":"",
                        "currency":"usd",
                        "expiration_datetime":null,
                        "description":null,
                        "sku":null,
                        "bulk_sku":null
                    }
                ]
            },
            "user":"honor"
        },
        {
            "created":"2018-05-25T06:08:27.508362Z",
            "mode":"audit",
            "is_active":true,
            "course_details":{
                "course_id":"course-v1:edX+DemoX+Demo_Course",
                "course_name":"edX DemoX",
                "enrollment_start":null,
                "enrollment_end":null,
                "course_start":"2017-01-01T00:00:00Z",
                "course_end":null,
                "invite_only":false,
                "academic_institution": 'אוניברסית אריאל בשומרון',
                "progress": 'בואו נתחיל את הקורס >>',
                'image': "http://127.0.0.1/app/uploads/2021/05/תמונת_קורס.jpg",
                "course_modes":[
                    {
                        "slug":"audit",
                        "name":"audit",
                        "min_price":0,
                        "suggested_prices":"",
                        "currency":"usd",
                        "expiration_datetime":null,
                        "description":null,
                        "sku":null,
                        "bulk_sku":null
                    }
                ]
            },
            "user":"honor"
        }
    ];
    const id = 'myCoursesStripeId';

    appendMyCourses(mockData, id);

}

function appendMyCourses(coursesData, id) {
    let courseStripe = document.getElementById(id);
    if(!courseStripe) return;

    coursesData.forEach(item =>{
        let itemData = {
            thumb: item.course_details.image,
            progress: item.course_details.progress ? item.course_details.progress : '',
            name: item.course_details.course_name,
            academic_institution: item.course_details.academic_institution
        }
        let temp = document.createElement("div");
        temp.className = 'course-stripe-item';
        temp.innerHTML =
            '<div class="course-img" style="background-image: url('+itemData.thumb+');"></div>'+
            '<div class="item-content"">'+
            '<p class="course-progress" ><a href="">' + itemData.progress +'</a></p>'+
            '<h3><a href="">'+itemData.name+'</a></h3>'+
            '<p class="institution-name">'+itemData.academic_institution+'</p>'+
            ' </div>';


        courseStripe.append(temp)
    });
}

function changeArrowClass(id, type=null) {
    if(!jQuery(`#${id}`).children('.slick-button')[0]) return;
    const slickTrack = jQuery(`#${id} .slick-track`)[0]
    const trackLength = parseInt(slickTrack.lastChild.getAttribute('data-slick-index'))
    let currentIndex = jQuery(`#${id} .slick-track .slick-active`).attr("data-slick-index");

        // Change the opacity of the arrows depend if it possible to click on them
    if(currentIndex > 0) {
        jQuery(`#${id}`).children('.slick-prev')[0].classList.add('activate');
    } else {
        jQuery(`#${id}`).children('.slick-prev')[0].classList.remove('activate');
    }

    let width = jQuery(document).width();
    let index = 3;
    if(width < 992) index = 2;
    if (type == 'testimonials') {
        index = 2;
        if(width < 992) index = 1;
    }
    if(trackLength - currentIndex <= index) {
        jQuery(`#${id}`).children('.slick-next')[0].classList.add('off');
    } else {
        jQuery(`#${id}`).children('.slick-next')[0].classList.remove('off');
    }

}

function mouseHoverOnCourse() {
    jQuery(`.course-stripe-item`).unbind('mouseenter');
    let enterTimer;

    jQuery('.course-stripe-item').mouseenter(function (event) {
        if(jQuery('body').children('div.course-item-hover').length > 0) {
            let id = jQuery('body').children('div.course-item-hover')[0].classList[1];
            let oldHoverElement = jQuery(`.${id}`);
            oldHoverElement.appendTo(`#${id}`);
            oldHoverElement.css('display', 'none');
            oldHoverElement.css('inset', 'unset');
        }
        enterTimer = setTimeout(function() {
            let width = document.documentElement.clientWidth;
            if(width > 768) {
                let id = event.target.id;
                if(id == '') { id = event.target.parentElement.id;}
                if(id == '') { id = event.target.parentElement.parentElement.id;}
                if(id == '') { id = event.target.parentElement.parentElement.parentElement.id;}

                let element = jQuery(`.${id}`);
                let parentElem = jQuery(`#${id}`);
                let top = parentElem.offset().top - 5;
                let left;
                if(width > 1200) {
                     left = parentElem.offset().left - 12;
                } else if(width > 768 && width <= 1200) {
                    left = parentElem.offset().left - 30;
                } else {
                    left = parentElem.offset().left - 20;
                }
                let pos = {top, left};
                element.appendTo(jQuery('body'));
                element.css({
                    display : 'block',
                    position : 'absolute',
                }).offset(pos)
            }
        }, 700);
    })
    jQuery('.course-stripe-item').mouseleave(function(){
        clearTimeout(enterTimer);
    })
    jQuery('.course-item-hover').mouseleave(function (event) {
        clearTimeout(enterTimer);
        let id = event.currentTarget.classList[1]
        let element = jQuery(`.${id}`);
        element.appendTo(`#${id}`);
        element.css('display', 'none');
        element.css('inset', 'unset');
    })

}

function clickOnCourseInfoButton() {
    jQuery(`.info-button`).unbind('click');

    jQuery(`.info-button`).click(function(event) {
        let id = event.target.parentElement.parentElement.id

        closePopupIfOpen(id)

        let element = jQuery(`.mobile-course-popup${id}`)
        element.appendTo(jQuery('body'));
        if(element.css('display') == 'none') {
            element.show();
            jQuery(".bg-overlay").addClass('active');
            jQuery('body').css('overflow-y', 'hidden');

        }
        else if (element.css('display') == 'block') {
            element.appendTo( jQuery(`#${id}`));
            element.hide()
            jQuery(".bg-overlay").removeClass('active');
            jQuery('body').css('overflow-y', 'unset');
            jQuery('body').remove(element);
        }

        jQuery(`.course-popup-close${id}`).click(function() {
            element.appendTo( jQuery(`#${id}`));
            element.hide()
            jQuery(".bg-overlay").removeClass('active');
            jQuery('body').css('overflow-y', 'unset');
            jQuery('body').remove(jQuery(`.${id}`));
        })
    })
}

function getHoverTags(tags) {
    let hoverTagsHtml = '';
    for (let i = 0; i < tags.length; i++) {

        let tagLength = tags[i].length;
        let hoverTagClass = 'regular-tag';

        if(tagLength >= 26) hoverTagClass = 'ellipsis-text';

        hoverTagsHtml = hoverTagsHtml + '<span class="'+ hoverTagClass +'" title="'+ tags[i] +'"><p class="'+ hoverTagClass +'">'+tags[i]+'</p></span>';
    }

    return hoverTagsHtml;
}

function getDesktopTags(tags) {
    let tagsHtml = '';
    for (let i = 0; i < tags.length; i++) {
        if (i > 1){
            tagsHtml = tagsHtml + '<span class="extra-tags">+</span>';
            break;
        }

        if (i >= 1){
            tagsHtml = tagsHtml + '<span class="extra-tags-mobile">+</span>';
        }

        let tagLength = tags[i].length;
        let tagClass = 'regular-tag';
        if(tagLength >= 8) tagClass = 'ellipsis-text';
        let tag2 = '';
        if(i == 1) tag2 = 'tag-2';

        tagsHtml = tagsHtml + '<span class="'+ tagClass +' '+ tag2 +'" ><p class="'+ tagClass +'">'+tags[i]+'</p></span>';
    }

    return tagsHtml;
}

function goalGradient() {
    let width = jQuery(window).width();
    if(width > 710) return;
    let goalDiv = document.createElement('div');
    goalDiv.className = 'goal-stripe-gradient';
    jQuery('.goals-slider').children('div.slick-list')[0].append(goalDiv);
}