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

    echo $stripeType;
    switch ($stripeType) {

        case 'Academic Institution Stripe':{
            AcademicInstitutionStripe($stripeId);
            break;
        }
        case 'Narrative Stripe':{
            nerativeCoursesStripe($stripeId);
            break;
        }

        case 'Tags Stripe':
            echo "Tags Stripe";
            break;

        case 'Info Stripe':
            infoStripe($stripeId);
            break;

        case 'Courses Stripe':
            coursesStripe($stripeId);
            break;

    }
}







function academicInstitutionStripe($stripeId){

    global $sitepress;

    get_template_part('template', 'parts/Stripes/academic-institution-stripe',
        array(
            'args' => array(
                'id'=>  $stripeId,
                'title' => getFieldByLanguage(get_field('hebrew_title', $stripeId), get_field('english_title', $stripeId), get_field('arabic_title', $stripeId), $sitepress->get_current_language()),
                'carousel' => get_field('academic_institution', $stripeId),
            )
        ));

}


function nerativeCoursesStripe($stripeId){

    global $sitepress;

    $title = getFieldByLanguage(get_field('hebrew_title', $stripeId), get_field('english_title', $stripeId), get_field('arabic_title', $stripeId), $sitepress->get_current_language());

    $subTitle = getFieldByLanguage(get_field('hebrew_sub_title', $stripeId), get_field('english_sub_title', $stripeId), get_field('arabic_sub_title', $stripeId), $sitepress->get_current_language());


    echo "<br>";
    echo $title;
    echo $subTitle;
    echo $stripeId;

    get_template_part('template', 'parts/Stripes/nerative-stripe',
        array(
            'args' => array(
                'id' => $stripeId,
                'image' => get_field('logo', $stripeId),
                'title' => $title,
                'subtitle' => $subTitle,
                'carousel' => get_field('courses', $stripeId),
            )
        ));

}



function coursesStripe($stripeId){

    global $sitepress;

    $title = getFieldByLanguage(get_field('hebrew_title', $stripeId), get_field('english_title', $stripeId), get_field('arabic_title', $stripeId), $sitepress->get_current_language());

    $subTitle = getFieldByLanguage(get_field('hebrew_sub_title', $stripeId), get_field('english_sub_title', $stripeId), get_field('arabic_sub_title', $stripeId), $sitepress->get_current_language());


    get_template_part('template', 'parts/Stripes/courses-stripe',
        array(
            'args' => array(
                'id' => $stripeId,
                'title' => $title,
                'subtitle' => $subTitle,
                'carousel' => get_field('courses', $stripeId),
            )
        ));
}


function infoStripe($stripeId){

    global $sitepress;

    $title = getFieldByLanguage(get_field('hebrew_title', $stripeId), get_field('english_title', $stripeId), get_field('arabic_title', $stripeId), $sitepress->get_current_language());


    get_template_part('template', 'parts/Stripes/info-stripe',
        array(
            'args' => array(
                'id' => $stripeId,
                'title' => $title,
                'carousel' => get_field('info', $stripeId)["info_item"],
            )
        ));
}

?>


