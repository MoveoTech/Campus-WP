<?php
/**
 * Template Name: New Courses Page Design
 * Created by Ido Leybovitch.
 * Date: 16/03/2022
 * Time: 14:00
 */
?>

<?php

global $site_settings, $fields, $wp_query, $sitepress;

$form_short_code_sidebar = $site_settings['form_short_code_sidebar'];
$filters_list    = get_field( 'filters_list', 'courses_index_settings' );
$academic_filter = get_field( 'campus_order_academic_institutions_list', 'courses_index_settings' );
$visible                   = 15;
$form_short_code_no_result = '';
$form_short_code_sidebar   = $site_settings['form_short_code_sidebar'];

//if ( empty( $_GET['termid'] ) ) {
//    $class                  = 'search-course background-instead-banner';
//    $text_on_banner_content = '';
//    $text_on_banner_content .= '<h1>' . __( 'Courses', 'single_corse' ) . '</h1>';
//
//    echo get_banner_area( $banner_for_mobile = false, $banner = false, $text_on_banner_content, $class );
//}

$catalog_stripe_id = get_field('catalog_stripe')[0];

$course_attrs = array(
    'class' => 'col-xs-12 col-md-6 col-xl-4 course-item-with-border',
);
$params = [
    'limit'   => 27,
];

$academic_institutions = pods( 'academic_institution', array('limit'   => -1 ));
$courses = pods( 'courses', $params, true);
$count = $courses->total_found(); // TODO new count
$academic_name = cin_get_str('Institution_Name');
$choose_str = __('Choose Institution', 'single_corse');
$title_str = cin_get_str( 'filter_courses_title_ajax' );
$my_class = "ajax_filter";
$catalog_title = getFieldByLanguage(get_field('catalog_title'), get_field('catalog_english_title'), get_field('catalog_arabic_title'), $sitepress->get_current_language());
?>

<div class="catalog-banner">
    <div class="back-img-1" ></div>
    <div class="back-img-2" ></div>
    <div class="catalog-banner-content">
        <h1 class="catalog-header" style="color: #ffffff"><?=$catalog_title?></h1>
        <form role="search" method="get" class="hero-search-form" action="<?= esc_url(home_url('/')); ?>" novalidate>
            <label class="sr-only"><?php _e('Search for:', 'single_corse'); ?></label>
            <div class="input-group group-search-form">
                <input type="text" value="<?= get_search_query(); ?>" name="s" class="search-field form-control" placeholder="<?php echo hero_search_placeholder(); ?>" aria-required="true">
                <?php /* if(isset($_GET['termid'])){ ?>
            <input type="hidden" name="termid" value="<?= fixXSS($_GET['termid']); ?>"  placeholder="<?php _e('Search Course', 'single_corse'); ?>">
        <?php } */ ?>
                <span class="input-group-btn">
                  <button class="search-submit"><?php _e('Search', 'single_corse'); ?></button>
                </span>
            </div>
        </form>
    </div>
</div>

<div class="wrap-search-page-course <?= $my_class ?>">
    <div class="container">
        <div class="row justify-content-between">
            <div class="filtersSection">
                <div class="allFiltersWrapDiv">
                    <?php
                         get_template_part('template', 'parts/Filters/filters-section',
                            array(
                                'args' => array(
                                    'filters_list' => $filters_list,
                                    'academic_filter' => $academic_institutions->data(),
                                )
                            ));
                    ?>
                </div>
                </div>
            <div class="catalogWrap">
<!--                <div class="coursesResults">-->
<!--                    <h1>דיב של תוצאות קורסים אם יש</h1>-->
<!---->
<!--                </div>-->
                <div class="catalogStripeWrap">

                    <?php
//                    console_log($catalog_stripe_id);
                    $title = getFieldByLanguage(get_field('hebrew_title', $catalog_stripe_id), get_field('english_title', $catalog_stripe_id), get_field('arabic_title', $catalog_stripe_id), $sitepress->get_current_language());
                    $subTitle = getFieldByLanguage(get_field('hebrew_sub_title', $catalog_stripe_id), get_field('english_sub_title', $catalog_stripe_id), get_field('arabic_sub_title', $catalog_stripe_id), $sitepress->get_current_language());

                    get_template_part('template', 'parts/Stripes/catalog-stripe',
                        array(
                            'args' => array(
                                'id' => $catalog_stripe_id,
                                'title' => $title,
                                'subtitle' => $subTitle,
                                'courses' =>get_field('catalog_courses', $catalog_stripe_id) ,
                            )
                        ));
                    ?>

                </div>

            </div>

        </div>
    </div>
</div>








<!--<div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 col-12">-->
<!--    <div class="row">-->
        <!--                    <div aria-label="--><?//= __( 'click here to remove filter button', 'single_corse' ) ?><!--" class="hidden" id="filter_dynamic_tags_demo">-->
        <!--                        <a role="button" aria-label=" --><?//= __( 'click to remove the filter', 'single_corse' ) ?><!-- " class="filter_dynamic_tag" data-name data-id href="javascript: void(0);"></a>-->
        <!--                    </div>-->
        <!--                    --><?php //if ( $no_results_found ) { ?>
        <!--                        <div class="sum-all-course col-lg-12" role="alert">-->
        <!--                            <h2 class="wrap-sum">-->
        <!--                                 <span>'--><?//= __( 'No suitable courses found for', 'single_corse' ) ?><!--</span>-->
        <!--                                 <span class="">"--><?//= fixXSS( $_GET['s'] ) ?><!--"</span>-->
        <!--                            </h2>-->
        <!--                        </div>-->
        <!--                    --><?php //if ( $form_short_code_no_result = get_field( 'form_short_code_no_result', 'options' ) ) { ?>
        <!--                        <div class="col-12 lokking-for-form no-result-form">--><?//= $form_short_code_no_result ?><!--</div>-->
        <!--                    --><?php //} } else {?>
        <!--                   <div class="sum-all-course col-lg-12" role="alert">-->
        <!--                        <h2 class="wrap-sum">-->
        <!--                            <span>--><?//= __( 'Showing', 'single_corse' ) ?><!--</span>-->
        <!--                            <span id="add-sum-course" class="sum-of-courses-result">ggg--><?//= $count ?><!--</span>-->
        <!--                            <span>--><?//= cin_get_str( 'matching_courses' ) ?><!--</span>-->
        <!--                        </h2>-->
        <!--                    </div>-->
        <!--                    --><?php //}
//        global $filter_tags; ?>
<!--        <div class="col-12">-->
            <!--                        <div class="row wrap-top-bar-search">-->
            <!--                            <div class="col-md-8 col-sm-8 col-lg-8 filter-dynamic" id="filter_dynamic_tags">--><?//= $filter_tags ?><!--</div>-->
            <!--                            <div class="d-flex justify-content-end col-md-4 col-sm-4 col-lg-4 top-bar-search">-->
            <!--                                <div id="orderby_title">--><?//= cin_get_str( 'archive_orderby_title' ) ?><!--</div>-->
            <!--                                <div class="wrap-orderby">-->
            <!--                                    <input class="recomended-course sr-only" type="radio" id="orderbyrecomended" name="orderby" checked value="menu_order">-->
            <!--                                    <label aria-label="--><?//= __( 'sort by the best recommended', 'single_corse' ) ?><!--" class="orderby" for="orderbyrecomended">--><?//= cin_get_str( 'Popular' ) ?><!--</label>-->
            <!--                                </div>-->
            <!--                                <div class="wrap-orderby">-->
            <!--                                    <input class="newest-course sr-only" type="radio" name="orderby" id="orderbynew" value="date">-->
            <!--                                    <label aria-label=" --><?//= __( 'sort by the newest', 'single_corse' ) ?><!--" class="orderby" for="orderbynew">--><?//= cin_get_str( 'Newest' ) ?><!--<br></label>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                        </div>-->
<!--            <div class="row">-->
<!--                <div class="wrap-content-search-page col-12">-->
<!--                    <div class="hidden no-result-inside-filter">-->
<!--                        <h4>--><?//= __( 'No courses were found with the desired filter results', 'single_corse' ) ?><!--...</h4>-->
<!--                    </div>-->
<!--                    <div class="row output-courses" id="coursesBox" > --><?php
//
//                        while ($courses->fetch()) {
//
//                            get_template_part('template', 'parts/Courses/course-card',
//                                array(
//                                    'args' => array(
//                                        'course' => $courses,
//                                        'attrs' => $course_attrs,
//                                    )
//                                ));
//                        } ?>
<!--                    </div>-->
<!--                    --><?php
//                    if ( $count >= 15 && $visible >= 15 ) {
//                        $arialabel_acc = cin_get_str( 'load_more_courses' );?>
<!--                        <button class='load-more-wrap' aria-label='$arialabel_acc' id='course_load_more' >--><?//= __( 'Load more', 'single_corse' ) ?><!--</button>-->
<!--                    --><?php //} ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->





