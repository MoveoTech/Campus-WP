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
$mobile_menu = get_filters_menu($menuFilters);

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
                                'menuFilters' => $menuFilters,
                            )
                        ));
                    ?>
                </div>
                <div class="openFiltersMenu">
                    <span><?= filtersMobileMenuLanguage() ?></span>
                    <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
                </div>

            </div>
            <div class="catalogWrap">

<!--                <div id="coursesBox" class="row output-courses coursesResults">-->

<!--                    . START Number of match courses OR No Results -->

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

<!--                    . END Match Results -->

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
<!--    <div class="bg-overlay filtersMenuOverlay"></div>-->
<!--    <div class="filters-mobile-menu-popup">-->
        <?= $mobile_menu; ?>
<!--        <div class="mobile-menu-asset"></div>-->
<!--    </div>-->

<?php
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

//
//
//    if ($current === 'עברית') :
//        {
//            $courses = 'הקורסים שלי';
//            $language = 'שינוי שפה';
//            $profile = 'פרופיל';
//            $controlpanel = 'לוח בקרה';
//            $logout = 'התנתקות';
//            $loginRegister = 'תפריט פילטרים';
//        }
//    elseif ($current === 'English') :
//        {
//            $courses = 'My Courses';
//            $language = 'Change Language';
//            $profile = 'Profile';
//            $controlpanel = 'Control Panel';
//            $logout = 'Log out';
//            $loginRegister = 'Login / Register';
//        }
//    elseif ($current === 'العربية') :
//        {
//            $courses = 'دوراتي';
//            $language = 'تغيير اللغة';
//            $profile = 'الملف الشخصي';
//            $controlpanel = 'لوحة المراقبة';
//            $logout = 'تسجيل خروج';
//            $loginRegister = 'تسجيل الدخول / تسجيل';
//        }
//    endif;

//
//    return get_template_part('template', 'parts/Filters/filtersMobileMenu',
//        array(
//            'args' => array(
//                'menuFilters' => $menuFilters,
//            )
//        ));
//foreach ($menuFilters as $filterGroup) {
//    return '<li class="mobile-list-item logged-in-item">' . $filterGroup . '</li>';
//}
//    $groupFilters =
//
//    return '
//    <ul id="menu-mobile-menu-1" class="filters-mobile-menu">';
//
//        foreach ($menuFilters as $filterGroup) {
//            return '<li class="mobile-list-item logged-in-item">' . $filterGroup . '</li>';
//        }
//    '<li class="mobile-list-item logged-in-item"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/courses-icon.svg' .'"><a target="_blank" href="'. get_field('link_to_dashboard_for_campus', 'option') .'"><span class="list-item-content">'.$courses.'</span></a></li>
//       <li class="mobile-list-item change-mobile-lang"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/lang-logo.svg' .'"><a class="a-link"><span class="list-item-content">'.$language.'</span><img class="mobile-menu-vector" width="9.93px" height="5.68px" src="' . get_bloginfo('stylesheet_directory') . '/assets/images/vector-black.svg' .'"/></a> </li>
//       <div class="secondary-mobile-lang-menu">
//           <ul id="menu-language-menu-1" class="nav-lang">
//                <li id="wpml-ls-item-he" class="wpml-ls-menu-item mobile-list-item ' . current_active_lang( 'he' ) . '"><a href="' . get_lang_url( 'he' ) . '"><span class="wpml-ls-native">עב</span></a></li>
//                <li id="wpml-ls-item-en" class="wpml-ls-menu-item mobile-list-item ' . current_active_lang( 'en' ) . '"><a href="' . get_lang_url( 'en' ) . '"><span class="wpml-ls-native">En</span></a></li>
//                <li id="wpml-ls-item-ar" class="wpml-ls-menu-item mobile-list-item ' . current_active_lang( 'ar' ) . '"><a href="' . get_lang_url( 'ar' ) . '"><span class="wpml-ls-native">العر</span></a></li>
//            </ul>
//        </div>
//        <li class="mobile-list-item logged-in-item"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/profile.svg' .'"><a class="profile-button" target="_blank"><span class="list-item-content">'.$profile.'</span></a></li>
//        <li class="mobile-list-item logged-in-item"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/equalizer.svg' .'"><a target="_blank" href="'. get_field('link_to_dashboard_for_campus', 'option') .'"><span class="list-item-content">'.$controlpanel.'</span></a></li>
//        <li class="mobile-list-item mobile-logged-out logged-in-item"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/logout.svg' .'"><a class="logout-button" ><span class="list-item-content">'.$logout.'</span></a></li>
//        <li class="mobile-list-item mobile-login-register"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/login-register.svg' .'"><a class="login-register-button" href="'. get_field('link_to_login_and_register', 'option') .'/login?next=/home' . $encoded_path .'"><span class="list-item-content">'.$loginRegister.'</span></a></li>
//    </ul>
//
//    ';
}

