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

?>
<div class="wrapEachFiltergroup">
    <div class="wrapEachFilterTag">
        <div class="buttonWrap">
            <p class="filterGroupTitle" ><?= $title ?></p>
            <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
        </div>
    </div>
        <div class="inputsContainer">

        <?php foreach ($tags as $tag) {
            $tagId =  $tag->id;
            $tag_name = getFieldByLanguage($tag->name, $tag->english_name, $tag->arabic_name, $sitepress->get_current_language());
            $checked = '';
        ?>

        <div class="filterInput">
            <label class="filterTagLabel" for="<?= $tagId ?>">
                <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name='tag' data-value="<?= $tagId ?>" name="tag_name '[]'" value="<?= $tag_name ?>" id="<?= $tagId ?>"/>
                <div class="wrap-term-and-sum tagNameWrap" >
                    <span class="term-name"><?= $tag_name ?></span>
                </div>
            </label>
        </div>


        <?php  } ?>
    </div>
</div>


