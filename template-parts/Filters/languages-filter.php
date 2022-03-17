<?php

$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['languages']) || count($filter['languages']) < 1)
    return;

global $sitepress;

$languagesArray = $filter['languages'];
$languages = [];
foreach ($languagesArray as $language) {
    $language_name = getFieldByLanguageFromString($language, $sitepress->get_current_language());
    array_push($languages, $language_name);
}

$title = $filter['title'];
$count = count($languages);
?>

<div class="wrap-terms-group">
    <h2 class="search-page-tax-name"><?= $title ?></h2>
    <select class="more-tags">
        <option selected="selected" hidden class="checkbox-filter-search"  data-name='language' data-value="<?= $language ?>" name=" language '[]'" value="<?= $language ?>" id="language_<?= $i ?>">שפה</option>

        <?php
        $i=0;
        foreach ($languages as $language) {
            $checked = '';
            ?>

            <option <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name='language' data-value="<?= $language ?>" name=" language '[]'" value="<?= $language ?>" id="language_<?= $i ?>">
                <?= $language ?>
            </option>

            <?php $i++;
        } ?>
    </select>
</div>
