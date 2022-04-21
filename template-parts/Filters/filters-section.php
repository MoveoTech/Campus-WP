<?php
require_once 'filterTypes.php';
$filtersList = wp_parse_args(
    $args["args"]
);

if(empty($filtersList) || empty($filtersList['academic_filter']))
return;
global $get_params, $sitepress;

$academic_institutions = $filtersList['academic_filter'];
$filters = $filtersList['menuFilters'];
$academic_name = cin_get_str('Institution_Name');
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
        } ?>
        <?php
        if(count($filtersInputs)>0){

            /** adding filter group template */
            get_template_part('template', 'parts/Filters/addMoreFilters',
                array(
                    'args' => array(
                        'filters'=>  $filtersInputs,
                    )
                )
            );
        } ?>

        <div class="wrapEachFilterButton" id="resetButton">
            <p class="resetFilterButton filterGroupTitle"><?= ResetFiltersLanguage(); ?></p>
        </div>
    </div>

</div>

                                    <!--order by section - DO NOT REMOVE - for the next version-->

<!--    <div>-->
<!--        <select>-->
<!--            <option name="orderByPopularity">--><?php //echo orderByPopularityLanguage() ?><!--</option>-->
<!--            <option name="orderByName">--><?php //echo orderByNameLanguage() ?><!--</option>-->
<!--            <option name="orderByNewest">--><?php //echo orderByNewestLanguage() ?><!--</option>-->
<!--        </select>-->
<!---->
<!--    </div>-->

<!-- END FILTERS SECTION .-->
