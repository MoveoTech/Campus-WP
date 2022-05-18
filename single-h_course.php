<?php
global $site_settings, $fields;

//fields on Course page
$permalink = get_permalink();

$course_id_edx = $fields['course_id_edx'];

$what_is_explanation = $site_settings['what_is_explanation'];
$course_banner = $fields['course_banner'];
$time_now = strtotime(date('Y-m-d'));

$enrollment_start = $fields['enrollment_start'];
//$new = str_replace('/','-',$enrollment_start);
if ($enrollment_start)
    $time_st_enrollment_start = get_course_strtotime($enrollment_start);

$enrollment_end = $fields['enrollment_end'];
if ($enrollment_end)
    $time_st_enrollment_end = get_course_strtotime($enrollment_end);

$start = $fields['start'];
$time_st_start = strtotime($start);

$end = $fields['end'];
if ($end)
    $time_st_end = get_course_strtotime($end);

$price = $fields['price'];
$duration = $fields['duration'];
$description = $fields['description'];
$syllabus = $fields['syllabus'];

$corporation_institution = $fields['corporation_institution'];
$subject_of_daat = $fields['subject_of_daat'];
$duration = $fields['duration'];
$pacing = $fields['pacing'];
$language_course = $fields['language_course'];
$subtitle_lang = $fields['subtitle_lang'];
$prior = $fields['prior_knowledge'];
$ele_prior = "";

if ($prior) {
    switch ($prior) {
        case 'none':
            $ele_prior = __('None', 'single_corse');
            break;
        case 'string':
            $ele_prior = $fields['string_prior_knowledge'];
            break;
        case 'link':
            $link_target = $fields['link_prior_knowledge']['target'] ? $fields['link_prior_knowledge']['target'] : '_self';
            $ele_prior = '<a href="' . $fields['link_prior_knowledge']['url'] . '" target="' . esc_attr($link_target) . '">' . $fields['link_prior_knowledge']['title'] . '</a>';
            break;
    }
}
$mobile_available = $fields['mobile_available'];
$certificate = $fields['certificate'];


$knowledge = $fields['knowledge'];
$more_details = $fields['more_details'];

echo '<div style="display: none;">';
//user connect
$is_connect_to_site = false;
//$cookie_name = get_field('cookie_name', 'options');
//if (isset($_COOKIE[$cookie_name]) && !empty($_COOKIE[$cookie_name])) {
//    $is_connect_to_site = true;
//}
if (isset($_COOKIE['edxloggedin']) && !empty($_COOKIE['edxloggedin'])) {
    $is_connect_to_site = $_COOKIE['edxloggedin'];
}
var_dump($_COOKIE['edxloggedin']);
echo '</div>';
$banner_btn_text = $str_time_course = '';
$time_course = '';
$time_course_n_con = "";
$class_link = '';
$link_btn = $site_settings['link_to_api_courses'] . "/courses/" . $course_id_edx . "/info";
$link_dashboard = $site_settings['link_to_dashboard_for_campus'];
$register_api_n_con = false;
$data_end_api = '';
$two_btn = false; // שני כפתורים אחד - אם המשתמש רשום לקורס והשני אם משתמש לא רשום לקורס
$class_link_n_con = $enroll_time_n_con = $data_end_api_n_con = $link_btn_n_con = '';


if (!$is_connect_to_site) {//משתמש שלא רשום לאתר בכל מקרה קודם צריך להרשם לאתר
    $banner_btn_text = cin_get_str('registration_to_campus');
    $encoded_path = urlencode($_SERVER['REQUEST_URI']);
    $link_btn = $site_settings['link_to_login_and_register'] . "/login?next=/home" . $encoded_path;

} else {
    $banner_btn_text = $fields['logged_in_banner_btn_text'];
    $link_btn = $fields['logged_in_banner_btn_link'];
}


/*טקסט שיופיע על הקוביה עם נתוני הקורס*/
if ($pacing == 'self') {
    // עבור קורסים בלימוד עצמי - כאשר היום הוא בין תאריך התחלה וסיום של הקורס - צריך להיות כתוב טקסט ייעודי שינוהל בתרגומים, ולא תאריך ההתחלה
    if ($time_st_start <= $time_now && $time_st_end >= $time_now) {
        $start_text = cin_get_str('selp_pacing_start_text');
    }
}
if ($start) {
    $start = date('d/m/Y', strtotime($start));
    if ($enrollment_start && ($time_st_enrollment_start > $time_now)) {//לפני תחילת ההרשמה
        $time_course = __('Registration starts at', 'single_corse');
        $str_time_course = $time_course . ' ' . $enrollment_start . ', ';
        $time_course = __('The course will begin on', 'single_corse');
        $str_time_course .= $time_course . ' ' . $start;
    } elseif ($time_st_start > $time_now) {//הקורס לא התחיל - וההרשמה פתוחה
        $time_course = __('The course will begin on', 'single_corse');
        $str_time_course = $time_course . ' ' . $start . ', ';
        $time_course = __('Registration is open', 'single_corse');
        $str_time_course .= $time_course;
    } elseif ($time_st_start <= $time_now && $time_st_end >= $time_now) {//בין בין תאריכי הקורס
        $time_course = __('The course is open', 'single_corse');
        if (!($enrollment_end && ($time_st_enrollment_end < $time_now))) {
            $time_course .= '. ' . __('Registration is open', 'single_corse');
        }
    } elseif ($enrollment_end && ($time_st_enrollment_end >= $time_now)) {//לפני תאריך סיום ההרשמה
        $time_course = __('The course is over. Viewing content is possible', 'single_corse');
    } else {
//        $time_course_n_con = __("The course is over" ,'single_corse');
        if ($is_connect_to_site)
            $time_course = __('The course is over. Viewing content is possible', 'single_corse');
        else
            $time_course = __('The course is over', 'single_corse');
    }
} else {
    $time_course = __("The course is under development. The running dates will be published later", 'single_corse');
}
if (!$str_time_course) {
    $str_time_course = $time_course;
}
/*codes error to enroll a user in a course*/
$codes_error_api = $site_settings['codes_error_api'];
if ($codes_error_api) {
    foreach ($codes_error_api as $code_error) {
        echo '<div class="code-error-api" hidden data-code-error="' . $code_error['code'] . '">' . $code_error['text_error'] . '</div>';
    }
}
echo '<div class="unknown_code_error_api" hidden>' . $site_settings['unknown_code_error_api'] . '</div>';
echo '<div class="signed_up_course" hidden>' . __('Registration to course', 'single_corse') . '</div>';

$btn = '<a id="hybrid_banner_btn" class="signup-course-button con_to_course ' . $class_link . '" target="_blank" href="' . $link_btn . '">' . $banner_btn_text . '</a>';

$_content = '';
if ($fields['banner_logo']) {
    $_content = '<span class="img_wrap"><img src="' . $fields['banner_logo']['url'] . '" alt="' . $fields['banner_logo']['alt'] . '"/></span>';
}
$title = $fields['title_on_banner_hybrid_course'];
$title = $title ? wrap_text_with_char($title) : $post->post_title;
$_content .= "<h1 id='hybrid_banner_h1'>" . $title . "</h1>";
$_content .= "<div id='hybrid_banner_content'>{$fields['banner_content']}</div>";
$_content .= $btn;

$args = array(
    'banner_image_desktop' => $fields['banner_for_desktop'],
    'banner_image_mobile' => $fields['banner_for_mobile'],
    'content' => $_content,
    'bg_color' => 'light_blue'
);

set_query_var('banner_args', $args);
get_template_part('templates/banner', 'half_img');

?>
<?php
$js_code = get_field("js_code");
if (!empty($js_code)) {
    echo '<script type="text/javascript">' . $js_code . '</script>';
}
?>
    <div class="information-bar" data-course_id_edx="<?= $course_id_edx ?>">
        <div class="container">
            <div class="row information-bar-inner justify-content-between">
                <div class="col-12 col-md-8">
                    <div class="row">
                        <?php if ($start) : ?>
                            <div class="start-bar-info col-4 col-sm-4">
                                <div class="start-date-title-bar title-bar"><?php echo __('Start Date', 'single_corse'); ?></div>
                                <p class="text-bar-course"><?php echo $start_text ? $start_text : $start; ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($price) : ?>
                            <div class="price-bar-info col-3 col-sm-4">
                                <div class="price-course-bar title-bar"><?= __('Price', 'single_corse'); ?></div>
                                <p class="text-bar-course"><?php echo __($price, 'single_corse'); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($duration) : ?>
                            <div class="duration-bar-info col-5 col-sm-4">
                                <div class="duration-bar title-bar"><?= __('Course Duration', 'single_corse'); ?></div>
                                <p class="text-bar-course"><?php echo __($duration, 'single_corse'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                if ($org = $fields['org']) : ?>
                    <div class="uni-logo1 col-6 col-sm-2 align-self-center">
                        <?php $img_insti_id = $org->ID; ?>
                        <a href="<?= get_permalink($org->ID); ?>">
                            <img alt='<?= cin_get_str('logo_h_course_alt'); ?>' src="<?= get_the_post_thumbnail_url($img_insti_id, 'thumbnails'); ?>"
                                 alt="<?php $org->post_title; ?>"/>
                        </a>
                    </div>
                <?php endif;
                if(!$fields['hide_org_in_course_page'])
                    if ($institution = $fields['assimilation_organizations']) :
                        $institution = $institution[0]; ?>
                        <div class="uni-logo2 col-6 col-sm-2">
                            <div class="hybrid_info_bar_title"><?= cin_get_str('hybrid_embedded_by'); ?></div>
                            <a href="<?= get_permalink($institution->ID); ?>">
                            <img alt='<?= cin_get_str('logo_h_course2_alt'); ?>' src="<?php the_field('ins_icon', $institution->ID); ?>"
                                 alt="<?php $institution->post_title; ?>"/>
                            </a>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
    </div>
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
                        <?php if (!empty(get_the_content())) : ?>
                            <p role="heading" aria-level="2" class="title-description"><?= __('Description', 'single_corse'); ?>:</p>
                            <div class="text-description-of-course">
                            <span class="read-more-text">
                               <?php echo wpautop(get_the_content()); ?>
                            </span>
                            </div>
                            <button class="course_test_type_readmore course_test_readmore_collapse collapsed"
                                    aria-hidden="true" aria-expanded="false">
                                <span aria-label='<?= __('read more', 'single_corse'); ?>'><?= __('Read More', 'single_corse'); ?></span>
                                <span aria-label='<?= __('read less', 'single_corse'); ?>'><?= __('Read Less', 'single_corse'); ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-12 col-lg-4 info-course-list">
                    <div class="wrap-info-single-course">
                        <div class="course-info-times">
                            <span class="con_to_course" role="heading" aria-level="2"><?= $str_time_course ?></span>
                            <span class="user_not_con_to_course"><?= __($time_course_n_con, 'single_corse'); ?></span>
                        </div>
                        <div class="wrap-info-single-course-inner">
                            <div class="content-info-wrap">
                                <?php if ($org) : ?>
                                    <div class="">
                                        <span class="org info-course-list-bold"><?= cin_get_str('hybrid_course_org_name'); ?>:</span>
                                        <span><?= $org->post_title ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($institution && !$fields['hide_org_in_course_page']) : ?>
                                    <div class="corporation_institution info-course">
                                        <span class="info-course-list-bold"><?= cin_get_str('hybrid_embedded_by'); ?>:</span>
                                        <a href="<?= get_permalink($institution->ID) ?>"
                                           class="item_corporation_institution"
                                           target="_blank"> <?= $institution->post_title; ?>
                                            <img class="corporation_img" src="<?php the_field('ins_icon', $institution->ID); ?>" />
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if ($duration) : ?>
                                    <div class="">
                                        <span class="duration info-course-list-bold"><?= __('Duration', 'single_corse'); ?>:</span>
                                        <span><?= __($duration, 'single_corse'); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($start) : ?>
                                    <div class="">
                                        <span class="start info-course-list-bold"><?= __('Start Date', 'single_corse'); ?>:</span>
                                        <span><?= $start_text ? $start_text : $start; ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($end) : ?>
                                    <div class="">
                                        <span class="end info-course-list-bold"><?= __('End Date', 'single_corse'); ?>:</span>
                                        <span><?= $end; ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($price) : ?>
                                    <div class="">
                                        <span class="price info-course-list-bold"><?= __('Price', 'single_corse'); ?>:</span>
                                        <span><?= __($price, 'single_corse'); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($language_course) : ?>
                                    <div class="">
                                        <span class="language info-course-list-bold"><?= cin_get_str('Language'); ?>:</span>
                                        <span><?= $language_course->name; ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($subtitle_lang) : ?>
                                    <div class="">
                                        <span class="subtitle_lang info-course-list-bold"><?= cin_get_str('Subtitle_language'); ?>:</span>
                                        <?php foreach ($subtitle_lang as $lang): ?>
                                            <span class="info_lang_span"><?= $lang->name; ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="sharing" role="list">
                        <span class="sharing-text"><?= __('Sharing: ', 'single_corse'); ?></span>
                        <a target="_blank" class="socials-post linkdin"
                           href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $permalink; ?>" aria-label='<?= cin_get_str('social_network_linkedin2'); ?>'></a>
                        <a target="_blank" class="socials-post facebook"
                           href="https://www.facebook.com/sharer/sharer.php?u=<?= $permalink; ?>" aria-label='<?= cin_get_str('social_network_facebook2'); ?>'></a>
                        <a target="_blank" class="socials-post twitter"
                           href="https://twitter.com/home?status=<?= $permalink; ?>" aria-label='<?= cin_get_str('social_network_twitter2'); ?>'></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lecturer-about-course" id="hybrid_course_team">
        <div class="container">
            <div class="row">
                <?php
                $align = '';

                $persons_list = array(
                    'course_team',
                    'training_team'
                );
                foreach ($persons_list as $list) {
                    if ($course_team = $fields[$list]) { ?>
                        <div class="col-md-12 col-lg-6 hybrid_course_team_side">
                            <h2 class="course-staff-title"><?= cin_get_str('hybrid_course_' . $list . '_title'); ?>
                                :</h2>
                            <div class="row ">
                                <?php foreach ($course_team as $lecturer_single) {
                                    $lecturer_single_id = $lecturer_single->ID;
                                    $rol_single_course = get_field('role', $lecturer_single_id);
                                    $email_lecturer = get_field('email', $lecturer_single_id);
                                    $site_link = get_field('site_link', $lecturer_single_id);
                                    $org_lecturer = get_field('academic_institution', $lecturer_single_id);
                                    ?>
                                    <div class="col-lg-6 col-xl-4 col-md-12 single-lecturer-wrap">
                                        <div class="single-lecturer">
                                            <?php
                                            $img_lecturer = '';
                                            if (get_the_post_thumbnail_url($lecturer_single_id)) {
                                                $img_exsist = get_the_post_thumbnail_url($lecturer_single_id) ? get_the_post_thumbnail_url($lecturer_single_id, 'medium') : get_bloginfo('stylesheet_directory') . '/assets/images/campus_avatar.png';
                                            } ?>
                                            <div class="img-lecturer circle-image-lecturer"
                                                 style="background-image: url(<?= $img_exsist; ?>)" aria-label='<?= $lecturer_single->post_title;?> <?= $rol_single_course; ?>'></div>
                                            <div class="content-lecturer">
                                                <h3 class="lecturer-title"><?= $lecturer_single->post_title; ?></h3>
                                                <p class="lecturer-role"><?= $rol_single_course; ?></p>
                                                <div id="popup_lecturer" class="single-lecturer-popup dialog"
                                                     role="dialog"
                                                     aria-model="true" aria-hidden="true">
                                                    <button type="button"
                                                            class="close close-lecturer last-popup-element first-popup-element close-popup-button"
                                                            tabindex="0"
                                                            aria-label='<?= __('close', 'single_corse'); ?>'>X
                                                    </button>
                                                    <div aria-label='<?= $lecturer_single->post_title; ?>' class="img-lecturer-popup circle-image-lecturer"
                                                         style="background-image: url(<?= $img_exsist; ?>)"></div>
                                                    <h2 class="lecturer-title-popup"><?= $lecturer_single->post_title; ?></h2>
                                                  <div class="lecturer-role-popup-wrap">
                                                      <?php if($rol_single_course){ ?>
                                                          <span class="lecturer-role-popup"><?= $rol_single_course; ?></span>
                                                      <?php } ?>
                                                      <?php if ($org_lecturer) { ?>
                                                          <span class="lecturer-role-popup"> | <?= $org_lecturer->post_title; ?></span>
                                                      <?php } ?>
                                                  </div>
                                                    <div class="lecturer-content"><?= $lecturer_single->post_content; ?></div>
                                                </div>
                                                <?php if ($lecturer_single->post_content) { ?>
                                                    <p aria-label='<?= cin_get_str('about_me'); ?>: <?= $lecturer_single->post_title; ?> '
                                                       aria-pressed="true" aria-haspopup="true" role="button"
                                                       tabindex="0"
                                                       class="lecturer-little-about open-popup-button"><?= cin_get_str('about_me'); ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
<?php

if ($more_courses = $fields['more_courses']) {
    echo "
    <div id='hybrid_course_more_items_wrap' class='more-courses-section'>
        <div class='container'>
            <div class='row'>
                <h3 class='col-12  more-courses-interest'>" . cin_get_str('other_course') . "</h3>
            </div>
            <div class='more-courses-inner' id='hybrid_course_more_items'>
                ";
    foreach ($more_courses as $post) {
        setup_postdata($post);
        echo draw_course_item(array(
            'class' => 'col-sm-12 col-md-6 col-lg-4 col-xl-3 course-item-with-border',
            'hybrid_course' => true
        ));
    }
    wp_reset_postdata();
    echo "
            </div>
            <p class='course-page-bottom-info'>" . cin_get_str('text_before_archive_link_single_page') . ":</p>
            <a class='for-all-courses-link' href='" . get_permalink($institution->ID) . "'>" . cin_get_str('All_Courses') . "</a>
        </div>
    </div>";
}