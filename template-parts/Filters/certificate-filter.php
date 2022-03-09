<?php

$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['certificate']) || count($filter['certificate']) < 1)
    return;

global $sitepress;

$certificatesArray = $filter['certificate'];
$title = $filter['title'];
$certificates = [];
foreach ($certificatesArray as $certificate) {
    $certificate_name = getFieldByLanguageFromString($certificate, $sitepress->get_current_language());

    array_push($certificates, $certificate_name);
}
//var_dump($certificates);

$title = $filter['title'];
$count = count($certificates);
?>

<div class="wrap-terms-group">
    <h2 class="search-page-tax-name"><?= $title ?></h2>
    <div class="more-tags">

        <?php foreach ($certificates as $certificate) {
            $checked = '';
            //TODO get all courses that have this tag -> $count = result.
            ?>

            <div class="wrap-filter-search">
                <label class="term-filter-search" for="<?= $certificate ?>">
                    <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name=' $language ' data-value="<?= $certificate ?>" name=" $language '[]'" value="<?= $certificate ?>" id="<?= $certificate ?>"/>
                    <div class="wrap-term-and-sum" >
                        <span class="term-name"><?= $certificate ?></span>
                        <span class="sum">(<?= $count ?>)</span>
                    </div>
                </label>
            </div>

            <?php if (count($certificates) > 7) {?>
                <button class="show-more-tags collapsed" type="button" aria-hidden="true">
                    <span><?= __('Show More Tags', 'single_corse') ?></span>
                    <span><?= __('Show Less Tags', 'single_corse') ?></span>
                </button>


            <?php } } ?>
    </div>
</div>
