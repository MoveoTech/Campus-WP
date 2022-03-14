<?php

function filter_by_tag() {
    $dataObject = $_POST['dataObject'];
    $type = $_POST['type'];
//    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';
//
    if(!$type || ($type != "courses" ) || !$dataObject || count($dataObject) < 0)
        wp_send_json_error( 'Error: Invalid data!' );

    // filtering each data type
    $dataToReturn = [];
$courses = pods($type, getFilterParams($dataObject));
//    $data = pods($type);
//    $courses = $data->find(getFilterParams($dataObject));

//    while ($data->fetch()) {
//        if($type == "courses")
//            array_push($dataToReturn, coursesData($data, $lang));
//        elseif ($type == "academic_institution")
//            array_push($dataToReturn, academicInstitutionsData($data, $lang));
//        elseif ($type == "tags")
//            array_push($dataToReturn, tagsData($data, $lang));
//    }

//    wp_send_json_success( json_encode($dataObject));
    wp_send_json_success( json_encode($courses));

}
add_action('wp_ajax_filter_by_tag', 'filter_by_tag');
add_action('wp_ajax_nopriv_filter_by_tag', 'filter_by_tag');


function getFilterParams($dataObject){

    $where= '';
    $order = "t.order DESC";
    $sql = array();


    // filter by language
        if($dataObject['language']){
            $tagsData = $dataObject['language'];

            foreach($tagsData as $tag) {
                $sql[] = ' t.language LIKE "'.$tag.'%" ';
            }

        };

    // filter by certificate
    if($dataObject['certificate']){
        $tagsData = $dataObject['certificate'];

        foreach($tagsData as $tag) {
            $sql[] = ' t.certificate LIKE "'.$tag.'%" ';
        }

    };

    // filter by language
    if($dataObject['institution']){
        $tagsData = $dataObject['institution'];

        foreach($tagsData as $tag) {
            $sql[] = ' t.institution LIKE "'.$tag.'%" ';
        }

    };
//
//    // filter by language
//    if($dataObject['language']){
//        $tagsData = $dataObject['language'];
//
//        foreach($tagsData as $tag) {
//            $sql[] = ' t.language LIKE "'.$tag.'%" ';
//        }
//
//    };






       // declaring params for all filters
    $where = implode('OR', $sql);
    $params = array(
        'limit' => -1,
        'where'=>$where,
        'orderBy' => $order
    );

    return $params;

}