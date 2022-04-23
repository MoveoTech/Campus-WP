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
$current_language = $sitepress->get_current_language();

$menuFilters = get_field('filters');
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
    $params = getParamsForDefaultLang();
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
$academic_name = cin_get_str('Institution_Name');
$choose_str = __('Choose Institution', 'single_corse');
$title_str = cin_get_str( 'filter_courses_title_ajax' );
$my_class = "ajax_filter";
$catalog_title = getFieldByLanguage(get_field('catalog_title'), get_field('catalog_english_title'), get_field('catalog_arabic_title'), $sitepress->get_current_language());

$idArrayOfBestMatches = array();
$coursesIdArray = [];

$i = 0;
foreach ($courses->rows as $course) {
    array_push($idArrayOfBestMatches, $course->id);
    $coursesIdArray[$i] = $course->id;
    $i++;
}

$coursesIDs = implode(',', $coursesIdArray);
$second_params = getSecondsFiltersParams($filters, $idArrayOfBestMatches);

if($second_params) {
    $oneOrMoreMatches = pods('courses', $second_params);
}

/** No result translate */
$no_result_text_he = "לא מצאנו בדיוק את מה שחיפשת אבל אולי יעניין אותך...";
$no_result_text_en = "We didn't find exactly what you were looking for but maybe you will be interested ...";
$no_result_text_ar = "لم نعثر على ما كنت تبحث عنه بالضبط ولكن ربما تكون مهتمًا ...";

if(count($oneOrMoreMatches->rows) === 0 && count($courses->rows) === 0){
    $no_results_found = true;
}

?>

<div class="catalog-banner">

    <div class="back-img-1" ></div>
    <div class="back-img-2" ></div>

    <div class="catalog-banner-content">
        <h1 class="catalog-header" style="color: #ffffff"><?=$catalog_title?></h1>
        <?= get_template_part('templates/hero', 'search') ?>
    </div>
</div>

<div class="wrap-search-page-course <?= $my_class ?>">
    <div class="container">
        <div class="row justify-content-between">
            <div class="filtersSection">
                <div class="allFiltersWrapDiv">
                    <?php
                    if(!wp_is_mobile()){
                        get_template_part('template', 'parts/Filters/filters-section',
                            array(
                                'args' => array(
                                    'academic_filter' => $academic_institutions->data(),
                                    'menuFilters' => $menuFilters,
                                )
                            ));
                    }
                    ?>
                </div>
                <div class="openFiltersMenu">
                    <span><?= filtersMobileMenuLanguage(); ?></span>
                    <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
                </div>

            </div>

            <div class="catalogWrap">
                <div hidden id="catalog_courses" value="<?php print_r($coursesIDs); ?>" ></div>
                <div id="coursesBox" class="row output-courses coursesResults">

                    <!--. START Number of match courses OR No Results -->
                    <?php if ( $no_results_found ) { ?>

                            <div>
                                <p class="noResultText"><?= getFieldByLanguage($no_result_text_he, $no_result_text_en, $no_result_text_ar, $current_language) ?></p>
                            </div>
                <?php } else {
                        while ($courses->fetch()) {
                            get_template_part('template', 'parts/Courses/result-course-card',

                                array(
                                    'args' => array(
                                        'course' => $courses,
                                        'attrs' => $course_attrs,
                                    )
                                ));
                        }
                        if($oneOrMoreMatches) {

                            while ($oneOrMoreMatches->fetch()) {

                                get_template_part('template', 'parts/Courses/result-course-card',
                                    array(
                                        'args' => array(
                                            'course' => $oneOrMoreMatches,
                                            'attrs' => $course_attrs,
                                        )
                                    )
                                );
                            }
                        }
                    }
                    ?>
                    <!--. END Match Results -->
                </div>

                <?php
               /** LOAD MORE COURSES BUTTON */
//                $arialabel_acc = cin_get_str( 'load_more_courses' );
//                ?>
<!--                <button id='courses_load_more' class='load-more-wrap' aria-label=--><?//= $arialabel_acc ?><!-- >--><?//= __( 'Load more', 'single_corse' )?><!--</button>-->
                <?php /** END LOAD MORE COURSES BUTTON */?>

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
if (wp_is_mobile()) {
    get_filters_menu($menuFilters);
}
function get_filters_menu($menuFilters) {

    $encoded_path = urlencode($_SERVER['REQUEST_URI']);
    $current = cin_get_str('header_current_languages');
    get_template_part('template', 'parts/Filters/filtersMobileMenu',
        array(
            'args' => array(
                'menuFilters' => $menuFilters,
                'encoded_path' => $encoded_path,
                'currentLanguage' => $current,

            )
        ));
}

