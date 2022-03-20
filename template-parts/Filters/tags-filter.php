<?php

$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['tags']) || count($filter['tags']) < 1)
    return;
global $sitepress;
$tagsArray = $filter['tags'];
$title = $filter['title'];
$tags = pods('tags',podsFilterParams($tagsArray))->data();
$count = count($tags);
?>
<div class="wrap-terms-group">
    <button  class="filterGroupTitle" id="<?= $title ?>filterButton" ><?= $title ?></button>
    <div class="inputsContainer" id="<?= $title ?>">

        <?php foreach ($tags as $tag) {
            $tagId =  $tag->id;
            $tag_name = getFieldByLanguage($tag->name, $tag->english_name, $tag->arabic_name, $sitepress->get_current_language());
            $checked = '';
        ?>

        <div class="filterInput">
            <label class="term-filter-search" for="<?= $tagId ?>">
                <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name='tag' data-value="<?= $tagId ?>" name="tag_name '[]'" value="<?= $tag_name ?>" id="<?= $tagId ?>"/>
                <div class="wrap-term-and-sum" >
                    <span class="term-name"><?= $tag_name ?></span>
                </div>
            </label>
        </div>


        <?php  } ?>
    </div>
</div>


