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

    <!-- START FILTERS SECTION .-->

<div class="checkboxFiltersWrap">

    <div id="groupFiltersContainer">
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
    </div>

    <?php
    if(count($filtersInputs)>0){
        getMoreFilters($filtersInputs);
    }
    /** adding filter group template */
   function getMoreFilters($filtersInputs){
       get_template_part('template', 'parts/Filters/addMoreFilters',
           array(
               'args' => array(
                   'filters'=>  $filtersInputs,
               )
           ));
   }
    ?>
    <div class="wrapEachFilterButton" id="resetButton">
        <p class="resetFilterButton filterGroupTitle"><?= ResetFiltersLanguage(); ?></p>
    </div>
</div>

<!--    <div>-->
<!--        <select>-->
<!--            <option name="orderByPopularity">--><?php //echo orderByPopularityLanguage() ?><!--</option>-->
<!--            <option name="orderByName">--><?php //echo orderByNameLanguage() ?><!--</option>-->
<!--            <option name="orderByNewest">--><?php //echo orderByNewestLanguage() ?><!--</option>-->
<!--        </select>-->
<!---->
<!--    </div>-->

<!-- END FILTERS SECTION .-->
