<?php
/**
 * Template Name: Single Course
 * Created by Ali Khutaba.
 * Date: 06/02/2022
 * Time: 14:00
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>

<body <?php body_class(); ?>>
<!--[if lt IE 9]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
</div>
<![endif]-->
<?php
do_action('get_header');
get_template_part('templates/header');


$slug = pods_v( 'last', 'url' );

$slug = sanitize_text_field(rawurldecode($slug));

$course = pods( 'courses', $slug, true);

/** single pages slugs */
$single_course_slug = 'onlinecourse/';
$single_institution_slug = 'institution/';

// Check if the pod is valid and exists.
if ( false == $course || ! $course->exists()) {
    // The pod item doesn't exists.
    global $wp_query;
    $wp_query->set_404();
    status_header( 404 );
    get_template_part( 404 );
    include locate_template( 'templates/footer.php' );
    exit();
}


global $sitepress, $site_settings, $fields;

$site_settings = get_fields('options');
$what_is_explanation = $site_settings['what_is_explanation'];
$time_now = strtotime(date('Y-m-d'));


//fields on Course page
$name = getFieldByLanguage($course->display('name'), $course->display('english_name'), $course->display('arabic_name') ,$sitepress->get_current_language());
$permalink = getHomeUrlWithoutQuery() . $single_course_slug . $course->display('permalink');
$course_id_edx = $course->display('course_id_edx');
$course_image_banner = $course->display('banner_image');
$enrollment_start = $course->display('enrollment_start');
$enrollment_end = $course->display('enrollment_end');
$start = $course->display('start_date');
$end = $course->display('end_date');
$price = $course->display('price');
$duration = $course->display('duration');
$description = $course->display('course_products');
$content = $course->display('description');
$syllabus = $course->display('syllabus_link');
$duration = $course->display('duration');
$pacing = $course->display('pacing');
$language_course = $course->display('language');
$subtitle_lang = $course->display('subtitle_language');
$mobile_available = $course->display('mobile_available') === 'Yes' ? true : false;
$certificates = $course->display('certificate');
$course_video = $course->display('trailer');
$js_code = $course->display('javascript_code');
$org = $course->display('academic_institution');
$lecturers = $course->field(array('name'=>'lecturer', 'output'=>'pods'));
$testimonials = $course->field(array('name'=>'testimonial', 'output'=>'pods'));
$corporation_institution = $course->field(array('name'=>'corporation_institution', 'output'=>'pods'));
$external_link = $course->display('external_link');
$excerpt = $course->display('excerpt');

$course_attrs = array(
    'class' => 'col-sm-12 col-md-6 col-lg-4 col-xl-3 course-item-with-border',
);

$allLanguagesCertificate =  explode(',',$certificates,3);
$certificate = $allLanguagesCertificate ? getFieldByLanguage($allLanguagesCertificate[0],$allLanguagesCertificate[1],$allLanguagesCertificate[2], $sitepress->get_current_language()) :null;

$relatedCourses = pods( 'courses', array('limit' => 4, 'orderby' => 'RAND()'), true);

// Calc Fields :

$time_st_enrollment_start = $enrollment_start ? get_course_strtotime($enrollment_start) : null;
$time_st_enrollment_end = $enrollment_end ? get_course_strtotime($enrollment_end) : null;
$time_st_start = $start ? strtotime(date('d/m/Y', strtotime($start))) : null;
$time_st_end = $end ? get_course_strtotime($end) : null;
$pacingArray = $pacing ? explode(',', $pacing) : null;
$pacing = $pacingArray ? getFieldByLanguage($pacingArray[0], $pacingArray[1], $pacingArray[2], $sitepress->get_current_language()) : null;
$language_course = $language_course ? getFieldByLanguageFromString($language_course, $sitepress->get_current_language()) : null;

if($subtitle_lang){

    $fieldSubTitleLanguageArray = explode('&', $subtitle_lang);

    $subtitle_lang = array();
    foreach ($fieldSubTitleLanguageArray as $lang){
        array_push($subtitle_lang,getFieldByLanguageFromString($lang, $sitepress->get_current_language()));
    }

}

if (!empty($js_code)) {
    echo '<script type="text/javascript">' . $js_code . '</script>';
}
if($org)
    $org = pods('academic_institution',array('limit'   => -1,'where'   => 't.name = "'. $org . '"'), true);
else
    $org = null;

/** user connect */
$is_connect_to_site = false;
$cookie_name = get_field('cookie_name', 'options');
if (isset($_COOKIE[$cookie_name]) && !empty($_COOKIE[$cookie_name])) {
    $is_connect_to_site = true;
}
if (isset($_COOKIE['edxloggedin']) && !empty($_COOKIE['edxloggedin'])) {
    $is_connect_to_site = $_COOKIE['edxloggedin'];
}
echo '</div>';

$enroll_time = $str_time_course = '';
$time_course = '';
$time_course_n_con = "";
$class_link = '';
$link_btn = $site_settings['link_to_api_courses'] . "/courses/" . $course_id_edx . "/info";
$link_dashboard = $site_settings['link_to_dashboard_for_campus'];
$register_api_n_con = false;
$data_end_api = '';
$two_btn = false;// שני כפתורים אחד - אם המשתמש רשום לקורס והשני אם משתמש לא רשום לקורס
$class_link_n_con = $enroll_time_n_con = $data_end_api_n_con = $link_btn_n_con = '';

if (!$is_connect_to_site) {//משתמש שלא רשום לאתר בכל מקרה קודם צריך להרשם לאתר
    $enroll_time = cin_get_str('registration_to_campus');
    $encoded_path = urlencode($_SERVER['REQUEST_URI']);
    $link_btn = $site_settings['link_to_login_and_register'] . "/login?next=/home" . $encoded_path;

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
if ($pacingArray && $pacingArray[1] = 'self') {
    // עבור קורסים בלימוד עצמי - כאשר היום הוא בין תאריך התחלה וסיום של הקורס - צריך להיות כתוב טקסט ייעודי שינוהל בתרגומים, ולא תאריך ההתחלה
    if ($time_st_start <= $time_now && $time_st_end >= $time_now) {
        $start_text = cin_get_str('selp_pacing_start_text');
    }
}

if ($start) {
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

<?php if ($course_image_banner) {

    $title_on_banner = $course->display('title_on_banner');
    $title = $title_on_banner ? wrap_text_with_char($title_on_banner) :  $name;

    $banner_for_mobile = $course->display('banner_image_for_mobile');

    $class = 'about-course gray-part';
    $text_on_banner_content = '';
    $text_on_banner_content .= '<h1 class="title-course">' . $title . '</h1>';
    $text_on_banner_content .= '<div class="excerpt-course">' . $excerpt . '</div>';
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
        $video_on_banner = '<a href="#"  aria-haspopup="true" role="button" tabindex="0" title="' . $title . '" data-url="https://www.youtube.com/embed/' . $video_id . '?autoplay=1&showinfo=1&autohide=1&rel=0&enablejsapi=1&wmode=transparent" class="popup-about-course-video open-popup-button-2020"></a>';
    } else {
        $video_on_banner = '';
    }
    ?>
    <?= get_banner_area($banner_for_mobile, array('url' => $course_image_banner), $text_on_banner_content, $class, $video_on_banner); ?>
    <?php
} ?>

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
            <?php if ($org) :?>
                <div class="org-logo d-flex row justify-content-end col-12 col-xl-2 col-md-2 col-sm-3 col-lg-2 align-items-center">
                    <a aria-label='<?= $org->display( 'name' ); ?>' href="<?= getHomeUrlWithoutQuery() . $single_institution_slug . $org->display( 'permalink' ); ?>">
                        <div style="background-image: url(<?= $org->display( 'image' ); ?>)" class="academic-course-image"></div>
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
                    <?php if ($content) : ?>
                        <p class="title-description"><?= __('Description', 'single_corse'); ?>:</p>
                        <div class="text-description-of-course">
                            <span class="read-more-text">
                               <?php echo wpautop($content); ?>
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
                                    <span><?= getFieldByLanguage($org->display( 'name' ), $org->display( 'english_name' ), $org->display( 'arabic_name' ),$sitepress->get_current_language()); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ( ! empty( $corporation_institution ) ) : ?>
                                <div class="corporation_institution info-course">
                                    <span class="info-course-list-bold"><?= __('In Collaboration With', 'single_corse'); ?>:</span>
                                    <?php
                                    foreach ($corporation_institution as $item){
                                        $name = getFieldByLanguage($item->display('name'), $item->display('english_name'), $item->display('arabic_name') ,$sitepress->get_current_language());
                                        $thumb = $item->display('image');
                                        $url = getHomeUrlWithoutQuery() . $single_institution_slug . $item->display('permalink');
                                        ?>
                                        <a href="<?= $url ?>" class="item_corporation_institution"
                                           target="_blank"> <?= $name; ?>
                                            <img class="corporation_img"
                                                 src="<?= $thumb; ?>">
                                        </a>
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
                                    <span><?= $pacing; ?></span>
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
                                    <span><?= $language_course; ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($subtitle_lang) :?>
                                <div class="">
                                    <span class="subtitle_lang info-course-list-bold"><?= cin_get_str('Subtitle_language'); ?>:</span>
                                    <?php foreach ($subtitle_lang as $lang): ?>
                                        <span class="info_lang_span"><?= $lang; ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($mobile_available) :?>
                                <div class="">
                                    <span class="mobile_available info-course-list-bold"><?= __('Mobile', 'single_corse'); ?>:</span>
                                    <span><?= __('Includes support', 'single_corse'); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($certificate) :?>
                                <div class="">
                                    <span class="certificate info-course-list-bold"><?= __('Diploma', 'single_corse'); ?>:</span>
                                    <span><?= $certificate; ?> </span>
                                </div>
                            <?php endif; ?>
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

<?php if ( ! empty( $lecturers ) ) : ?>
    <div class="lecturer-about-course">
        <div class="container">
            <div class="row">
                <h2 class="course-staff-title"><?= __('The course staff', 'single_corse'); ?>:</h2>
            </div>
            <div class="row">

                <?php
                foreach ( $lecturers as $lecturer ){
                    $name = getFieldByLanguage($lecturer->display('name'), $lecturer->display('english_name'), $lecturer->display('arabic_name') ,$sitepress->get_current_language());
                    $content = getFieldByLanguage($lecturer->display('hebrew_description'), $lecturer->display('english_description'), $lecturer->display('arabic_description') ,$sitepress->get_current_language());
                    $thumb = $lecturer->display('image');
                    $thumb = $thumb ? $thumb : get_bloginfo('stylesheet_directory') . '/assets/images/campus_avatar.png';
                    $rol_single_course = getFieldByLanguage($lecturer->display('hebrew_role'), $lecturer->display('english_role'), $lecturer->display('arabic_role') ,$sitepress->get_current_language());
                    $email_lecturer = $lecturer->display('email');
                    $org_lecturer = $lecturer->field('academic_institution');
                    $org_lecturer = getFieldByLanguage($org_lecturer['name'], $org_lecturer['english_name'], $org_lecturer['arabic_name'] ,$sitepress->get_current_language());
                    ?>

                    <div class="single-lecturer">

                        <div class="img-lecturer circle-image-lecturer" aria-label='<?= $name; ?>'
                             style="background-image: url(<?= $thumb; ?>)"></div>
                        <div class="content-lecturer">
                            <div class="lecturer-title"><?= $name; ?></div>
                            <p class="lecturer-role"><?= $rol_single_course; ?></p>
                            <div id="popup_lecturer" class="single-lecturer-popup dialog" role="dialog"
                                 aria-model="true" aria-hidden="true">
                                <button type="button"
                                        class="close close-lecturer last-popup-element first-popup-element close-popup-button"
                                        tabindex="0" aria-label='<?= __('close', 'single_corse'); ?>'>X
                                </button>
                                <div class="img-lecturer-popup circle-image-lecturer"
                                     style="background-image: url(<?= $thumb; ?>)"></div>
                                <h2 class="lecturer-title-popup"><?= $name; ?></h2>
                                <div class="lecturer-role-popup-wrap">
                                    <?php if($rol_single_course){ ?>
                                        <span class="lecturer-role-popup"><?= $rol_single_course; ?></span>
                                    <?php } ?>
                                    <?php if ($org_lecturer): ?>
                                        <span class="lecturer-role-popup"> | <?= $org_lecturer; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="lecturer-content"><?= $content; ?></div>
                            </div>
                            <?php if ($content): ?>
                                <p aria-label='<?= cin_get_str('about_me'); ?>: <?= $name; ?> '
                                   aria-pressed="true" aria-haspopup="true" role="button" tabindex="0"
                                   class="lecturer-little-about open-popup-button"><?= cin_get_str('about_me'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ( ! empty( $testimonials ) ) : ?>
    <div class="testimonial-course-page">
        <div class="container">
            <div class="row testimonials-course-page-items">
                <h4 class="col-12 title_of_testimonials"><?= cin_get_str('Learners_Testimonials'); ?>:</h4>
                <?php foreach ( $testimonials as $testimonial ){
                    $content = getFieldByLanguage($testimonial->display('hebrew_description'), $testimonial->display('english_description'), $testimonial->display('arabic_description') ,$sitepress->get_current_language());
                ?>
                    <div class="col-md-12 col-lg-6 testimonials-course-page-items-inner">
                        <?php $img_testimonial = get_bloginfo('stylesheet_directory') . '/assets/images/quotesmall.png'; ?>
                        <div class="img-quotesmall testimonial-course-page-img"
                             style="background-image: url(<?= $img_testimonial ?>)" class="quotesmall"></div>
                        <div class="quote-text-course-page"><?= $content; ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!--more courses area 4 posts-->

<!--the terms returns an id not an object-->
<?php if ( ! empty( $relatedCourses ) ) : ?>

<div class="more-courses-section">
    <div class="container">
        <div class="row">
            <h3 class="col-12  more-courses-interest"><?= cin_get_str('other_course'); ?></h3>
        </div>
        <div class="row more-courses-inner" id="single_course_related_container">
            <?php
            while ($relatedCourses->fetch()) {
                $output_courses .= get_template_part('template', 'parts/Courses/course-card',
                    array(
                        'args' => array(
                            'course' => $relatedCourses,
                            'attrs' => $course_attrs,
                        )
                    ));
                ?>
            <?php } ?>
        </div>
        <div class="row justify-content-center">
            <p class="course-page-bottom-info"><?= cin_get_str('text_before_archive_link_single_page'); ?>:</p>
        </div>
        <div class="row justify-content-center for-all-courses">
            <a class="for-all-courses-link"
               href="<?= home_url('/catalog'); ?>"><?= cin_get_str('All_Courses'); ?></a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
do_action('get_footer');
get_template_part('templates/footer');
wp_footer();
?>
</body>
</html>