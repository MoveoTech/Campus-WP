<?php

function getFiltersArray($paramsArray) {
    if($paramsArray) {

        foreach ($paramsArray as $key => $value) {

            /** Check if the params from url is tags and put it in different arrays */
            if(str_contains($key, 'tags_')) {
                $key = substr($key,5);

                if($tags[$key]){
                    array_push($tags[$key], $value);

                } else {
                    $tags[$key] = [];
                    array_push($tags[$key], $value);
                }

                $tags[$key] = explode(",", $tags[$key][0]);
                $obj['tags'] = $tags;

            } else {
                $itemsArray = explode(',', $value);
                if($obj[$key]){
                    foreach ($itemsArray as $item) {
                        array_push($obj[$key], $item);
                    }

                } else {
                    $obj[$key] = [];
                    foreach ($itemsArray as $item) {
                        array_push($obj[$key], $item);
                    }
                }

            }
        }

        $filters['search'] = $obj;

        return $filters;
    }
}


function getPodsFilterParams($filters = null) {
    $sql = array();
    global $sitepress;
    $current_lang = $sitepress->get_current_language();
    if(!$filters) {
        if($current_lang === 'he'){
            $default_lang = '(t.language LIKE "%Hebrew%")';
        } else if($current_lang === 'en'){
            $default_lang = '(t.language LIKE "%English%")';
        } else if($current_lang === 'ar'){
            $default_lang = '(t.language LIKE "%Arabic%")';
        }

        $sql[] = $default_lang;
    }
    /** GET ONLY COURSES THAT ARE NOT HIDDEN */
    $sql[] = '(t.hide_in_site=0)';
    $order = '';

    if($filters) {
        if($filters['search']['text_s']){
            $search_value = $filters['search']['text_s'][0];
            $search_array = explode(' ', $search_value);
            $sqlSearch = array();
            $search_orderBy = array();

            /**
             * First, check if the course contains the exact search value string
             */
            $sqlSearchFullText = array();
            $full_text_search = '';

            $sqlSearchFullText[] = ' t.name LIKE "%'.$search_value.'%" ';
            $sqlSearchFullText[] = ' t.english_name LIKE "%'.$search_value.'%" ';
            $sqlSearchFullText[] = ' t.arabic_name LIKE "%'.$search_value.'%" ';
            $sqlSearchFullText[] = ' t.description LIKE "%'.$search_value.'%" ';
            $sqlSearchFullText[] = ' t.course_products LIKE "%'.$search_value.'%" ';
            $sqlSearchFullText[] = ' t.alternative_names LIKE "%'.$search_value.'%" ';

            $full_text_search .= 'CASE WHEN ';
            $full_text_search .= "(" . implode('OR', $sqlSearchFullText) . ")";
            $full_text_search .= 'THEN 1000 ELSE 0 END';

            $search_orderBy[] = $full_text_search;

            /**
             * Search for each word in the text in a separate search
             */
            foreach($search_array as $word) {
                $sqlSearchText = array();
                $orderBy_text = '';

                $sqlSearchText[] = ' t.name LIKE "%'.$word.'%" ';
                $sqlSearchText[] = ' t.english_name LIKE "%'.$word.'%" ';
                $sqlSearchText[] = ' t.arabic_name LIKE "%'.$word.'%" ';
                $sqlSearchText[] = ' t.description LIKE "%'.$word.'%" ';
                $sqlSearchText[] = ' t.course_products LIKE "%'.$word.'%" ';
                $sqlSearchText[] = ' t.alternative_names LIKE "%'.$word.'%" ';

                $sqlSearch[] ="(" . implode('OR', $sqlSearchText) . ")" ;

                $orderBy_text .= 'CASE WHEN ';
                $orderBy_text .= "(" . implode('OR', $sqlSearchText) . ")";
                $orderBy_text .= 'THEN 1 ELSE 0 END';

                $search_orderBy[] = $orderBy_text;
            }

            $singleSearchQuery = implode(' OR ', $sqlSearch) ;
            $sql[] = $singleSearchQuery;
            $order .= "(" . implode('+', $search_orderBy) . ") DESC, " ;
        }

        if($filters['search']['language']){
            $params_items = $filters['search']['language'];
            $sqlLang = array();

            foreach($params_items as $value) {
                $sqlLang[] = ' t.language LIKE "%'.$value.'%" ';
            };

            $langQuery = "(" . implode('OR', $sqlLang) . ")";
            $sql[] = $langQuery;
        };

        if($filters['search']['certificate']){

            $params_items = $filters['search']['certificate'];
            $sqlCert = array();

            foreach($params_items as $value) {
                $sqlCert[] = ' t.certificate LIKE "%'.$value.'%" ';
            }

            $certQuery = "(" . implode('OR', $sqlCert) . ")";
            $sql[] = $certQuery;
        };

        if($filters['search']['institution']){

            $params_items = $filters['search']['institution'];
            $sqlInst = array();

            foreach($params_items as $value) {
                $sqlInst[] = ' academic_institution.name LIKE "%'.$value.'%" ';
                $sqlInst[] = ' academic_institution.english_name LIKE "%'.$value.'%" ';
                $sqlInst[] = ' academic_institution.arabic_name LIKE "%'.$value.'%" ';
            }

            $instQuery ="(" . implode('OR', $sqlInst) . ")";
            $sql[] = $instQuery;
        };

        if($filters['search']['tags']){

            $tags_object = $filters['search']['tags'];
            $sqlTags = array();

            foreach($tags_object as $group) {
                $sqlGroupTags = array();
                $havingSql = array();

                foreach ($group  as $tag){
                    $sqlGroupTags[] = ' tags.name LIKE "%'.$tag.'%" ';
                    $sqlGroupTags[] = ' tags.english_name LIKE "%'.$tag.'%" ';
                    $sqlGroupTags[] = ' tags.arabic_name LIKE "%'.$tag.'%" ';
                    $havingSql[] = ' tags_id LIKE "%,' . $tag .',%" ';
                }
                $havOr[] = "(" . implode('OR', $havingSql) . ")";
                $sqlTags[] ="(" . implode('OR', $sqlGroupTags) . ")" ;
            }

            $tagsQuery = implode(' OR ', $sqlTags);
            $having =  implode(' AND ', $havOr);
            $sql[] = $tagsQuery;
        };
        /** checking if its stripes custom catalog page */
        if($filters['search']['stripe_id']){
            $stripeId = intval($filters['search']['stripe_id'][0]);
            $coursesIds = get_field('courses', $stripeId);
            $stripeQuery = "t.id IN (";
            foreach ($coursesIds as $singleId) {
                $stripeQuery .= $singleId . ",";
            }
            $stripeQuery = substr_replace($stripeQuery, ")", -1);
            $sql[] = '(' . $stripeQuery . ')';
        }
    }
    $byName = getFieldByLanguage("t.name", "t.english_name", "t.arabic_name", $current_lang);
    $where = implode(" AND ", $sql);
    $order .= "t.order DESC," . $byName;

    $params = array(
        'select'=> '`t`.*, concat(",",group_concat(`tags`.`english_name` SEPARATOR ","), ",") as `tags_id`',
        'limit' => -1,
        'where'=>$where,
        'groupby'=> 't.id',
        'having'=> $having,
        'orderby'=> $order
    );
    return $params;
}


