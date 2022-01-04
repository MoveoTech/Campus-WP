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
            AcademicInstitutionStripe($stripeId);
            break;
        }
        case 'Nerative Stripe':{
            nerativeCoursesStripe($stripeId);
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




function academicInstitutionStripe($stripeId){

    global $sitepress;

    get_template_part('template', 'parts/Stripes/academic-institution-stripe',
        array(
            'args' => array(
                'id'=>  $stripeId,
                'title' => getFieldByLanguage(array(
                    'hebrew'=>get_field('hebrew_title', $stripeId),
                    'english'=>get_field('english_title', $stripeId),
                    'arabic'=>get_field('arabic_title', $stripeId)
                ), $sitepress->get_current_language(), 'hebrew', 'english', 'arabic'),
                'carousel' => get_field('academic_institution', $stripeId),
            )
        ));

}


function nerativeCoursesStripe($stripeId){

    global $sitepress;

    $title = getFieldByLanguage(array(
        'hebrew'=>get_field('hebrew_title', $stripeId),
        'english'=>get_field('english_title', $stripeId),
        'arabic'=>get_field('arabic_title', $stripeId)
    ), $sitepress->get_current_language(), 'hebrew', 'english', 'arabic');

    $subTitle = getFieldByLanguage(array(
        'hebrew'=>get_field('hebrew_sub_title', $stripeId),
        'english'=>get_field('english_sub_title', $stripeId),
        'arabic'=>get_field('arabic_sub_title', $stripeId)
    ), $sitepress->get_current_language(), 'hebrew', 'english', 'arabic');

    get_template_part('template', 'parts/Stripes/academic-institution-stripe',
        array(
            'args' => array(
                'id'=>  $stripeId,
                'title' =>$title,
                'carousel' => get_field('academic_institution', $stripeId),
            )
        ));

}



?>


