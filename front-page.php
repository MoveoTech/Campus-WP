<?php
require_once 'inc/classes/Course_stripe.php';
require_once 'template-parts/Stripes/stripeTypes.php';

global $site_settings, $fields;

$hero_image = $fields['hero_image'];
$hero_image_mobile = $fields['hero_image_mobile'];
$hero_title = ($fields['hero_title']);
$hero_subtitle =  $fields['hero_subtitle'];

?>

    <!--Banner area-->
<?php if ($hero_image) : ?>
    <?php
    $class = 'home';
    $title = str_replace('%', '<span class="span-brake"></span>', $hero_title);
    $text_on_banner_content = '';
    $text_on_banner_content .= '<h1>'. $title .'</h1>';
    ?>
    <div class="hero-banner" >
        <div class="banner-image" >
            <div class="bckg-1"></div>
            <div class="bckg-2"></div>
            <div class="desktop-banner" style="background-image: url(<?= $hero_image['url'] ?>)"></div>
            <div class="mobile-banner" style="background-image: url(<?= $hero_image_mobile['url'] ?>)"></div>
            <div class="hero-gradient"></div>
            <div class="hero-container">
                <div class="container" >
                <div class="text-on-banner">
                    <h1><?=$hero_title?></h1>
                    <h5><?=$hero_subtitle?></h5>
                </div>
                <?= get_template_part('templates/hero', 'search') ?>
            </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    <!--End Banner area-->



    <!--STRIPES SECTION-->

<?php
//---------- STRIPES SECTION ----------

$cookieValue = $_COOKIE['prod-olivex-user-info'];
$edxUserValue =  $_COOKIE['edx-user-info'];

global  $sitepress;
?>
<div id="testingdiv" style="border: 2px solid red;"></div>
<?php

if ( $sitepress->get_current_language() == 'en' ) {
    $frontPageHe = apply_filters( 'wpml_object_id', get_option('page_on_front'), 'page', FALSE, 'he'  );

    if($cookieValue && strpos($cookieValue,"username") != false)
        $stripes = get_field( "loggedin_users_stripes", $frontPageHe );
    else if ($edxUserValue && strpos($edxUserValue,"username") != false) {
        $stripes = get_field( "loggedin_users_stripes", $frontPageHe );
    }
    else
        $stripes = get_field( "anonymous_users_stripes", $frontPageHe );
}else{

    if($cookieValue && strpos($cookieValue,"username") != false)
        $stripes = $fields['loggedin_users_stripes'];
    else if ($edxUserValue && strpos($edxUserValue,"username") != false) {
        $stripes = $fields['loggedin_users_stripes'];
    }
    else
        $stripes = $fields['anonymous_users_stripes'];
}

foreach($stripes as $stripeId ) {
    getStripeType($stripeId);
}

//---------- STRIPES SECTION ----------
?>

    <!--STRIPES SECTION-->




<?php add_action('wp_footer', function () {
    get_template_part('templates/event_popup');
});
