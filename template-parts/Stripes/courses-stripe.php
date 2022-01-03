<?php

$courses_stripe = wp_parse_args(
    $args["carousel"]
);

if(empty($courses_stripe) )
    return;
?>
<div class="home-page-courses-stripe">
    <div class="stripe-header">
        <h1><?php echo $courses_stripe['carousel_title'] ?></h1>
        <p><?php echo $courses_stripe['carousel_subtitle'] ?></p>
    </div>

    <?php
    get_template_part('template', 'parts/Stripes/courses-carousel',
        array(
            'courses_stripe' => $courses_stripe['carousel'],
        ));
    ?>

</div>