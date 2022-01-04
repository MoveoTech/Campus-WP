<?php

function stripe_data() {
    $idsArray = $_POST['idsArray'];
    $type = $_POST['type'];
    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';

    if(!$type || ($type != "courses" && $type != "tags"  && $type != "academic_institution" ) || !$idsArray || count($idsArray) < 1)
        wp_send_json_error( 'Error: Invalid data!' );


    $dataToReturn = [];

    $data = pods($type);
    $data->find(getParams($idsArray));

    while ($data->fetch()) {
        if($type == "courses")
            array_push($dataToReturn, coursesData($data, $lang));
        elseif ($type == "academic_institution")
            array_push($dataToReturn, academicInstitutionsData($data, $lang));
        elseif ($type == "tags")
            array_push($dataToReturn, tagsData($data, $lang));
    }

    wp_send_json_success( json_encode($dataToReturn));

}
add_action('wp_ajax_stripe_data', 'stripe_data');
add_action('wp_ajax_nopriv_stripe_data', 'stripe_data');



function academicInstitutionsData($data, $lang){

    return array(
        'name' => getFieldByLanguage(array(
            'name'=>$data->display('name'),
            'english_name'=>$data->display('english_name'),
            'arabic_name'=>$data->display('arabic_name')

        ), $lang, 'name', 'english_name', 'arabic_name'),
        'image' => $data->display('image'),
        'permalink' => $data->display('permalink')
    );
}



function tagsData($data, $lang){

    return array(
        'name' => getFieldByLanguage(array(
            'name'=>$data->display('name'),
            'english_name'=>$data->display('english_name'),
            'arabic_name'=>$data->display('arabic_name')

        ), $lang, 'name', 'english_name', 'arabic_name'),
        'permalink' => $data->display('name')
        );
}








function coursesData($data, $lang){


    return array(
        'name' => getFieldByLanguage(array(
            'name'=>$data->display('name'),
            'english_name'=>$data->display('english_name'),
            'arabic_name'=>$data->display('arabic_name')

        ), $lang, 'name', 'english_name', 'arabic_name'),
        'image' => $data->display('image'),
        'description' => $data->display('description'),
        'academic_institution' => getFieldByLanguage($data->field('academic_institution'), $lang, 'name', 'english_name', 'arabic_name'),
        'tags' => getCourseTags($data->field('tags'), $lang),
        'permalink' => $data->display('permalink')

    );
}








function getCourseTags($data, $lang)
{
    $tags = [];

    foreach ($data as $tag) {
        array_push($tags, getFieldByLanguage($tag, $lang, 'name', 'english_name', 'arabic_name'));
    }
    return $tags;
}



function getParams($idsArray){

    $where = "t.id IN (";
    $order = "FIELD(t.id,";

    foreach($idsArray as $id ) {
        $where = $where . $id . ",";
        $order = $order . $id . ",";

    }
    $where = substr_replace($where, ")", -1);
    $order = substr_replace($order, ")", -1);

    $params = array(
        'limit' => -1,
        'where'=>$where,
        'orderby'=> $order
    );
    return $params;

}