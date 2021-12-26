<?php
$docroot = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
require_once($docroot.'/wp-load.php');

//$edx = 'course-v1:TAU+ACD_TAU_cs101x+2019_3';

$all = get_posts(array(
   'post_type' => 'course',
   'posts_per_page' => -1
));
foreach($all as $item){
    $id = $item->ID;
    $edx = get_field('course_id_edx', $id);

    $edx = str_replace(':', '-', $edx);

    if(strpos($edx, '+') > 0) {
        $arr = explode('+', $edx);
        $edx = $arr[0] . '-' . $arr[1];
    }

//    wp_update_post(array(
//        'ID'        => $id,
//        'post_name' => $edx
//    ));
}
echo 'done';