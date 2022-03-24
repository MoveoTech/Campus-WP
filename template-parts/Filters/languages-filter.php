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

?>

<div class="wrapEachFiltergroup">
    <div class="wrapEachFilterTag">
        <div class="buttonWrap" >
            <p  class="filterGroupTitle" ><?= $title ?></p>
            <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
        </div>
    </div>
    <div class="inputsContainer" > <?php
        $i=0;
        foreach ($languages as $language) {
            $checked = '';
            ?>

            <div class="filterInput">
                <label class="filterTagLabel" for="language_<?= $i ?>">
                    <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name='language' data-value="<?= $language ?>" name=" language '[]'" value="<?= $language ?>" id="language_<?= $i ?>"/>
                    <div class="wrap-term-and-sum tagNameWrap" >
                        <span class="term-name"><?= $language ?></span>
                    </div>
                </label>
            </div>

            <?php
            $i++;
        } ?>
    </div>

</div>

