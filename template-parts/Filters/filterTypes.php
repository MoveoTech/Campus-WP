<?php

function getFilterType($filterId){

    $filterType = get_field('filter_type', $filterId);

    switch ($filterType) {

        case 'Academic Institutions':{
            academicInstitutionFilter($filterId);
            break;
        }

        case 'Tags':{
            tagsFilter($filterId);
            break;
        }
//
//        case 'Certificate':
//            certificateFilter($filterId);
//            break;
//
//        case 'Languages':
//            languagesFilter($filterId);
//            break;
    }
}


function academicInstitutionFilter($filterId){

    global $sitepress;

    $academic_institutions = pods( 'academic_institution', array('limit'   => -1 ) );
    $title = getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language());

    get_template_part('template', 'parts/Filters/academic-institution-filter',
        array(
            'args' => array(
                'id'=>  $filterId,
                'title' => $title,
                'academic_institutions' => $academic_institutions->data(),
            )
        ));

}
function tagsFilter($filterId){

    global $sitepress;

    $tags = get_field('tags_list', $filterId);
    $title = getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language());

    get_template_part('template', 'parts/Filters/tags-filter',
        array(
            'args' => array(
                'id'=>  $filterId,
                'title' => $title,
                'tags' => $tags,
            )
        ));

}
function certificateFilter($filterId){

    global $sitepress;

    $academic_institutions = pods( 'academic_institution' );

    get_template_part('template', 'parts/Filters/certificate-filter',
        array(
            'args' => array(
                'id'=>  $filterId,
                'title' => getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language()),
                'academic_institutions' => $academic_institutions,
            )
        ));

}
function languagesFilter($filterId){

    global $sitepress;

    $academic_institutions = pods( 'academic_institution' );

    get_template_part('template', 'parts/Filters/languages-filter',
        array(
            'args' => array(
                'id'=>  $filterId,
                'title' => getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language()),
                'academic_institutions' => $academic_institutions,
            )
        ));

}

function podsFilterParams($tags_filter)
{

    $where = "t.id IN (";
    $order = "FIELD(t.id,";

    foreach ($tags_filter as $tag) {
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