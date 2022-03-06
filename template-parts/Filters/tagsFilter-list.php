<?php
$tagsFiltersList = wp_parse_args(
    $args["args"]
);

if(empty($tagsFiltersList) || empty($tagsFiltersList['academic_filter']))
    return;
