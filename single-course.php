<?php
/**
 * Created by PhpStorm.
 * User: estero
 * Date: 23/10/2018
 * Time: 13:51
 */

//Course Page

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
$org = $fields['org'];
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
$course_video = $fields['course_video'];


$lecturer = $fields['lecturer'];
$testimonials = $fields['testimonial'];
$knowledge = $fields['knowledge'];
$more_details = $fields['more_details'];

echo '<div style="display: none;">';
//user connect
$is_connect_to_site = false;
$cookie_name = get_field('cookie_name', 'options');
if (isset($_COOKIE[$cookie_name]) && !empty($_COOKIE[$cookie_name])) {
    $is_connect_to_site = true;
}
if (isset($_COOKIE['edxloggedin']) && !empty($_COOKIE['edxloggedin'])) {
    $is_connect_to_site = $_COOKIE['edxloggedin'];
}
//if($_COOKIE['edxloggedin'] !== true){
//    if($_COOKIE[get_field('cookie_name','options')]){
//        $is_connect_to_site = $_COOKIE['edxloggedin'];
//    }
//
//}
echo '</div>';
$enroll_time = $str_time_course = '';
$time_course = '';
$time_course_n_con = "";
$class_link = '';
$link_btn = $site_settings['link_to_api_courses'] . "/courses/" . $course_id_edx . "/info";
$link_dashboard = $site_settings['link_to_dashboard_for_campus']; // TODO change for koastage
$register_api_n_con = false;
$data_end_api = '';
$two_btn = false;// שני כפתורים אחד - אם המשתמש רשום לקורס והשני אם משתמש לא רשום לקורס
$class_link_n_con = $enroll_time_n_con = $data_end_api_n_con = $link_btn_n_con = '';
$external_link = get_field('external_link');
if (!$is_connect_to_site) {//משתמש שלא רשום לאתר בכל מקרה קודם צריך להרשם לאתר
    $enroll_time = cin_get_str('registration_to_campus');
    $encoded_path = urlencode($_SERVER['REQUEST_URI']);
    $link_btn = $site_settings['link_to_login_and_register'] . "/login?next=/home" . $encoded_path; // TODO change for koastage

} elseif (!empty($external_link)) {//קורס במערכת חיצונית
    $link_btn = $link_btn_n_con = $external_link;
    $enroll_time = $enroll_time_n_con = cin_get_str('external_link');
    $str_time_course = cin_get_str('external_link_more_text');
    $two_btn = true;
    $register_api_n_con = true;
    $data_end_api_n_con = 'dashboard';

} else if (empty($enrollment_start) || $time_st_enrollment_start > $time_now) {//לפני פתיחת ההרשמה
    $enroll_time = __('Registration will begin soon', 'single_course');;
    $class_link = 'disabled';

} elseif (!empty($enrollment_end) && $time_st_enrollment_end < $time_now) {//אחרי סיום ההרשמה
    $two_btn = true;

    $enroll_time = cin_get_str('Course_Page');

    $enroll_time_n_con = __('Registration completed', 'single_course');
    $class_link_n_con = 'disabled';
} else { //בין פתיחת ההרשמה
    $two_btn = true;
    if ($time_st_start > $time_now) {//לפתיחת הקורס
        $class_link = 'disabled';
        $enroll_time = __('Start soon', 'single_course');

        $enroll_time_n_con = cin_get_str('Enroll');
        $data_end_api_n_con = 'popup';//עוברים לפופאפ
        $register_api_n_con = true;
    } elseif ($time_st_end >= $time_now) {//בין תחילת הקורס לסיום הקורס
        $enroll_time = cin_get_str('Course_Page');

        $enroll_time_n_con = cin_get_str('Enroll');
        $data_end_api_n_con = 'dashboard';//עוברים למערכת ניהול של הקמפוס - קורסים
        $link_btn_n_con = $link_dashboard;
        $register_api_n_con = true;
    } else {//בין סיום הקורס לסיום ההרשמה
        $enroll_time = cin_get_str('Course_Page');
        $data_end_api = 'course';//עוברים לדף הבית של הקורס

        $enroll_time_n_con = cin_get_str('Enroll');
        $data_end_api_n_con = 'dashboard';//עוברים למערכת ניהול של הקמפוס - קורסים
        $link_btn_n_con = $link_dashboard;
        $register_api_n_con = true;
    }
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
        $time_course = __('The course is open', 'single_course');
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

$link = $course_video;
$query_string = array();
parse_str(parse_url($link, PHP_URL_QUERY), $query_string);

$video_id = ($link) ? $query_string["v"] : '';
?>
<?php if ($course_banner) {
    $title = $fields['title_on_banner_course'];
    $title = $title ? wrap_text_with_char($title) :  get_the_title();
    $banner_for_mobile = $fields['banner_for_mobile_course'];
    $class = 'about-course gray-part';
    $text_on_banner_content = '';
    $text_on_banner_content .= '<h1 class="title-course">' . $title . '</h1>';
    $text_on_banner_content .= '<p class="excerpt-course">' . get_the_excerpt() . '</p>';
    $text_on_banner_content .= '<span class="signup-course-button-wrap">';

    $text_on_banner_content .= '<a class="signup-course-button con_to_course ' . $class_link . '" target="_blank" href="' . $link_btn . '">' . $enroll_time . '</a>';

    if ($two_btn) {//button - to connect to course and button - no connect to course
        if ($register_api_n_con) {
            $text_on_banner_content .= '<button class="signup-course-button register_api user_not_con_to_course ' . $class_link_n_con . '" data-link-end="' . $link_btn_n_con . '" data-id-course="' . $course_id_edx . '" data-action-end-api="' . $data_end_api_n_con . '">' . $enroll_time_n_con . '</button>';
        } else {
            $text_on_banner_content .= '<a class="signup-course-button user_not_con_to_course ' . $class_link_n_con . '" target="_blank" href="' . $link_btn_n_con . '">' . $enroll_time_n_con . '</a>';
        }
    }
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
} ?>
<?php
$js_code = get_field("js_code");
if (!empty($js_code)) {
    echo '<script type="text/javascript">' . $js_code . '</script>';
}
?>
<div class="information-bar" data-course_id_edx="<?= $course_id_edx ?>">
    <div class="container">
        <div class="row information-bar-inner">
            <div class="col-12 col-xl-9 col-md-10 col-sm-12 col-lg-10">
                <div class="row">
                    <?php if ($start) : ?>
                        <div class="start-bar-info col-xs-5 col-5 col-sm-4 col-md-3 col-lg-4 col-xl-4">
                            <div class="start-date-title-bar title-bar"><?php echo __('Start Date', 'single_corse'); ?></div>
                            <p class="text-bar-course"><?php echo $start_text ? $start_text : $start; ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($price) : ?>
                        <div class="price-bar-info ol-xs-3 col-2 col-sm-3 col-md-2 col-lg-2 col-xl-3">
                            <div class="price-course-bar title-bar"><?= __('Price', 'single_corse'); ?></div>
                            <p class="text-bar-course"><?php echo __($price, 'single_corse'); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($duration) : ?>
                        <div class="duration-bar-info col-xs-4 col-5 col-sm-5 col-md-4 col-lg-6 col-xl-5">
                            <div class="duration-bar title-bar"><?= __('Course Duration', 'single_corse'); ?></div>
                            <p class="text-bar-course"><?php echo __($duration, 'single_corse'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($org) : ?>
                <div class="org-logo d-flex row justify-content-end col-12 col-xl-2 col-md-2 col-sm-3 col-lg-2 align-items-center">
                    <?php $img_insti_id = $org->ID; ?>
                    <a aria-label='<?= $org->post_title ?>' href="<?= get_permalink($org->ID); ?>">
                        <div style="background-image: url(<?= get_the_post_thumbnail_url($img_insti_id, 'thumbnails'); ?>)"
                             class="academic-course-image"></div>
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
                        <p class="title-description"><?= __('Description', 'single_corse'); ?>:</p>
                        <div class="text-description-of-course">
                            <span class="read-more-text">
                               <?php echo wpautop(get_the_content()); ?>
                            </span>
                        </div>
                        <button class="course_test_type_readmore course_test_readmore_collapse collapsed"
                                aria-hidden="true">
                            <span aria-label='<?= __('read more', 'single_corse'); ?>'><?= __('Read More', 'single_corse'); ?></span>
                            <span aria-label='<?= __('read less', 'single_corse'); ?>'><?= __('Read Less', 'single_corse'); ?></span>
                        </button>
                    <?php endif; ?>
                    <?php if ($syllabus) : ?>
                        <div class="syllabus-course-page">
                            <a aria-label='<?= __('syllabus link to pdf file', 'single_corse'); ?>' target="_blank"
                               href="<?= $syllabus; ?>"><?= __('Full Syllabus', 'single_corse'); ?></a>
                        </div>
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
                                    <span class="org info-course-list-bold"><?= cin_get_str('Institution_Name'); ?>:</span>
                                    <span><?= $org->post_title ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($corporation_institution) : ?>
                                <div class="corporation_institution info-course">
                                    <span class="info-course-list-bold"><?= __('In Collaboration With', 'single_corse'); ?>:</span>
                                    <?php
                                    foreach ($corporation_institution as $item) {
                                        ?>
                                        <a href="<?= get_permalink($item->ID) ?>" class="item_corporation_institution"
                                           target="_blank"> <?= $item->post_title; ?>
                                            <img class="corporation_img"
                                                 src="<?= get_the_post_thumbnail_url($item->ID, 'medium'); ?>">
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($subject_of_daat) : ?>
                                <div class="info_subject">
                                    <span class="subject info-course-list-bold"><?= cin_get_str('Subjects'); ?>:</span>
                                    <?php foreach ($subject_of_daat as $subject_of_daat_item) { ?>
                                        <span class="info_subject_span"><?= $subject_of_daat_item->name; ?></span>
                                    <?php } ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($duration) : ?>
                                <div class="">
                                    <span class="duration info-course-list-bold"><?= __('Duration', 'single_corse'); ?>:</span>
                                    <span><?= __($duration, 'single_corse'); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($pacing) : ?>
                                <div class="">
                                    <span class="pacing info-course-list-bold"><?= cin_get_str('Course_Pace'); ?>:</span>
                                    <span><?= __($pacing, 'single_corse'); ?></span>
                                    <div role="button" tabindex="0"
                                         class="what_is_pacing"><?= __('What Is This', 'single_corse'); ?>
                                        <div class="what_is_pacing_explanation"><?= $what_is_explanation ? $what_is_explanation : ''; ?>
                                            <div class="triangle-with-shadow">▼</div>
                                        </div>
                                    </div>
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
                            <?php if ($prior) : ?>
                                <div class="">
                                    <span class="prior info-course-list-bold"><?= __('Prior knowledge', 'single_corse'); ?>:</span>
                                    <span><?= $ele_prior; ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($mobile_available) : ?>
                                <div class="">
                                    <span class="mobile_available info-course-list-bold"><?= __('Mobile', 'single_corse'); ?>:</span>
                                    <span><?= __('Includes support', 'single_corse'); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($certificate) : ?>
                                <div class="">
                                    <span class="certificate info-course-list-bold"><?= __('Diploma', 'single_corse'); ?>:</span>
                                    <span><?= $certificate->name; ?> </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="sharing">
                    <span class="sharing-text"><?= __('Sharing: ', 'single_corse'); ?></span>
                    <a target="_blank" class="socials-post linkdin" aria-label='<?= cin_get_str('social_network_linkedin'); ?>'
                       href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $permalink; ?>"></a>
                    <a target="_blank" class="socials-post facebook" aria-label='<?= cin_get_str('social_network_facebook'); ?>'
                       href="https://www.facebook.com/sharer/sharer.php?u=<?= $permalink; ?>"></a>
                    <a target="_blank" class="socials-post twitter" aria-label='<?= cin_get_str('social_network_twitter'); ?>'
                       href="https://twitter.com/home?status=<?= $permalink; ?>"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($lecturer) : ?>
    <div class="lecturer-about-course">
        <div class="container">
            <div class="row">
                <h2 class="course-staff-title"><?= __('The course staff', 'single_corse'); ?>:</h2>
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
                        if (get_the_post_thumbnail_url($lecturer_single_id)) {
                            $img_exsist = get_the_post_thumbnail_url($lecturer_single_id) ? get_the_post_thumbnail_url($lecturer_single_id, 'medium') : get_bloginfo('stylesheet_directory') . '/assets/images/campus_avatar.png';
                        } ?>
                        <div class="img-lecturer circle-image-lecturer" aria-label='<?= $lecturer_single->post_title; ?>'
                             style="background-image: url(<?= $img_exsist; ?>)"></div>
                        <div class="content-lecturer">
                            <div class="lecturer-title"><?= $lecturer_single->post_title; ?></div>
                            <p class="lecturer-role"><?= $rol_single_course; ?></p>
                            <div id="popup_lecturer" class="single-lecturer-popup dialog" role="dialog"
                                 aria-model="true" aria-hidden="true">
                                <button type="button"
                                        class="close close-lecturer last-popup-element first-popup-element close-popup-button"
                                        tabindex="0" aria-label='<?= __('close', 'single_corse'); ?>'>X
                                </button>
                                <div class="img-lecturer-popup circle-image-lecturer"
                                     style="background-image: url(<?= $img_exsist; ?>)"></div>
                                <h2 class="lecturer-title-popup"><?= $lecturer_single->post_title; ?></h2>
                                <div class="lecturer-role-popup-wrap">
                                    <?php if($rol_single_course){ ?>
                                        <span class="lecturer-role-popup"><?= $rol_single_course; ?></span>
                                    <?php } ?>
                                    <?php if ($org_lecturer): ?>
                                        <span class="lecturer-role-popup"> | <?= $org_lecturer->post_title; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="lecturer-content"><?= $lecturer_single->post_content; ?></div>
                            </div>
                            <?php if ($lecturer_single->post_content): ?>
                                <p aria-label='<?= cin_get_str('about_me'); ?>: <?= $lecturer_single->post_title; ?> '
                                   aria-pressed="true" aria-haspopup="true" role="button" tabindex="0"
                                   class="lecturer-little-about open-popup-button"><?= cin_get_str('about_me'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($testimonials) : ?>
    <div class="testimonial-course-page">
        <div class="container">
            <div class="row testimonials-course-page-items">
                <h4 class="col-12 title_of_testimonials"><?= cin_get_str('Learners_Testimonials'); ?>:</h4>
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="col-md-12 col-lg-6 testimonials-course-page-items-inner">
                        <?php $img_testimonial = get_bloginfo('stylesheet_directory') . '/assets/images/quotesmall.png'; ?>
                        <div class="img-quotesmall testimonial-course-page-img"
                             style="background-image: url(<?= $img_testimonial ?>)" class="quotesmall"></div>
                        <div class="quote-text-course-page"><?= $testimonial->post_content; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($more_details) : ?>
    <div class="more_details">
        <div class="container">
            <div class="more_details-text"><?= $more_details; ?></div>
        </div>
    </div>
<?php endif; ?>

<!--more courses area 4 posts-->

<!--the terms returns an id not an object-->
<div class="more-courses-section">
    <div class="container">
        <div class="row">
            <h3 class="col-12  more-courses-interest"><?= cin_get_str('other_course'); ?></h3>
        </div>
        <div class="row more-courses-inner" id="single_course_related_container">
            <?php
            for ($i = 0; $i < 4; $i++) {
                echo '<div class="course-item-inner load_related_courses col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="course_wrap">
                                <a class="course_top"></a>
                                <a class="course-bottom">
                                    <div class="course-content">
                                        <div class="course-title"></div>
                                        <div class="course-title second"></div>
                                        <p class="course-text"></p>
                                        <div class="course_duration"></div>
                                    </div>
                                </a>
                            </div>
                        </div>';
            }
            ?>
        </div>
        <div class="row justify-content-center">
            <p class="course-page-bottom-info"><?= cin_get_str('text_before_archive_link_single_page'); ?>:</p>
        </div>
        <div class="row justify-content-center for-all-courses">
            <a class="for-all-courses-link"
               href="<?= get_post_type_archive_link('course'); ?>"><?= cin_get_str('All_Courses'); ?></a>
        </div>
    </div>
</div>
<?php global $sitepress; ?>
<script>
    jQuery.ajax({
        url: '<?= get_bloginfo('stylesheet_directory'); ?>/assets/ajax/related_courses.php',
        data: {post_id: <?= $post->ID; ?>, lang: '<?= $sitepress->get_current_language(); ?>'},
        method: 'POST'
    }).done(function (data) {
        jQuery('#single_course_related_container').html(data);
    });
</script>