<?php
$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['certificate']) || count($filter['certificate']) < 1)
    return;

global $sitepress;

$certificatesArray = $filter['certificate'];
$title = $filter['title'];
$certificates = [];
foreach ($certificatesArray as $certificate) {
    $certificate_name = getFieldByLanguageFromString($certificate, $sitepress->get_current_language());
    array_push($certificates, $certificate_name);
}
?>