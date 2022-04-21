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

?>

<div class="filters-mobile-menu-popup">
    <div class="navFiltersMenu">
        <p class="resetFilterButton"><?= ResetFiltersLanguage(); ?></p>
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
            <p class="filterButtonMobileMenu"><?= filtersMobileMenuLanguage(); ?></p>

        </div>
    </div>
</div>
