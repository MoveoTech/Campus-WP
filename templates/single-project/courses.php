<?php
global $fields;
$courses = $fields['courses_list'];
$wp_query = new WP_Query(array(
    'post_type' => 'course',
    'posts_per_page' => -1,
    'post__in' => $courses,
    'orderby' => 'post__in',
    'prevent_reorder' => true
));
$strings = get_courses_search_filter($wp_query, $fields['filters_list'], $fields['campus_order_academic_institutions_list']);
//        print_r($strings);
//
$count = count($courses);
$courses_str = $strings['courses'];
$aside_str = $strings['aside'];

$form_short_code_sidebar = $fields['form_below_filters'] ? do_shortcode('[contact-form-7 id="'. $fields['form_below_filters'] .'"]') : '';

echo '<div class="wrap-search-page-course">
    <div class="container">
        <div class="row justify-content-end">
            <div class="search-course-form col-lg-3">'; get_search_form(); echo '</div>
        </div>
        <div class="row justify-content-between">
            <aside class="col-xs-12 col-md-12 col-lg-3 col-xl-3 col-sm-12 sidebar-search-course">
                <div class="wrap-all-filter-names">
                    <div class="clear-filter-area">
                            <span class="filter-course-title" role="heading" aria-level="2">'. __('Filter Courses' ,'single_corse').'</span>
                    </div>' .$aside_str. '</div>
                <div class="lokking-for-form">' . $form_short_code_sidebar. '</div>
            </aside>
            <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 col-12">
                <div class="row">
                    <div aria-label="'. __('click here to remove filter button' ,'single_corse').'" class="hidden" id="filter_dynamic_tags_demo">
                        <a role="button" aria-label=" '. __('click to remove the filter' ,'single_corse').' " class="filter_dynamic_tag" data-name data-id href="javascript: void(0);"></a>
                    </div>
                    <div class="sum-all-course col-lg-12" role="alert"><h3 class="wrap-sum">';
echo '<span>' .  __('Showing', 'single_corse') .'</span>
                        <span id="add-sum-course" class="sum-of-courses-result">' . $count .'</span>
                        <span>' . cin_get_str('matching_courses') .'</span>';

echo
'</div></div>';
echo
    '<div class="col-12">
                        <div class="row wrap-top-bar-search">
                        <div class="col-md-8 col-sm-8 col-lg-8 filter-dynamic" id="filter_dynamic_tags"></div>
                        <div class="d-flex justify-content-end col-md-4 col-sm-4 col-lg-4 top-bar-search">
                            <div class="wrap-orderby">
                                <input class="recomended-course sr-only" type="radio" id="orderbyrecomended" checked name="orderby" value="menu_order">
                                <label aria-label="'. __('sort by the best recommended', 'single_corse') .'" role="button" tabindex="0" class="orderby active" for="orderbyrecomended">'. cin_get_str('Popular') .'</label>
                            </div>
                            <div class="wrap-orderby">
                                <input class="newest-course sr-only" type="radio" name="orderby" id="orderbynew" value="date">
                                <label aria-label=" ' .__('sort by the newest', 'single_corse') .'" role="button" tabindex="0" class="orderby" for="orderbynew">'. cin_get_str('Newest') .'<br></label>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="wrap-content-search-page col-12">
                                <div class="hidden no-result-inside-filter"><h4>' . __('No courses were found with the desired filter results' ,'single_corse') .'...</h4></div>
                                <div class="row output-courses">' . $courses_str . '</div>';

if($count >= 15){
    $arialabel_acc = cin_get_str('load_more_courses');
    echo "<button class='load-more-wrap' aria-label='$arialabel_acc' id='course_load_more' >". __('Load more' ,'single_corse') ."</button>";
}
echo '
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>';