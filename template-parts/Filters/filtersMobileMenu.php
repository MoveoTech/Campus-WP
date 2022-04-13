<?php
require_once 'filterTypes.php';
$filtersList = wp_parse_args(
    $args["args"]
);
if(empty($filtersList) || empty($filtersList['menuFilters']))
    return;
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


<div hidden class="filters-mobile-menu-popup">
    <div class="navFiltersMenu">
        <p class="resetFilterButton"><?= ResetFiltersLanguage(); ?></p>
    </div>
    <div id="filtersSectionMobile">

    <?php
    foreach ($filters as $filterGroupId) {
        getFilterType($filterGroupId);
    }
    ?>
    </div>
    <div class="buttonNavFiltersMenu">
        <div class="buttonFilterWrap">
            <p class="filterButtonMobileMenu"><?= filtersMobileMenuLanguage(); ?></p>

        </div>
    </div>
</div>
