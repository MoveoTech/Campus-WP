<?php

$stripe = wp_parse_args(
    $args["args"]
);

if(empty($stripe) || empty($stripe['id']) || empty($stripe['courses']) )
    return;

$courses_url = home_url('/') . 'course/' ;
$stripeTitle = $stripe['title'];
$stripeSubtitle = $stripe['subtitle'];
$stripeId = $stripe['id'];
$courses = $stripe['courses'];
?>

    <div class="catalogStripeContainer">

            <div class="catalogStripeHeader">
                <?php
                if($stripeTitle != '' && !empty($stripeTitle)) : ?>
                    <h1><?php echo $stripeTitle ?></h1>
                <?php endif; ?>
                <?php if($stripe['subtitle'] && $stripe['subtitle'] !== '') : ?>
                    <p><?php echo $stripe['subtitle'] ?></p>
                <?php endif; ?>

            </div>

            <?php
        get_template_part('template', 'parts/Stripes/catalog-courses-carousel',
            array(
                'args' => array(
                    'courses' => $courses,
                    'id' => $stripeId,
                )
            ));
        ?>
    </div>

