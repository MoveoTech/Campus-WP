<?php

function get_courses() {
    $coursesIDs = $_POST['coursesIDs'];
    $reloadCourses = [];
    for($i = 0; $i < sizeof($coursesIDs); $i++) {
        $mypod = pods( 'courses', $coursesIDs[$i] );
        array_push($reloadCourses, $mypod);
    }

    echo json_encode($reloadCourses);
    die();
}
add_action('wp_ajax_get_courses', 'get_courses');
add_action('wp_ajax_nopriv_get_courses', 'get_courses');
