<?php
require_once 'filterTypes.php';
$filtersList = wp_parse_args(
    $args["args"]
);
if(empty($filtersList) || empty($filtersList['menuFilters']))
    return;
global $get_params, $sitepress;

$filters = $filtersList['menuFilters'];
$encoded_path = $filtersList['encoded_path'];
$current = $filtersList['currentLanguage'];

$reset_filter_button = __("Reset Filters", "Catalog_page");
$mobile_menu_filter_button = __("Filter", "Catalog_page");

?>

<div class="filters-mobile-menu-popup">
    <div class="navFiltersMenu">
        <p class="resetFilterButton"><?= $reset_filter_button ?></p>
    </div>
    <div id="filtersSectionMobile">

    <?php
    foreach ($filters as $filterGroupId) {
        getFilterType($filterGroupId);
    }
    ?>
    </div>
    <div class="buttonNavFiltersMenu">
        <div class="buttonFilterWrap">
            <p class="filterButtonMobileMenu"><?= $mobile_menu_filter_button ?></p>

        </div>
    </div>
</div>
