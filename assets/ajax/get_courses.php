<?php

function get_courses() {
    $coursesIDs = $_POST['coursesIDs'];

    echo json_encode($coursesIDs);
    die();
}
add_action('wp_ajax_get_courses', 'get_courses');
add_action('wp_ajax_nopriv_get_courses', 'get_courses');
