<?php
/**
 * Template Name: TEST
 */
require_once 'inc/classes/Course_stripe.php';



?>
<div style="height: 100px"></div>

<?php

//---------- STRIPES SECTION ----------
$cookieValue = $_COOKIE['prod-olivex-user-info'];
if($cookieValue && str_contains($cookieValue,"username"))
    $stripes = $fields['loggedin_users_stripes'];

else
    $stripes = $fields['anonymous_users_stripes'];


foreach($stripes as $stripeId ) {
    getStripeType($stripeId);
}

//---------- STRIPES SECTION ----------



function getStripeType($stripeId){

    $stripeType = get_field('stripe_type', $stripeId);

    switch ($stripeType) {

        case 'Academic Institution Stripe':{
            get_template_part('template', 'parts/Stripes/academic-institution-stripe',
                array(
                    'args' => array(
                        'id'=>  $stripeId,
                        'title'=>  get_field('title', $stripeId),
                        'carousel' => get_field('academic_institution', $stripeId),
                    )
                ));
            break;
        }
        case 'Nerative Stripe':{
            get_template_part('template', 'parts/Stripes/courses-stripe',
                array(
                    'title'=>  get_field('title', $stripeId),
                    'carousel' => get_field('courses', $stripeId),
                ));
            break;
        }

        case 'Tags Stripe':
            echo "Tags Stripe";
            break;

        case 'Info Stripe':
            echo "Info Stripe";
            break;

    }


}



?>


