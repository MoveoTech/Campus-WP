<?php
/**
 * Template Name: TEST
 */

?>
<div style="height: 100px"></div>

<?php


$academic_institutions_stripe = $fields['academic_institution_test'];

get_template_part('template', 'parts/Stripes/academic-institution-stripe',
    array(
        'academic_institutions_stripe' => $academic_institutions_stripe,
    ));




?>

<div style="height: 100px">foofofof</div>

