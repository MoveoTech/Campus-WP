<?php

function filter_by_tag() {
    $dataObject = $_POST['dataObject'];
    $type = $_POST['type'];
    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';
//
    if(!$type || ($type != "courses" ) || !$dataObject || count($dataObject) < 0)
        wp_send_json_error( 'Error: Invalid data!' );

    // filtering each data type
    $dataToReturn = array();
    $strictFilter = array();
    $semiFilter = array();



    $strictfilteredCourses = pods($type, getFilterParams($dataObject));
    $semifilteredCourses = pods($type, getSemiFilterParams($dataObject));




    while ($strictfilteredCourses->fetch()) {
        $strictFilter[] = filteredCoursesData($strictfilteredCourses,$lang);

    }
    while ($semifilteredCourses->fetch()) {
        $semiFilter[] = filteredCoursesData($semifilteredCourses,$lang);
    }

    $dataToReturn = ['strictFilter'=> $strictFilter,'semiFilter' => $semiFilter];
    wp_send_json_success( json_encode($dataToReturn));

}
add_action('wp_ajax_filter_by_tag', 'filter_by_tag');
add_action('wp_ajax_nopriv_filter_by_tag', 'filter_by_tag');


function getSemiFilterParams($dataObject){

    $where= '';
    $order = "t.order DESC";
    $sql = array();


    // filter by language
        if($dataObject['language']){
            $tagsData = $dataObject['language'];

            foreach($tagsData as $tag) {
                $sql[] = ' t.language LIKE "%'.$tag.'%" ';
            }

        };

    // filter by certificate
    if($dataObject['certificate']){
        $tagsData = $dataObject['certificate'];

        foreach($tagsData as $tag) {
            $sql[] = ' t.certificate LIKE "%'.$tag.'%" ';
        }

    };

    // filter by institution
    if($dataObject['institution']){
        $tagsData = $dataObject['institution'];

        foreach($tagsData as $tag) {
            $sql[] = ' academic_institution.name LIKE "%'.$tag.'%" ';
            $sql[] = ' academic_institution.english_name LIKE "%'.$tag.'%" ';
            $sql[] = ' academic_institution.arabic_name LIKE "%'.$tag.'%" ';
        }

    };

    // filter by tags
    if($dataObject['tags']){
        $tagsData = $dataObject['tags'];

        foreach($tagsData as $tag) {
            $sql[] = ' tags.name LIKE "%'.$tag.'%" ';
            $sql[] = ' tags.english_name LIKE "%'.$tag.'%" ';
            $sql[] = ' tags.arabic_name LIKE "%'.$tag.'%" ';
        }

    };






       // declaring params for all filters
    $where = implode('OR', $sql);
    $params = array(
        'limit' => -1,
        'where'=>$where,
        'orderBy' => $order
    );

    return $params;

}

function getFilterParams($dataObject){

    $where= '';
    $order = "t.order DESC";
    $sql = array();
    $langQuery = '';
    $certQuery = '';
    $instQuery = '';
    $tagsQuery = '';



    // filter by language
        if($dataObject['language']){
            $tagsData = $dataObject['language'];
            $sqlLang = array();
            foreach($tagsData as $tag) {
                $sqlLang[] = ' t.language LIKE "%'.$tag.'%" ';
            };
            $langQuery = "(" . implode('OR', $sqlLang) . ")";
            $sql[] = $langQuery;
        };

    // filter by certificate
    if($dataObject['certificate']){
        $tagsData = $dataObject['certificate'];
        $sqlCert = array();
        foreach($tagsData as $tag) {
            $sqlCert[] = ' t.certificate LIKE "%'.$tag.'%" ';
        }
        $certQuery = "(" . implode('OR', $sqlCert) . ")";
        $sql[] = $certQuery;
    };

    // filter by language
    if($dataObject['institution']){
        $tagsData = $dataObject['institution'];
        $sqlInst = array();
        foreach($tagsData as $tag) {
            $sqlInst[] = ' academic_institution.name LIKE "%'.$tag.'%" ';
            $sqlInst[] = ' academic_institution.english_name LIKE "%'.$tag.'%" ';
            $sqlInst[] = ' academic_institution.arabic_name LIKE "%'.$tag.'%" ';
        }
        $instQuery ="(" . implode('OR', $sqlInst) . ")";
        $sql[] = $instQuery;
    };

    // filter by language
    if($dataObject['tags']){
        $tagsData = $dataObject['tags'];
        $sqlTags = array();
        foreach($tagsData as $tag) {
            $sqlTags[] = ' tags.name LIKE "%'.$tag.'%" ';
            $sqlTags[] = ' tags.english_name LIKE "%'.$tag.'%" ';
            $sqlTags[] = ' tags.arabic_name LIKE "%'.$tag.'%" ';
        }
        $tagsQuery ="(" . implode('OR', $sqlTags) . ")";
        $sql[] = $tagsQuery;
    };





       // declaring params for all filters
    $where = implode('AND', $sql);
    $params = array(
        'limit' => -1,
        'where'=>$where,
        'orderBy' => $order
    );

    return $params;

}

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


