<?php
$course_id = isset($_POST['course_id'])&& !empty($_POST['course_id']) ? fixXSS($_POST['course_id']) : '';
$data = array(
    'course_id' => $course_id,
);
$data_string = json_encode($data);

$url = 'https://campus-dev.opencraft.hosting/api/enrollment/v1/enrollment';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
);
$result = curl_exec($ch);
curl_close($ch);

print_r($result);