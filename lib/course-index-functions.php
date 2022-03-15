<?php
//get courses filter from search page
function get_courses_search_filter_server_side($query, $filters_list, $academic_filter)
{
    // 28/6 - Hanniek - Change the logic. they choose taxonomies in a flexible field
    // For every chosen tax - they also choose it's order type.
    // Only chosen tax will be in the sidebar.

    //get banner if entered from term id (in url)
//print_r($query);
    $output_courses = '';
    $i = 0;
    global $post;
    $course_attrs = array(
        'class' => 'col-xs-12 col-md-6 col-xl-4 course-item-with-border',
    );
    while ($query->have_posts()) : $query->the_post();
//        $post_fields = get_fields();

        $more_posts_id = $post->ID;
        $more_posts_org = get_field('org');
        $more_posts_org_id = icl_object_id($more_posts_org->ID, 'post', false, ICL_LANGUAGE_CODE);

        $more_posts_duration = get_field('duration');
        $more_posts_marketing_feature = get_field('marketing_feature');
        $more_posts_thumbnail_url = (get_the_post_thumbnail_url($more_posts_id)) ? get_the_post_thumbnail_url($more_posts_id) : site_url() . '/wp-content/uploads/2018/10/asset-v1JusticeJustice0012017_1type@assetblock@EDX3.png';
        $start = get_field('start');

//        echo "<div style='display: none;'>";
        //more_posts_org_lang = get_post($more_posts_org_id);
        if (is_object($more_posts_org) && $more_posts_org_id == $more_posts_org->ID) {
            if (!empty($more_posts_org)) {
                $academic['terms'][$more_posts_org->ID]['term_id'] = $more_posts_org->ID;
                $academic['terms'][$more_posts_org->ID]['term_name'] = $more_posts_org->post_title;
                $academic['terms'][$more_posts_org->ID]['sum'] = $academic['terms'][$more_posts_org->ID]['sum'] + 1;
            }
        }
//        echo '</div>';
        $output_courses .= draw_course_item($course_attrs);
        $i++;
    endwhile;

    wp_reset_postdata();
    // test

    $output_tags_button = '';
    $output_terms = '';
    $ajax_btn = '<a href="javascript: void(0);" class="ajax_filter_btn" role="button">' . __('Filter Courses', 'single_corse') . '</a>';
    $output_terms .= '
    <form class="wrap-all-tags-filter" id="ajax_filter">
        <input type="hidden" name="action" value="ajax_load_courses" />
        <input type="hidden" name="paged" value="1" />
        <input type="hidden" name="orderby" value="menu_order" />
        <input type="hidden" name="lang" value="he" />
        <div class="wrap-mobile-filter-title">
            <button id="close-nav-search" class="close-nav-search" type="button"></button>
            <p class="filter-title-mobile">' . __('Filter Courses', 'single_corse') . '</p>';
// print_r($academic);

    // המרת התגיות מעברית לשפות האחרות
    global $sitepress;
    $current_lang = $sitepress->get_current_language();

    $academic_name = cin_get_str('Institution_Name');

    $excluded_json = json_decode($academic_filter);
    if ($excluded_json->items) {
        $tmp_select = $tmp_checkbox = '';

        if($current_lang != 'he'){
            $list = array();
            foreach ($excluded_json->items as $he_item) {
                $id = icl_object_id($he_item, 'page', false,ICL_LANGUAGE_CODE);
                $list[] = $id;
            }
            $excluded_json->items = $list;
        }
		global $get_params, $filter_tags;

        foreach ($excluded_json->items as $ac_id) {
            $title = get_the_title($ac_id);
	        $checked = $selected = '';
	        if(in_array($ac_id, $get_params['institution'])){
		        // אם הצ'קבוקס הזה צריך להיות מסומן
		        $checked = 'checked';
				$selected = 'selected';
		        $filter_tags .= "<a role='button' class='filter_dynamic_tag ajax_filter_tag' data-name='institution' data-id='$ac_id' href='javascript: void(0);'>$title</a>";
	        }
            $tmp_select .= '<option '. $selected .' class="academic-option-item" value="' . $ac_id . '">' . $title . '</option>';
            $tmp_checkbox .= '
            <div class="wrap-filter-search">    
                <label class="term-filter-search" for="institution_' . $ac_id . '">
                    <input '. $checked .' class="checkbox-filter-search" type="checkbox" data-name="institution" data-value="' . $ac_id . '" value="' . $ac_id . '" id="institution_' . $ac_id . '">
                    <div class="wrap-term-and-sum"><span class="term-name">' . $title . '</span></div>
                </label>
            </div>';
        }
        if($tmp_select) {
            $choose_str = __('Choose Institution', 'single_corse');
            $output_terms .= '<div class="wrap-terms-group wrap-terms-institution">
                <h2 class="search-page-tax-name">' .$academic_name . '</h2>
                <select multiple class="sr-only selected-academic" name="academic_select[]" aria-hidden="true" tabindex="-1">
                    <option>' . $choose_str . '</option>
                    '. $tmp_select .'
                </select>
            <button role="combobox" aria-expanded="false" data-original="' . $choose_str . '" type="button" class="filter_main_button dropdown_open">
                    '. $choose_str .'
                </button>
                <div class="wrap-checkbox_institution wrap-terms-group">' . $tmp_checkbox . '</div>
            </div>';
        }
    }

    $output_terms .= '
            <a href="javascript: void(0);" class="clear-link" role="button" id="clear_all_filters">' . __('Clear All', 'single_corse') . '</a>
            '. $ajax_btn .'
            </div>';

    foreach($filters_list as $filter) {

        $tax = $filter['taxonomy'];
        $items = $filter['terms_list'];

        $excluded_json = json_decode($items);

        if($current_lang != 'he'){
            $list = array();
            foreach ($excluded_json->items as $he_item) {
                $id = icl_object_id($he_item, $tax, false,ICL_LANGUAGE_CODE);
                $list[] = $id;
            }

            $excluded_json->items = $list;
        }

        if ($filter['acf_fc_layout'] == 'automatic_order') {
            if ($filter['order_type'] == 'amount') {
                $orderby = 'count';
                $order = 'DESC';
            } else {
                $orderby = 'name';
                $order = 'ASC';
            }

            $args = array(
                'taxonomy' => $tax,
                'exclude' => $excluded_json->items,
                'orderby' => $orderby,
                'order' => $order,
            );
            $terms = get_terms($args);
        } else {
            $includes = $excluded_json->items;
            $args = array(
                'taxonomy' => $tax,
                'include' => $includes
            );
            $terms = get_terms($args);
            usort($terms, function ($a, $b) use ($includes) {
                $pos_a = array_search($a->term_id, $includes);
                $pos_b = array_search($b->term_id, $includes);
                return $pos_a - $pos_b;
            });
        }
        switch ($tax) {
            case 'tags_knowledge':
                $field_name = 'tags_knowledge';
                $name = __('Field Of Knowledge', 'single_corse');
                break;
            case 'course_duration':
                $field_name = 'course_duration_tag';
                $name = cin_get_str('course_duration_filter_title');
                break;
            case 'age_strata':
                $field_name = 'age_strata';
                $name = __('Age Strata', 'single_corse');
                break;
            case 'skill':
                $field_name = 'skill';
                $name = __('Skill', 'single_corse');
                break;
            case 'areas_of_knowledge':
                $field_name = 'knowledge';
                $name = __('Learning Target', 'single_corse');
                break;
            case 'subject':
                $field_name = 'subject_of_daat';
                $name = __('Subject', 'single_corse');
                break;
            case 'language':
                $field_name = 'language_course';
                $name = __('Language', 'single_corse');
                break;
            case 'tags_course':
                $field_name = 'tags';
                $name = __('Courses Tags', 'single_corse');
                break;
        }
        
        $tmp_select = '';
        if (count($terms) > 0) {
            $index = 1;

            foreach ($terms as $term) {
                $tmp_select .= draw_new_filter_item_from_term($tax, $term, $index);
                $index++;
            }
            if($tmp_select){
                $output_terms .= '
                <div class="wrap-terms-group">
                    <h2 class="search-page-tax-name">' . $name . '</h2>
                    <div class="more-tags">
                        '. $tmp_select .'
                    </div>
                </div>';
            }
        }
        if (count($terms) > 7) {
            $output_terms .= '<button class="show-more-tags collapsed" type="button" aria-hidden="true"><span>' . __('Show More Tags', 'single_corse') . '</span>
        <span>' . __('Show Less Tags', 'single_corse') . '</span></button>';

        }
    }
    $output_terms .= $ajax_btn;

    $output_terms .= '<div class="wrap-button-filter">
        <button type="button" class="search-close-button d-md-none d-xs-block">' . __('Show Courses', 'single_corse') . '</button>
    </div></form>';

    return array(
        'courses' => $output_courses,
        'aside' => $output_terms
    );
}

//add_filter('terms_clauses', function($pieces, $taxonomies, $args ){
//    print_r($pieces);
//
//    return $pieces;
//}, 10, 3);

function draw_filter_item_from_term($tax, $term, $index)
{
    global $get_params, $filter_tags;
    if(in_array($term->term_id, $get_params[$tax])){
        // אם הצ'קבוקס הזה צריך להיות מסומן
        $checked = 'checked';
        $filter_tags .= "<a role='button' class='filter_dynamic_tag ajax_filter_tag' data-name='{$tax}[]' data-id='$term->slug' href='javascript: void(0);'>$term->name</a>";
    }
    $output_terms = '';
    if ($index == 7) {
        $access = 'data-accessibility-2020';
    } else {
        $access = '';
    }
    $output_terms .= '<div class="wrap-filter-search" ' . $access . ' >';
    $output_terms .= '<label class="term-filter-search" for="' . $tax . "_" . $term->term_id . '">';
    $output_terms .= '<input '. $checked .' class="checkbox-filter-search" type="checkbox" data-name="'. $tax .'" data-value="'. $term->term_id .'" name="' . $tax . '[]" value="' . $term->slug . '" id="' . $tax . "_" . $term->term_id . '">';
    $output_terms .= '<div class="wrap-term-and-sum" ><span class="term-name">' . $term->name . '</span>
        <span class="sum">(' . $term->count . ')</span>';
    $output_terms .= '</div></label></div>';

    return $output_terms;
}

function ajax_load_courses_func(){

    global $lang_strings;
    $lang_strings = get_langs_json_object();
    $args = $_POST;

    unset($args['action'], $args['academic_select'], $args['lang']);

    $args['exclude_hidden_courses'] = true;
    $args['post_type'] = 'course';
    $args['post_status'] = 'publish';
    $args['posts_per_page'] = 15;

    if($_POST['academic_select']){
        $args['meta_query'] = array(
            'relation' => 'OR'
        );
        foreach($_POST['academic_select'] as $org) {
            $args['meta_query'][] = array(
                'key' => 'org',
                'value' => $org,
                'compare' => '='
            );
        }
    }
//	print_r($args);
    $query = new WP_Query($args);

    $output = array();
    $output['total'] = $query->found_posts;

    if($query->have_posts()){

        $course_attrs = array(
            'class' => 'col-xs-12 col-md-6 col-xl-4 course-item-with-border',
        );

        while($query->have_posts()){
            $query->the_post();
            $output['html'] .= draw_course_item($course_attrs);
        }
    }else{
    }

    echo json_encode($output);
    die();
}
add_action('wp_ajax_ajax_load_courses', 'ajax_load_courses_func');
add_action('wp_ajax_nopriv_ajax_load_courses', 'ajax_load_courses_func');

function courses_posts_per_page(){
    return  (ICL_LANGUAGE_CODE == 'he' && !isset($_GET['termid'])) ? 15 : -1;
}







// New create course function
function create_course_and_filters_side( $filters_list, $academic_filter) {


    global $sitepress;
    $current_lang = $sitepress->get_current_language();


    $output_terms = '';
    $ajax_btn = '<a href="javascript: void(0);" class="ajax_filter_btn" role="button">' . __('Filter Courses', 'single_corse') . '</a>';
    $output_terms .= '
    <form class="wrap-all-tags-filter" id="ajax_filter">
        <input type="hidden" name="action" value="ajax_load_courses" />
        <input type="hidden" name="paged" value="1" />
        <input type="hidden" name="orderby" value="menu_order" />
        <input type="hidden" name="lang" value="he" />
        <div class="wrap-mobile-filter-title">
            <button id="close-nav-search" class="close-nav-search" type="button"></button>
            <p class="filter-title-mobile">' . __('Filter Courses', 'single_corse') . '</p>';

    $academic_name = cin_get_str('Institution_Name');

    $excluded_json = json_decode($academic_filter);

    if ($excluded_json->items) {
        $tmp_select = $tmp_checkbox = '';

        if($current_lang != 'he'){
            $list = array();
            foreach ($excluded_json->items as $he_item) {
                $id = icl_object_id($he_item, 'page', false,ICL_LANGUAGE_CODE);
                $list[] = $id;
            }
            $excluded_json->items = $list;
        }
        global $get_params, $filter_tags;

        foreach ($excluded_json->items as $ac_id) {
            $title = get_the_title($ac_id);
            $checked = $selected = '';
            if(in_array($ac_id, $get_params['institution'])){
                // אם הצ'קבוקס הזה צריך להיות מסומן
                $checked = 'checked';
                $selected = 'selected';
                $filter_tags .= "<a role='button' class='filter_dynamic_tag ajax_filter_tag' data-name='institution' data-id='$ac_id' href='javascript: void(0);'>$title</a>";
            }
            $tmp_select .= '<option '. $selected .' class="academic-option-item" value="' . $ac_id . '">' . $title . '</option>';
            $tmp_checkbox .= '
            <div class="wrap-filter-search">    
                <label class="term-filter-search" for="institution_' . $ac_id . '">
                    <input '. $checked .' class="checkbox-filter-search" type="checkbox" data-name="institution" data-value="' . $ac_id . '" value="' . $ac_id . '" id="institution_' . $ac_id . '">
                    <div class="wrap-term-and-sum"><span class="term-name">' . $title . '</span></div>
                </label>
            </div>';
        }
        if($tmp_select) {
            $choose_str = __('Choose Institution', 'single_corse');
            $output_terms .= '<div class="wrap-terms-group wrap-terms-institution">
                <h2 class="search-page-tax-name">' .$academic_name . '</h2>
                <select multiple class="sr-only selected-academic" name="academic_select[]" aria-hidden="true" tabindex="-1">
                    <option>' . $choose_str . '</option>
                    '. $tmp_select .'
                </select>
            <button role="combobox" aria-expanded="false" data-original="' . $choose_str . '" type="button" class="filter_main_button dropdown_open">
                    '. $choose_str .'
                </button>
                <div class="wrap-checkbox_institution wrap-terms-group">' . $tmp_checkbox . '</div>
            </div>';
        }
    } //TODO change the old code

    $output_terms .= '
            <a href="javascript: void(0);" class="clear-link" role="button" id="clear_all_filters">' . __('Clear All', 'single_corse') . '</a>
            '. $ajax_btn .'
            </div>';

    foreach($filters_list as $filter) {

        $tax = $filter['taxonomy'];
        $items = $filter['terms_list'];

        $excluded_json = json_decode($items);

        if($current_lang != 'he'){
            $list = array();
            foreach ($excluded_json->items as $he_item) {
                $id = icl_object_id($he_item, $tax, false,ICL_LANGUAGE_CODE);
                $list[] = $id;
            }

            $excluded_json->items = $list;
        }
        if ($filter['acf_fc_layout'] == 'automatic_order') {
            if ($filter['order_type'] == 'amount') {
                $orderby = 'count';
                $order = 'DESC';
            } else {
                $orderby = 'name';
                $order = 'ASC';
            }

            $args = array(
                'taxonomy' => $tax,
                'exclude' => $excluded_json->items,
                'orderby' => $orderby,
                'order' => $order,
            );
            $terms = get_terms($args);
        } else {
            $includes = $excluded_json->items;
            $args = array(
                'taxonomy' => $tax,
                'include' => $includes
            );
            $terms = get_terms($args);
            usort($terms, function ($a, $b) use ($includes) {
                $pos_a = array_search($a->term_id, $includes);
                $pos_b = array_search($b->term_id, $includes);
                return $pos_a - $pos_b;
            });
        }
        switch ($tax) {
            case 'tags_knowledge':
                $field_name = 'tags_knowledge';
                $name = __('Field Of Knowledge', 'single_corse');
                break;
            case 'course_duration':
                $field_name = 'course_duration_tag';
                $name = cin_get_str('course_duration_filter_title');
                break;
            case 'age_strata':
                $field_name = 'age_strata';
                $name = __('Age Strata', 'single_corse');
                break;
            case 'skill':
                $field_name = 'skill';
                $name = __('Skill', 'single_corse');
                break;
            case 'areas_of_knowledge':
                $field_name = 'knowledge';
                $name = __('Learning Target', 'single_corse');
                break;
            case 'subject':
                $field_name = 'subject_of_daat';
                $name = __('Subject', 'single_corse');
                break;
            case 'language':
                $field_name = 'language_course';
                $name = __('Language', 'single_corse');
                break;
            case 'tags_course':
                $field_name = 'tags';
                $name = __('Courses Tags', 'single_corse');
                break;
        }

        $tmp_select = '';
        if (count($terms) > 0) {
            $index = 1;

            foreach ($terms as $term) {
                $tmp_select .= draw_new_filter_item_from_term($tax, $term, $index);
                $index++;
            }
            if($tmp_select){
                $output_terms .= '
                <div class="wrap-terms-group">
                    <h2 class="search-page-tax-name">' . $name . '</h2>
                    <div class="more-tags">
                        '. $tmp_select .'
                    </div>
                </div>';
            }
        }
        if (count($terms) > 7) {
            $output_terms .= '<button class="show-more-tags collapsed" type="button" aria-hidden="true"><span>' . __('Show More Tags', 'single_corse') . '</span>
        <span>' . __('Show Less Tags', 'single_corse') . '</span></button>';

        }
    }

    return array(
        'aside' => $output_terms
    );
}

function draw_new_course_item( $attrs, $course ) {
    global $sitepress;
    $ID = $course->display('id');
    $title = getFieldByLanguage($course->display( 'name' ), $course->display( 'english_name' ), $course->display( 'arabic_name' ),$sitepress->get_current_language());
    $institution_name = getFieldByLanguage($course->field( 'academic_institution.name' ), $course->field( 'academic_institution.english_name' ), $course->field( 'academic_institution.arabic_name' ), $sitepress->get_current_language());
    $marketing_feature = sortTagsByOrder($course->field('marketing_tags')) ;
    $url_course_img_slick = $course->display( 'image' );
    $duration = $course->display( 'duration' );
    $course_permalink = $course->display('permalink');
    $site_url = get_home_url();
    $url = $site_url . '/course/' . $course_permalink;
    $haveyoutube          = $course->display( 'trailer' );
    $output = '';
    $attrs['class'] .= $attrs['hybrid_course'] ? ' hybrid_course' : '';

//return
//
//    '<div class="item_post_type_course course-item ' . $attrs['class'] . '" data-id="' . $ID . '" ' . $attrs['filters'] . '><div class="course-item-inner">';
//
//    if($haveyoutube) {
//       '<a class="course-item-image has_background_image haveyoutube " data-id="' . $ID . '"' . 'data-popup' . ' aria-pressed="true" aria-haspopup="true" role="button" href="javascript:void(0)" aria-label="' . wrap_text_with_char( $title ) . '" data-classToAdd="course_info_popup" style="background-image: url(' . $url_course_img_slick . ');"></a>';
//    } else {
//       '<div class="course-item-image has_background_image donthaveyoutube " data-id="' . $ID . '"data-classToAdd="course_info_popup" style="background-image: url(' . $url_course_img_slick . ');"></div>';
//    }
//
//    '<a class="course-item-details" tabindex="0" href="' . $url . '">
//        <h3 class="course-item-title">' . wrap_text_with_char( $title ) . '</h3>
//    </a>';
//
//    if ($institution_name) {
//        '<p class="course-item-org">' . $institution_name . '</p>';
//    }
//
//    if ( $duration ) {
//        '<div class="course-item-duration">' . __( $duration, 'single_corse' ) . '</div>';
//    }
//
//    if ( $marketing_feature ) {
//        $tags_array = [];
//        for($i = 0; $i < count($marketing_feature); $i++ ){
//            $tag = getFieldByLanguage($marketing_feature[$i]['name'], $marketing_feature[$i]['english_name'], $marketing_feature[$i]['arabic_name'], $sitepress->get_current_language());
//            array_push($tags_array, $tag);
//        }
//        $tags_string = implode(', ',$tags_array);
//
//        '<div class="course-item-marketing">';
//        '' . $tags_string . '</div>';
//    }



    if ( $haveyoutube ) {
        $haveyoutube = "haveyoutube";
        $data_popup  = "data-popup";
        $image_html  = '<a class="course-item-image has_background_image ' . $haveyoutube . '" data-id="' . $ID . '"' . $data_popup . ' aria-pressed="true" aria-haspopup="true" role="button" href="javascript:void(0)" aria-label="' . wrap_text_with_char( $title ) . '" data-classToAdd="course_info_popup" style="background-image: url(' . $url_course_img_slick . ');"></a>';
    } else {
        $haveyoutube = "donthaveyoutube";
        $data_popup  = "";
        $image_html  = '<div class="course-item-image has_background_image ' . $haveyoutube . '" data-id="' . $ID . '"' . $data_popup . '   data-classToAdd="course_info_popup" style="background-image: url(' . $url_course_img_slick . ');"></div>';
    } // TODO old code

    $output         .= '<div class="item_post_type_course course-item ' . $attrs['class'] . '" data-id="' . $ID . '" ' . $attrs['filters'] . '><div class="course-item-inner">';
    $output         .= $image_html;
    $output         .= '<a class="course-item-details" tabindex="0" href="' . $url . '">
                <h3 class="course-item-title">' . wrap_text_with_char( $title ) . '</h3>';
    if ( $institution_name ) {
        $output .= '<p class="course-item-org">' . $institution_name . '</p>';
    }
    if ( $duration ) {
        $output .= '<div class="course-item-duration">' . __( $duration, 'single_corse' ) . '</div>';
    }
    if ( $marketing_feature ) {
        $tags_array = [];
        for($i = 0; $i < count($marketing_feature); $i++ ){
            $tag = getFieldByLanguage($marketing_feature[$i]['name'], $marketing_feature[$i]['english_name'], $marketing_feature[$i]['arabic_name'], $sitepress->get_current_language());
            array_push($tags_array, $tag);
        }
        $tags_string = implode(', ',$tags_array);

        $output .= '<div class="course-item-marketing">';
        $output .= '' . $tags_string . '</div>';
    }
    $output .= '<div class="course-item-link">
                    <span>' . cin_get_str( 'Course_Page' ) . '</span>
                </div>
            </a></div></div>';

    return $output;
}


function draw_new_filter_item_from_term($tax, $term, $index)
{
    global $get_params, $filter_tags;
    if(in_array($term->term_id, $get_params[$tax])){
        // אם הצ'קבוקס הזה צריך להיות מסומן
        $checked = 'checked';
        $filter_tags .= "<a role='button' class='filter_dynamic_tag ajax_filter_tag' data-name='{$tax}[]' data-id='$term->slug' href='javascript: void(0);'>$term->name</a>";
    }
    $output_terms = '';
    if ($index == 7) {
        $access = 'data-accessibility-2020';
    } else {
        $access = '';
    }
    $output_terms .= '<div class="wrap-filter-search" ' . $access . ' >';
    $output_terms .= '<label class="term-filter-search" for="' . $tax . "_" . $term->term_id . '">';
    $output_terms .= '<input '. $checked .' class="checkbox-filter-search" type="checkbox" data-name="'. $tax .'" data-value="'. $term->term_id .'" name="' . $tax . '[]" value="' . $term->slug . '" id="' . $tax . "_" . $term->term_id . '">';
    $output_terms .= '<div class="wrap-term-and-sum" ><span class="term-name">' . $term->name . '</span>
        <span class="sum">(' . $term->count . ')</span>';
    $output_terms .= '</div></label></div>';

    return $output_terms;
} //TODO change the old code
