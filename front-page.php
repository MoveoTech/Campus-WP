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
            <img class="desktop-banner" src="<?= $hero_image['url'] ?>" >
            <img class="mobile-banner" src="<?= $hero_image_mobile['url'] ?>" >
            <div class="container" >
                <div class="text-on-banner">
                    <h1><?=$hero_title?></h1>
                    <h5><?=$hero_subtitle?></h5>
                </div>
                <?= get_template_part('templates/hero', 'search') ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--End Banner area-->




<?php
//---------- STRIPES SECTION ----------

$cookieValue = $_COOKIE['prod-olivex-user-info'];
if($cookieValue && str_contains($cookieValue,"username"))
    $stripes = $fields['loggedin_users_stripes'];

else
    $stripes = $fields['anonymous_users_stripes'];

foreach($stripes as $stripeId ) {
    getStripeType($stripeId);
}

//---------- STRIPES SECTION ----------
?>





<?php add_action('wp_footer', function () {
    get_template_part('templates/event_popup');
});
