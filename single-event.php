<?php
global $site_settings, $fields;

//fields on Course page
$permalink = get_permalink();

$course_banner = $fields['course_banner'];

$course_video = $fields['course_video'];
$query_string = array();
parse_str(parse_url($course_video, PHP_URL_QUERY), $query_string);

$video_id = ($course_video)? $query_string["v"]: '';
?>
<?php // if ($course_banner) {
    $title = $fields['title_on_banner_event'];
    $title = $title ? wrap_text_with_char($title) : get_the_title();
    $banner_for_mobile = $fields['banner_for_mobile_course'];
    $class = 'about-course gray-part';
    $text_on_banner_content = '';
    $text_on_banner_content .= '<h1 class="title-course">' . $title . '</h1>';
    $text_on_banner_content .= '<p class="excerpt-course">' . get_the_excerpt() . '</p>';
    $text_on_banner_content .= '<span class="signup-course-button-wrap">';

    $text_on_banner_content .= '<a class="signup-course-button con_to_course" target="_blank" href="' . $fields['banner_btn_link'] . '" aria-label="' . $fields['banner_btn_text'] . ' - '. get_the_title() .'">' . $fields['banner_btn_text'] . '</a>';
    $text_on_banner_content .= '</span>';
    if ($course_video) {
        $video_on_banner = '<a href="#"  aria-haspopup="true" role="button" tabindex="0" title="' . get_the_title() . '" data-url="https://www.youtube.com/embed/' . $video_id . '?autoplay=1&showinfo=1&autohide=1&rel=0&enablejsapi=1&wmode=transparent" class="popup-about-course-video open-popup-button-2020"></a>';
        //aria-pressed="false" data-classtoadd="popup-about-course"
    } else {
        $video_on_banner = '';
    }
    ?>
    <?= get_banner_area($banner_for_mobile, $course_banner, $text_on_banner_content, $class, $video_on_banner); ?>
    <?php
//}

$js_code = get_field("js_code");
if(!empty($js_code)) {
    echo '<script type="text/javascript">' . $js_code . '</script>';
}

$date_str = get_event_date($fields['event_date'], $fields['event_time'], true);

?>
    <div class="information-bar">
        <div class="container">
            <div class="row information-bar-inner">
                <div class="start-bar-info col-12 col-lg-4">
                    <div class="start-date-title-bar title-bar"><?php echo __('Date','single_corse'); ?></div>
                    <p class="text-bar-course"><?php echo $date_str; ?></p>
                </div>
                <div class="price-bar-info col-12 col-lg-4">
                    <div class="price-course-bar title-bar"><?= __('Price' ,'single_corse'); ?></div>
                    <p class="text-bar-course"><?php echo __('free' ,'single_corse'); ?></p>
                </div>
                <div class="org-logo col-12 col-lg-3">
                    <?php $img = get_field('term_img', $fields['producer']); ?>
                    <div style="background-image: url(<?= $img; ?>)" class="academic-course-image"></div>
                </div>
            </div>
        </div>
    </div>
<?php

$description = $fields['description'];

$lecturer = $fields['lecturer'];
$more_details = $fields['more_details'];

?>
    <div class="content-course-page">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7 content-single-course">
                    <div class="content-single-course-inners">
                        <?php if ($description) : ?>
                            <div class="description">
                                <div class="content-wp">
                                    <?php echo $description; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty( get_the_content() )) : ?>
                            <h2 class="title-description"><?= __('Description','single_corse'); ?>:</h2>
                            <div class="text-description-of-course">
                            <span class="read-more-text">
                               <?php echo wpautop(get_the_content()); ?>
                            </span>
                            </div>
                            <button class="course_test_type_readmore course_test_readmore_collapse collapsed" aria-hidden="true" aria-expanded="false">
                                <span aria-label='<?= cin_get_str('read_more_event_desc'); ?>'><?= __('Read More','single_corse'); ?></span>
                                <span aria-label='<?= __('read less','single_corse'); ?>'><?= __('Read Less','single_corse'); ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-12 col-lg-4 event_facebook_wrap">
                    <iframe id="facebook_likes_embed"  aria-label='<?= cin_get_str('social_network_facebook'); ?>' src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fcampus.gov.il&tabs&width=436&height=190&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                    <div class="sharing">
                        <span class="sharing-text"><?= __('Sharing: ','single_corse'); ?></span>
                        <a target="_blank" class="socials-post linkedin" aria-label='<?= cin_get_str('social_network_linkedin'); ?>' href="https://www.linkedin.com/shareArticle?mini=true&url=<?=$permalink;?>"></a>
                        <a target="_blank" class="socials-post facebook" aria-label='<?= cin_get_str('social_network_facebook'); ?>' href="https://www.facebook.com/sharer/sharer.php?u=<?=$permalink;?>"></a>
                        <a target="_blank" class="socials-post twitter" aria-label='<?= cin_get_str('social_network_twitter'); ?>' href="https://twitter.com/home?status=<?=$permalink;?>"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php if ($lecturer) :?>
    <div class="lecturer-about-course">
        <div class="container">
            <div class="row">
                <h2 class="course-staff-title"><?=  cin_get_str('participants');?>:</h2>
            </div>
            <div class="row">
                <?php foreach ($lecturer as $lecturer_single):
                    $lecturer_single_id = $lecturer_single->ID;
                    $rol_single_course = get_field('role', $lecturer_single_id);
                    $email_lecturer = get_field('email', $lecturer_single_id);
                    $site_link = get_field('site_link', $lecturer_single_id);
                    $org_lecturer = get_field('academic_institution', $lecturer_single_id);
                    ?>

                    <div class="single-lecturer">
                        <?php
                        $img_lecturer = '';
                        if(get_the_post_thumbnail_url($lecturer_single_id)){
                            $img_exsist = get_the_post_thumbnail_url($lecturer_single_id) ? get_the_post_thumbnail_url($lecturer_single_id,'medium') : get_bloginfo('stylesheet_directory') .'/assets/images/campus_avatar.png' ;
                        }?>
                        <div class="img-lecturer circle-image-lecturer" style="background-image: url(<?= $img_exsist; ?>)" aria-label="<?= $lecturer_single->post_title; ?>"></div>
                        <div class="content-lecturer">
                            <div class="lecturer-title"><?= $lecturer_single->post_title; ?></div>
                            <p class="lecturer-role"><?= $rol_single_course; ?></p>
                            <div id="popup_lecturer" class="single-lecturer-popup single-close-wrap dialog" role="dialog" aria-model="true">
                                <button type="button" class="close close-lecturer last-popup-element first-popup-element close-popup-button" tabindex="0" aria-label='<?= __('close','single_corse'); ?>'>X</button>
                                <div class="img-lecturer-popup circle-image-lecturer" aria-label="<?= $lecturer_single->post_title; ?>" style="background-image: url(<?= $img_exsist; ?>)"></div>
                                <h2 class="lecturer-title-popup"><?= $lecturer_single->post_title; ?></h2>
                                <div class="lecturer-role-popup-wrap">
                                    <?php if($rol_single_course){ ?>
                                         <span class="lecturer-role-popup"><?= $rol_single_course; ?></span>
                                    <?php } ?>
                                    <?php if($org_lecturer): ?>
                                        <span class="lecturer-role-popup"> | <?= $org_lecturer->post_title; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="lecturer-content"><?= $lecturer_single->post_content; ?></div>
                            </div>
                            <?php if($lecturer_single->post_content): ?>
                                <p aria-label="<?=  cin_get_str('about_me'); ?>: <?= $lecturer_single->post_title; ?> " aria-pressed="true" aria-haspopup="true" role="button" tabindex="0" class="lecturer-little-about open-popup-button"><?= cin_get_str('about_me'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if($more_events = $fields['more_events']) {

    echo "
    <div class='more-courses-section'>
        <div class='container'>
            <div class='row'>
                <h3 class='col-12  more-courses-interest'>". cin_get_str('more_events_title') ."</h3>
            </div>
            <div class='row more-courses-inner' id='single_course_related_container'>
                ";
                foreach($more_events as $post){
                    setup_postdata($post);
                    echo draw_event_item(array(
                        'class' => 'col-sm-12 col-md-6 col-lg-4 col-xl-3 course-item-with-border'
                    ));
                }
                wp_reset_postdata();
                echo "
            </div>
            <div class='row justify-content-center'>
                <p class='course-page-bottom-info'>". cin_get_str('text_before_archive_link_single_page_event') .":</p>
            </div>
            <div class='row justify-content-center for-all-courses'>
                <a class='for-all-courses-link' href='". get_post_type_archive_link(  'event' ) ."'>". cin_get_str('all_events') ."</a>
            </div>
        </div>
    </div>";
}
