<?php
require_once 'filterTypes.php';
$filtersList = wp_parse_args(
    $args["args"]
);
//if(empty($filtersList) || empty($filtersList['menuFilters']))
//    return;
global $get_params, $sitepress;

$filters = $filtersList['menuFilters'];
//console_log($filters);
//var_dump($filters);
$encoded_path = $filtersList['encoded_path'];
$current = $filtersList['currentLanguage'];

if ($current === 'עברית') :
    {
        $courses = 'הקורסים שלי';
        $language = 'שינוי שפה';
        $profile = 'פרופיל';
        $controlpanel = 'לוח בקרה';
        $logout = 'התנתקות';
        $loginRegister = 'תפריט פילטרים';
    }
elseif ($current === 'English') :
    {
        $courses = 'My Courses';
        $language = 'Change Language';
        $profile = 'Profile';
        $controlpanel = 'Control Panel';
        $logout = 'Log out';
        $loginRegister = 'Login / Register';
    }
elseif ($current === 'العربية') :
    {
        $courses = 'دوراتي';
        $language = 'تغيير اللغة';
        $profile = 'الملف الشخصي';
        $controlpanel = 'لوحة المراقبة';
        $logout = 'تسجيل خروج';
        $loginRegister = 'تسجيل الدخول / تسجيل';
    }
endif;
?>
<div class="filters-mobile-menu-popup">

    <?php
    foreach ($filters as $filterGroupId) {
        getFilterType($filterGroupId);

    }

    ?>

<!--<ul class="nav-mobile">-->
<!--    <li class="mobile-list-item logged-in-item"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/courses-icon.svg' .'"><a target="_blank" href="'. get_field('link_to_dashboard_for_campus', 'option') .'"><span class="list-item-content">--><?//= $courses ?><!--</span></a></li>-->
<!--    <li class="mobile-list-item change-mobile-lang"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/lang-logo.svg' .'"><a class="a-link"><span class="list-item-content"> --><?//=$language ?><!--</span><img class="mobile-menu-vector" width="9.93px" height="5.68px" src="' . get_bloginfo('stylesheet_directory') . '/assets/images/vector-black.svg' .'"/></a> </li>-->
<!--    <div class="secondary-mobile-lang-menu">-->
<!--        <ul id="menu-language-menu-1" class="nav-lang">-->
<!--            <li id="wpml-ls-item-he" class="wpml-ls-menu-item mobile-list-item ' . current_active_lang( 'he' ) . '"><a href="' . get_lang_url( 'he' ) . '"><span class="wpml-ls-native">עב</span></a></li>-->
<!--            <li id="wpml-ls-item-en" class="wpml-ls-menu-item mobile-list-item ' . current_active_lang( 'en' ) . '"><a href="' . get_lang_url( 'en' ) . '"><span class="wpml-ls-native">En</span></a></li>-->
<!--            <li id="wpml-ls-item-ar" class="wpml-ls-menu-item mobile-list-item ' . current_active_lang( 'ar' ) . '"><a href="' . get_lang_url( 'ar' ) . '"><span class="wpml-ls-native">العر</span></a></li>-->
<!--        </ul>-->
<!--    </div>-->
<!--    <li class="mobile-list-item logged-in-item"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/profile.svg' .'"><a class="profile-button" target="_blank"><span class="list-item-content">--><?//= $profile ?><!-- </span></a></li>-->
<!--    <li class="mobile-list-item logged-in-item"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/equalizer.svg' .'"><a target="_blank" href="'. get_field('link_to_dashboard_for_campus', 'option') .'"><span class="list-item-content">--><?//= $controlpanel ?><!-- </span></a></li>-->
<!--    <li class="mobile-list-item mobile-logged-out logged-in-item"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/logout.svg' .'"><a class="logout-button" ><span class="list-item-content">--><?//= $logout ?><!--</span></a></li>-->
<!--    <li class="mobile-list-item mobile-login-register"><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/login-register.svg' .'"><a class="login-register-button" href="'. get_field('link_to_login_and_register', 'option') .'/login?next=/home' . $encoded_path .'"><span class="list-item-content">checking --><?//= $loginRegister ?><!--</span></a></li>-->
<!--</ul>-->
</div>

