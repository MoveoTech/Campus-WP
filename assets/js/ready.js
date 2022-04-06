//carusel slick to institution logos - home page
import('./scrolling.js')
import('./user_menu.js')
var current_lang = jQuery('#current_lang').val();
var is_rtl = !(jQuery('html[lang = "en-US"]').length > 0);
var prevSlick = '<button type="button" class="slick-prev slick-button" tabindex="-1" aria-label="' + global_vars.prev_btn_text + '"></button>';
var nexSlick = '<button type="button" id="slick-next" class="slick-next slick-button" tabindex="-1" aria-label="' + global_vars.next_btn_text + '"></button>';
var focusables = 'input, button, a, textarea, select, [tabindex]';
var class_to_add;
jQuery(document).ready(function () {

    jQuery('.single_project_quote_long_text').each(function () {
        var height = jQuery(this).height();
        var innerHeight = jQuery(this).children('span').height();
        if (innerHeight > height) {
            jQuery(this).next('.single_project_quote_btn').show();
        } else {
            jQuery(this).next('.single_project_quote_btn').hide()
        }
    });
    jQuery('.single_project_quote_btn').on('click', function (e) {
        e.preventDefault();
        jQuery(this).toggleClass('active').prev().toggleClass('expanded');
        if (jQuery(this).hasClass('active')) {
            jQuery(this).attr('aria-expanded', 'true');
        } else {
            jQuery(this).attr('aria-expanded', 'false');
        }
    });

    /* Hybrid courses */

    /*if(jQuery(window).width() > 991) {
        jQuery('#hybrid_course_more_items').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            rtl: is_rtl,
            nextArrow: nexSlick,
            prevArrow: prevSlick,
            infinite: false
        });
    }*/

    jQuery('.hybrid_more_courses_btn').on('click', function () {
        jQuery(this).closest('#hybrid_inst_courses').toggleClass('open');
    });

    /*  */

    jQuery('.dropdown_langs_btn').on('click', function () {
        jQuery(this).toggleClass('open');
        if (jQuery(window).width() > 767)
            jQuery(this).next().fadeToggle();
        else
            jQuery(this).next().slideToggle();


        // Accessibility
        if (jQuery(this).is('.open')) {
            jQuery(this).attr('aria-expanded', 'true');
        } else
            jQuery(this).attr('aria-expanded', 'false');

    });

    if (jQuery('.wrap-search-page-course.no_ajax_filter').length > 0)
        course_filter_url();

    var title = jQuery('.nav-lang .wpml-ls-current-language a span')[1].lang
    var lang = title === 'en' ? 'en' : (title === 'he' ? 'he' : (title === 'ar' ? 'ar' : null))
    if(lang) {
        setCookie('openedx-language-preference', lang, 30);
    }

    jQuery('.wpml-ls-menu-item').click(function(event) {

        const id = event.currentTarget.id;
        if(id === 'menu-item-wpml-ls-83-en' || id === 'wpml-ls-item-en') {
            setCookie('openedx-language-preference', 'en', 30);
        } else if(id === 'menu-item-wpml-ls-83-ar' || id === 'wpml-ls-item-ar') {
            setCookie('openedx-language-preference', 'ar', 30);
        } else if(id === 'menu-item-wpml-ls-83-he' || id === 'wpml-ls-item-he') {
            setCookie('openedx-language-preference', 'he', 30);
        }
    })

    if (jQuery(window).width() > 1024) {
        jQuery(document).on('click', function (e) {
            jQuery('.wrap-checkbox_institution').fadeOut();
        });

        jQuery('.wrap-terms-institution').on('click', function (e) {
            e.stopPropagation();
        });
    }

    // קוקי לזיהוי כניסה ראשונה להדגשת הצ'אטבוט
    if (!getCookie('first_time_in_site')) {
        setCookie('first_time_in_site', 1, 3);
        jQuery('body').addClass('no_cookies');
    }

    /*Runs the enrollment only the first time you log in - to check the login,
     and every time you enter a course page*/
    // if((getCookie("edxloggedin") != "true") || (jQuery('body.single-course').length)){
    if ((!getCookie(global_vars.cookie_name)) || (jQuery('body.single-course').length)) {
        jQuery.ajax({
            method: "GET",
            url: global_vars.link_to_enrollment_api,
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            xhrFields: {withCredentials: true},
            success: function (data, textStatus, jqXHR) {
                console.log('succeeded: authenticated');
                //console.log(data);

                show_username();
                if ((jQuery('body.single-course').length)) {
                    var course_id_edx = jQuery('.information-bar').data('course_id_edx');
                    var connect_to_course = false;
                    jQuery.each(data, function (index, value) {
                        if (value['course_details']['course_id'] == course_id_edx) {
                            connect_to_course = true;
                        }
                    });
                    if (!connect_to_course) {
                        // רק אם מוזן משהו בטקסט שלא רשום לקורס - הוא מציג אותו אחרת הטקסט נכנס לאלמנט שנקרא שכן מחובר לקורס
                        if (jQuery('.signup-course-button-wrap .user_not_con_to_course').length) {
                            jQuery('.signup-course-button-wrap .user_not_con_to_course').show();
                            jQuery('.signup-course-button-wrap .con_to_course').hide();
                        }

                        if (jQuery('.course-info-times .user_not_con_to_course').text()) {
                            jQuery('.course-info-times .con_to_course').hide();
                            jQuery('.course-info-times .user_not_con_to_course').show();
                        }

                    }
                }
            },
            error: function () {//user not connect
                show_username();
            }
        });
    } else if (getCookie(global_vars.cookie_name)) {
        // else if(getCookie("edxloggedin") == "true" && getCookie(global_vars.cookie_name)){
        //Retrieves the name of the surfer from the cookie
        show_username();
    }
//להרשם לקורס
    jQuery('body').on('click', '.register_api', function () {
        var course_id_edx = jQuery('.information-bar').data('course_id_edx');
        var link_end = jQuery(this).data('link-end');
        var action_end_api = jQuery(this).data('action-end-api');
        jQuery.ajax({
            method: "post",
            url: global_vars.link_to_change_enrollment_api,
            data: {
                "course_id": course_id_edx,
                "csrfmiddlewaretoken": jQuery.cookie('csrftoken-marketing'),
                "enrollment_action": "enroll",
            },
            xhrFields: {withCredentials: true},
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                console.log('succeeded: enrollment status changed');

                if (action_end_api == 'dashboard' || action_end_api == 'course') {
                    location.href = link_end;
                } else if (action_end_api == 'popup') {
                    alert(jQuery('.signed_up_course').text());
                    jQuery('.user_not_con_to_course').hide();
                    jQuery('.con_to_course').show();
                }
            },
            error: function (jqXHR) {
                if (jQuery('.code-error-api[data-code-error="' + jqXHR.status + '"]').length) {
                    alert(jQuery('.code-error-api[data-code-error="' + jqXHR.status + '"]').text());


                } else {
                    var text_unknown_code = jQuery('.unknown_code_error_api').text();
                    text_unknown_code = text_unknown_code.replace('{code}', jqXHR.status);
                    alert(text_unknown_code);
                }
                /*if (jqXHR.status == 403) {
                    console.error("Not authenticated");
                }
                else if (jqXHR.status == 400) {
                    //כבר רשום
                }*/
            }
        });
    });

    // //contact form insert after only o mobile
    // if (jQuery(window).width() < 767) {
    //     jQuery('.lokking-for-form').appendTo('.wrap-content-search-page');
    // }
    //
    // //onload show the contact
    // jQuery('.lokking-for-form').css('display', 'block');


    // Courses-slick

    jQuery('body').on('click', '.course-item-image.haveyoutube', function () {
        jQuery('#popup-course-hp').clone().appendTo('#popup > div');
        jQuery('#popup_overlay #popup').attr("aria-hidden", "false");
        jQuery('.close-popup-course-button').on('click', function () {
            jQuery('#popup_overlay #popup').attr("aria-hidden", "true");
            close_popup();
        });
        var is_event = jQuery(this).closest('.course-item').is('.item_post_type_event') ? 'event_popup' : 'course_popup';
        jQuery('#popup > div #popup-course-hp .popup-course-link').addClass(is_event);
        jQuery.ajax({
            type: 'POST',
            url: global_vars.ajax_url,
            data: {
                'action': 'get_course_popup',
                'post_id': jQuery(this).data('id'),
                'lang': current_lang,

            },
        }).done(function (response) {
            var json = response.data;
            jQuery('#popup > div #popup-course-hp .popup-video').attr('title', json.popup_title);
            jQuery('#popup > div #popup-course-hp .popup-video').attr('src', json.popup_video);

            jQuery('#popup > div #popup-course-hp .pupup_text').html(json.popup_title);
            jQuery('#popup > div #popup-course-hp .excerpt').text(json.popup_excerpt);
            jQuery('#popup > div #popup-course-hp .popup-lecturer-thumbnail').attr('style', 'background-image: url(' + json.popup_lecturer_thumbnail + ')');
            jQuery('#popup > div #popup-course-hp .mediapupup-heading').text(json.popup_lecturer_title);
            jQuery('#popup > div #popup-course-hp .popup-academic-institution-title').text(json.popup_academic_institution_title);
            jQuery('#popup > div #popup-course-hp .popup-duration-popup-course').text(json.popup_duration_popup_course);
            jQuery('#popup > div #popup-course-hp .popup-course-link-inner').attr('href', json.popup_course_link);

            //after all data is loader the remove the loader
            jQuery('#popup .popup-loader').fadeOut();

        });

    });
    // jQuery('.lecturer-little-about').on('keydown',function (e) {
    //         if(e.which==13){
    //
    //             jQuery(this).click();
    //         }
    // });
    //popup lecturer in course page
    jQuery('.lecturer-little-about').on('click', function () {
        jQuery(this).parents('.single-lecturer').addClass('active');
        jQuery(this).prev('.single-lecturer-popup').addClass('active');
        jQuery('body').addClass('lecturer_popup_open');
        jQuery(this).prev('.single-lecturer-popup').attr('aria-hidden', 'false');
        jQuery('.background-popup').addClass('modal-backdrop fade show');
        //jQuery('body').addClass('popup_open');
        //jQuery(this).prev('.single-lecturer-popup').find('.close-lecturer').focus();
        setTimeout(function () {
            jQuery('.close-lecturer').focus();
        }, 300);

    });

    jQuery('.close-popup-button').on('click', function () {
        setTimeout(function () {
            jQuery('.single-lecturer-popup').attr('aria-hidden', 'true');
        }, 300);
    })

    jQuery('.background-popup').click(function () {
        // jQuery(this).parents('.single-lecturer').addClass('active');
        if (jQuery(".wrap-all-tags-filter").is('.open')) {
            jQuery(".wrap-all-tags-filter").toggleClass('open').animate({
                width: "toggle"
            });
        }
        if (jQuery(".nav-mobile-campus").is('.open')) {
            jQuery(".nav-mobile-campus").toggleClass('open').animate({
                width: "toggle"
            });
            jQuery('html').toggleClass('menu_open');
        }
        jQuery('.single-lecturer-popup').removeClass('active');
        jQuery('body').removeClass('lecturer_popup_open');
        jQuery(this).removeClass('modal-backdrop fade show');
        // jQuery('body').addClass('popup_open');
    });

    jQuery('.single-lecturer-popup').click(function (e) {
        e.stopPropagation();
    });
    jQuery('.post-type-archive-course #popup').click(function (e) {
        e.stopPropagation();
    });

    // close popup lecturen on click on x button
    jQuery('.close-lecturer').click(function () {
        jQuery(this).parents('.single-lecturer').removeClass('active');
        jQuery(this).parent('.single-lecturer-popup').removeClass('active');
        jQuery('body').removeClass('lecturer_popup_open');
        jQuery('.background-popup').removeClass('modal-backdrop fade show');
    });

    jQuery(".lecturer-little-about").focus(function (e) {
        var el = jQuery('.single-lecturer.active .lecturer-little-about');
        if (el.length != 0) {
            jQuery(".close-lecturer").focus();
        }
    });
    //close popup lecturer on click on the open element
    jQuery('.single-close-wrap').click(function () {
        jQuery(this).removeClass('active');
        jQuery('.background-popup').removeClass('modal-backdrop fade show');
    });

    // Courses slider var
    initCourseSlider(is_rtl, prevSlick, nexSlick);
    jQuery('.link-data-filter').on('click', function () {
        jQuery(this).addClass('active').siblings().removeClass('active');
        jQuery(this).attr('aria-selected', 'true').siblings().attr('aria-selected', 'false');
        // First of all - remove current items
        jQuery('.courses-slick').slick('unslick');
        jQuery('.courses-slick .course-item').remove();

        // Filters items in the stock
        var id = jQuery(this).data('filter');

        // Append relevant items from the stock to the slider and then init the slider
        jQuery('#course_stock .course-item[data-filter *= ",' + id + ',"]').clone().appendTo('.courses-slick');
        initCourseSlider(is_rtl, prevSlick, nexSlick);

    });


    //toggle faq
    jQuery('.faq-title-inner').on('keydown', function (e) {
        if (e.which == 13) {
            jQuery(this).click();
        }
    });
    jQuery('.faq-answer').on('keydown', function (e) {
        if (e.which == 13) {
            jQuery(this).prev().click();
            jQuery(this).prev().focus();
        }
    });
    jQuery('.faq-title-inner').click(function () {
        $parent = jQuery(this).parent();
        $parent.toggleClass('active');
        $parent.next().slideToggle();
        var expanded_txt = '';
        if ($parent.hasClass('active')) {
            jQuery(this).attr('aria-expanded', 'true');
            $parent.next().focus();
            // if (jQuery('[lang="he-IL"]')) {
            //     expanded_txt = 'מורחב';
            // } else {
            //     if (jQuery('[lang="en-US"]')) {
            //         expanded_txt = 'expanded';
            //     } else {
            //         expanded_txt = 'واسع';
            //     }
            // }
        } else {
            jQuery(this).attr('aria-expanded', 'false');
            // if (jQuery('[lang="he-IL"]')) {
            //     expanded_txt = 'מכווץ';
            // } else {
            //     if (jQuery('[lang="en-US"]')) {
            //         expanded_txt = 'constricted';
            //     } else {
            //         expanded_txt = 'مقيدة';
            //     }
            // }
        }
        jQuery(this).attr("aria-label", expanded_txt);
    });
    jQuery(".how_it_work_link ").click(function () {
        if (jQuery(window).width() < 767) {
            jQuery(".nav-mobile-campus").animate({
                width: "toggle"
            });
            jQuery(".background-popup").removeClass('modal-backdrop fade show header-nav');
        }

    });
    //opens nav at mobile burger header
    jQuery(".navbar-mobile-button").click(function () {
        jQuery(".nav-mobile-campus").toggleClass('open').animate({
            width: "toggle"
        });
        jQuery(".mobile-menu-popup").toggleClass('active');
        if(!jQuery(".bg-overlay")[0].classList.contains('active') && jQuery(".mobile-menu-popup")[0].classList.contains('active')) {
            jQuery(".bg-overlay").addClass('active');
            jQuery(".header_section").addClass('menu-open');

        } else if(!jQuery(".mobile-menu-popup")[0].classList.contains('active')) {
            jQuery(".bg-overlay").removeClass('active');
            jQuery(".header_section").removeClass('menu-open');

        }
        jQuery('html').toggleClass('menu_open');

    });
    if (jQuery(window).width() < 769) {
        //toggle nav search page filters
        jQuery(".clear-filter-area").click(function () {
            jQuery(".wrap-all-tags-filter").toggleClass('open').animate({
                width: "toggle"
            });
            jQuery('.background-popup').addClass('modal-backdrop show');
        });
        jQuery('.search-close-button, #close-nav-search').click(function () {
            if (jQuery(".wrap-all-tags-filter").is('.open')) {
                jQuery(".wrap-all-tags-filter").toggleClass('open').animate({
                    width: "toggle"
                });
            }
            jQuery('.background-popup').removeClass('modal-backdrop show');

        })
    }

    //Scroll top
    if (jQuery(document).height() > jQuery(window).height() + 800) {
        jQuery('.scroll-top').removeClass('d-none');
        jQuery('.scroll-top').click(function (e) {
            e.preventDefault()
            jQuery("html, body").animate({scrollTop: 0}, 500)
        });
    }

    //open the popup from banner from about course page
// 03/06/2020 new version popup
//     jQuery('[data-accessibility-2020] .checkbox-filter-search').on('focus',function () {
//          jQuery(this).parent().parent().parent().parent().next().click();
//     });
    jQuery('.popup-about-course-video').on('click', function (e) {

        // if(!detectIE()) {
        //e.preventDefault();
        //var url = jQuery(this).data('url');
        // console.log(url);
        // jQuery('#popup div').html('<iframe width="560" height="315" src="' + url + '" frameborder="0" allowfullscreen></iframe>');
        // }
        // 03/06/2020
        e.preventDefault();
        // e.stopPropagation();
        var url = jQuery(this).data('url');
        jQuery("#popup_2020 iframe").attr('src', url);
        jQuery('body').toggleClass('popup_open_2020');
        //jQuery(this).focusout();
        jQuery(this).addClass('active');
        //jQuery('.signup-course-button').focus();
        jQuery('.close-popup-button-2020').focus();
        //console.log(jQuery('.close-popup-button-2020'));
    });
    jQuery(".close-popup-button-2020").on("click", function (e) {
        e.stopPropagation();
        jQuery("#popup_overlay_2020").click();
    });
    jQuery(".close-popup-button-2020").on("keydown", function (e) {
        if (e.which == 27) {
            jQuery("#popup_overlay_2020").click();
        }
    });
    jQuery('#popup_overlay_2020').click(function (e) {
        // close_popup();
        //if (jQuery(e.target).hasClass('close-popup-iframe')) {

        close_popup_2020();
        // }
        // if ((jQuery(e.target).parents('.dialog').length == 0)) {
        //    close_popup();
        //  }


    });
    if (jQuery('#popup_overlay_new_event').length > 0) {
        // Check event date vs today
        var d = new Date();
        var midnight = new Date(d.getFullYear(), d.getMonth(), d.getDate(), 0, 0, 0);
        midnight = Math.floor(midnight.getTime() / 1000);

        var eventDate = new Date((jQuery('#popup_overlay_new_event').data('date') * 1000));
        var eventMidnight = new Date(eventDate.getFullYear(), eventDate.getMonth(), eventDate.getDate(), 0, 0, 0);
        eventMidnight = Math.floor(eventMidnight.getTime() / 1000);

        if (midnight <= eventMidnight) {

            var event_id = jQuery('#popup_overlay_new_event').attr('data-id');
            var cookie_name = 'watched_event_' + event_id;
            var event_watched = getCookie(cookie_name);
            if (!event_watched) {
                jQuery('#popup_overlay_new_event').removeClass('hide').find(focusables).first().focus();
                jQuery('html').addClass('event_popup_is_open');
                setCookie(cookie_name, true, global_vars.event_cookie_days);

                focus_popup('#popup_overlay_new_event');
                focus_popup('#popup_lecturer');
            }

            // jQuery('#popup_overlay_new_event').removeClass('hide');
            jQuery('#popup_overlay_new_event').click(function (e) {
                if (e.target == this || jQuery(e.target).hasClass('close-popup-course-button')) {
                    jQuery('#popup_overlay_new_event').addClass('hide');
                    jQuery('#popup_new_event').attr('aria-hidden', 'true');
                    jQuery('html').removeClass('event_popup_is_open');
                }
            });
        }
    }
    jQuery("a.brand").on('focus', function (e) {
        var el = jQuery("body.popup_open_2020 #popup_2020 [tabindex][tabindex!='-1']:last");
        if (el.length > 0) {
            e.preventDefault();
            jQuery("#popup_2020 .close-popup-button-2020").focus();
        }
    });
// End 03/06/2020 new version popup

    jQuery(".close-popup-button").on("click", function (e) {
        e.preventDefault();
        jQuery("#popup_overlay").click();
    });
    //open the youtube popup from "how it works"
    jQuery('body').on('click', '.open_yt_lightbox', function (e) {
        // if(!detectIE()) {
        e.preventDefault();
        var url = jQuery(this).data('url');
        jQuery('#popup_overlay #popup').attr('aria-hidden', 'false');
        jQuery('#popup div').html('<button aria-label="' + global_vars.close_text + '" role="button" class="last-popup-element first-popup-element close-popup-button close-popup-iframe"></button><iframe width="560" height="315" src="' + url + '" frameborder="0" allowfullscreen></iframe>');
        // }
        jQuery('.dialog .close-popup-iframe').click(function () {
            close_popup();
        })
    });
    jQuery('.close-popup-iframe').on("click", function () {
        setTimeout(function () {
            jQuery('#popup_overlay #popup').attr('aria-hidden', 'true');
        }, 300);
    });
    // פתיחת פופאפ
    jQuery('body').on('click', '[data-popup]', function (e) {
        class_to_add = jQuery(this).data('classtoadd');
        if (jQuery("#popup #popup-course-hp").length != 0) {
            jQuery("#popup>button.close-popup-button").hide();
        } else {
            jQuery("#popup>button.close-popup-button").show();
        }
        jQuery('html').addClass('popup_open');
        jQuery('html').addClass(class_to_add);
        jQuery(this).addClass('active');
        setTimeout(function () {
            jQuery(".dialog .last-popup-element").focus();
        }, 500);//פקס את הרכיב קליקאבילי הראשון
    });
    jQuery('*').on('keyup', function (e) {
        if (e.keyCode == 27) {
            close_popup();
        }
    });
    // jQuery()
    jQuery('#popup_overlay').click(function (e) {
        // close_popup();
        if (jQuery(e.target).hasClass('close-popup-iframe')) {
            close_popup();
        }
        if ((jQuery(e.target).parents('.dialog').length == 0)) {
            close_popup();
        }


    });
    var x = jQuery('.wrap-checkbox_institution .term-filter-search').eq(0);
    jQuery('.wrap-checkbox_institution .term-filter-search:last').on('keydown', function (e) {
        if (e.which == 9) {
            setTimeout(function () {
                jQuery(x).focus();
            }, 20);
        }
    });

    //what is hover
    jQuery('.last-popup-element.first-popup-element.close-popup-button.close-popup-iframe').on('keydown', function (e) {
        if (e.which == 9) {
            jQuery(this).next().focus();
        }
    });
    jQuery('.what_is_pacing').hover(function () {

        jQuery('.what_is_pacing_explanation').toggleClass('what-is-active');

    });
    jQuery('.what is pacing').focus(function () {
        jQuery('.what_is_pacing_explanation').toggleClass('what-is-active')
    });

    //show more tags in course search page

    jQuery('.show-more-tags').click(function () {
        if (jQuery(this).is('.collapsed')) {
            var heightReadMore = jQuery(this).prev().children('.more-tags').height();
            jQuery(this).prev().css('max-height', heightReadMore + jQuery(this).prev().children('.search-page-tax-name').height());
        } else {
            jQuery(this).prev().css('max-height', '');
        }
        jQuery(this).toggleClass('collapsed');

    });

    //read more and read less
    var heightReadMore = jQuery('.read-more-text').height();
    // alert(heightReadMore);

    if (heightReadMore > 120) {
        jQuery('.course_test_readmore_collapse').css('display', 'block');
        //alert('read more');
        jQuery('.read-more-text a').attr('tabindex', '-1');
    }
    jQuery('.course_test_readmore_collapse').click(function () {
        if (jQuery(this).is('.collapsed')) {
            jQuery('.text-description-of-course').css('max-height', heightReadMore);
            jQuery('.read-more-text a').attr('tabindex', '0');
            jQuery(this).attr('aria-expanded', 'true');
        } else {
            jQuery('.text-description-of-course').css('max-height', '');
            jQuery(this).attr('aria-expanded', 'false');
        }
        jQuery(this).toggleClass('collapsed');

    });

    jQuery('select[data-name="academic_institution"]').on('change', function () {
        var val_item = jQuery(this).val();
        console.log(val_item + ' val');
        jQuery('input[data-name="institution"]').prop('checked', false);
        jQuery('input[data-name="institution"][value="' + val_item + '"]').prop('checked', true).change();
        //if move to first choose
        if (jQuery(".selected-academic option:first").prop('selected')) {
            jQuery('.term-filter-search').change();
        }
        change_select_text();
    });
    jQuery('.filter_main_button').on('click', function () {
        jQuery('.wrap-checkbox_institution').fadeToggle();
        setTimeout(function () {
            jQuery('.wrap-checkbox_institution.wrap-terms-group[style="display: block;"]').prev().attr('aria-expanded', 'true');
            jQuery('.wrap-checkbox_institution.wrap-terms-group[style="display: none;"]').prev().attr('aria-expanded', 'false');
        }, 550)
    });


    jQuery('.wrap-checkbox_institution').on('keydown', function (e) {
        if (e.which == 27) {
            jQuery('.filter_main_button').click();
            jQuery('.clear_all_filters').focus();
        }
    });
    //slick testimonials lobby page

    jQuery('#slick-testimonials-lobby').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        rtl: is_rtl,
        infinite: true,
        dots: false,
        nextArrow: nexSlick,
        prevArrow: prevSlick,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                    arrows: false
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]

    })
    //sum all courses results


    //newest and popular filters
    jQuery(".wrap-orderby input").on('change', function () {

        jQuery(".wrap-orderby input").removeAttr('checked');
        jQuery(this).attr('checked', true);

        if (jQuery(this).attr('name') == 'event_order') {
            ul = jQuery('#all_events');
            ul.children().each(function (i, li) {
                ul.prepend(li)
            });
            if (jQuery(this).data('filter') == 'future') {
                jQuery('#all_events .course-item:not([data-status = "future"])').hide();
            } else {
                jQuery('#all_events .course-item').show();
            }
        } else {
            var data = jQuery(this).val();

            if (is_ajax_filter()) {
                jQuery('form [name = "orderby"]').val(data);
                ajax_filter_courses(false);
            } else {
                if (data == 'date') {
                    var low = -1;
                    var high = 1;
                } else {
                    var low = 1;
                    var high = -1;
                }

                jQuery('.output-courses > div').sort(function (a, b) {
                    var contentA = parseInt(jQuery(a).attr('data-' + data));
                    var contentB = parseInt(jQuery(b).attr('data-' + data));
                    return (contentA < contentB) ? high : low;
                }).appendTo('.output-courses');
                restart_loadmore_course();
            }
        }
        if (jQuery(this).is(':checked')) {
            jQuery(this).next('.orderby').addClass('active');
            jQuery(this).parent().siblings().children('.orderby').removeClass('active');
        }
    });
    //Search page filter
    jQuery('#filter_dynamic_tags').on('click', 'a', function () {
        var id = jQuery(this).data('id');
        var name = jQuery(this).data('name');
        jQuery('.checkbox-filter-search[data-name = "' + name + '"][value = "' + id + '"]').prop('checked', false).change();
        jQuery('.checkbox-filter-search[name = "' + name + '"][value = "' + id + '"]').prop('checked', false).change();
        jQuery('option.academic-option-item[value = "' + id + '"]').prop('selected', false);

        if (is_ajax_filter())
            ajax_filter_courses(false);
    });
    //clear all search
    jQuery('#clear_all_filters').on('click', function () {
        jQuery('.course-item').removeClass('hidden_filter');
        jQuery('[type="checkbox"]:checked').prop("checked", false).change();
        jQuery('.selected-academic').val("");
        jQuery('.no-result-inside-filter').hide();
        jQuery('.wrap-checkbox_institution').fadeOut();
        change_select_text();

        if (is_ajax_filter()) {
            ajax_filter_courses(false);
        }
    });

    jQuery('.checkbox-filter-search[data-name = "institution"]').change(function () {
        jQuery('.selected-academic').val("null");
        change_select_val();
    });

    jQuery('#ajax_filter').on('submit', function () {
        ajax_filter_courses(false);
    });
    jQuery('.ajax_filter_btn').on('click', function () {
        ajax_filter_courses(false);
    });
    jQuery('.wrap-all-tags-filter:not(#ajax_filter) .term-filter-search').change(function () {
        courses_js_filter();
    });

    if (jQuery('.wrap-all-tags-filter:not(#ajax_filter)').length) {
        var vars = getUrlVars();
        if (vars) {
            console.log(vars)
        }
    } else {
        change_select_val();
    }


    jQuery('#course_load_more').on('click', function () {
        if (is_ajax_filter())
            ajax_filter_courses(true);
        else
            course_loadmore();
    });

    //breadcrumbs
    jQuery('#breadcrumbs span span:first').attr('role', 'navigation');
    // Accessability
    // Tooltip
    jQuery(".wpml-ls-item-he a").attr("title", global_vars.menu_he_title);
    jQuery(".wpml-ls-item-ar a").attr("title", global_vars.menu_ar_title); //"تغيير لغة الموقع إلى اللغة العربية");
    jQuery(".wpml-ls-item-en a").attr("title", global_vars.menu_en_title); //"change the site language to english");
    jQuery(".contact-us-icons-socials-link.google").attr("aria-label", "google");
    jQuery(".contact-us-icons-socials-link.twitter").attr("aria-label", "twitter");
    jQuery(".contact-us-icons-socials-link.linkdin").attr("aria-label", "linkdin");
    jQuery(".contact-us-icons-socials-link.instegram").attr("aria-label", "instegram");
    jQuery(".contact-us-icons-socials-link.facebook").attr("aria-label", "facebook");
    setTimeout(function () {
        jQuery("#testimonials-slider-slick .slick-prev").attr("id", "right-button-slider-testimonials");
        jQuery("#testimonials-slider-slick .slick-next").attr("id", "left-button-slider-testimonials");
        jQuery("#academic-institution-slider .slick-prev").attr("id", "right-button-slider-academic-institution");
        jQuery("#academic-institution-slider .slick-next").attr("id", "left-button-slider-academic-institution");
        jQuery(".carousel-item.slick-slide,.item-testimonials").removeAttr("tabindex");
        jQuery("#right-button-slider-academic-institution,#left-button-slider-academic-institution").click(function () {
            setTimeout(function () {
                jQuery(".carousel-item.slick-slide").removeAttr("tabindex");
            }, 500);
        });
        jQuery("#right-button-slider-testimonials,#left-button-slider-testimonials").click(function () {
            setTimeout(function () {
                jQuery(".item-testimonials").removeAttr("tabindex");
            }, 500);
        });
    }, 500);

    jQuery("#academic-institution-slider .slick-prev").keydown(function (e) {
        if (e.which === 9) {
            setTimeout(function () {
                jQuery('.carousel-item.slick-slide[aria-hidden=false] a').first().focus();
            }, 400);
        }
    });
    // jQuery(".carousel-item.slick-slide[aria-hidden=false] a").first().keydown(function (e) {
    //     if (e.which === 9 && e.shiftKey) {
    //         setTimeout(function (){
    //             jQuery('#academic-institution-slider .slick-prev').focus();
    //         },400);
    //     }
    //  });

    jQuery(".lokking-for-form .submit-looking").click(function () {
        setTimeout(function () {
            jQuery(".lokking-for-form .wpcf7-not-valid").first().focus();
        }, .2500);
    });
    jQuery(".checkbox-filter-search").focus(function () {
        jQuery(this).parents(".term-filter-search").css("outline", "1")
    });
    jQuery(".checkbox-filter-search").blur(function () {

    });
    //   var opendPopup;
    //  jQuery(".open-popup-button").click(function () {
    //  alert("hi");
    //  setTimeout(function () {
    //     jQuery(".dialog .last-popup-element").focus();
    //  }, 500);//פקס את הרכיב קליקאבילי הראשון
    //  opendPopup = jQuery(this);
    // });
    jQuery("#popup_lecturer").keydown(function (e) {//shift+tab על אלמנט ראשון בפופאפ
        if (e.which === 9 && e.shiftKey) {
            e.preventDefault();
            jQuery(this).find(".last-popup-element").focus();
        }
    });
    // jQuery(".dialog .last-popup-element").keydown(function (e) { //shift בלבד על אלמנט אחרון בפופאפ
    //     if (e.which === 9 && !e.shiftKey) {
    //         e.preventDefault();
    //         setTimeout(function () {
    //             jQuery(".dialog .last-popup-element").focus();
    //         }, 2000);
    //     }
    // });
    // jQuery(".donthaveyoutube").click(function(){
    //     jQuery(this).removeClass("open-popup-button");
    // });
    jQuery(".lecturer-little-about").keydown(function (e) {
        if (e.keyCode == 13) {
            jQuery(this).click();
        }
    });
    // היות שהאירוע לא נמצא על הכפתור הסגירה אלא על הפופאפ עצמו
    // jQuery(".dialog .close-popup-button").click(function () {
    //     opendPopup.focus();
    // });
    jQuery("#popup_overlay_2020").on('focus', function (e) {
        var el = jQuery("html.popup_open .dialog #popup-course-hp .close-popup-course .last-popup-element");
        //console.log(el);
        if (el.length > 0) {
            e.preventDefault();
            jQuery("html.popup_open .dialog #popup-course-hp .close-popup-course .last-popup-element").focus();
        }
    });
    jQuery('.faq-item .faq-title-inner').each(function () {
        var lang_txt = '';
        if (jQuery('[lang="he-IL"]')) {
            lang_txt = 'ניתן ללחוץ לפתיחה וסגירה';
        } else {
            if (jQuery('[lang="en-US"]')) {
                lang_txt = 'You can click to open and close';
            } else {
                lang_txt = 'يمكنك النقر فوق فتح وإغلاق';
            }
        }
        var txt = jQuery(this).text();
        if (txt == undefined)
            txt = '';
        jQuery(this).attr("aria-label", txt + " " + lang_txt);
    });
    //נפתח בכרטסיה חדשה
    jQuery("[target='_blank']").each(function () {
        var a_lbl = jQuery(this).attr("aria-label");
        if (a_lbl == undefined)
            a_lbl = jQuery(this).text();
        jQuery(this).attr("aria-label", a_lbl + " " + "נפתח בכרטסיה חדשה");
    });

    //style select:
    jQuery(".select-subject select").each(function () {
        var $this = jQuery(this);
        var numberOfOptions = jQuery(this).children('option').length;
        console.log("num-options " + numberOfOptions);

        $this.addClass('select-hidden');
        $this.wrap('<div class="select"></div>');
        $this.after('<div class="select-styled"></div>');

        var $styledSelect = $this.next('div.select-styled');
        var $textStyledSelect = $this.find('option:selected') ? $this.children('option:selected').text() : $this.children('option').eq(0).text();
        $styledSelect.text($textStyledSelect);

        var $list = jQuery('<ul />', {
            'class': 'select-options'
        }).insertAfter($styledSelect);

        console.log("num-options " + numberOfOptions);
        for (var i = 0; i < numberOfOptions; i++) {
            jQuery('<li />', {
                text: $this.children('option').eq(i).text(),
                rel: $this.children('option').eq(i).val()
            }).appendTo($list);
        }

        var $listItems = $list.children('li');

        $styledSelect.click(function (e) {
            e.stopPropagation();
            jQuery('div.select-styled.active').not(this).each(function () {
                jQuery(this).removeClass('active').next('ul.select-options').hide();
            });
            jQuery(this).toggleClass('active').next('ul.select-options').toggle();
        });

        $listItems.click(function (e) {
            e.stopPropagation();
            $styledSelect.text(jQuery(this).text()).removeClass('active');
            $this.val(jQuery(this).attr('rel'));
            $list.hide();
            console.log($this.val());
        });

        // jQuery(document).click(function () {
        //     $styledSelect.removeClass('active');
        //     $list.hide();
        // });

    });

    const userInfo = get_user_info();
    if(userInfo) {
        jQuery('.profile-button').attr('href', userInfo['header_urls']['learner_profile'])
        jQuery('.logout-button').attr('href', userInfo['header_urls']['logout'])
        if(jQuery('.mobile-login-register').hasClass('active')) {
            jQuery('.mobile-login-register').removeClass('active');
            jQuery('.mobile-menu-asset').removeClass('active')

        }
    }
    if(!userInfo) {
        jQuery('.logged-in-item').hide();
        jQuery('.mobile-login-register').addClass('active')
        jQuery('.mobile-menu-asset').addClass('active')
    }

});

jQuery(document).on('scroll', function () {
    // console.log(jQuery(this).scrollTop());
    if (jQuery(this).scrollTop() > 0)
        jQuery('.scroll-top').addClass('show');
    else
        jQuery('.scroll-top').removeClass('show');
});

function ajax_filter_courses(loadmore) {
    if (loadmore) {
        jQuery('[name = "paged"]').val(parseInt(jQuery('[name = "paged"]').val()) + 1);
    } else {
        jQuery('[name = "paged"]').val(1);
    }
    var formData = jQuery('#ajax_filter').serializeArray();
    jQuery('body').addClass('ajax_filter_is_working');
    jQuery.ajax({
        url: global_vars.ajax_url,
        data: formData,
        method: 'POST',
        dataType: 'JSON'
    }).done(function (json) {
        if (loadmore) {
            jQuery('.output-courses').append(json.html);
        } else {

            var checked = jQuery('#ajax_filter [type="checkbox"]:checked'),
                ob = {},
                params = '',
                sign = '';
            jQuery('#filter_dynamic_tags a').remove();

            if (checked.length > 0) {
                jQuery(checked).each(function () {

                    // set vars
                    var text = jQuery(this).next('.wrap-term-and-sum').find('.term-name').text();
                    var name = jQuery(this).attr('name') ? jQuery(this).attr('name') : jQuery(this).data('name');
                    var value = jQuery(this).val();

                    //add filter same type at the top:
                    var tag = jQuery('#filter_dynamic_tags_demo a').clone();
                    tag.attr('data-id', value);
                    tag.attr('data-name', name);
                    tag.text(text);
                    tag.attr("aria-label", text + tag.attr("aria-label"));
                    tag.attr('class', 'filter_dynamic_tag ajax_filter_tag');
                    tag.appendTo('#filter_dynamic_tags');

                    var dataname = jQuery(this).data('name');
                    var dataval = jQuery(this).data('value');
                    if (ob[dataname] == undefined) {
                        ob[dataname] = true;
                        params += sign + 'filter_' + dataname + '=' + dataval;
                        sign = '&';
                    } else {
                        params += ',' + dataval;
                    }
                });
            }
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + params;
            window.history.pushState({path: newurl}, '', newurl);

            jQuery('.sum-of-courses-result').html(json.total);
            if (json.total == 0) {
                jQuery('.no-result-inside-filter').show();
                jQuery('.output-courses').html('');
            } else {
                jQuery('.no-result-inside-filter').hide();
                jQuery('.output-courses').html(json.html);
                jQuery('.sum-of-courses-result').html(json.total);
            }
            if (jQuery('.background-popup').is('.show')) {
                close_sidebar();
            }
        }
        if (jQuery('.item_post_type_course').length < json.total)
            jQuery('#course_load_more').show();
        else
            jQuery('#course_load_more').hide();

        jQuery('body').removeClass('ajax_filter_is_working');
    });
}

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

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires+"; path=/";
}

function show_username() {
    var edx_user_info = getCookie(global_vars.cookie_name);
    if (edx_user_info) {
        edx_user_info = edx_user_info.replace(/\\054/g, ',');
        var username = JSON.parse(JSON.parse(edx_user_info))['username'];//Comes JSON of JSON
        jQuery('.name-user').html(username);
        jQuery('html').addClass('user_is_logged_in');
    } else {
        jQuery('html').addClass('user_is_not_logged_in');
    }

}

function get_user_info() {
    let edx_user_info = getCookie(global_vars.cookie_name);
    if (edx_user_info) {
        edx_user_info = edx_user_info.replace(/\\054/g, ',');
        return JSON.parse(JSON.parse(edx_user_info))
    }
    return null;
}

function close_sidebar() {
    if (jQuery(".wrap-all-tags-filter").is('.open')) {
        jQuery(".wrap-all-tags-filter").toggleClass('open').animate({
            width: "toggle"
        });
    }
    jQuery(".background-popup").removeClass('modal-backdrop fade show');
}

function restart_loadmore_course() {
    var i = 1;
    jQuery('.course-item:not(.hidden_filter)').removeClass('hidden_loadmore').filter(function () {
        return i++ > 15;
    }).addClass('hidden_loadmore');

    check_load_more();
}

function course_loadmore() {
    var i = 0;
    jQuery('.course-item.hidden_loadmore:not(.hidden_filter)').filter(function () {
        return i++ < 15;
    }).removeClass('hidden_loadmore');
    check_load_more();
}

function check_load_more() {
    if (jQuery('.hidden_loadmore').length == 0)
        jQuery('#course_load_more').fadeOut();
    else
        jQuery('#course_load_more').fadeIn();
}

function close_popup() {
    jQuery('html').removeClass('popup_open').removeClass(class_to_add);
    jQuery('#popup div').html('');
    jQuery('[data-popup].active').focus();
}

function close_popup_2020() {
    jQuery('body').toggleClass('popup_open_2020');
    //jQuery('#popup div').html('');
    //jQuery('[data-popup].active').focus();
    jQuery("#popup_2020 iframe").attr('src', '');
    jQuery('.popup-about-course-video.open-popup-button-2020.active').focus();
    jQuery('.popup-about-course-video.open-popup-button-2020').removeClass('active');
}

function initCourseSlider(is_rtl, prevSlick, nexSlick) {
    if (jQuery(window).width() < 480) {
        jQuery('.courses-slick').slick({
            rtl: is_rtl,
            // slidesPerRow: 2,
            // // centerMode: true,
            centerPadding: '60px',
            // rows:2,
            prevArrow: prevSlick,
            nextArrow: nexSlick,
            arrows: false,
            // infinite: false,
            // slidesToShow:1
        });
    } else {
        jQuery('.courses-slick').slick({

            rtl: is_rtl,
            slidesPerRow: 3,
            // // centerMode: true,
            centerPadding: '60px',
            rows: 2,
            prevArrow: prevSlick,
            nextArrow: nexSlick,
            arrows: false,
            infinite: false,
            // infinite: false,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesPerRow: 2,
                        rows: 2,
                        infinite: true,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesPerRow: 1,
                        rows: 6,
                        centerMode: false,
                        centerPadding: '60px',
                        arrows: false,
                        swipe: false,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesPerRow: 1,
                        rows: 1,
                        centerMode: false,
                        centerPadding: '60px',
                        // arrows: true,
                        swipe: true,
                        slidesToShow: 1
                        // rows: 1,
                    }
                }
            ]
        });
    }
    // else {
    //     jQuery('.courses-slick').slick({
    //         rtl: lang,
    //         slidesToShow:1
    //     });
    // }


}

// //sort date(newest) and normal(popular)
// jQuery.fn.sortDivs = function sortDivs(data) {
//     jQuery("> div", this[0]).sort(dec_sort).appendTo(this[0]);
//     function dec_sort(a, b){ return (jQuery(b).data(data)) < (jQuery(a).data(data)) ? 1 : -1; }
// }
function change_select_val() {
    jQuery('.wrap-checkbox_institution').find('[type="checkbox"]:checked').each(function () {
        var val = jQuery(this).val();
        if (val)
            jQuery('.wrap-terms-institution').find('select option[value = "' + val + '"]').prop('selected', true);
    });

    change_select_text();
}

function change_select_text() {
    console.log('change text');
    var select1 = jQuery('.selected-academic');
    var selected = jQuery(select1).children(':selected');
    var i = 0;
    var text = '';
    var sign = '';
    var nameStr = "";
    var val = '';
    jQuery(selected).each(function () {
        val = jQuery(this).val();
        nameStr += val + ',';
        /* if(i < 2){*/
        text += sign + jQuery(this).text();
        sign = ', ';
        /* }else{
             //return false;
         }*/
        i++;
    });
    if (selected.length > 2) {
        var plus = selected.length - 2;
        /*text += '[+ ' + plus + ']';*/

    }

    if (text == '')
        text = jQuery(select1).closest('.wrap-terms-group').find('[role = "combobox"]').data('original');
    jQuery(select1).closest('.wrap-terms-group').find('.filter_main_button').text(text);
}

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function course_filter_url() {
    var url_vars = getUrlVars();
    for (var filter in url_vars) {
        var values = url_vars[filter];
        var tmp = '_' + filter;
        if (tmp.indexOf('filter_') > 0) {
            var arr = values.indexOf(',') > 0 ? values.split(',') : [values];
            var tax = filter.slice(7, filter.length);

            for (var i = 0; i < arr.length; i++) {
                jQuery('input[data-name="' + tax + '"][value="' + arr[i] + '"]').prop('checked', true);
            }
        }
    }
    setTimeout(function () {
        change_select_val();
        courses_js_filter();
    }, 10);
}

function is_ajax_filter() {
    return jQuery('#ajax_filter').length > 0;
}


function focus_popup(popup_wrap) {
    jQuery(popup_wrap).find(focusables).filter(':visible').last().on('keyup', function (e) {
        if (e.keyCode == 9 && !(e.shiftKey)) {
            e.preventDefault();
            jQuery(popup_wrap).find(focusables).filter(':visible').first().focus();
        }
    });
    jQuery(popup_wrap).find(focusables).filter(':visible').first().on('keydown', function (e) {
        if (e.keyCode == 9 && e.shiftKey) {
            e.preventDefault();
            jQuery(popup_wrap).find(focusables).filter(':visible').last().focus();
        }
    });
}

function courses_js_filter() {

    jQuery('.no-result-inside-filter').hide();
    jQuery('.course-item').addClass('hidden_filter').removeClass('hidden_loadmore');
    var checked = jQuery('.checkbox-filter-search:checked');
    jQuery('#filter_dynamic_tags a').remove();
    var $all,
        params = '',
        ob = {},
        sign = '';
    if (checked.length > 0) {
        jQuery(checked).each(function () {

            // set vars
            var text = jQuery(this).next('.wrap-term-and-sum').find('.term-name').text();

            var name = jQuery(this).data('name');
            var value = jQuery(this).val();

            //add filter same type at the top:
            var tag = jQuery('#filter_dynamic_tags_demo a').clone();
            tag.data('id', value);
            tag.data('name', name);
            tag.text(text);
            tag.attr("aria-label", text + tag.attr("aria-label"));
            tag.appendTo('#filter_dynamic_tags');

            //add selector to the filter
            var str = '[data-' + name + ' *= ",' + value + ',"],';
            if (ob[name] == undefined) {
                ob[name] = str;
                params += sign + 'filter_' + name + '=' + value;
                sign = '&';
            } else {
                ob[name] += str;
                params += ',' + value;
            }
        });
        // filter courses
        $all = jQuery('.course-item');
        jQuery.each(ob, function (key, value) {
            value = value.slice(0, -1);
            $all = $all.filter(value);
        });

        $all.removeClass('hidden_filter');
    } else {
        jQuery('.course-item').removeClass('hidden_filter');
    }

    /*$academic_choosen = jQuery('.selected-academic');
    if($academic_choosen.val()){
        $all = jQuery('.course-item');
        console.log($academic_choosen.val());
        $all = $all.filter($academic_choosen.val());
    }*/
    //check course result sum(length)
    var sum_length = jQuery('.course-item:not(.hidden_filter)').length;
    jQuery('#add-sum-course').html(sum_length);

    restart_loadmore_course();
    if ($all && $all.length == 0) {
        jQuery('.no-result-inside-filter').show();
    }

    var sign = params ? '&' : '';

    if (jQuery('.wrap-all-tags-filter [name = "s"]').val())
        params = 's=' + jQuery('.wrap-all-tags-filter [name = "s"]').val() + sign + params;
    if (jQuery('.wrap-all-tags-filter [name = "termid"]').val())
        params = 'termid=' + jQuery('.wrap-all-tags-filter [name = "termid"]').val() + sign + params;

    params = params ? '?' + params : '';
    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + params;
    window.history.pushState({path: newurl}, '', newurl);
}

function enroll(json) {
    let xhr = new XMLHttpRequest();

    xhr.onload = () => {
        console.log(xhr.status);
        console.log(xhr.responseText);
    };

    xhr.open('POST', global_vars.link_to_change_enrollment_api);

    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRFToken', getCookie('csrftoken-marketing'));

    xhr.send(JSON.stringify(json));
}