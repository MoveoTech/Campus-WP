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
$count = count($tags);
?>
<div class="wrap-terms-group">
    <h2 class="search-page-tax-name"><?= $title ?></h2>
    <div class="more-tags">

        <?php foreach ($tags as $tag) {
            $tagId =  $tag->id;
            $tag_name = getFieldByLanguage($tag->name, $tag->english_name, $tag->arabic_name, $sitepress->get_current_language());
            $url_title = $tag->english_name;
            $checked = '';
            //TODO get all courses that have this tag -> $count = result.
        ?>

        <div class="wrap-filter-search">
            <label class="term-filter-search" for="<?= $tagId ?>">
                <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name='tag' data-group='<?= $english_name ?>' data-value="<?= $url_title ?>" name="tag_name '[]'" value="<?= $tag_name ?>" id="<?= $tagId ?>"/>
                <div class="wrap-term-and-sum" >
                    <span class="term-name"><?= $tag_name ?></span>
                    <span class="sum">(<?= $count ?>)</span>
                </div>
            </label>
        </div>


        <?php if (count($tags) > 7) {?>
            <button class="show-more-tags collapsed" type="button" aria-hidden="true">
                <span><?= __('Show More Tags', 'single_corse') ?></span>
                <span><?= __('Show Less Tags', 'single_corse') ?></span>
            </button>


        <?php } } ?>
    </div>
</div>


