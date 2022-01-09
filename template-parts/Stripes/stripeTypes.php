<?php


function getStripeType($stripeId){

    $stripeType = get_field('stripe_type', $stripeId);

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
            tagsStripe($stripeId);
            break;

        case 'Goals Stripe':
            goalsStripe($stripeId);
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

function goalsStripe($stripeId){

    global $sitepress;

    $title = getFieldByLanguage(get_field('hebrew_title', $stripeId), get_field('english_title', $stripeId), get_field('arabic_title', $stripeId), $sitepress->get_current_language());

    get_template_part('template', 'parts/Stripes/goals-stripe',
        array(
            'args' => array(
                'id' => $stripeId,
                'title' => $title,
                'carousel' => get_field('goals', $stripeId)["goal_item"],
            )
        ));
}

function tagsStripe($stripeId){

    global $sitepress;
    $title = getFieldByLanguage(get_field('hebrew_title', $stripeId), get_field('english_title', $stripeId), get_field('arabic_title', $stripeId), $sitepress->get_current_language());

    get_template_part('template', 'parts/Stripes/tags-stripe',
        array(
            'args' => array(
                'title' => $title,
                'tags' => get_field('tags', $stripeId),
            )
        ));
}

function podsParams($tags_stripe)
{

    $where = "t.id IN (";
    $order = "FIELD(t.id,";

    foreach ($tags_stripe as $tag) {
        $where = $where . $tag . ",";
        $order = $order . $tag . ",";

    }
    $where = substr_replace($where, ")", -1);
    $order = substr_replace($order, ")", -1);

    $params = array(
        'limit' => -1,
        'where' => $where,
        'orderby' => $order
    );
    return $params;

}

function randomColor() {
    return array(
        '#70C6D1',
        '#F1595A',
        '#FDCC07',
        '#46b01b',
        '#ee8e2b'
    )[rand(0,4)];

}