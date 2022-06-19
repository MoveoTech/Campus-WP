<?php

function get_tag_data() {
    $tag_id = $_POST['id'];
    $type = $_POST['type'];
    $lang = $_POST['lang'] ? $_POST['lang'] : 'he';

    if(!$type || ($type != "tags" ))
        wp_send_json_error( 'Error: Invalid data!' );

    if(!$tag_id)
        wp_send_json_error( 'Error: Required ID!' );

    $tag = pods($type,$tag_id);
    $tag_name = getFieldByLanguage($tag->display('name'),$tag->display('english_name'),$tag->display('arabic_name'),$lang);

    $dataToReturn['tag']['name']  = $tag_name;
    $dataToReturn['tag']['english_name']  = $tag->display('english_name');
    $dataToReturn['tag']['id']  = $tag_id;

    wp_send_json_success( json_encode($dataToReturn));
}
add_action('wp_ajax_get_tag_data', 'get_tag_data');
add_action('wp_ajax_nopriv_get_tag_data', 'get_tag_data');