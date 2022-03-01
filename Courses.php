<?php
/**
 * Template Name: new Courses
 * Created by Ido Leybovitch.
 * Date: 28/02/2022
 * Time: 11:00
 */
?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?> style="margin-top: 0 !important;">
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
  <?php
      do_action('get_header');
      get_template_part('templates/header');

global $site_settings, $field, $wp_query, $sitepress;

$form_short_code_sidebar = $site_settings['form_short_code_sidebar'];
$filters_list    = get_field( 'filters_list', 'courses_index_settings' );
$academic_filter = get_field( 'campus_order_academic_institutions_list', 'courses_index_settings' );
$visible                   = 15;
$form_short_code_no_result = '';
$form_short_code_sidebar   = $site_settings['form_short_code_sidebar'];

if ( empty( $_GET['termid'] ) ) {
    $class                  = 'search-course background-instead-banner';
    $text_on_banner_content = '';
    $text_on_banner_content .= '<h1>' . __( 'Courses', 'single_corse' ) . '</h1>';

    echo get_banner_area( $banner_for_mobile = false, $banner = false, $text_on_banner_content, $class );
}

$params = [
    'limit'   => 27,
];
$courses = pods( 'courses', $params, true);


//---- The old archive course code ----//


//if ( $sitepress->get_current_language() == 'he' ) {
//    $strings   = get_courses_search_filter_server_side( $wp_query, $filters_list, $academic_filter );
    $strings   = create_course_and_filters_side( $courses, $filters_list, $academic_filter );
    $title_str = cin_get_str( 'filter_courses_title_ajax' );
    $my_class = "ajax_filter";
//} else {
//    $strings   = get_courses_search_filter( $wp_query, $filters_list, $academic_filter );
//    $title_str = cin_get_str( 'filter_courses_title_no_ajax' );
//    $my_class = "no_ajax_filter";
//}
$count = $courses->total_found(); // TODO new count
//$count       = $wp_query->found_posts; // TODO old count
$courses_str = $strings['courses'];
$aside_str   = $strings['aside'];


echo '<div class="wrap-search-page-course '. $my_class .'">
    <div class="container">
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
  do_action('get_footer');
  get_template_part('templates/footer');
  wp_footer();
?>
  </body>
</html>
