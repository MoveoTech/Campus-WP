<?php
/**
 * Created by PhpStorm.
 * User: estero
 * Date: 12/11/2018
 * Time: 09:04
 */

global $fields;

$banner_image_404 = get_field('banner_image_404', 'option');
$main_title_404 = get_field('main_title_404', 'option');
$main_label_404 = get_field('main_label_404', 'option');

$secondary_title_404 = get_field('secondary_title_404', 'option');
$label_404 = get_field('label_404', 'option');
$button_404 = get_field('button_404', 'option');
$link_404 = get_field('link_404', 'option');
$optional_link_name_404 = get_field('optional_link_name_404', 'option');
$optional_link_404 = get_field('optional_link_404', 'option');

?>
<!--Banner area-->
<?php if ($banner_image_404) : ?>
    <div class="banner-wrapper">
        <div class="gray-on-banner not-found gray-part d-xs-none d-sm-none d-md-none d-lg-inline-block d-xl-inline-block"></div>
        <div class="banner-image not-found gray-part d-block d-sm-block d-lg-inline-block" style="background-image: url(<?= $banner_image_404['url']; ?>)">
            <div class="more-content-404">
                <h1 class="main_title_404"><?= $main_title_404 ?></h1>
                <p class="main_label_404"><?= $main_label_404 ?> </p>
            </div>
        </div>
        <div class="background-on-banner">
            <div class="container">
                <div class="text-on-banner not-found gray-part centering-on-banner">
                    <h2 class="secondary_title_404"><?= $secondary_title_404 ?></h2>
                    <p class="label_404"><?= $label_404 ?></p>
                    <a href="<?= $link_404; ?>" class="link-banner button_404_page"><?= $button_404 ?></a>
                    <a href="<?= $optional_link_404 ?>" class="link-banner_404"><?= $optional_link_name_404 ?></a>
                </div>
            </div>
        </div>
    </div>
<!--End Banner area-->
<?php endif; ?>