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
                <span class="input-group-btn">
                  <button class="search-submit"><?php _e('Search', 'single_corse'); ?></button>
                </span>
            </div>
        </form>
    </div>

</div>

<div class="wrap-search-page-course">

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

                <div class="coursesResults"></div>

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




