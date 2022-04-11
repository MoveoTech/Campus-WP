<?php
/**
 * Template Name: New-Courses
 * Created by Ido Leybovitch.
 * Date: 28/02/2022
 * Time: 11:00
 */
?>

<?php

global $site_settings, $field, $wp_query, $sitepress, $filter_tags;

/**
 * CHECK THE QUERY PARAMS
 */
$url = get_current_url();
$components = parse_url($url);

if($components['query']){
    parse_str($components['query'], $url_params);
}

if($url_params){
    $filters = getFiltersArray($url_params);
    $params = getPodsFilterParams($filters);
} else {
    $params = [
        'limit'   => 1,
        'orderBy' => 't.order DESC',
    ];
}

/** OLD PARAMETERS */
$visible                   = 15;
$form_short_code_no_result = '';
$form_short_code_sidebar   = $site_settings['form_short_code_sidebar'];
$course_attrs = array(
    'class' => 'col-xs-12 col-md-6 col-xl-4 course-item-with-border',
);

/** NEW PARAMETERS */
$catalog_stripe_id = get_field('catalog_stripe');
$academic_institutions = pods( 'academic_institution', array('limit'   => -1 ));
$courses = pods( 'courses', $params, true);
$count = $courses->total_found();
$academic_name = cin_get_str('Institution_Name');
$choose_str = __('Choose Institution', 'single_corse');
$title_str = cin_get_str( 'filter_courses_title_ajax' );
$my_class = "ajax_filter";
$catalog_title = getFieldByLanguage(get_field('catalog_title'), get_field('catalog_english_title'), get_field('catalog_arabic_title'), $sitepress->get_current_language());

if($count == '0'){
    $no_results_found = true;
}

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
                                'academic_filter' => $academic_institutions->data(),
                            )
                        ));
                    ?>
                </div>
            </div>

            <div class="catalogWrap">

<!--                <div id="coursesBox" class="row output-courses coursesResults">-->
                    <!--. START Number of match courses OR No Results -->
<!--                    --><?php //if ( $no_results_found ) { ?>
<!--                        <div class="sum-all-course col-lg-12" role="alert">-->
<!--                            <h2 class="wrap-sum">-->
<!--                                <span>'--><?//= __( 'No suitable courses found for', 'single_corse' ) ?><!--</span>-->
<!--                                <span class="">"--><?//= fixXSS( $_GET['text_s'] ) ?><!--"</span>-->
<!--                            </h2>-->
<!--                        </div>-->
<!--                        --><?php //if ( $form_short_code_no_result = get_field( 'form_short_code_no_result', 'options' ) ) { ?>
<!--                            <div class="col-12 lokking-for-form no-result-form">--><?//= $form_short_code_no_result ?><!--</div>-->
<!--                        --><?php //} }
//                    else {
//
//                        while ($courses->fetch()) {
//                            get_template_part('template', 'parts/Courses/course-card',
//                                array(
//                                    'args' => array(
//                                        'course' => $courses,
//                                        'attrs' => $course_attrs,
//                                    )
//                                ));
//                        } }?>
                    <!--. END Match Results -->
<!--                </div>-->

                <div class="catalogStripeWrap">

                    <?php
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

<?php


