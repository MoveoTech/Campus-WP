<?php

function sort_by_courses() {
    $sortType = $_POST['sortType'];
    $coursesIds = $_POST['coursesIds'];
    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';


    if(!$sortType || count($coursesIds) <= 0)
        wp_send_json_error( 'Error: Invalid data!' );

    $dataToReturn = array();
    $params = getSortByParams($sortType,$coursesIds);

    $courses = pods( 'courses',$params,true);

    while ($courses->fetch()) {
        $sortedCoursesData[] =  sortedCoursesData($courses, $lang);
    }

   $dataToReturn['courses'] = $sortedCoursesData;
   $dataToReturn['params'] = $params;

   wp_send_json_success( json_encode($dataToReturn));

}
add_action('wp_ajax_sort_by_courses', 'sort_by_courses');
add_action('wp_ajax_nopriv_sort_by_courses', 'sort_by_courses');

///** UTILS FUNCTIONS */
function sortedCoursesData($filteredCourse,$lang){

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

function  getSortByParams($sortType,$coursesIds) {

    $where = "t.id IN (";
    $sortBy ="";
    switch ($sortType) {
        case "sortByRelevance":
            $sortBy = "t.order";
            break;
        case "sortByNewest":
            $sortBy = "t.start_date DESC";
            break;
        case "sortByOldest":
            $sortBy = "t.start_date";
            break;
        case "sortByAtoZ":
            $sortBy = "t.name , t.start_date DESC";
            break;
        case "sortByZtoA":
            $sortBy = "t.name DESC";
            break;
        default:
            $sortBy ="t.order";
    }

    foreach ($coursesIds as $singleId) {
        $where = $where . $singleId . ",";
    }
    $where = substr_replace($where, ")", -1);

    $params = array(
        'limit' => -1,
        'where' => $where,
        'orderby' => $sortBy,
    );
    return $params;
}
