<?php
/**
 * Template Name: Contact Us
 */

$contact_us_phone = $fields['contact_us_phone'];
$contact_us_phone_image = $fields['contact_us_phone_image'];
$contact_us_email = $fields['contact_us_email'];
$contact_us_email_image = $fields['contact_us_email_image'];
$social_networks = $site_settings['social_networks'];

// Banner with Breadcrumbs
$class = 'contact_us background-instead-banner';
$text_on_banner_content = '';
$text_on_banner_content .= '<h1>' . get_the_title() . '</h1>';
?>
<?= get_banner_area($banner_for_mobile = false, $banner = false, $text_on_banner_content, $class); ?>

<!-- content of page -->
<div id="contact_us_page">
    <div id="contact_us_banner_image" class="container-fluid banner-image"
         style="background-image: url(<?= $fields['contact_us_image_desktop'] ?>)"></div>

    <div id="wrap_contact_us_container">
        <div class="container contact-us-page">
            <div id="ways_contact_us_floor" class="contact_us_floors">
                <h2 class="contact_us_titles"><?= $fields['contact_us_title'] ?></h2>
                <div class="ways_contact_us_row row">
                    <div class="ways_contact_us_wrap col-6 col-md-3 col-lg-2 col-xl-1">
                        <div class="ways_contact_us_image"><img src="<?= $contact_us_phone_image; ?>"></div>
                        <a target="_blank" href="tel:<?= $contact_us_phone; ?>"
                           class="contact-us-text ways_contact_us_text"><?= $contact_us_phone; ?></a>
                    </div>
                    <div class="ways_contact_us_wrap col-6 col-md-3 col-lg-3 col-xl-2">
                        <div class="ways_contact_us_image"><img src="<?= $contact_us_email_image; ?>"></div>
                        <a target="_blank" title="Please Press To Copy To Clipboard" href="mailto:<?= $contact_us_email ?>"
                           class="contact-us-text copy-to-clipboard ways_contact_us_text"><?= $contact_us_email; ?></a>
                    </div>
                    <?php
                    foreach ($social_networks as $social_network) { ?>
                        <div class="ways_contact_us_wrap col-6 col-md-3 col-lg-1 col-xl-1">
                            <a target="_blank"
                               class="ways_contact_us_links link_<?php echo $social_network['name_of_class']; ?>"
                               href="<?php echo $social_network['url']; ?>"></a>
                        </div>
                    <?php } ?>
                </div>
                <div id="contact_us_activity_time">
                    <?= $fields['contact_us_activity_time'] ?>
                </div>
            </div>

            <?php
            if ($fields['flash_updates_show']) { ?>
                <div id="flash_updates_contact_us_floor" class="contact_us_floors">
                    <h2 class="contact_us_titles"><?= $fields['flash_updates_title'] ?></h2>
                    <div id="flash_updates_content"><?= $fields['flash_updates_content'] ?></div>
                </div>
            <?php } ?>

            <div id="you_have_a_question_floor" class="contact_us_floors">
                <h2 class="contact_us_titles"><?= $fields['you_have_a_question_title'] ?></h2>
                <a id="you_have_a_question_link"
                   href="<?= $fields['you_have_a_question_link'] ?>"><?= $fields['you_have_a_question_text_btn'] ?></a>
            </div>

            <div id="contact_us_form_floor" class="contact_us_floors">
                <div class="contact_us_form_wrap_contact">
                    <h2 class="contact_us_titles"><?= $fields['contact_us_form_title'] ?></h2>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    @media (max-width: 767px) {
        #contact_us_banner_image {
            background-image: url(<?= $fields['contact_us_image_mobile'] ?>) !important;
        }
    }
</style>
