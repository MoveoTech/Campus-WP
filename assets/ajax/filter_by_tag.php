<?php

function filter_by_tag() {
    $dataObject = $_POST['dataObject'];
    $type = $_POST['type'];
    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';
//
//    if(!$type || ($type != "courses" && $type != "tags"  && $type != "academic_institution" ) || !$dataObject || count($dataObject) < 0)
//        wp_send_json_error( 'Error: Invalid data!' );

    // filtering each data type
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
//    $tagfilter = $dataObject['tags'][0];

//    $where = 't.tags ="testingtag"';
////    $where = 't.tags LIKE "%'. $tagfilter. '%"';
//    $order = "t.order DESC";
    $where= '';
    $sql = array();
    if($dataObject['language']){

        $tagsData = $dataObject['language'];
//        $where = 't.name LIKE "%'.$tagsData[0].'%"';
        $sql[] = 't.name LIKE "%'.$tagsData[0].'%"';
        $sql[] = 't.description LIKE "%'.$tagsData[0].'%"';
        $sql[] = 't.language LIKE "%'.$tagsData[0].'%"';
        $sql[] = 't.lecturer LIKE "%'.$tagsData[0].'%"';
//    foreach($tagsData as $tag) {
//        $where = $where . $tag . ",";
//
    }

//    };

//    foreach($dataObject as $dataType ) {
//
//
////        $order = $order . $dataType . ",";
//    }

//    $where = substr_replace($where, "'%", -1);

//    $order = substr_replace($order, ")", -1);
    $where = implode('OR', $sql);
    $params = array(
        'limit' => -1,
        'where'=>$where,
//        'orderBy' => 't.order DESC'
    );

    return $params;

}