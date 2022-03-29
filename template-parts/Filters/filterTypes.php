<?php

function getFilterType($filterId){

    $filterType = get_field('filter_type', $filterId);

    switch ($filterType) {

        case 'Academic Institutions':
            academicInstitutionFilter($filterId);
            break;


        case 'Tags':
            tagsFilter($filterId);
            break;


        case 'Languages':
            languagesFilter($filterId);
            break;

        case 'Certificate':
            certificateFilter($filterId);
            break;
    }
}


function academicInstitutionFilter($filterId){

    global $sitepress;

    $academic_institutions = get_field('academic_institutions_list', $filterId);
    $title = getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language());

    get_template_part('template', 'parts/Filters/academic-institution-filter',
        array(
            'args' => array(
                'id'=>  $filterId,
                'title' => $title,
                'academic_institutions' => $academic_institutions,
            )
        ));

}

function tagsFilter($filterId){

    global $sitepress;

    $tags = get_field('tags_list', $filterId);
    $title = getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language());
    $english_title = get_field('english_title', $filterId);
    get_template_part('template', 'parts/Filters/tags-filter',
        array(
            'args' => array(
                'id'=>  $filterId,
                'title' => $title,
                'english_title' => $english_title,
                'tags' => $tags,
            )
        ));

}

function languagesFilter($filterId){

    global $sitepress;

    $languages = pods('courses')->fields('language', 'data');
    $title = getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language());

    get_template_part('template', 'parts/Filters/languages-filter',
        array(
            'args' => array(
                'id' =>  $filterId,
                'title' => $title,
                'languages' => $languages,
            )
        ));

}

function certificateFilter($filterId){

    global $sitepress;
    $certificates = get_field('certificate_list', $filterId);
    $title = getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language());

    get_template_part('template', 'parts/Filters/certificate-filter',
        array(
            'args' => array(
                'id'=>  $filterId,
                'title' => $title,
                'certificate' => $certificates,
            )
        ));

}

