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

$reset_filter_button = __("Reset Filters", "Catalog_page");

/** sort by translate */
$sortByRelevance = __( "Sort by Relevance","Catalog_page");
$sortByNewest = __( "Sort by The Newest", "Catalog_page");
$sortByOldest = __( "Sort by The Oldest","Catalog_page");
$sortByAtoZ = __( "Sort by A to Z", "Catalog_page");
$sortByZtoA = __( "Sort by Z to A", "Catalog_page");



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
            <p class="resetFilterButton filterGroupTitle"><?= $reset_filter_button ?></p>
        </div>

        <!--order by section-->
        <div class="sortByWrapper">
            <span id="border"></span>
            <div id="sortByButton">
                <p id="sortByText" data="sortByRelevance"><?= $sortByRelevance ?></p>
                <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
            </div>
            <div id="sortByOptions">
                <span class="sortOption active" id="sortByRelevance"><?= $sortByRelevance ?></span>
                <span class="sortOption" id="sortByNewest"><?= $sortByNewest ?></span>
                <span class="sortOption" id="sortByOldest"><?= $sortByOldest ?></span>
                <span class="sortOption" id="sortByAtoZ"><?= $sortByAtoZ ?></span>
                <span class="sortOption" id="sortByZtoA"><?= $sortByZtoA ?></span>
            </div>
        </div>
    </div>

</div>

<!-- END FILTERS SECTION .-->
