<?php
$docroot = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
require_once($docroot . '/wp-load.php');


$post_id = fixXSS($_POST['post_id']);
$current_lang = fixXSS($_POST['lang']);
global $sitepress;
$sitepress->switch_lang($current_lang);

$item = get_post($post_id);

$fields = get_fields($item);
$item_type = $item->post_type;

$item_video_popup_course = $fields['course_video'];
$lecturer_popup_course = $fields['lecturer'];

if ($item_type == 'course') {
    $duration_popup_course = $fields['duration'];
    $dates = __($duration_popup_course, 'single_corse');
    $academic_institution_popup_course = $fields['org'];
    if ($academic_institution_popup_course) {
        $academic_title = $academic_institution_popup_course->post_title;
    }
} else {
    $dates = get_event_date($fields['event_date'], $fields['event_time']);
    $academic_institution_popup_course = $fields['producer'] ? $fields['producer'] : get_field('default_producer', 'events_global_settings');
    $academic_title = $academic_institution_popup_course->name;
}
$post_title_popup_course = $fields['title_on_banner_course'];
$post_title_popup_course = $post_title_popup_course ? wrap_text_with_char($post_title_popup_course) : $item->post_title;
$post_excerpt_popup_course = $item->post_excerpt;


$query_string = array();
parse_str(parse_url($item_video_popup_course, PHP_URL_QUERY), $query_string);
$video_id = $item_video_popup_course ? $query_string["v"] : '';


//content array
$ajax = [];
$ajax['popup_title'] = $post_title_popup_course;
$ajax['popup_video'] = 'https://www.youtube.com/embed/' . $video_id . '?autoplay=0&showinfo=0&autohide=1&rel=0&enablejsapi=1&wmode=transparent';
$ajax['popup_excerpt'] = $post_excerpt_popup_course;

if ($lecturer_popup_course) {
    $lecturer_post_thumbnail = get_the_post_thumbnail_url($lecturer_popup_course[0]->ID);
    $ajax['popup_lecturer_thumbnail'] = $lecturer_post_thumbnail;
    $ajax['popup_lecturer_title'] = $lecturer_popup_course[0]->post_title;
    $ajax['popup_academic_institution_title'] = $academic_title;
}
$ajax['popup_duration_popup_course'] = $dates;

$url = get_permalink($item->ID);
$wpml_permalink = apply_filters('wpml_permalink', $url, $current_lang);

$ajax['popup_course_link'] = $wpml_permalink;

$json_output = wp_json_encode($ajax);
print_r($json_output);







