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

<!--<div class="home-page-courses-stripe catalog-page-courses-stripe">-->
    <div class="catalogStripeContainer">
<!--        <div class="stripe-header">-->
            <div class="catalogStripeHeader">
                <?php
                if($stripeTitle != '' && !empty($stripeTitle)) : ?>
                    <h1><?php echo $stripeTitle ?></h1>
                <?php endif; ?>

            </div>
<!--            <div class="show-all-courses"><a href="--><?php //echo $courses_url ?><!--"><p> --><?php //echo more_courses_text($stripe['carousel']) ?><!--</p></a></div>-->
<!--        </div>-->
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
<!--</div>-->
