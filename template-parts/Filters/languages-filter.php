<?php

$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['academic_institutions']) || count($filter['academic_institutions']) < 1)
    return;

$academic_institutions = $filter['academic_institutions'];
$title = $filter['title'];

?>