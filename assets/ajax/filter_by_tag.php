<?php

function filter_by_tag() {
    $filters = $_POST['filters'];
    $type = $_POST['type'];
    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';

    if(!$type || ($type != "courses" ))
        wp_send_json_error( 'Error: Invalid data!' );
    if(!$filters || count($filters) <= 0){
        $params = array(
            'limit' => 27,
            'where'=> 't.hide_in_site=0',
            'orderby'=> "t.order DESC"
        );
    } else {
        $params = getPodsFilterParams($filters);

    }

    /** filtering each data type */
    $dataToReturn = array();
    $filtersCoursesToReturn = array();
    $filteredCourses = pods($type, $params);
    $idArrayOfBestMatches = array();

    while ($filteredCourses->fetch()) {
        $filtersCoursesToReturn[] =  filteredCoursesData($filteredCourses, $lang);
        $idArrayOfBestMatches[] = $filteredCourses->display('ID');
    }

    /** Get all courses that have at list 1 filter match */

    $second_params = getSecondsFiltersParams($filters, $idArrayOfBestMatches);
    if($second_params) {
     $oneOrMoreMatches = pods($type, $second_params);
        while ($oneOrMoreMatches->fetch()) {
            $filtersCoursesToReturn[] =  filteredCoursesData($oneOrMoreMatches, $lang);
        }
    }

    $dataToReturn['courses'] = $filtersCoursesToReturn;
    $dataToReturn['filters'] = $filters;

    wp_send_json_success( json_encode($dataToReturn));

}
add_action('wp_ajax_filter_by_tag', 'filter_by_tag');
add_action('wp_ajax_nopriv_filter_by_tag', 'filter_by_tag');

/** UTILS FUNCTIONS */
function filteredCoursesData($filteredCourse,$lang){

    $academic_institution = $filteredCourse->field('academic_institution');
    return array(
        'name' => getFieldByLanguage($filteredCourse->display('name'), $filteredCourse->display('english_name'), $filteredCourse->display('arabic_name'), $lang),
        'image' => $filteredCourse->display('image'),
        'certificate' => $filteredCourse->display('certificate'),
        'excerpt' => $filteredCourse->display('excerpt'),
        'language' => $filteredCourse->display('language'),
        'order' => $filteredCourse->display('order'),
        'haveyoutube' => $filteredCourse->display('trailer'),
        'academic_institution' => getFieldByLanguage($academic_institution['name'], $academic_institution['english_name'], $academic_institution['arabic_name'], $lang),
        'tags' => getCourseTags($filteredCourse->field('tags'), $lang),
        'marketing_tags' => getCourseTags($filteredCourse->field('marketing_tags'), $lang),
        'permalink' => $filteredCourse->display('permalink'),
        'id' => $filteredCourse->display('ID'),
        'duration' => $filteredCourse->display('duration'),
        'buttonText' => course_popup_button_text()
    );
}

function filteredCourseTags($data, $lang) {
    $tags = [];

    foreach ($data as $tag) {
        array_push($tags, getFieldByLanguage($tag['name'], $tag['english_name'], $tag['arabic_name'], $lang));
    }
    return $tags;
}

