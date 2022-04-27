<?php

$filter = wp_parse_args(
    $args["args"]
);

global $sitepress;
$moreFilters = $filter['filters'];
?>

<div id="morefiltersBox" class="moreFilters wrapEachFiltergroup">

    <div class="extraButtonsWrap">

        <div class="wrapEachFilterButton">
            <div class="buttonWrap" >
                <p class="filterGroupTitle"><?= addingMoreFiltersLanguage(); ?></p>
                <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/plus-sign.svg'?>"/>
            </div>
        </div>

    </div>
    <div class="inputsContainer" >
        <?php $i = 0;
        foreach($moreFilters as $filterId ) {
            $title = getFieldByLanguage(get_field('hebrew_title', $filterId), get_field('english_title', $filterId), get_field('arabic_title', $filterId), $sitepress->get_current_language());
            $checked = '';
            ?>
            <div class="filterInput">
                <label class="filterTagLabel" for="moreFilters_<?= $i ?>">
                    <input <?= $checked ?> class="checkbox-filter-search extraFilterCheckbox " type="checkbox" data-name="moreFilters" data-value="<?= $filterId ?>" name=" moreFilters '[]'"  value="<?= $title ?>" id="moreFilters_<?= $i ?>">
                    <div class="wrap-term-and-sum tagNameWrap" >
                        <span class="term-name"><?= $title ?></span>
                    </div>
                </label>
            </div>
            <?php $i++;
            }?>
    </div>

</div>

