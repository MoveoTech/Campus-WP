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

/** sort by translate */
$sortByRelevance = getFieldByLanguage("סידור לפי רלוונטיות", "Sort by Relevance", "ترتيب بحسب الملائمة", $current_lang);
$sortByNewest = getFieldByLanguage("סידור לפי החדש ביותר", "Sort by The Newest", "ترتيب بحسب المساق الأجدد", $current_lang);
$sortByOldest = getFieldByLanguage("סידור לפי הישן ביותר", "Sort by The Oldest", "ترتيب بحسب المساق الأقدم", $current_lang);
$sortByAtoZ = getFieldByLanguage("סידור לפי א' עד ת'", "Sort by A to Z", "ترتيب من الألف الى الياء", $current_lang);
$sortByZtoA = getFieldByLanguage("סידור לפי ת' עד א'", "Sort by Z to A", " ترتيب من الياء الى ألألف", $current_lang);

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

        <!--order by section-->
        <div class="sortByWrapper">
            <span id="border"></span>
            <div id="sortByButton">
                <p id="sortByText"><?= $sortByRelevance ?></p>
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

    <div id="selectedTags"></div>
</div>

<!-- END FILTERS SECTION .-->
