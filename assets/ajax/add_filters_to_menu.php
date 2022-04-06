<?php

function add_filters_to_menu() {
    $dataArray = $_POST['dataArray'];
    $type = $_POST['type'];

    if(!$type || ($type != "moreFilters" ) || !$dataArray || count($dataArray) < 0)
        wp_send_json_error( 'Error: Invalid data!' );


        $filterType = get_field('filter_type', $dataArray);
        $dataToReturn = get_filter_type($filterType, $dataArray) ;

    wp_send_json_success( json_encode($dataToReturn));

}
add_action('wp_ajax_add_filters_to_menu', 'add_filters_to_menu');
add_action('wp_ajax_nopriv_add_filters_to_menu', 'add_filters_to_menu');

/** Checking filter type and matching to the correct function */
function get_filter_type($filterType, $filterId){

    switch ($filterType) {

        case 'Academic Institutions':
           return academicInstitution_moreFilter($filterId);

        case 'Tags':
            return tags_moreFilter($filterId);

        case 'Languages':
              return  languages_moreFilter($filterId);

        case 'Certificate':
               return certificate_moreFilter($filterId);

    }
}

/** Getting the data of type - academic institution */
function academicInstitution_moreFilter($filterId){
    global $sitepress;
    $academic_institutions_array = get_field('academic_institutions_list', $filterId);

    return array(
        'filtersList' => pods('academic_institution', podsFilterParams($academic_institutions_array))->data(),
        'groupName' => getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language()),
        'language' => $sitepress->get_current_language(),
        'filterId' => $filterId,
        'dataType' => 'institution'
    );
}

/** Getting the data of type - tags */
function tags_moreFilter($filterId){
    global $sitepress;
    $tags_array = get_field('tags_list', $filterId);

    return array(
        'filtersList' => pods('tags',podsFilterParams($tags_array))->data(),
        'groupName' => getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language()),
        'language' => $sitepress->get_current_language(),
        'filterId' => $filterId,
        'dataType' => 'tag_' . get_field('english_title', $filterId)
    );
}

/** Getting the data of type - language */
function languages_moreFilter($filterId){
    /** translating filters */
    global $sitepress;
    $languagesArray = pods('courses')->fields('language', 'data');
    $languages = [];
    $i = 0;
    foreach ($languagesArray as $language) {

        $language_name = getFieldByLanguageFromString($language, $sitepress->get_current_language());
        $languageObject = ["id"=>$i, "name"=>$language_name];
        array_push($languages, $languageObject);
        $i++;
    }
            return array(
                'filtersList' => $languages,
                'groupName' => getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language()),
                'language' => $sitepress->get_current_language(),
                'filterId' => $filterId,
                'dataType' => 'language'
            );
}

/** Getting the data of type - certificate */
function certificate_moreFilter($filterId){

    /** translating filters */
    global $sitepress;
    $certificatesArray = get_field('certificate_list', $filterId);
    $certificates = [];
    $i = 0;
    foreach ($certificatesArray as $certificate) {

        $certificate_name = getFieldByLanguageFromString($certificate, $sitepress->get_current_language());
        $english_name = getFieldByLanguageFromString($certificate, 'en');
        $certificateObject = ["id"=>$i, "name"=>$certificate_name, "english_name"=>$english_name];
        array_push($certificates, $certificateObject);
        $i++;
    }

    return array(
        'filtersList' => $certificates,
        'groupName' => getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language()),
        'language' => $sitepress->get_current_language(),
        'filterId' => $filterId,
        'dataType' => 'certificate'
    );
}
