<?php
//$docroot = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
//require_once($docroot . '/wp-load.php');

    function get_course_popup() {
        global $sitepress;

        $post_id = fixXSS($_POST['post_id']);
        $current_lang = fixXSS($_POST['lang']);
        $sitepress->switch_lang($current_lang);
        $item = pods('courses', $post_id);
//        $item_type = 'course';
        $item_video_popup_course = $item->display('trailer');
        $lecturer_popup_course = $item->display('lecturer');
        $duration_popup_course = $item->display('duration');// TODO new
        $dates = __($duration_popup_course, 'single_corse');
        $academic_institution_popup_course = $item->display('academic_institution');// TODO new
        if ($academic_institution_popup_course) {
            $academic_title = getFieldByLanguage($academic_institution_popup_course['name'],$academic_institution_popup_course['english_name'],$academic_institution_popup_course['arabic_name'], $sitepress->get_current_language());
        }
        $post_title_popup_course = $item->display('title_on_banner');// TODO new
        $post_title_popup_course = $post_title_popup_course ? wrap_text_with_char($post_title_popup_course) : getFieldByLanguage($item->display('name'),$item->display('english_name'),$item->display('arabic_name'), $sitepress->get_current_language());
        $course_permalink = $item->display('permalink'); //TODO new
        $site_url = get_current_url();//TODO new
        $url = $site_url . 'course/' . $course_permalink;//TODO new
        $wpml_permalink = apply_filters('wpml_permalink', $url, $current_lang);

        $query_string = array();
        parse_str(parse_url($item_video_popup_course, PHP_URL_QUERY), $query_string);
        $video_id = $item_video_popup_course ? $query_string["v"] : '';
        $ajax = [];
        $ajax['popup_title'] = $post_title_popup_course;
        $ajax['popup_video'] = 'https://www.youtube.com/embed/' . $video_id . '?autoplay=0&showinfo=0&autohide=1&rel=0&enablejsapi=1&wmode=transparent';
        if ($lecturer_popup_course) {
            $ajax['popup_academic_institution_title'] = $academic_title;
        }
        $ajax['popup_duration_popup_course'] = $dates;
        $ajax['popup_course_link'] = $wpml_permalink;

        $json_output = wp_json_encode($ajax);
        print_r($json_output);
//
//        $idsArray = $_POST['idsArray'];
//        $type = $_POST['type'];
//        $lang = $_POST['lang'] ? $_POST['lang'] : 'he';
//
//        if(!$type || ($type != "courses" && $type != "tags"  && $type != "academic_institution" ) || !$idsArray || count($idsArray) < 1)
//            wp_send_json_error( 'Error: Invalid data!' );
//
//
//        $dataToReturn = [];
//
//        $data = pods($type);
//        $data->find(getParams($idsArray));
//
//        while ($data->fetch()) {
//            if($type == "courses")
//                array_push($dataToReturn, coursesData($data, $lang));
//            elseif ($type == "academic_institution")
//                array_push($dataToReturn, academicInstitutionsData($data, $lang));
//            elseif ($type == "tags")
//                array_push($dataToReturn, tagsData($data, $lang));
//        }
//
//        wp_send_json_success( json_encode($dataToReturn));

    }
add_action('wp_ajax_get_course_popup', 'get_course_popup');
add_action('wp_ajax_nopriv_get_course_popup', 'get_course_popup');





//$item = get_post($post_id); // TODO old
//$item = pods('courses', $post_id); // TODO new

//$fields = get_fields($item);// TODO old
//$item_type = $item->post_type;// TODO old
//$item_type = 'course'; // TODO new (temporary)

//$item_video_popup_course = $fields['course_video']; // TODO old
//$item_video_popup_course = $item->display('trailer'); // TODO new
//$lecturer_popup_course = $fields['lecturer'];// TODO old
//$lecturer_popup_course = $item->display('lecturer'); // TODO new


//if ($item_type == 'course') {
////    $duration_popup_course = $fields['duration'];// TODO old
//    $duration_popup_course = $item->display('duration');// TODO new
//    $dates = __($duration_popup_course, 'single_corse');
////    $academic_institution_popup_course = $fields['org'];// TODO old
//    $academic_institution_popup_course = $item->display('academic_institution');// TODO new
//    if ($academic_institution_popup_course) {
//        $academic_title = getFieldByLanguage($academic_institution_popup_course['name'],$academic_institution_popup_course['english_name'],$academic_institution_popup_course['arabic_name'], $sitepress->get_current_language());
//    }
//}
//TODO old
//else {
//    $dates = get_event_date($fields['event_date'], $fields['event_time']);
//    $academic_institution_popup_course = $fields['producer'] ? $fields['producer'] : get_field('default_producer', 'events_global_settings');
//    $academic_title = $academic_institution_popup_course->name;
//}
//$post_title_popup_course = $fields['title_on_banner_course'];// TODO old
//$post_title_popup_course = $item->display('title_on_banner');// TODO new
//$post_title_popup_course = $post_title_popup_course ? wrap_text_with_char($post_title_popup_course) : getFieldByLanguage($item->display('name'),$item->display('english_name'),$item->display('arabic_name'), $sitepress->get_current_language());
//$post_excerpt_popup_course = $item->post_excerpt;// TODO old


//$query_string = array();
//parse_str(parse_url($item_video_popup_course, PHP_URL_QUERY), $query_string);
//$video_id = $item_video_popup_course ? $query_string["v"] : '';


//content array
//$ajax = [];
//$ajax['popup_title'] = $post_title_popup_course;
//$ajax['popup_video'] = 'https://www.youtube.com/embed/' . $video_id . '?autoplay=0&showinfo=0&autohide=1&rel=0&enablejsapi=1&wmode=transparent';
//$ajax['popup_excerpt'] = $post_excerpt_popup_course;

//if ($lecturer_popup_course) {
////    $lecturer_post_thumbnail = get_the_post_thumbnail_url($lecturer_popup_course[0]->ID);// TODO old
////    $ajax['popup_lecturer_thumbnail'] = $lecturer_post_thumbnail;
////    $ajax['popup_lecturer_title'] = $lecturer_popup_course[0]->post_title;
//    $ajax['popup_academic_institution_title'] = $academic_title;
//}
//$ajax['popup_duration_popup_course'] = $dates;
//
////$url = get_permalink($item->ID); //TODO old
//$course_permalink = $item->display('permalink'); //TODO new
//$site_url = get_current_url();//TODO new
//$url = $site_url . 'course/' . $course_permalink;//TODO new
//
//$wpml_permalink = apply_filters('wpml_permalink', $url, $current_lang);
//
//$ajax['popup_course_link'] = $wpml_permalink;
//
//$json_output = wp_json_encode($ajax);
//print_r($json_output);







