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

?>

<div class="wrapEachFiltergroup">
    <div class="wrapEachFilterTag">
        <div class="buttonWrap" >
            <p  class="filterGroupTitle" ><?= $title ?></p>
            <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
            <img class="filterVectorMobile" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/filtersMenuVectorDown.svg'?>"/>

        </div>
    </div>
    <div class="inputsContainer catalogFilters" > <?php
        $i=0;
        foreach ($languages as $language) {
            $name = $language['name'];
            $url_title = $language['url_title'];
            $checked = '';
            ?>

            <div class="filterInput">
                <label class="filterTagLabel" for="language_<?= $i ?>">
                    <input <?= $checked ?> class="checkbox-filter-search filtersInputWeb" type="checkbox" data-name='language' data-group='<?= $title ?>' data-value="<?= $url_title ?>" name=" $name '[]'" value="<?= $name ?>" id="language_<?= $i ?>"/>
                    <div class="wrap-term-and-sum tagNameWrap" >
                        <span class="term-name"><?= $name ?></span>
                    </div>
                </label>
            </div>

            <?php
            $i++;
        } ?>
    </div>

</div>

