<?php
/**
 * Template Name: Catalog
 * Created by Ido Leybovitch.
 * Date: 28/02/2022
 * Time: 11:00
 */
?>

<?php

global $site_settings, $field, $wp_query, $sitepress, $filter_tags;
$current_language = $sitepress->get_current_language();
/**
 * CHECK THE QUERY PARAMS
 */
$components = parse_url($_SERVER['QUERY_STRING']);

if($components['path']){
    parse_str($components['path'], $url_params);
}

$stripe_title = null;
$custom_stripe_catalog_page = false;
if($url_params){
    $filters = getFiltersArray($url_params);
    /**
     * Checking if have tag from tags stripe and
     * get the current name by tag id
     */
    if($filters['search']['tags']['Stripe']) {
        $tag_params = $filters['search']['tags']['Stripe'][0];
        $tag_id = explode('-',$tag_params)[0];
        $tag = pods('tags',$tag_id);
        $tag_name = $tag->display('english_name');
        $filters['search']['tags']['Stripe'][0] = $tag_name;
    }
    /** Checking if url have stripe_id for custom catalog page */
    if(isset($filters['search']['stripe_id'])){
        $custom_stripe_catalog_page = true;
        global $sitepress;
        $lang = $sitepress->get_current_language();
        if(isset($filters['search']['stripe_id'][0]) && intval($filters['search']['stripe_id'][0])){
            $stripe_id = $filters['search']['stripe_id'][0];
            if($lang != 'he') $stripe_title = get_field($lang.'_title', $stripe_id);
            if(!$stripe_title) $stripe_title = get_field('he_title', $stripe_id);
        }
    }
    $params = getPodsFilterParams($filters);
} else {
    $params = getPodsFilterParams();
}

/** PARAMETERS */
if(!$custom_stripe_catalog_page){
    $catalog_stripe_id = get_field('catalog_stripe');
}

$menu_filters = get_field('filters');
$academic_institutions = pods( 'academic_institution', array('limit'   => -1 ));
$courses = pods( 'courses', $params, true);
$academic_name = cin_get_str('Institution_Name');
$choose_str = __('Choose Institution', 'single_corse');
$title_str = cin_get_str( 'filter_courses_title_ajax' );
$my_class = "ajax_filter";
$catalog_title = getFieldByLanguage(get_field('catalog_title'), get_field('catalog_english_title'), get_field('catalog_arabic_title'), $sitepress->get_current_language());
$course_attrs = array(
    'class' => 'col-xs-12 col-md-6 col-xl-4 course-item-with-border',
);

$courses_id_array = [];

$i = 0;
foreach ($courses->rows as $course) {
    $courses_id_array[$i] = $course->id;
    $i++;
}

/** Get just the first 20 courses */
$courses->rows = array_slice($courses->rows, 0,20);

$courses_ids = implode(',', $courses_id_array);

$count_show = getFieldByLanguage("מוצגים", "Show", "يتم تقديم", $current_language);
$count_courses = getFieldByLanguage("קורסים", "Courses", "دورة", $current_language);
$count_number = $courses->total();

/** translate numbers to arabic */
if($current_language == 'ar'){
    $count_number = getArabicNumbers($count_number);
}

    /** No result translate */
$no_result_text_he = "לא מצאנו בדיוק את מה שחיפשת אבל אולי יעניין אותך...";
$no_result_text_en = "We didn't find exactly what you were looking for but maybe you will be interested ...";
$no_result_text_ar = "لم نعثر على ما كنت تبحث عنه بالضبط ولكن ربما تكون مهتمًا ...";

$no_results_found = $count_number === 0;
?>

<div class="catalog-banner <?= $custom_stripe_catalog_page? "customCatalogBanner": null ?>">

    <div class="back-img-1" ></div>
    <div class="back-img-2" ></div>

    <div class="catalog-banner-content">
        <h1 class="catalog-header <?= $custom_stripe_catalog_page? "customCatalogHeader": null ?>" style="color: #ffffff"><?= $custom_stripe_catalog_page? $stripe_title: $catalog_title?></h1>

        <?= $custom_stripe_catalog_page? null: get_template_part('templates/hero', 'search') ?>
    </div>
</div>

<div class="wrapCourseContent <?= $my_class ?>">
    <div class="coursesContainer">
        <div class="row justify-content-between catalogPageBox">
            <div class="filtersWrap">
                <div class="filtersSection">
                    <div class="allFiltersWrapDiv">
                        <?php
                        get_template_part('template', 'parts/Filters/filters-section',
                            array(
                                'args' => array(
                                    'academic_filter' => $academic_institutions->data(),
                                    'menuFilters' => $menu_filters,
                                )
                            ));
                        ?>
                    </div>
                    <div class="openFiltersMenu">
                        <div class="mobile-filters-counter"></div>
                        <span><?= filtersMobileMenuLanguage(); ?></span>
                        <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
                    </div>
                </div>
            </div>
            <div class="counterWrap">
                <p><?= $count_show ." " ?> <span id="counterValue"><?= $count_number ?></span><?= " ". $count_courses ?></p>
            </div>

            <div id="selectedTags"></div>

            <div class="catalogWrap">
                <div hidden id="catalog_courses" data-value="<?php print_r($courses_ids); ?>" ></div>

                <div id="coursesBox" class="row output-courses coursesResults catalogPageBox">

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
                    }
                    ?>
                    <!--. END Match Results -->
                </div>

                 <!--. LOAD MORE COURSES SKELETONS  -->
                <?php get_template_part('template', 'parts/catalogCourse-skeleton'); ?>

        <?php if($catalog_stripe_id){ ?>
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
        <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php

    get_filters_menu($menu_filters);
function get_filters_menu($menu_filters) {

    $encoded_path = urlencode($_SERVER['REQUEST_URI']);
    $current = cin_get_str('header_current_languages');
    get_template_part('template', 'parts/Filters/filtersMobileMenu',
        array(
            'args' => array(
                'menuFilters' => $menu_filters,
                'encoded_path' => $encoded_path,
                'currentLanguage' => $current,

            )
        ));
}

