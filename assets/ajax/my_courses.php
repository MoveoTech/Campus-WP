<?php

function my_courses() {
    $edxIdsArray = $_POST['idsArray'];
    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';

    if(!$edxIdsArray || count($edxIdsArray) < 1)
        wp_send_json_error( 'Error: Invalid data!' );

    $dataToReturn = [];

    $data = pods("courses");
    $data->find(getMyCoursesParams($edxIdsArray));
    while ($data->fetch()) {
        array_push($dataToReturn, coursesData($data, $lang));

    }

    wp_send_json_success( json_encode($dataToReturn));

}
add_action('wp_ajax_my_courses', 'my_courses');
add_action('wp_ajax_nopriv_my_courses', 'my_courses');


function getMyCoursesParams($idsArray){

    $sql = array();
    foreach($idsArray as $id ) {
        $sql[] = 't.course_id_edx LIKE "%'.$id.'+%"';
    }
    $where = implode(" OR ", $sql);

    $params = array(
        'limit' => -1,
        'where'=>$where,
    );
    return $params;

};

