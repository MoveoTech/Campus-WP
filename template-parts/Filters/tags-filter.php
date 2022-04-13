<?php

$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['tags']) || count($filter['tags']) < 1)
    return;
global $sitepress;
$tagsArray = $filter['tags'];
$title = $filter['title'];
$english_name = $filter['english_title'];
$tags = pods('tags',podsFilterParams($tagsArray))->data();

?>
<div class="wrapEachFiltergroup">
    <div class="wrapEachFilterTag">
        <div class="buttonWrap">
            <p class="filterGroupTitle" ><?= $title ?></p>
            <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
        </div>
    </div>
        <div class="inputsContainer catalogFilters">

        <?php foreach ($tags as $tag) {
            $tagId =  $tag->id;
            $tag_name = getFieldByLanguage($tag->name, $tag->english_name, $tag->arabic_name, $sitepress->get_current_language());
            $url_title = $tag->english_name;
            $checked = '';
        ?>

        <div class="filterInput">
            <label class="filterTagLabel" for="tag_<?= $tagId ?>">
                <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name='tag' data-group='<?= $english_name ?>' data-value="<?= $url_title ?>" name="tag_name '[]'" value="<?= $tag_name ?>" id="tag_<?= $tagId ?>"/>
                <div class="wrap-term-and-sum tagNameWrap" >
                    <span class="term-name"><?= $tag_name ?></span>
                </div>
            </label>
        </div>


        <?php  } ?>
    </div>
</div>


