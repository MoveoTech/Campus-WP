<?php
////
function sort_by_courses() {
    $sortType = $_POST['sortType'];
    $coursesIds = $_POST['coursesIds'];
    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';

$params = getSortByParams($sortType,$coursesIds);
//////    $courses = pods( 'courses', $params, true);
//////    $idArrayOfBestMatches = array();
////
//////    if($params){
//////        $sortedCourses = pods("courses", null);
//////        while ($sortedCourses->fetch()) {
//////
////////            $filtersCoursesToReturn[] =  filteredCoursesData($sortedCourses, $lang);
////////            $allcourses[] = $sortedCourses->display('ID');
//////        }
//////    }
    $courses = pods( 'courses',$params,true);
//////    $sortedCourses = pods("courses", null);
//////    $courses = $sortedCourses->display('ID');
   $dataToReturn = array();
////
////    $sortedCourses = pods( 'courses');
////
////
   $dataToReturn['courses'] = $courses;
//   $dataToReturn['params'] = $params;
////
////
   wp_send_json_success( json_encode($dataToReturn));
////
}
add_action('wp_ajax_sort_by_courses', 'sort_by_courses');
add_action('wp_ajax_nopriv_sort_by_courses', 'sort_by_courses');
//////
///////** UTILS FUNCTIONS */
//////function filteredCoursesData($filteredCourse,$lang){
//////
//////    $academic_institution = $filteredCourse->field('academic_institution');
//////    return array(
//////        'name' => getFieldByLanguage($filteredCourse->display('name'), $filteredCourse->display('english_name'), $filteredCourse->display('arabic_name'), $lang),
//////        'image' => $filteredCourse->display('image'),
//////        'certificate' => $filteredCourse->display('certificate'),
//////        'excerpt' => $filteredCourse->display('excerpt'),
//////        'language' => $filteredCourse->display('language'),
//////        'order' => $filteredCourse->display('order'),
//////        'haveyoutube' => $filteredCourse->display('trailer'),
//////        'academic_institution' => getFieldByLanguage($academic_institution['name'], $academic_institution['english_name'], $academic_institution['arabic_name'], $lang),
//////        'tags' => getCourseTags($filteredCourse->field('tags'), $lang),
//////        'marketing_tags' => getCourseTags($filteredCourse->field('marketing_tags'), $lang),
//////        'permalink' => $filteredCourse->display('permalink'),
//////        'id' => $filteredCourse->display('ID'),
//////        'duration' => $filteredCourse->display('duration'),
//////        'buttonText' => course_popup_button_text()
//////    );
//////}
//function  getSortByParams($sortType,$coursesIds) {
//
//    $where = "t.id IN (";
//    $sortBy = "t.name";

//    switch ($sortType) {
//        case "sortByRelevance":
//            $sortBy = "t.order";
//            break;
//        case "sortByNewest":
//            $sortBy = "t.start_date DESC";
//            break;
//        case "sortByOldest":
//            $sortBy = "t.order ACS";
//            break;
//        case "sortByAtoZ":
//            $sortBy = "t.name ACS";
//            break;
//        case "sortByZtoA":
//            $sortBy = "t.name DESC";
//            break;
//    }
//    $order = "t.name";
//    $order = "FIELD(". $sortBy. ")";
//
//    foreach ($coursesIds as $singleId) {
//        $where = $where . $singleId . ",";
//    }

//    $where = substr_replace($where, ")", -1);
//    $order = substr_replace($order, ")", -1);
//
//    $params = array(
//        'limit' => -1,
//        'where' => $where,
//        'orderby' => $order,
//    );
//    return $params;
//
//}
function  getSortByParams($sortType,$coursesIds)
{
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
            $sortBy = "t.order ACS";
            break;
        case "sortByAtoZ":
            $sortBy = "t.name ACS";
            break;
        case "sortByZtoA":
            $sortBy = "t.name DESC";
            break;
    }
    $sortBy = "t.name";
    $order = "t.name";
    foreach ($coursesIds as $singleId) {
        $where = $where . $singleId . ",";
    }
    $where = substr_replace($where, ")", -1);
//    $order = substr_replace($order, ")", -1);

    $params = array(
        'limit' => -1,
        'where' => $where,
        'orderby' => $order
    );
    return $params;
}
//function sort_by_courses()
//{
//    $filters = $_POST['filters'];
//    $type = $_POST['type'];
//    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';
//
//    if (!$type || ($type != "courses"))
//        wp_send_json_error('Error: Invalid data!');
//    if (!$filters || count($filters) <= 0) {
//        $params = null;
//    } else {
//        $params = getPodsFilterParams($filters);
//
//    }
//    $dataToReturn = array();
//
//    $dataToReturn['courses'] = "vdousfhgkdsghksghkdsjghkjsgJKx";
//
//    wp_send_json_success( json_encode($dataToReturn));
//
//    /** filtering each data type */
////    $filtersCoursesToReturn = array();
////    $idArrayOfBestMatches = array();
////    if ($params) {
////        $filteredCourses = pods($type, $params);
////        while ($filteredCourses->fetch()) {
////            $filtersCoursesToReturn[] = filteredCoursesData($filteredCourses, $lang);
////            $idArrayOfBestMatches[] = $filteredCourses->display('ID');
////        }
////    }
////
////    /** Get all courses that have at list 1 filter match */
////    if (!$filters || count($filters) <= 0) {
////        $second_params = null;
////    } else {
////        $second_params = getSecondsFiltersParams($filters, $idArrayOfBestMatches);
////    }
////    if ($second_params) {
////        $oneOrMoreMatches = pods($type, $second_params);
////        while ($oneOrMoreMatches->fetch()) {
////            $filtersCoursesToReturn[] = filteredCoursesData($oneOrMoreMatches, $lang);
////        }
////    }
////
////    $dataToReturn['params'] = $params;
////    $dataToReturn['second_params'] = $second_params;
////    $dataToReturn['courses'] = $filtersCoursesToReturn;
////    $dataToReturn['filters'] = $filters;
//
////    wp_send_json_success(json_encode($dataToReturn));
//
//}
//
//add_action('wp_ajax_sort_by_courses', 'sort_by_courses');
//add_action('wp_ajax_nopriv_sort_by_courses', 'sort_by_courses');
//
///** UTILS FUNCTIONS */
//function filteredCoursesData($filteredCourse, $lang)
//{
//
//    $academic_institution = $filteredCourse->field('academic_institution');
//    return array(
//        'name' => getFieldByLanguage($filteredCourse->display('name'), $filteredCourse->display('english_name'), $filteredCourse->display('arabic_name'), $lang),
//        'image' => $filteredCourse->display('image'),
//        'certificate' => $filteredCourse->display('certificate'),
//        'excerpt' => $filteredCourse->display('excerpt'),
//        'language' => $filteredCourse->display('language'),
//        'order' => $filteredCourse->display('order'),
//        'haveyoutube' => $filteredCourse->display('trailer'),
//        'academic_institution' => getFieldByLanguage($academic_institution['name'], $academic_institution['english_name'], $academic_institution['arabic_name'], $lang),
//        'tags' => getCourseTags($filteredCourse->field('tags'), $lang),
//        'marketing_tags' => getCourseTags($filteredCourse->field('marketing_tags'), $lang),
//        'permalink' => $filteredCourse->display('permalink'),
//        'id' => $filteredCourse->display('ID'),
//        'duration' => $filteredCourse->display('duration'),
//        'buttonText' => course_popup_button_text()
//    );
//}
//
//function filteredCourseTags($data, $lang)
//{
//    $tags = [];
//
//    foreach ($data as $tag) {
//        array_push($tags, getFieldByLanguage($tag['name'], $tag['english_name'], $tag['arabic_name'], $lang));
//    }
//    return $tags;
//}
//
