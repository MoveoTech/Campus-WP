<?php
/**
 * Created by PhpStorm.
 * User: estero
 * Date: 08/10/2018
 * Time: 09:15
 */

include locate_template( 'lib/post_types.php' );
include locate_template( 'lib/languages_functions.php' );
include locate_template( 'lib/acf_fields.php' );
include locate_template( 'lib/course-index-functions.php' );
include locate_template( 'admin_files/admin_funcs.php' );
include locate_template( 'assets/ajax/stripe_data.php' );
include locate_template( 'assets/ajax/my_courses.php' );
include locate_template( 'assets/ajax/get_course_popup.php' );

/**
 * Daat Ester
 * Adding option page to header and footer
 */

if ( function_exists( 'acf_add_options_page' ) ) {

	$option_page = acf_add_options_page( array(
		'page_title' => 'Option Page Campus',
		'menu_slug'  => 'option-page-campus',
		'capability' => 'edit_posts',
		'redirect'   => false
	) );

	acf_add_options_page( array(
		'page_title'  => 'Events Global Settings',
		'menu_slug'   => 'events_global_settings',
		'capability'  => 'edit_posts',
		'parent_slug' => 'edit.php?post_type=event',
		'post_id'     => 'events_global_settings'
	) );
}

/**
 * Adding menu to footer
 */

function register_my_menu() {
	register_nav_menu( 'footer_menu', __( 'Footer link-data-filterMenu' ) );
	register_nav_menu( 'lang_menu', __( 'languages Menu' ) );
	register_nav_menu( 'sidebar_menu', __( 'Side Bar Menu' ) );
}

add_action( 'init', 'register_my_menu' );

add_filter( 'user_can_richedit', function ( $param ) {
	return true;
}, 1 );


function redirect($url){
    wp_redirect($url);
    exit;
}

function set_user_default_language() {

    $get_language = $_COOKIE['openedx-language-preference'];
    $url = home_url('/');
    $current_url = home_url($_SERVER['REQUEST_URI']);

    if (is_admin() || strpos($current_url, "wp-") != false)
        return;

    if($get_language == 'ar') {
        if(strpos($url, "en") != false)
            redirect(replace_first_str("en", "ar", $current_url));

        if(strpos($url, "ar") == false)
            redirect(replace_first_str($url, $url . $get_language . '/' , $current_url));
    }

    if($get_language == 'en') {
        if(strpos($url, "ar") != false)
            redirect(replace_first_str("ar", "en", $current_url));

        if(strpos($current_url, "en/") == false)
            redirect(replace_first_str($url, $url . $get_language . '/' , $current_url));
    }

    if($get_language == 'he') {
        if(strpos($url, "ar") != false)
            redirect(replace_first_str("ar", "", $current_url));

        if(strpos($url, "en") != false)
            redirect(replace_first_str("en", "", $current_url));
    }

}
add_action( 'wp_loaded', 'set_user_default_language' );




function style_of_campus_enqueue() {
	wp_enqueue_style( 'assistant', 'https://fonts.googleapis.com/css?family=Assistant:500,400,600,700,800&amp;subset=hebrew' );
	wp_enqueue_style( 'style', get_bloginfo( 'stylesheet_directory' ) . '/assets/css/style.css', array(), '1.9.7' );
    global  $sitepress;
    if ( $sitepress->get_current_language() == 'en' ) {
        wp_enqueue_style( 'css_ltr_css', get_bloginfo( 'stylesheet_directory' ) . '/assets/css/ltr.css', null, '1.9' );
    }

	wp_enqueue_script( 'popper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' );
	wp_enqueue_script( 'slick_js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'cookie_js', '//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'ready_js', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/ready.js', array(
		'jquery',
		'slick_js',
		'cookie_js'
	), '1.2.15' );
	wp_enqueue_script( 'bootstrap_js', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/bootstrap.min.js' );
    wp_enqueue_script('home_page_js', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/home_page.js', array('jquery'));
    wp_localize_script('home_page_js', 'stripe_data_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_localize_script('home_page_js', 'my_courses_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));

	wp_localize_script( 'ready_js', 'global_vars', array(
			'link_to_enrollment_api'        => get_field( 'link_to_enrollment_api', 'option' ),
			'link_to_change_enrollment_api' => get_field( 'link_to_change_enrollment_api', 'option' ),
			'cookie_name'                   => get_field( 'cookie_name', 'option' ),
			'ajax_url'                      => admin_url( 'admin-ajax.php' ),
			'courses_posts_per_page'        => courses_posts_per_page(),
			'event_cookie_days'             => get_field( 'events_popup_cookie_length', 'events_global_settings' ),
			'prev_btn_text'                 => cin_get_str( 'prev_btn_text' ),
			'next_btn_text'                 => cin_get_str( 'next_btn_text' ),
			'close_text'                    => cin_get_str( 'close_btn_popup' ),
			'menu_he_title'                 => cin_get_str( 'menu_he_title' ),
			'menu_ar_title'                 => cin_get_str( 'menu_ar_title' ),
			'menu_en_title'                 => cin_get_str( 'menu_en_title' ),
		)
	);
}

add_action( 'wp_enqueue_scripts', 'style_of_campus_enqueue' );

// get lang menu
//function get_lang_menu() {
//	$output_lang_menu = '';
//	if ( is_archive( 'course' ) or is_search() or is_singular( 'course' ) or is_singular( 'h_course' ) ) {
//		$lang_class = '';
//
//		$output_lang_menu .= '<div class="menu-language-menu-container">
//        <ul id="menu-language-menu-1" class="nav-lang">
//        <li id="wpml-ls-item-he" class="wpml-ls-menu-item wpml-ls-item-he ' . current_active_lang( 'he' ) . '"><a href="' . get_lang_url( 'he' ) . '"><span class="wpml-ls-native">עב</span></a></li>
//        <li id="wpml-ls-item-ar" class="wpml-ls-menu-item wpml-ls-item-ar ' . current_active_lang( 'ar' ) . '"><a href="' . get_lang_url( 'ar' ) . '"><span class="wpml-ls-native">العر</span></a></li>
//        <li id="wpml-ls-item-en" class="wpml-ls-menu-item wpml-ls-item-en ' . current_active_lang( 'en' ) . '"><a href="' . get_lang_url( 'en' ) . '"><span class="wpml-ls-native">En</span></a></li>
//        </ul></div>';
//	} else {
//		if ( has_nav_menu( 'lang_menu' ) ) :
//			wp_nav_menu( [ 'theme_location' => 'lang_menu', 'menu_class' => 'nav-lang' ] );
//		endif;
//	}
//	return $output_lang_menu;
//}

//get active lang with giving lang
function current_active_lang( $given_lang ) {
    global $sitepress;
    $language = $sitepress->get_current_language();
    $lang_class = '';
    if ( $language == $given_lang ) {
        $lang_class .= 'wpml-ls-current-language';
    }

    return $lang_class;
}

//get wpml lang with givin url
function get_lang_url( $lang ) {
    $base_url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'];
    $url      = $base_url . $_SERVER["REQUEST_URI"];
    $wpml_permalink = apply_filters( 'wpml_permalink', $url, $lang );
    return $wpml_permalink;
}

// pre get post
function wpsites_query( $query ) {
	if ( isset( $query->query['exclude_hidden_courses'] ) || ( ! is_admin() && ! $query->get( 'prevent_reorder' ) ) ) {
		if ( $query->is_main_query() ) {

			if ( is_post_type_archive( 'course' ) ) {
				$query->set( 'posts_per_page', courses_posts_per_page() );
				$query->set( 'orderby', "menu_order" );
				$query->set( 'order', 'DESC' );

				if ( $_GET && ! isset( $_GET['termid'] ) && ICL_LANGUAGE_CODE == 'he' ) {
					// טיפול במצב שמגיעים עם עמוד מסונן
					// כרגע קורה רק באתר בעברית
					global $get_params;
					$get_params = array();
					$tax_query  = array( 'relation' => 'AND' );
					foreach ( $_GET as $tax => $value ) {
						if ( strpos( '_' . $tax, 'filter_' ) > 0 ) {
							$tax                = substr( $tax, 7 );
							$value              = strpos( $value, ',' ) ? explode( ',', $value ) : array( $value );
							$get_params[ $tax ] = $value;
							if($tax == 'institution'){
								$meta = array(
									array(
										'key'     => 'org',
										'value'   => $value,
										'compare' => 'IN',
									),
								);
								$query->set( 'meta_query', $meta );

							} else {
								$tax_query[]        = array(
									'taxonomy' => $tax,
									'terms'    => $value,
									'field'    => 'term_id'
								);
							}
						}
					}
					$query->set( 'tax_query', $tax_query );
				}
			}
			if ( is_post_type_archive( 'event' ) ) {
				$query->set( 'posts_per_page', - 1 );
				$query->set( 'meta_query', array(
					'event_date' => array(
						'key'     => 'event_date',
						'compare' => 'EXISTS'
					)
				) );
				$query->set( 'orderby', "event_date" );
				$query->set( 'order', 'ASC' );
			}
			if ( $query->is_search ) {
				$query->set( 'post_type', 'course' );
				$query->set( 'posts_per_page', - 1 );
			}

			if ( isset( $_GET['termid'] ) && $query->get( 'post_type' ) == 'course' ) {
				$taxquery = array(
					array(
						'taxonomy' => 'tags_course',
						'field'    => 'id',
						'terms'    => fixXSS( $_GET['termid'] ),
					)
				);
				$query->set( 'tax_query', $taxquery );
			}
		}
		if ( $query->get( 'post_type' ) == 'course' || isset( $query->query['exclude_hidden_courses'] ) ) {
			if ( isset( $query->query['exclude_hidden_courses'] ) || ! is_single() || ! $query->is_main_query() ) {
				$meta       = $query->get( 'meta_query' );
				$meta_query = array(
					'relation' => 'AND',
					array(
						'relation' => 'OR',
						array(
							'key'     => 'campus_hide_in_site',
							'value'   => '0',
							'compare' => '=',
						),
						array(
							'key'     => 'campus_hide_in_site',
							'compare' => 'NOT EXISTS',
						)
					),
					$meta
				);
				$query->set( 'meta_query', $meta_query );
			}
		}
	}

	return $query;
}

add_action( 'pre_get_posts', 'wpsites_query' );

function fixXSS( $str ) {
	$str = strip_tags( $str );
	$str = str_replace( array( '"', "'", ')', '(', '<', '>', '&', ';', '%', '#', '@' ), '', $str );
	$str = htmlspecialchars( strip_tags( $str ), ENT_QUOTES, "UTF-8" );

	return $str;
}

//banner and text on banner area
function get_banner_area( $banner_for_mobile_output = false, $banner_fore_desctop_output, $text_on_banner_content_output, $class_output, $video_on_banner_output = false ) {

	$banner_output      = '';
	$url_banner_desctop = $banner_fore_desctop_output['url'];
	if ( $banner_for_mobile_output ) {
		$url_banner_mobile = $banner_for_mobile_output['url'];
	} else {
		$url_banner_mobile = $url_banner_desctop;
	}
	$breadcrumbs = '';
	if ( ! is_front_page() && ! is_tax() ) {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$breadcrumbs = yoast_breadcrumb( '<div aria-label="' . cin_get_str( "bread_crumbs" ) . '" class="' . $class_output . ' breadcrumbs-campus" id="breadcrumbs"><p class="container">', '</p></div>' );
		}
	}
	$banner_wrapper_class = $url_banner_desctop ? '' : 'no-image';
	$banner_output        .= '<div class="banner-wrapper ' . $class_output . ' ' . $banner_wrapper_class . '">';
	$banner_output        .= '<div class="gray-on-banner ' . $class_output . ' d-xs-none d-lg-inline-block"></div>';
	$banner_output        .= '<div class="banner-image ' . $class_output . ' d-none d-lg-inline-block" style="background-image: url(' . $url_banner_desctop . ')">' . $video_on_banner_output . '</div>';
	$banner_output        .= '<div class="background-on-banner ' . $class_output . '"><div class="container"><div class="text-on-banner ' . $class_output . ' centering-on-banner">';
	$banner_output        .= $text_on_banner_content_output;
	$banner_output        .= '</div></div></div>';
	$banner_output        .= '<div class="banner-image ' . $class_output . ' mobile d-sm-block d-lg-none d-xs-block" style="background-image: url(' . $url_banner_mobile . ')">' . $video_on_banner_output . '</div>';
	$banner_output        .= $breadcrumbs;
	$banner_output        .= '</div>';

	return $banner_output;
}

//get Academic institution calling this function
function get_academic_institution_slider( $academic_instit ) {
	$insitution_output     = '';
	$ul_institution_output = '<ul id="ul_academic_institution">';

	$insitution_output .= '<label for="right-button-slider-academic-institution" class="sr-only">' . __( 'next academic institutions', 'single_corse' ) . '</label>';
	$insitution_output .= '<label for="left-button-slider-academic-institution" class="sr-only">' . __( 'previous academic institutions', 'single_corse' ) . '</label>';
	$insitution_output .= '<div class="academic-institution" aria-hidden="true">';
	$insitution_output .= '<div class="container academic-inner">';
	$insitution_output .= '<div id="academic-institution-slider" aria-hidden="true" >';
	$logo_str          = cin_get_str( 'academic_logo' );
	foreach ( $academic_instit as $academic_institution ) {
		//print_r($academic_institution);
		$post_id           = $academic_institution->ID;
		$url_img_color     = get_the_post_thumbnail_url( $post_id );
		$icon_black        = get_field( 'icon_black', $post_id ) ? get_field( 'icon_black', $post_id ) : $url_img_color;
		$insitution_output .= '<div class="carousel-item">';
		$insitution_output .= '<a href="' . get_permalink( $post_id ) . '" aria-label="' . $academic_institution->post_title . '">
                                        <img aria-hidden="true" class="instit-item icon-black" src="' . $icon_black . '" alt="' . $academic_institution->post_title . '" >
                                        <img class="instit-item icon-color" src="' . $url_img_color . '">
                                    </a>';
		$insitution_output .= '</div>';

		$ul_institution_output .= '<li><a href="' . get_permalink( $post_id ) . '" tabindex="-1" arial-label="' . $logo_str . ' - ' . $academic_institution->post_title . '">' . $academic_institution->post_title . '</a></li>';
	}
	$insitution_output     .= '</div></div></div>';
	$ul_institution_output .= '</ul>';
	echo $ul_institution_output;

	return $insitution_output;
}

//get faq calling this function
function get_faq( $faq_title_output, $faq_objecr, $more_faq_link_output ) {
	$faq_output       = '';
	$string_more_faq_ = __( 'More Faq', 'single_corse' );
	$faq_output       .= '<div class="faq-section">';
	$faq_output       .= '<div class="container">';
	$faq_output       .= '<h3 aria-level="2" class="faq-title">' . $faq_title_output . '</h3>';
	$faq_output       .= '<div class="row faq-content" role="list">';
	foreach ( $faq_objecr as $faq_single ) {
		$faq_output .= '<div class="col-12 faq-item">';
		$faq_output .= '<h3 class="faq-question"><a aria-expanded="false"  href="javascript: void(0);" role="button" class="faq-title-inner" tabindex="0">' . wrap_text_with_char( $faq_single->post_title ) . '</a></h3>';
		$faq_output .= '<div class="faq-answer" >' . $faq_single->post_content . '</div>';
		$faq_output .= '</div>';
	}
	$faq_output .= '</div>';
	$faq_output .= '<div class="row justify-content-center">';
	$faq_output .= '<a class="more-faq" href="' . $more_faq_link_output . '">' . $string_more_faq_ . '</a>';
	$faq_output .= '</div>';
	$faq_output .= '</div></div>';

	return $faq_output;
}

//get how it works calling this function
function get_how_it_works( $how_it_works_title_output, $video_boxes_output ) {
	$how_it_works_output = '';
	$how_it_works_output .= '<div class="how-it-work-section" id="how-it-work">';
	$how_it_works_output .= '<div class="container how-it-work-section-inner">';
	$how_it_works_output .= '<div class="row">';
	$how_it_works_output .= '<h3 aria-level="2" class="title col-12">' . $how_it_works_title_output . '</h3>';
	$how_it_works_output .= '</div>';
	$how_it_works_output .= ' <div class="row boxes-items">';
	$level               = cin_get_str( 'level' );
	$index               = 1;
	foreach ( $video_boxes_output as $video_box ) {
		$link                = $video_box['you_tube_video'];
		$video_title         = $video_box['title'];
		$query_string        = array();
		$x                   = parse_str( parse_url( $link, PHP_URL_QUERY ), $query_string );
		$video_id            = $query_string["v"];
		$thumb               = "https://img.youtube.com/vi/$video_id/mqdefault.jpg";
		$aria_label          = "$level $index - $video_title";
		$how_it_works_output .= '<div class="col-lg-4 col-md-12  video_boxes_wrap video_boxes_wrap">';
		$how_it_works_output .= '<a aria-haspopup="true" role="button" data-popup data-classtoadd="youtube_popup" aria-label="' . $aria_label . '" href="javascript: void(0);" class="open_yt_lightbox open-popup-button" data-url="https://www.youtube.com/embed/' . $video_id . '?autoplay=0&controls=1&showinfo=0&autohide=1&rel=0&enablejsapi=1&wmode=transparent"">';
		$index               += 1;
		$how_it_works_output .= '<div class="you-tube-video has_background_image" style="background-image:' . 'url(' . $thumb . ')"></div>';
		$how_it_works_output .= '<div class="title-video-boxes">' . $video_title . '</div>';
		$how_it_works_output .= '</a>';
		$how_it_works_output .= '</div>';
	}
	$how_it_works_output .= '</div></div></div>';

	return $how_it_works_output;
}

function get_filtered_courses_masc( $courses_filter_term_output, $title_course_section_output ) {

	$final_output = '';
	$final_output .= '<div class="courses-section">';
	$final_output .= '<div class="container wrap-courses">';
	$final_output .= '<div role="heading" aria-level="2" class="row justify-content-center title-main-courses">' . $title_course_section_output . '</div>';
	$final_output .= '<div class="tags-courses-filter">';
	$final_output .= '<div class="tags-filter-items">';
	$final_output .= '<a  class="active link-data-filter" href="javascript:void(0)" data-filter="all" role="tab" aria-selected="true" aria-controls="TAB_COURSES">' . __( "All", "single_corse" ) . "</a>";
	foreach ( $courses_filter_term_output as $course_filter_term_home ) {
		$final_output .= '<a class="link-data-filter" href="javascript:void(0)" role="tab" aria-selected="false" aria-controls="TAB_COURSES" data-filter="' . $course_filter_term_home->term_id . '">' . $course_filter_term_home->name . '</a>';
	}
	$final_output .= '</div></div>';
	$final_output .= '<div class="courses-slick" role="tabpanel" id="TAB_COURSES" tabindex="0">REPLACEME</div>';
	$final_output .= '<div class="hidden" id="course_stock">REPLACEME</div>';
	$final_output .= '</div>';
	$final_output .= '<div class="all-courses-link">';
	$final_output .= '<a href="' . get_post_type_archive_link( "course" ) . '">' . __( "All Courses", "single_corse" ) . '</a>';
	if ( is_front_page() ) {
		$final_output .= '<a href="' . get_post_type_archive_link( "event" ) . '">' . cin_get_str( 'all_events' ) . '</a>';
	}

	$final_output .= '</div>';
	$final_output .= '</div></div>';

	return $final_output;
}

//get courses filter calling this function
function get_filtered_courses( $courses_filter_term_output, $title_course_section_output, $args, $posts = null ) {

	global $post;


	if ( $args ) {
		$args['exclude_hidden_courses'] = true;
		$query                          = new WP_Query( $args );
//        print_r($query);
		$posts = $query->posts;
	}
	if ( $posts ) {
		$courses_output = '';
		global $post;
		foreach ( $posts as $post ) {

			setup_postdata( $post );
			$terms_tags_filter = wp_get_post_terms( $post->ID, 'tag_filter', array( 'fields' => 'all' ) );

			$str = ',all,';
			foreach ( $terms_tags_filter as $tags ) {
				$str .= $tags->term_id . ',';
			}

			$attrs          = array(
				'filters' => 'data-filter="' . $str . '"',
				'class'   => ' '
			);
			$func_name      = 'draw_' . $post->post_type . '_item';
			$courses_output .= $func_name( $attrs );
		}
		wp_reset_query();
	}

	$output = get_filtered_courses_masc( $courses_filter_term_output, $title_course_section_output );
	$output = str_replace( 'REPLACEME', $courses_output, $output );

	return $output;

}

function draw_course_item( $attrs ) {
	global $post;
	$output = '';
	$org    = $attrs['org'] ? $attrs['org'] : get_field( 'org' );

	$marketing_feature = $attrs['marketing'] ? $attrs['marketing'] : get_field( 'marketing_feature' );
	$marketing_feature = $marketing_feature ? $marketing_feature->name : ( $attrs['hybrid_course'] ? cin_get_str( 'hybrid_badge' ) : '' );

	$duration             = get_field( 'duration' );
	$haveyoutube          = get_field( 'course_video' );
	$url_course_img_slick = ( get_the_post_thumbnail_url( get_the_ID() ) ) ? get_the_post_thumbnail_url( get_the_ID(), 'medium' ) : site_url() . '/wp-content/uploads/2018/10/asset-v1JusticeJustice0012017_1type@assetblock@EDX3.png';
	if ( $haveyoutube ) {
		$haveyoutube = "haveyoutube";
		$data_popup  = "data-popup";
		$image_html  = '<a class="course-item-image has_background_image ' . $haveyoutube . '" data-id="' . $post->ID . '"' . $data_popup . ' aria-pressed="true" aria-haspopup="true" role="button" href="javascript:void(0)" aria-label="' . wrap_text_with_char( $post->post_title ) . '" data-classToAdd="course_info_popup" style="background-image: url(' . $url_course_img_slick . ');"></a>';
	} else {
		$haveyoutube = "donthaveyoutube";
		$data_popup  = "";
		$image_html  = '<div class="course-item-image has_background_image ' . $haveyoutube . '" data-id="' . $post->ID . '"' . $data_popup . '   data-classToAdd="course_info_popup" style="background-image: url(' . $url_course_img_slick . ');"></div>';
	}
	$attrs['class'] .= $attrs['hybrid_course'] ? ' hybrid_course' : '';
	$output         .= '<div class="item_post_type_course course-item ' . $attrs['class'] . '" data-id="' . $post->ID . '" ' . $attrs['filters'] . '><div class="course-item-inner">';
	$output         .= $image_html;
	$output         .= '<a class="course-item-details" tabindex="0" href="' . get_permalink( $post->ID ) . '">
                <h3 class="course-item-title">' . wrap_text_with_char( $post->post_title ) . '</h3>';
	if ( $org ) {
		$output .= '<p class="course-item-org">' . $org->post_title . '</p>';
	}
	if ( $duration ) {
		$output .= '<div class="course-item-duration">' . __( $duration, 'single_corse' ) . '</div>';
	}
	if ( $marketing_feature ) {
		$output .= '<div class="course-item-marketing">';
		$output .= '' . $marketing_feature . '</div>';
	}
	$output .= '<div class="course-item-link">
                    <span>' . cin_get_str( 'Course_Page' ) . '</span>
                </div>
            </a></div></div>';

	return $output;
}

function draw_event_item( $attrs = array() ) {
	global $post;
	$class = $attrs['class'] ? $attrs['class'] : 'col-xs-12 col-md-6 col-xl-3 course-item-with-border';
	$title = $post->post_title;
	$link  = get_permalink();
	$id    = $post->ID;
	$thumb = get_the_post_thumbnail_url( $id );
//    $thumb = $thumb ? $thumb : site_url() . '/wp-content/uploads/2018/10/asset-v1JusticeJustice0012017_1type@assetblock@EDX3.png';
	$event_fields = get_fields( $id );
	$date_str     = get_event_date( $event_fields['event_date'], $event_fields['event_time'] );

	$type      = $event_fields['event_type'];
	$type_name = $type->name;
	$type_img  = get_field( 'term_img', $type );

	$haveyoutube = get_field( 'course_video' );
	if ( $haveyoutube ) {
		$haveyoutube = "haveyoutube";
		$data_popup  = "data-popup";
		$event_image = "<a class='course-item-image has_background_image open-popup-button $haveyoutube' data-id='$id' data-post_type='event' aria-pressed='true' aria-haspopup='true' role='button' href='javascript:void(0)' $data_popup data-classToAdd='course_info_popup' style='background-image: url($thumb);'></a>";
	} else {
		$event_image = "<span class='course-item-image has_background_image open-popup-button donthaveyoutube' data-post_type='event' style='background-image: url($thumb);'></span>";
	}

	$type_img = $type_img ? "<img src='$type_img' alt='$type_name' class='event_thumb_type_img' />" : '';

	$output = "<div class='item_post_type_event course-item {$attrs['hidden']} $class' {$attrs['filters']} data-id='$id'>
           <div class='course-item-inner'>
                $event_image
               <a class='course-item-details' href='$link'>
                    <h3 class='course-item-title'>$title</h3>
                    <div class='course-item-duration'>$date_str</div>
                    <div class='course-item-link'>
                        <span>" . cin_get_str( 'to_event_page' ) . "</span>
                    </div>
                    $type_img
                </a>
            </div>
        </div>";

	return $output;
}

//get courses filter from search page
function get_courses_search_filter( $query, $filters_list, $academic_filter, $list = null ) {
	// 28/6 - Hanniek - Change the logic. they choose taxonomies in a flexible field
	// For every chosen tax - they also choose it's order type.
	// Only chosen tax will be in the sidebar.

	$all_names = array();
//
	$academic = array(
		'field_name' => 'academic_institution',
		'name'       => cin_get_str( 'Institution_Name' ),
		'terms'      => array()
	);
	foreach ( $filters_list as $filter ) {
		switch ( $filter['taxonomy'] ) {
			case 'tags_knowledge':
				$all_names['tags_knowledge'] = array(
					'field_name' => 'tags_knowledge',
					'name'       => __( 'Field Of Knowledge', 'single_corse' ),
					'orderby'    => $filter['order_type'],
					'order_type' => $filter['acf_fc_layout'],
					'items'      => $filter['terms_list'],
					'terms'      => array()
				);
				break;
			case 'course_duration':
				$all_names['course_duration'] = array(
					'field_name' => '',
					'name'       => cin_get_str('course_duration_filter_title'),
					'orderby'    => $filter['order_type'],
					'order_type' => $filter['acf_fc_layout'],
					'items'      => $filter['terms_list'],
					'terms'      => array()
				);
				break;
			case 'age_strata':
				$all_names['age_strata'] = array(
					'field_name' => 'age_strata',
					'name'       => __( 'Age Strata', 'single_corse' ),
					'orderby'    => $filter['order_type'],
					'order_type' => $filter['acf_fc_layout'],
					'items'      => $filter['terms_list'],
					'terms'      => array()
				);
				break;
			case 'skill':
				$all_names['skill'] = array(
					'field_name' => 'skill',
					'name'       => __( 'Skill', 'single_corse' ),
					'orderby'    => $filter['order_type'],
					'order_type' => $filter['acf_fc_layout'],
					'items'      => $filter['terms_list'],
					'terms'      => array()
				);

				break;
			case 'areas_of_knowledge':
				$all_names['areas_of_knowledge'] = array(
					'field_name' => 'knowledge',
					'name'       => __( 'Learning Target', 'single_corse' ),
					'orderby'    => $filter['order_type'],
					'order_type' => $filter['acf_fc_layout'],
					'items'      => $filter['terms_list'],
					'terms'      => array()
				);
				break;
			case 'subject':
				$all_names['subject'] = array(
					'field_name' => 'subject_of_daat',
					'name'       => __( 'Subject', 'single_corse' ),
					'orderby'    => $filter['order_type'],
					'order_type' => $filter['acf_fc_layout'],
					'items'      => $filter['terms_list'],
					'terms'      => array()
				);
				break;
			case 'language':
				$all_names['language'] = array(
					'field_name' => 'language_course',
					'name'       => __( 'Language', 'single_corse' ),
					'orderby'    => $filter['order_type'],
					'order_type' => $filter['acf_fc_layout'],
					'items'      => $filter['terms_list'],
					'terms'      => array()
				);
				break;
			case 'tags_course':
				$all_names['tags_course'] = array(
					'field_name' => 'tags',
					'name'       => __( 'Courses Tags', 'single_corse' ),
					'orderby'    => $filter['order_type'],
					'order_type' => $filter['acf_fc_layout'],
					'items'      => $filter['terms_list'],
					'terms'      => array()
				);
				break;
		}
	}
	//get banner if entered from term id (in url)
//print_r($query);
	$output_courses = '';
	$i              = 0;
	global $post;
	while ( $query->have_posts() ) : $query->the_post();

		$post_fields = get_fields();

		$more_posts_id     = $post->ID;
		$more_posts_org    = $post_fields['org'];
		$more_posts_org_id = icl_object_id( $more_posts_org->ID, 'post', false, ICL_LANGUAGE_CODE );

		$more_posts_duration          = $post_fields['duration'];
		$more_posts_marketing_feature = $post_fields['marketing_feature'];
		$more_posts_thumbnail_url     = ( get_the_post_thumbnail_url( $more_posts_id ) ) ? get_the_post_thumbnail_url( $more_posts_id ) : site_url() . '/wp-content/uploads/2018/10/asset-v1JusticeJustice0012017_1type@assetblock@EDX3.png';
		$start                        = $post_fields['start'];

		$post_terms_arr = array();
		$popularity     = $post->menu_order;

		foreach ( $all_names as $tax => $value ) {
			$values = $tax == 'course_duration' ? get_the_terms($post->ID, 'course_duration') : $post_fields[ $value['field_name'] ];
			if ( $values ) {
				if ( is_array( $values ) ) {
					//print_r($values);
					foreach ( $values as $each_val ) {
						$post_terms_arr[ $tax ] = $post_terms_arr[ $tax ] . $each_val->term_id . ',';
						if ( $tax == 'tags_course' ) {
							$name                                                          = ICL_LANGUAGE_CODE == 'en' ? $each_val->name : ( ICL_LANGUAGE_CODE == 'he' ? get_field( 'translate_title_hebrew', $each_val->taxonomy . '_' . $each_val->term_id ) : get_field( 'translate_title_arab', $each_val->taxonomy . '_' . $each_val->term_id ) );
							$all_names[ $tax ]['terms'][ $each_val->term_id ]['term_name'] = $name;
						} else {
							$all_names[ $tax ]['terms'][ $each_val->term_id ]['term_name'] = $each_val->name;
						}
						$all_names[ $tax ]['terms'][ $each_val->term_id ]['term_id']    = $each_val->term_id;
						$all_names[ $tax ]['terms'][ $each_val->term_id ]['sum']        = $all_names[ $tax ]['terms'][ $each_val->term_id ]['sum'] + 1;
						$all_names[ $tax ]['terms'][ $each_val->term_id ]['popularity'] += $popularity;
					}
				} else {
					$post_terms_arr[ $tax ]                                       = $post_terms_arr[ $tax ] . $values->term_id . ',';
					$all_names[ $tax ]['terms'][ $values->term_id ]['term_id']    = $values->term_id;
					$all_names[ $tax ]['terms'][ $values->term_id ]['term_name']  = $values->name;
					$all_names[ $tax ]['terms'][ $values->term_id ]['sum']        = $all_names[ $tax ]['terms'][ $values->term_id ]['sum'] + 1;
					$all_names[ $tax ]['terms'][ $values->term_id ]['popularity'] += $popularity;
				}
			}
		}
//var_dump($all_names);
		$post_terms_str = '';
		foreach ( $post_terms_arr as $key => $value ) {
			$post_terms_str .= " data-$key=',$value'";
		}
		//more_posts_org_lang = get_post($more_posts_org_id);
		if ( is_object( $more_posts_org ) && $more_posts_org_id == $more_posts_org->ID ) {
			if ( ! empty( $more_posts_org ) ) {
				$academic['terms'][ $more_posts_org->ID ]['term_id']   = $more_posts_org->ID;
				$academic['terms'][ $more_posts_org->ID ]['term_name'] = $more_posts_org->post_title;
				$academic['terms'][ $more_posts_org->ID ]['sum']       = $academic['terms'][ $more_posts_org->ID ]['sum'] + 1;
			}
		}
		if ( $i > 14 ) {
			$hidden = 'hidden_loadmore';
		} else {
			$hidden = '';
		}
//        $output_courses .= '<div ' . $post_terms_str . ' class="' . $hidden . '  course-item-search course-item-inner" data-institution=",' . $more_posts_org_id . '," data-menu_order="' . $i . '" data-date="' . strtotime($start) . '">
//        ';
		$post_terms_str .= 'data-institution=",' . $more_posts_org_id . '," data-menu_order="' . $i . '" data-date="' . strtotime( $start ) . '"';
		$course_attrs   = array(
			'hidden'  => $hidden,
			'class'   => 'col-xs-12 col-md-6 col-xl-4 course-item-with-border',
			'filters' => $post_terms_str
		);
		$output_courses .= draw_course_item( $course_attrs );
		$i ++;
	endwhile;
//	print_r($all_names);

	wp_reset_postdata();

	$output_tags_button = '';
	$output_terms       = '';
	$output_terms       .= '
    <form class="wrap-all-tags-filter">
    	<input type="hidden" name="s" value="'. fixXSS($_GET['s']) .'" />
    	<input type="hidden" name="termid" value="'. fixXSS($_GET['termid']) .'" />
        <div class="wrap-mobile-filter-title">
            <button id="close-nav-search" class="close-nav-search" type="button"></button>
            <p class="filter-title-mobile">' . __( 'Filter Courses', 'single_corse' ) . '</p>';
// print_r($academic);

	// המרת התגיות מעברית לשפות האחרות
	global $sitepress;
	$current_lang = $sitepress->get_current_language();

	if ( $academic['terms'] ) {
		$tmp_select = $tmp_checkbox = '';
		$checkbox   = '';

		$excluded_json = json_decode( $academic_filter );

		if ( $current_lang != 'he' ) {
			$list = array();
			foreach ( $excluded_json->items as $he_item ) {
				$id     = icl_object_id( $he_item, 'page', false, ICL_LANGUAGE_CODE );
				$list[] = $id;
			}
			$excluded_json->items = $list;
		}

		foreach ( $excluded_json->items as $key ) {
			if ( isset( $academic['terms'][ $key ] ) ) {
				$value        = $academic['terms'][ $key ];
				$tmp_select   .= '<option class="academic-option-item" value="' . $key . '">' . $value['term_name'] . '</option>';
				$tmp_checkbox .= '<div class="wrap-filter-search">';
				$tmp_checkbox .= '<label class="term-filter-search" for="institution_' . $key . '">';
				$tmp_checkbox .= '<input class="checkbox-filter-search" type="checkbox" data-name="institution" name="filter_institution[]" value="' . $key . '" id="institution_' . $key . '">';
				$tmp_checkbox .= '<div class="wrap-term-and-sum" ><span class="term-name">' . $value["term_name"] . '</span>';
				$tmp_checkbox .= '<span class="sum"></span></div></label></div>';
			}
		}
		if ( $tmp_select ) {
			$output_terms .= '<div class="wrap-terms-group wrap-terms-institution">
                <h2 class="search-page-tax-name">' . $academic['name'] . '</h2>
                <select multiple class="sr-only selected-academic" data-name="' . $academic['field_name'] . '">
                    <option>' . __( 'Choose Institution', 'single_corse' ) . '</option>
                    ' . $tmp_select . '
                </select>
                <button role="combobox" aria-expanded="false" data-original="' . __( 'Choose Institution', 'single_corse' ) . '" type="button" class="filter_main_button dropdown_open">
                    ' . __( 'Choose Institution', 'single_corse' ) . '
                </button>
                <div class="wrap-checkbox_institution wrap-terms-group">' . $tmp_checkbox . '</div>
            </div>';
		}
	}
	$output_terms .= '
            <a href="javascript: void(0);" class="clear-link" role="button" id="clear_all_filters">' . __( 'Clear All', 'single_corse' ) . '</a></div>';
	foreach ( $all_names as $tax => $value ) {
		$tmp_select = '';
		if ( count( $value['terms'] ) > 0 ) {
			$index = 1;

			$excluded_json = json_decode( $value['items'] );

			if ( $current_lang != 'he' ) {
				$list = array();
				foreach ( $excluded_json->items as $he_item ) {
					$id     = icl_object_id( $he_item, $tax, false, ICL_LANGUAGE_CODE );
					$list[] = $id;
				}

				$excluded_json->items = $list;
			}
			if ( $value['order_type'] == 'automatic_order' ) {
				switch ( $value['orderby'] ) {
					case 'alphabet':
						usort( $value['terms'], function ( $a, $b ) {
							return $a['term_name'] <=> $b['term_name'];
						} );
						break;
					case 'amount':
						usort( $value['terms'], function ( $a, $b ) {
							return $b['sum'] <=> $a['sum'];
						} );
						break;
					case 'popularity':
						usort( $value['terms'], function ( $a, $b ) {
							return $b['popularity'] <=> $a['popularity'];
						} );
						break;
				}
				foreach ( $value['terms'] as $details ) {
					if ( ! in_array( $details['term_id'], $excluded_json->items ) ) {
						$tmp_select .= draw_filter_item( $tax, $details['term_id'], $details, $index );
						$index ++;
					}
				}
			} else { // בחירת פריטים באופן ידני

				foreach ( $excluded_json->items as $term_id ) {

					if ( isset( $value['terms'][ $term_id ] ) ) {
						$details    = $value['terms'][ $term_id ];
						$tmp_select .= draw_filter_item( $tax, $term_id, $details, $index );
						$index ++;
					}
				}
			}
			if ( $tmp_select ) {
				$output_terms .= '
                <div class="wrap-terms-group">
                    <h2 class="search-page-tax-name">' . $value["name"] . '</h2>
                    <div class="more-tags" role="list">
                        ' . $tmp_select . '
                    </div>
                </div>';
			}
		}
		if ( count( $value['terms'] ) > 7 ) {
			$output_terms .= '<button class="show-more-tags collapsed"><span>' . __( 'Show More Tags', 'single_corse' ) . '</span>
        <span>' . __( 'Show Less Tags', 'single_corse' ) . '</span></button>';

		}
	}
	$output_terms .= '<div class="wrap-button-filter"><button class="search-close-button d-md-none d-xs-block">' . __( 'Show Courses', 'single_corse' ) . '</button></div></form>';

	return array(
		'courses' => $output_courses,
		'aside'   => $output_terms
	);
}

function draw_filter_item( $tax, $term_id, $details, $index ) {
	$output_terms = '';
	if ( $index == 7 ) {
		$access = 'data-accessibility-2020';
	} else {
		$access = '';
	}
//	$checked = in_array($_GET[''])
	$output_terms .= '<div class="wrap-filter-search" ' . $access . ' >';
	$output_terms .= '<label class="term-filter-search" for="' . $tax . "_" . $term_id . '">';
	$output_terms .= '<input class="checkbox-filter-search" type="checkbox" data-name="' . $tax . '" name="filter_' . $tax . '[]" value="' . $term_id . '" id="' . $tax . "_" . $term_id . '">';
	$output_terms .= '<div class="wrap-term-and-sum" ><span class="term-name">' . $details["term_name"] . '</span>';
	$output_terms .= '
<span class="sum">(' . $details["sum"] . ')</span>
<span class="sum hidden">(' . $details["popularity"] . ')</span>
</div></label></div>';

	return $output_terms;
}

@ini_set( 'upload_max_size', '64M' );
@ini_set( 'post_max_size', '64M' );
@ini_set( 'max_execution_time', '300' );
//get courses from edex with API
//function get_and_insert_Courses_from_edx(){
//
//    $ch = curl_init();
//    $link = 'https://campus.gov.il/api/courses/v1/courses/';
//    $data = array("course_id" => "course-v1:edX+DemoX+Demo_Course");
//    $data_string = json_encode($data);
//    // set url
//    curl_setopt($ch, CURLOPT_URL, $link);
//
//    //return the transfer as a string
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    $all_courses = curl_exec($ch);
//    $result = json_decode($all_courses, true);
//    // close curl resource to free up system resources
//    curl_close($ch);
//
//    $res = $result['results'];
//
//    echo "<pre>";
//
//    print_r($res);
//    echo "</pre>";
//    $value = $res[0];
//   foreach ($res as $value) {
//    //print_r($value['name']);
//
//        $course_id = $value['id'];
//        $course_title = $value['name'];
//        $short_description = $value['short_description'];
//        $thumbnail_image = $value['media']['image']['small'];
//        $trailer = $value['media']['course_video']['uri'];
//        $start = $value['start'];
//        $end = $value['end'];
//        $pacing = $value['pacing'];
//        $org = $value['org'];
//        $mobile_available = $value['mobile_available'];
//        $enrollment_start = $value['enrollment_start'];
//        $enrollment_end = $value['enrollment_end'];
//        $blocks_url = $value['blocks_url'];
//
//        $args = array(
//            'post_type' => 'course',
//            'meta_query' => array(array(
//                'key' => 'course_id_edx',
//                'value' => $course_id,
//                'compare' => '=',
//            ))
//        );
//        $tttt = get_posts($args);
//        if($tttt[0]){ // בדיקה שמחזירה true במידה ונמצא פוסט במערכת התואם לID של הקורס הנוכחי בJSON
//            // echo 'post already exist';
//            $my_course = $tttt[0]->ID;
//            wp_update_post(array(
//                'ID' => $my_course,
//                'post_title' => $course_title
//            ));
//        }else{
//
//            $my_course = wp_insert_post(array(
//                'post_title' => $course_title,
//                 //'post_status' => 'publish',
//                'post_type' => 'course',
//                'post_excerpt' => $short_description,
//
//            ));
//        }
//       // set_post_thumbnail( $my_course, $thumbnail_id );
//       // var_dump($course_id);
//        update_field('course_id_edx', $course_id, $my_course);
//        update_field('course_video', $trailer, $my_course);
//        update_field('start', $start, $my_course);
//        update_field('end', $end, $my_course);
//        update_field('pacing', $pacing, $my_course);
//        update_field('org', $org, $my_course);
//        update_field('mobile_available', $mobile_available, $my_course);
//        update_field('enrollment_start', $enrollment_start, $my_course);
//        update_field('enrollment_end', $enrollment_end, $my_course);
//        update_field('blocks_url', $blocks_url, $my_course);
//
//
//            try {
//                $thumbnail_id = crb_insert_attachment_from_url($thumbnail_image);
//                if($thumbnail_id)
//                    set_post_thumbnail($my_course, $thumbnail_id);
//            } catch (Exception $e) {
//                echo 'Caught exception: ',  $e->getMessage(), "\n";
//            }
//        }
//    }

function crb_insert_attachment_from_url( $url, $post_id = null ) {

	//echo $url;
	if ( ! class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC . '/class-http.php' );
	}

	$http     = new WP_Http();
	$response = $http->request( $url );
	if ( $response['response']['code'] != 200 ) {
		return false;
	}

	$upload = wp_upload_bits( basename( $url ), null, $response['body'] );
	if ( ! empty( $upload['error'] ) ) {
		return false;
	}

	$file_path        = $upload['file'];
	$file_name        = basename( $file_path );
	$file_type        = wp_check_filetype( $file_name, null );
	$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
	$wp_upload_dir    = wp_upload_dir();

	$post_info = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
		'post_mime_type' => $file_type['type'],
		'post_title'     => $attachment_title,
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	// Create the attachment
	$attach_id = wp_insert_attachment( $post_info, $file_path, $post_id );

	// Include image.php
	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

	// Assign metadata to attachment
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;

}


//03/06/2020 new version popups

add_action( 'site_popups', function () {
	$output = '<div id="popup_2020" aria-modal="true" role="dialog" aria-hidden="true">
            <button aria-label="close" class="close-popup-button-2020" role="button" tabindex="0"></button>
            <div class="div_wrap_iframe_2020">
            <iframe width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
            </div>
            </div>';
	echo $output;

} );

//End 03/06/2020 new version popups

function print_date_export( $date ) {
	$createDate = new DateTime( $date );
	$strip      = $createDate->format( 'Y-m-d' );

	return $strip;
}

function get_event_date( $event_date, $event_time, $show_day = false ) {
	$time           = ' | ' . $event_time;
	$today          = strtotime( date( 'm/d/Y' ) );
	$tomorrow       = $today + ( 60 * 60 * 24 );
	$date           = strtotime( $event_date );
	$formatted_date = date( 'd/m/Y', $date );
	switch ( $date ) {
		case $today:
			$str = __( 'Today', 'single_corse' ) . $time;
			break;
		case $tomorrow:
			$str = __( 'Tomorrow', 'single_corse' ) . $time;
			break;
		default:
			if ( $date > $today ) {
				$str = $show_day ? get_day_in_week( date( 'w', $date ) ) . ' | ' . $formatted_date : $formatted_date;
				$str .= $time;
			} else {
				$lang = get_current_lang();
				$str  = get_field( 'past_event_msg_' . $lang, 'events_global_settings' );
			}
	}

	return $str;
}

function get_day_in_week( $day_num ) {
	$arr = array(
		__( 'Sunday', 'single_corse' ),
		__( 'Monday', 'single_corse' ),
		__( 'Tuesday', 'single_corse' ),
		__( 'Wednesday', 'single_corse' ),
		__( 'Thursday', 'single_corse' ),
		__( 'Friday', 'single_corse' ),
		__( 'Saturday', 'single_corse' ),
	);

	return $arr[ $day_num ];
}

add_filter( 'auto_update_plugin', '__return_false' );


function get_course_strtotime( $date_str ) {

	$arr = explode( '/', $date_str );
	$new = $arr[1] . '/' . $arr[0] . '/' . $arr[2];

	return strtotime( $new );
}

function wrap_text_with_char( $text, $char = '%' ) {
	// הפונקציה הזו מקבלת סטרינג ומחזירה אותו עם מעבר שורות בעת סימן %
	// אפשר לשלוח כפרמטר סימן אחר שהוא מגדיר חיתוך טקסט
	return str_replace( '%', '<div style="display: block;"></div>', $text );
}

add_action('wp_head', function(){
    if(is_single())
        if($keys = get_field('meta_keywords')) {
            echo "
    <meta property=\"keywords\" content=\"$keys\" />
";
        }
}, 1);

function new_search_placeholder() {
    global $sitepress;
    $current = $sitepress->get_current_language();
    $placeholder = 'חיפוש קורס';
    if ($current === 'en') {
        $placeholder = 'Search Course';
    }
    if ($current === 'ar') {
        $placeholder = 'البحث عن الدورة';
    }

    return $placeholder;
}

function hero_search_placeholder() {
    global $sitepress;
    $current = $sitepress->get_current_language();
    $placeholder = 'מה נרצה ללמוד היום?';
    if ($current === 'en') {
        $placeholder = 'What we want to learn today?';
    }
    if ($current === 'ar') {
        $placeholder = 'ما نريد أن نتعلمه اليوم?';
    }
    return $placeholder;
}

function course_popup_button_text() {
    global $sitepress;
    $current = $sitepress->get_current_language();
    $text = 'מעבר לעמוד הקורס';
    if ($current === 'en') {
        $text = 'Go to the course page';
    }
    if ($current === 'ar') {
        $text = 'اذهب إلى صفحة الدورة';
    }
    return $text;
}

function more_courses_text($carousel) {
    global $sitepress;
    $current = $sitepress->get_current_language();
    $text = '';
    if ($current === 'he') {
        $text .= 'לקטלוג הקורסים';
//            $text .= 'הצג  את ';
//            $text .= count($carousel);
//            $text .= ' הקורסים';
        }
    if ($current === 'en') {
        $text .= 'Course Catalog';
//            $text .= 'View the ';
//            $text .= count($carousel);
//            $text .= ' courses';
        }
    if ($current === 'ar') {
        $text .= 'كتالوج الدورة';
//            $text .= 'استعرض ';
//            $text .= count($carousel);
//            $text .= ' دورات';
        }

    return $text;
}

function getFieldByLanguage($heField, $enField, $arField, $lang)
{

    if($lang == "en" && $enField && $enField != "")
        return $enField;
    elseif ($lang == "ar" && $arField && $arField != "" )
        return $arField;
    else
        return $heField;

}

function getFieldByLanguageFromString($strField, $lang)
{
    try {
        $fieldLanguageArray = explode(',', $strField);
        if(count($fieldLanguageArray) != 3)
            return null;
        // TODO trim
        $language_course = $fieldLanguageArray ? getFieldByLanguage($fieldLanguageArray[0], $fieldLanguageArray[1], $fieldLanguageArray[2], $lang) : null;
        return $language_course;
    }
    catch (exception $e) {
        //code to handle the exception
        return null;
    }

}


function disallow_posts_with_same_title($messages) {

    global $post;

    global $wpdb ;

    $title = $post->post_title;

    $post_id = $post->ID ;

    $wtitlequery = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'stripes' AND post_title = '{$title}' AND ID != {$post_id} " ;

    $wresults = $wpdb->get_results( $wtitlequery) ;

    if ( $wresults ) {

        $error_message = 'This Stripe title is already used. Please choose another';

        add_settings_error('post_has_links', ”, $error_message, 'error');

        settings_errors( 'post_has_links' );

        $post->post_status = 'draft';

        wp_update_post($post);

        return;

    }

    return $messages;

}

add_action('post_updated_messages', 'disallow_posts_with_same_title');


// Remove Stripes row actions
function remove_row_actions_post( $actions ){
    if( get_post_type() === 'stripes' )
        return array();

}
add_filter( 'post_row_actions', 'remove_row_actions_post', 10, 1 );


// Remove ability to trash Stripes
function my_custom_admin_styles() {
    ?>
    <style type="text/css">
        .post-type-stripes form #delete-action{
            display:none;
        }
    </style>
    <?php
}
add_action('admin_head', 'my_custom_admin_styles');

function sortTagsByOrder($tags){
    usort($tags, "CompareTagsByOrder");
    return $tags;
}

function CompareTagsByOrder($tag1, $tag2) {
    return $tag2['order'] > $tag1['order'];
}

function replace_first_str($search_str, $replacement_str, $src_str){
    return (false !== ($pos = strpos($src_str, $search_str))) ? substr_replace($src_str, $replacement_str, $pos, strlen($search_str)) : $src_str;
}

