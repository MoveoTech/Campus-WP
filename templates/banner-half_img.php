<?php
$args = get_query_var('banner_args');

$url_banner_desktop = $args['banner_image_desktop'];
$url_banner_mobile = $args['banner_image_mobile'] ? $args['banner_image_mobile'] : $url_banner_desktop;

$bg = $args['bg_color'] ? $args['bg_color'] : 'white';
if ( function_exists('yoast_breadcrumb') ) {
    $breadcrumbs = yoast_breadcrumb('<div class="' . $class_output . ' breadcrumbs-campus" id="breadcrumbs"><p class="container">', '</p></div>');
}
?>

<div id='banner_half_img' class='banner-wrapper about-course gray-part' data-bg="<?= $bg; ?>">
    <div id="banner_half_img_mobile_img" class='has_background_image d-sm-block d-lg-none d-xs-block'
         style='background-image: url(<?= $url_banner_mobile; ?>)'></div>
    <div class='gray-on-banner about-course gray-part d-xs-none d-lg-inline-block'></div>
    <div class='banner-image about-course gray-part d-none d-lg-inline-block'
         style='background-image: url(<?= $url_banner_desktop; ?>)'></div>
    <div class='background-on-banner about-course gray-part'>
        <div class='container'>
            <div class="text-on-banner about-course gray-part centering-on-banner">
                <?= $args['content']; ?>
            </div>
        </div>
    </div>
</div>