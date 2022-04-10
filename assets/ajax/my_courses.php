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

    $order = "FIELD(t.course_id_edx,";
    $sql = array();
    foreach($idsArray as $id ) {
        $order = $order . "'". $id . "',";
        $sql[] = 't.course_id_edx LIKE "%'.$id.'+%"';
    }
    $where = implode(" OR ", $sql);
    $order = substr_replace($order, ")", -1);

    $params = array(
        'limit' => -1,
        'where'=>$where,
        'orderby'=> $order
    );
    return $params;

}

/*
 *     request example
 *
let data = {
    'action': 'my_courses',
    'lang' : getCookie('openedx-language-preference'),
    'idsArray': ['course-v1:CS+GOV_CS_selfpy101+1_2022','course-v1:moin+GOV_moin_me001+2018_1'],
}

jQuery.post(my_courses_ajax.ajaxurl, data, function(response){
    if(response.success){
        const data = JSON.parse(response.data);
        console.log(data)
        // button unable
    }
})

*/