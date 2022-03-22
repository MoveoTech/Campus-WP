<?php
require_once 'filterTypes.php';
$filtersList = wp_parse_args(
$args["args"]
);
if(empty($filtersList) || empty($filtersList['filters_list']) || empty($filtersList['academic_filter']))
return;

$tags_filters = $filtersList['filters_list'];
$academic_institutions = $filtersList['academic_filter'];
$filters = get_field('filters');
$academic_name = cin_get_str('Institution_Name');
global $get_params, $sitepress;
$current_lang = $sitepress->get_current_language();
?>


<!--<form class="wrap-all-tags-filter" id="ajax_filter">-->
<!--    <input type="hidden" name="action" value="ajax_load_courses" />-->
<!--    <input type="hidden" name="paged" value="1" />-->
<!--    <input type="hidden" name="orderby" value="menu_order" />-->
<!--    <input type="hidden" name="lang" value="he" />-->





    <!-- START FILTERS SECTION .-->


<div class="checkboxFiltersWrap">


    <?php
    $filtersInputs = array();
    $i= 0;
    foreach($filters as $filterId ) {

        $i++;
        if($i<=4){
            getFilterType($filterId);
        }
        if($i>4){
            array_push($filtersInputs,$filterId );

        }
    }

    ?>
    <div id="moreFiltersWrap">

        <!--        append more filters group here-->

    </div>

    <?php
    if(count($filtersInputs)>0){
        getMoreFilters($filtersInputs);
    }



   function getMoreFilters($filtersInputs){
       get_template_part('template', 'parts/Filters/addMoreFilters',
           array(
               'args' => array(
                   'filters'=>  $filtersInputs,
               )
           ));
   }
    ?>



<!--    <div class="wrapEachFilterButton">-->
<!--        <p class="addFilterButton filterGroupTitle">--><?//= addingMoreFiltersLanguage(); ?><!--<img src="--><?php //echo get_bloginfo('stylesheet_directory'). '/assets/images/plus-sign.svg'?><!--"/></p>-->
<!--    </div>-->
    <div class="wrapEachFilterButton">
        <p class="resetFilterButton filterGroupTitle"><?= ResetFiltersLanguage(); ?></p>
    </div>
</div>

    <!-- END FILTERS SECTION .-->

    <!-- FILTER BUTTON .-->

    <div>
        <select>
            <option name="orderByPopularity"><?php echo orderByPopularityLanguage() ?></option>
            <option name="orderByName"><?php echo orderByNameLanguage() ?></option>
            <option name="orderByNewest"><?php echo orderByNewestLanguage() ?></option>
        </select>

    </div>

    <!--        <a href="javascript: void(0);" class="filters_button ajax_filter_btn" role="button">--><?//= __('Filter Courses', 'single_corse') ?><!--</a>-->
    <!--        <a href="javascript: void(0);" class="ajax_filter_btn" role="button">--><?//= __('Filter Courses', 'single_corse') ?><!--</a>-->
    <!--        <div class="wrap-button-filter">-->
    <!--            <button type="button" class="search-close-button d-md-none d-xs-block">--><?//= __('Show Courses', 'single_corse') ?><!--</button>-->
    <!--        </div>-->


    <!-- END FILTER BUTTON .-->

    <?php

//    foreach ($tags_filters as $filter){
//        $tax = $filter['taxonomy'];
//        $items = $filter['terms_list'];
//
//        $excluded_json = json_decode($items);
//
//        if($current_lang != 'he'){
//            $list = array();
//            foreach ($excluded_json->items as $he_item) {
//                $id = icl_object_id($he_item, $tax, false,ICL_LANGUAGE_CODE);
//                $list[] = $id;
//            }
//            $excluded_json->items = $list;
//        }
//
//        if ($filter['acf_fc_layout'] == 'automatic_order') {
//            if ($filter['order_type'] == 'amount') {
//                $orderby = 'count';
//                $order = 'DESC';
//            } else {
//                $orderby = 'name';
//                $order = 'ASC';
//            }
//
//            $args = array(
//                'taxonomy' => $tax,
//                'exclude' => $excluded_json->items,
//                'orderby' => $orderby,
//                'order' => $order,
//            );
//            $terms = get_terms($args);
//        } else {
//            $includes = $excluded_json->items;
//            $args = array(
//                'taxonomy' => $tax,
//                'include' => $includes
//            );
//            $terms = get_terms($args);
//            usort($terms, function ($a, $b) use ($includes) {
//                $pos_a = array_search($a->term_id, $includes);
//                $pos_b = array_search($b->term_id, $includes);
//                return $pos_a - $pos_b;
//            });
//        }
//
//        switch ($tax) {
//            case 'tags_knowledge':
//                $field_name = 'tags_knowledge';
//                $name = __('Field Of Knowledge', 'single_corse');
//                break;
//            case 'course_duration':
//                $field_name = 'course_duration_tag';
//                $name = cin_get_str('course_duration_filter_title');
//                break;
//            case 'age_strata':
//                $field_name = 'age_strata';
//                $name = __('Age Strata', 'single_corse');
//                break;
//            case 'skill':
//                $field_name = 'skill';
//                $name = __('Skill', 'single_corse');
//                break;
//            case 'areas_of_knowledge':
//                $field_name = 'knowledge';
//                $name = __('Learning Target', 'single_corse');
//                break;
//            case 'subject':
//                $field_name = 'subject_of_daat';
//                $name = __('Subject', 'single_corse');
//                break;
//            case 'language':
//                $field_name = 'language_course';
//                $name = __('Language', 'single_corse');
//                break;
//            case 'tags_course':
//                $field_name = 'tags';
//                $name = __('Courses Tags', 'single_corse');
//                break;
//        }
//
//        if (count($terms) > 0) {
//            $index = 1;
//
//            foreach ($terms as $term) {
//                $tmp_select .= draw_new_filter_item_from_term($tax, $term, $index);
//                $index++;
//            }
//            if($tmp_select){?>
<!---->
<!--                <div class="wrap-terms-group">-->
<!--                    <h2 class="search-page-tax-name">--><?//= $name ?><!--</h2>-->
<!--                    <div class="more-tags">-->
<!--                        --><?//= $tmp_select ?>
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //}
//        }
//        if (count($terms) > 7) {?>
<!--            <button class="show-more-tags collapsed" type="button" aria-hidden="true"><span>--><?//= __('Show More Tags', 'single_corse') ?><!--</span>-->
<!--                <span>--><?//= __('Show Less Tags', 'single_corse') ?><!--</span></button>-->
<!---->
<!--        --><?php // }
//        ?>
<!--        <a href="javascript: void(0);" class="ajax_filter_btn" role="button">--><?//= __('Filter Courses', 'single_corse') ?><!--</a>-->
<!--        <div class="wrap-button-filter">-->
<!--            <button type="button" class="search-close-button d-md-none d-xs-block">--><?//= __('Show Courses', 'single_corse') ?><!--</button>-->
<!--        </div>-->
<!--    --><?php //}
    ?>



<!--</form>-->







<!--
    <div class="wrap-mobile-filter-title">
        <button id="close-nav-search" class="close-nav-search" type="button"></button>
       <p class="filter-title-mobile">--><?//= __('Filter Courses', 'single_corse') ?><!--</p>-->
        <?php

//get_template_part('template', 'parts/Filters/institutionsFilter-list',
//    array(
//        'args' => array(
//            'academic_filter' => $academic_institutions,
//        )
//    ));
//?>

       <?php
//        if($academic_institutions) {
//            $choose_str = __('Choose Institution', 'single_corse');
//        ?>
<!--        <div class="wrap-terms-group wrap-terms-institution">-->
<!--            <h2 class="search-page-tax-name">--><?//= $academic_name ?><!--</h2>-->
<!--            <select multiple class="sr-only selected-academic" name="academic_select[]" aria-hidden="true" tabindex="-1">-->
<!--                <option>--><?//= $choose_str ?><!--</option>-->
<!--                --><?php
//                foreach ($academic_institutions as $academic_institution){
//                    $title = $academic_institution->name;
//                    $ID = $academic_institution->id;
//                    $checked = $selected = '';
//                    if(in_array($ID, $get_params['institution'])){
//                        $checked = 'checked';
//                        $selected = 'selected';
//                    }
//                    ?>
<!--                    <option --><?//= $selected ?><!-- class="academic-option-item" value="--><?//= $ID ?><!--">--><?//= $title ?><!--</option>-->
<!---->
<!--                --><?php //} ?>
<!--            </select>-->
<!--            <button role="combobox" aria-expanded="false" data-original="--><?//= $choose_str ?><!--" type="button" class="filter_main_button dropdown_open">-->
<!--                --><?//= $choose_str ?>
<!--            </button>-->
<!--            <div class="wrap-checkbox_institution wrap-terms-group">-->
<!--            --><?php
//                foreach ($academic_institutions as $academic_institution){
//                $output_courses .= get_template_part('template', 'parts/Filters/institutionsFilter-list',
//                    array(
//                        'args' => array(
//                            'academic_filter' => $academic_institution,
//                        )
//                    ));
//            } ?>
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //}?>


<!--</div> -->
