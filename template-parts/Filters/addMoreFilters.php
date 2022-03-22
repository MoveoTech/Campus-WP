<?php

$filter = wp_parse_args(
    $args["args"]
);

global $sitepress;
$moreFilters = $filter['filters'];



//foreach($moreFilters as $filterId ) {
//    $title = getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language());
//
//
//}


?>


<div class="moreFilters wrapEachFiltergroup">
    <div class="wrapEachFilterButton">
        <p class="filterGroupTitle"><?= addingMoreFiltersLanguage(); ?><img src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/plus-sign.svg'?>"/></p>
    </div>

    <div class="inputsContainer" >

        <?php $i = 0;
        foreach($moreFilters as $filterId ) {
            $title = getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language());
            $checked = '';
            ?>

            <div class="filterInput">
                <label class="term-filter-search" for="moreFilters_<?= $i ?>">
                    <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name="moreFilters" data-value="<?= $filterId ?>" name=" moreFilters '[]'"  value="<?= $title ?>" id="moreFilters_<?= $i ?>">
                    <div class="wrap-term-and-sum" >
                        <span class="term-name"><?= $title ?></span>
                    </div>
                </label>
            </div>


            <?php $i++;
        };?>
    </div>
</div>

