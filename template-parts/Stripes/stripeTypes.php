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

        case 'My Courses Stripe':
            myCoursesStripe($stripeId);
            break;

        case 'Testimonials Stripe':
            testimonialsStripe($stripeId);
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

function myCoursesStripe($stripeId){
    global $sitepress;

    $title = getFieldByLanguage(get_field('hebrew_title', $stripeId), get_field('english_title', $stripeId), get_field('arabic_title', $stripeId), $sitepress->get_current_language());

    get_template_part('template', 'parts/Stripes/myCourses-stripe',
        array(
            'args' => array(
                'id' => $stripeId,
                'title' => $title,
            )
        ));
}

function testimonialsStripe($stripeId){
    global $sitepress;

    $title = getFieldByLanguage(get_field('hebrew_title', $stripeId), get_field('english_title', $stripeId), get_field('arabic_title', $stripeId), $sitepress->get_current_language());

    get_template_part('template', 'parts/Stripes/testimonials-stripe',
        array(
            'args' => array(
                'id' => $stripeId,
                'title' => $title,
                'carousel' => get_field('testimonials', $stripeId),
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



function randomColor() {
    return array(
        '#FDCC07',
        '#70C6D1',
        '#F1595A',
        '#91C653'
    )[rand(0,3)];
}

function randomBckgColor() {
    return array(
        'yellow',
        'green',
        'blue',
    )[rand(0,2)];
}

function getMediaType($item) {
    $mediaType = $item['info_media'];
    $media = array();

    if($mediaType == 'Image') $media = array("image" => $item['image']['url']);
    if($mediaType == 'Video') $media = array("video" => $item['video']);
    if($mediaType == 'Embeded Media') $media = array("embeded_media" => $item['embeded_media']);

    return $media;
}

function getMediaHtml($media) {
    $exportHtml = '';

    if($media['embed_media']) {
        $videoId = substr($media['embed_media'], 30);
        $exportHtml .= '<div class="open-iframe you-tube-video" data-url=" ' . $media['embed_media'] .'style="background-image: url(' + 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg"' + ')"' + '></div>';
    }


    if($media['image']) {
        $exportHtml .= '<img src="';
        $exportHtml .= $media['image'];
        $exportHtml .= '">';
    }
    return $exportHtml;
}


//function sortTagsByOrder($tags){
//    var_dump($tags);
//    usort($tags, "CompareTagsByOrder");
//    return $tags;
//}
//
//function CompareTagsByOrder($tag1, $tag2) {
//    return $tag1['order'] > $tag2['order'];
//}