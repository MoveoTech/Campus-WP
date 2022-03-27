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
    $english_name = getFieldByLanguageFromString($language, 'en');
    $language_details = array('name' => $language_name, 'url_title' => $english_name);
    array_push($languages, $language_details);
}

$title = $filter['title'];
$count = count($languages);
?>

<div class="wrap-terms-group">
    <h2 class="search-page-tax-name"><?= $title ?></h2>
    <div class="more-tags">

        <?php
        $i=0;
        foreach ($languages as $language) {
            $checked = '';
            //TODO get all courses that have this tag -> $count = result.

            $name = $language['name'];
            $url_title = $language['url_title'];
            ?>

            <div class="wrap-filter-search">
                <label class="term-filter-search" for="language_<?= $i ?>">
                    <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name='language' data-group='<?= $title ?>' data-value="<?= $url_title ?>" name=" $name '[]'" value="<?= $name ?>" id="language_<?= $i ?>"/>
                    <div class="wrap-term-and-sum" >
                        <span class="term-name"><?= $name ?></span>
                        <span class="sum">(<?= $count ?>)</span>
                    </div>
                </label>
            </div>

            <?php if (count($languages) > 7) {?>
                <button class="show-more-tags collapsed" type="button" aria-hidden="true">
                    <span><?= __('Show More Tags', 'single_corse') ?></span>
                    <span><?= __('Show Less Tags', 'single_corse') ?></span>
                </button>


            <?php }
        $i++;
        } ?>
    </div>
</div>