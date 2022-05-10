<?php
    function get_course_popup()
    {
        global $sitepress;

        $post_id = fixXSS($_POST['post_id']);
        $current_lang = fixXSS($_POST['lang']);
        $sitepress->switch_lang($current_lang);
        $item = pods('courses', $post_id);
        $item_video_popup_course = $item->display('trailer');
        $lecturer_popup_course = $item->field('lecturer')[0];
        $duration_popup_course = $item->display('duration');
        $post_excerpt_popup_course = $item->field('excerpt');
        $academic_institution_popup_course = $item->field('academic_institution');
        if ($academic_institution_popup_course) {
            $academic_title = getFieldByLanguage($academic_institution_popup_course['name'],$academic_institution_popup_course['english_name'],$academic_institution_popup_course['arabic_name'], $sitepress->get_current_language());
        }
        if ($lecturer_popup_course) {
            $popup_lecturer_title = getFieldByLanguage($lecturer_popup_course['name'],$lecturer_popup_course['english_name'],$lecturer_popup_course['arabic_name'], $sitepress->get_current_language());
        }
        $post_title_popup_course = $item->display('title_on_banner');
        $post_title_popup_course = $post_title_popup_course ? wrap_text_with_char($post_title_popup_course) : getFieldByLanguage($item->display('name'),$item->display('english_name'),$item->display('arabic_name'), $sitepress->get_current_language());
        $course_permalink = $item->display('permalink');
        $url = getHomeUrlWithoutQuery() . 'onlinecourse/' . $course_permalink;

        $query_string = array();
        parse_str(parse_url($item_video_popup_course, PHP_URL_QUERY), $query_string);
        $video_id = $item_video_popup_course ? $query_string["v"] : '';
        $ajax = [];
        $ajax['popup_title'] = $post_title_popup_course;
        $ajax['popup_video'] = 'https://www.youtube.com/embed/' . $video_id . '?autoplay=0&showinfo=0&autohide=1&rel=0&enablejsapi=1&wmode=transparent';
      if ($lecturer_popup_course) {
          $lecturer_data = pods('lecturer',  $lecturer_popup_course['pod_item_id']);
          $ajax['popup_lecturer_thumbnail'] = $lecturer_data->display('image');
          $ajax['popup_lecturer_title'] = $popup_lecturer_title;
      }
        $ajax['popup_academic_institution_title'] = $academic_title;
        $ajax['popup_excerpt'] = $post_excerpt_popup_course;
        $ajax['popup_duration_popup_course'] = $duration_popup_course;
        $ajax['popup_course_link'] = $url;

        wp_send_json_success( $ajax);


    }
add_action('wp_ajax_get_course_popup', 'get_course_popup');
add_action('wp_ajax_nopriv_get_course_popup', 'get_course_popup');