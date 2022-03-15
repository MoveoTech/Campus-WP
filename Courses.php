<?php
/**
 * Template Name: New-Courses
 * Created by Ido Leybovitch.
 * Date: 28/02/2022
 * Time: 11:00
 */
?>

<?php

global $site_settings, $field, $wp_query, $sitepress;

/**
 * CHECK THE QUERY PARAMS
 */

$url = get_current_url();
$components = parse_url($url);
if($components['query']){
    parse_str($components['query'], $url_params);

    /** CHECK IF QUERY PARAMS ITEMS LENGTH >= 2 */
    validatePathUrl($url_params);
}

if($url_params){
    $params = podsGetParams($url_params);
} else {
    $params = [
        'limit'   => 27,
    ];
}

/** OLD PARAMETERS */
$visible                   = 15;
$form_short_code_no_result = '';
$form_short_code_sidebar   = $site_settings['form_short_code_sidebar'];
if ( empty( $_GET['termid'] ) ) {
    $class                  = 'search-course background-instead-banner';
    $text_on_banner_content = '';
    $text_on_banner_content .= '<h1>' . __( 'Courses', 'single_corse' ) . '</h1>';

    echo get_banner_area( $banner_for_mobile = false, $banner = false, $text_on_banner_content, $class );
}
$course_attrs = array(
    'class' => 'col-xs-12 col-md-6 col-xl-4 course-item-with-border',
);

$academic_institutions = pods( 'academic_institution', array('limit'   => -1 ));
$courses = pods( 'courses', $params, true);
$count = $courses->total_found();
$academic_name = cin_get_str('Institution_Name');
$choose_str = __('Choose Institution', 'single_corse');
$title_str = cin_get_str( 'filter_courses_title_ajax' );
$my_class = "ajax_filter";

/**
 * The old archive course code *
 */
//if ( $sitepress->get_current_language() == 'he' ) {
//    $strings   = get_courses_search_filter_server_side( $wp_query, $filters_list, $academic_filter );
//    $strings   = create_course_and_filters_side( $filters_list, $academic_filter );
//    $title_str = cin_get_str( 'filter_courses_title_ajax' );
//    $my_class = "ajax_filter";
//} else {
//    $strings   = get_courses_search_filter( $wp_query, $filters_list, $academic_filter );
//    $title_str = cin_get_str( 'filter_courses_title_no_ajax' );
//    $my_class = "no_ajax_filter";
//}
//$aside_str   = $strings['aside'];

?>

<div class="wrap-search-page-course <?= $my_class ?>">
    <div class="container">
        <div class="row justify-content-between">
            <aside class="col-xs-12 col-md-12 col-lg-3 col-xl-3 col-sm-12 sidebar-search-course">
                <div class="wrap-all-filter-names">
                    <div class="clear-filter-area">
                            <span class="filter-course-title" role="heading" aria-level="2"><?= $title_str ?></span>
                    </div>
                    <?php
                         get_template_part('template', 'parts/Filters/filters-aside',
                            array(
                                'args' => array(
                                    'filters_list' => $filters_list,
                                    'academic_filter' => $academic_institutions->data(),
                                )
                            ));
                    ?>
                </div>
                <div class="lokking-for-form"><?= $form_short_code_sidebar ?></div>
            </aside>
            <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 col-12">
                <div class="row">
                    <div aria-label="<?= __( 'click here to remove filter button', 'single_corse' ) ?>" class="hidden" id="filter_dynamic_tags_demo">
                        <a role="button" aria-label=" <?= __( 'click to remove the filter', 'single_corse' ) ?> " class="filter_dynamic_tag" data-name data-id href="javascript: void(0);"></a>
                    </div>
                    <?php if ( $no_results_found ) { ?>
                        <div class="sum-all-course col-lg-12" role="alert">
                            <h2 class="wrap-sum">
                                 <span>'<?= __( 'No suitable courses found for', 'single_corse' ) ?></span>
                                 <span class="">"<?= fixXSS( $_GET['s'] ) ?>"</span>
                            </h2>
                        </div>
                    <?php if ( $form_short_code_no_result = get_field( 'form_short_code_no_result', 'options' ) ) { ?>
                        <div class="col-12 lokking-for-form no-result-form"><?= $form_short_code_no_result ?></div>
                    <?php } } else {?>
                   <div class="sum-all-course col-lg-12" role="alert">
                        <h2 class="wrap-sum">
                            <span><?= __( 'Showing', 'single_corse' ) ?></span>
                            <span id="add-sum-course" class="sum-of-courses-result"><?= $count ?></span>
                            <span><?= cin_get_str( 'matching_courses' ) ?></span>
                        </h2>
                    </div>
                    <?php }
                    global $filter_tags; ?>
                    <div class="col-12">
                        <div class="row wrap-top-bar-search">
                            <div class="col-md-8 col-sm-8 col-lg-8 filter-dynamic" id="filter_dynamic_tags"><?= $filter_tags ?></div>
                            <div class="d-flex justify-content-end col-md-4 col-sm-4 col-lg-4 top-bar-search">
                                <div id="orderby_title"><?= cin_get_str( 'archive_orderby_title' ) ?></div>
                                <div class="wrap-orderby">
                                    <input class="recomended-course sr-only" type="radio" id="orderbyrecomended" name="orderby" checked value="menu_order">
                                    <label aria-label="<?= __( 'sort by the best recommended', 'single_corse' ) ?>" class="orderby" for="orderbyrecomended"><?= cin_get_str( 'Popular' ) ?></label>
                                </div>
                                <div class="wrap-orderby">
                                    <input class="newest-course sr-only" type="radio" name="orderby" id="orderbynew" value="date">
                                    <label aria-label=" <?= __( 'sort by the newest', 'single_corse' ) ?>" class="orderby" for="orderbynew"><?= cin_get_str( 'Newest' ) ?><br></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="wrap-content-search-page col-12">
                                    <div class="hidden no-result-inside-filter">
                                        <h4><?= __( 'No courses were found with the desired filter results', 'single_corse' ) ?>...</h4>
                                    </div>
                                    <div class="row output-courses"><?php
                                        while ($courses->fetch()) {
                                            $output_courses .= get_template_part('template', 'parts/Courses/course-card',
                                                array(
                                                    'args' => array(
                                                        'course' => $courses,
                                                        'attrs' => $course_attrs,
                                                    )
                                                ));
                                        } ?>
                                    </div>
                                <?php
                                if ( $count >= 15 && $visible >= 15 ) {
                                    $arialabel_acc = cin_get_str( 'load_more_courses' );?>
                                    <button class='load-more-wrap' aria-label='$arialabel_acc' id='course_load_more' ><?= __( 'Load more', 'single_corse' ) ?></button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

function podsGetParams($paramsArray)
{

    $order = "t.order DESC";
    $sql = array();

if($paramsArray['s'] && strlen($paramsArray['s']) >= 2){
    $sql[] = 't.name LIKE "%'.$paramsArray['s'].'%"';
    $sql[] = 't.english_name LIKE "%'.$paramsArray['s'].'%"';
    $sql[] = 't.arabic_name LIKE "%'.$paramsArray['s'].'%"';
    $sql[] = 't.description LIKE "%'.$paramsArray['s'].'%"';
    $sql[] = 't.course_products LIKE "%'.$paramsArray['s'].'%"';
    $sql[] = 't.alternative_names LIKE "%'.$paramsArray['s'].'%"';
}

    $where = implode(" OR ", $sql);
    $params = array(
        'limit' => -1,
        'where' => $where,
        'orderby' => $order
    );
    return $params;

}

function validatePathUrl($urlParams) {
    if(strlen($urlParams['s']) < 2) {
        wp_redirect( get_home_url() );
        exit;
    }
}