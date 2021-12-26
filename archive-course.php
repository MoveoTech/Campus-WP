<?php

global $site_settings, $field;

$form_short_code_sidebar = $site_settings['form_short_code_sidebar'];
//print_r($site_settings);
//    //קטגוריות שלא יראו בפילטר של הסיידבר של הקורסים ותמיד כן מופיעות
//    $categories_not_show_filter = array();
// //קטגוריות שיראו בפילטר של הסיידבר של הקורסים ותמיד לא  מופיעות
//    $categories_show_filter = array();
$server_side = is_post_type_archive( 'course' );
if ( ( isset( $_GET['termid'] ) ) ) {
	$server_side = false;


	$tax_obj = get_term_by( 'id', $_GET['termid'], 'tags_course' );
	$field   = get_fields( $tax_obj );

	$filters_list    = $field['filters_list'];
	$academic_filter = $field['campus_order_academic_institutions_list'];

	//ברמת הTag course מזין אלו קטגוריות לא יראו בפילטור
	$categories_not_show_filter = $field['categories_not_show_filter'];
	// ברמת הTag course מזין אלו קטגוריות יראו ספציפית ותמיד לא מופיעות
	$categories_show_filter = $field['categories_show_filter'];

	$banner                     = $field['banner_search_tag'];
	$banner_mobile              = $field['banner_mobile_search_tag'];
	$text_on_banner_search_page = ICL_LANGUAGE_CODE == 'en' ? $field['text_on_banner_search_page'] : ( ICL_LANGUAGE_CODE == 'he' ? $field['translate_text_on_banner_hebrew'] : $field['translate_text_on_banner_arab'] );
	$name                       = ICL_LANGUAGE_CODE == 'en' ? $tax_obj->name : ( ICL_LANGUAGE_CODE == 'he' ? $field['translate_title_hebrew'] : $field['translate_title_arab'] );


	$banner_title = ICL_LANGUAGE_CODE == 'en' ? wrap_text_with_char( $field['banner_title_en'] ) : ( ICL_LANGUAGE_CODE == 'he' ? wrap_text_with_char( $field['banner_title_he'] ) : wrap_text_with_char( $field['banner_title_ar'] ) );

	if ( $banner_title != "" ) {
		$name = $banner_title;
	}

	$title = '';
	if ( $text_on_banner_search_page ) {
		$title = '<div class="sub-title-banner-term-tag">' . str_replace( '%', '<span class="span-brake"></span>', $text_on_banner_search_page ) . '</div>';
	}

	$class                  = 'search-tags';
	$text_on_banner_content = '';
	$text_on_banner_content .= '<h1 class="title-opacity-on-banner">' . $name . '</h1>';
	$text_on_banner_content .= $title;

	echo get_banner_area( $banner_mobile, $banner, $text_on_banner_content, $class );


	add_action( 'wp_footer', function () {
		global $event_id_for_popup, $field;
		$val                = $field['event_id_he'];
		$event_id_for_popup = ICL_LANGUAGE_CODE == 'he' ? $val : icl_object_id( $val, 'page', false, ICL_LANGUAGE_CODE );
		get_template_part( 'templates/event_popup' );
	} );
} else {
	$filters_list    = get_field( 'filters_list', 'courses_index_settings' );
	$academic_filter = get_field( 'campus_order_academic_institutions_list', 'courses_index_settings' );
}
if ( is_search() && ! have_posts() ) :
	$args        = array(
		'post_type'      => 'course',
		'post_status'    => 'publish',
		'posts_per_page' => - 1,
		'post__in'       => $site_settings['no_results_found_courses']
	);
	$wp_query    = new WP_Query( $args );
	$server_side = true;

	$visible                 = 15;
	$form_short_code_sidebar = '';
	$no_results_found        = true;

else :
	global $wp_query;

	$visible                   = 15;
	$form_short_code_no_result = '';
	$form_short_code_sidebar   = $site_settings['form_short_code_sidebar'];

	// Banner with Breadcrumbs
	if ( empty( $_GET['termid'] ) ) {
		$class                  = 'search-course background-instead-banner';
		$text_on_banner_content = '';
		$text_on_banner_content .= '<h1>' . __( 'Courses', 'single_corse' ) . '</h1>';

		echo get_banner_area( $banner_for_mobile = false, $banner = false, $text_on_banner_content, $class );
	}


endif;

if ( $server_side && ICL_LANGUAGE_CODE == 'he' ) {
	$strings   = get_courses_search_filter_server_side( $wp_query, $filters_list, $academic_filter );
	$title_str = cin_get_str( 'filter_courses_title_ajax' );
	$my_class = "ajax_filter";
} else {
	$strings   = get_courses_search_filter( $wp_query, $filters_list, $academic_filter );
	$title_str = cin_get_str( 'filter_courses_title_no_ajax' );
	$my_class = "no_ajax_filter";
}
$count       = $wp_query->found_posts;
$courses_str = $strings['courses'];
$aside_str   = $strings['aside'];
echo '<div class="wrap-search-page-course '. $my_class .'">
    <div class="container">
        <div class="row justify-content-end">
            <div class="search-course-form col-lg-3">';
get_search_form();
echo '</div>
        </div>
        <div class="row justify-content-between">
            <aside class="col-xs-12 col-md-12 col-lg-3 col-xl-3 col-sm-12 sidebar-search-course">
                <div class="wrap-all-filter-names">
                    <div class="clear-filter-area">
                            <span class="filter-course-title" role="heading" aria-level="2">' . $title_str . '</span>
                    </div>' . $aside_str . '</div>
                <div class="lokking-for-form">' . $form_short_code_sidebar . '</div>
            </aside>
            <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 col-12">
                <div class="row">
                    <div aria-label="' . __( 'click here to remove filter button', 'single_corse' ) . '" class="hidden" id="filter_dynamic_tags_demo">
                        <a role="button" aria-label=" ' . __( 'click to remove the filter', 'single_corse' ) . ' " class="filter_dynamic_tag" data-name data-id href="javascript: void(0);"></a>
                    </div>';
if ( $no_results_found ) {
	echo '<div class="sum-all-course col-lg-12" role="alert">
		<h2 class="wrap-sum">
			 <span>' . __( 'No suitable courses found for', 'single_corse' ) . '</span>
             <span class="">"' . fixXSS( $_GET['s'] ) . '"</span>
		</h2>
	</div>';

	if ( $form_short_code_no_result = get_field( 'form_short_code_no_result', 'options' ) ) {
		echo '<div class="col-12 lokking-for-form no-result-form">' . $form_short_code_no_result . '</div>  ';
	}
} else {
	echo '<div class="sum-all-course col-lg-12" role="alert">
		<h2 class="wrap-sum">
			<span>' . __( 'Showing', 'single_corse' ) . '</span>
            <span id="add-sum-course" class="sum-of-courses-result">' . $count . '</span>
            <span>' . cin_get_str( 'matching_courses' ) . '</span> 
		</h2>
	</div>';
}
global $filter_tags;
echo '<div class="col-12">
                        <div class="row wrap-top-bar-search">
                        <div class="col-md-8 col-sm-8 col-lg-8 filter-dynamic" id="filter_dynamic_tags">' . $filter_tags . '</div>
                        <div class="d-flex justify-content-end col-md-4 col-sm-4 col-lg-4 top-bar-search">
                            <div id="orderby_title">' . cin_get_str( 'archive_orderby_title' ) . '</div>
                            <div class="wrap-orderby">
                                <input class="recomended-course sr-only" type="radio" id="orderbyrecomended" name="orderby" checked value="menu_order">
                                <label aria-label="' . __( 'sort by the best recommended', 'single_corse' ) . '" class="orderby" for="orderbyrecomended">' . cin_get_str( 'Popular' ) . '</label>
                            </div>
                            <div class="wrap-orderby">
                                <input class="newest-course sr-only" type="radio" name="orderby" id="orderbynew" value="date">
                                <label aria-label=" ' . __( 'sort by the newest', 'single_corse' ) . '" class="orderby" for="orderbynew">' . cin_get_str( 'Newest' ) . '<br></label>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="wrap-content-search-page col-12">
                                <div class="hidden no-result-inside-filter"><h4>' . __( 'No courses were found with the desired filter results', 'single_corse' ) . '...</h4></div>
                                <div class="row output-courses">' . $courses_str . '</div>';

if ( $count >= 15 && $visible >= 15 ) {
	$arialabel_acc = cin_get_str( 'load_more_courses' );
	echo "<button class='load-more-wrap' aria-label='$arialabel_acc' id='course_load_more' >" . __( 'Load more', 'single_corse' ) . "</button>";
}
echo '
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>';