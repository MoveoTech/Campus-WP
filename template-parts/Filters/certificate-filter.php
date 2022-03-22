<?php

$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['certificate']) || count($filter['certificate']) < 1)
    return;

global $sitepress, $get_params;

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
    <div class="more-tags" >

        <?php
        $keys = array_keys($certificates);
        $i = 0;
        foreach ($certificates as $certificate) {

            $checked = '';


//            if(in_array($ID, $get_params['certificate'])){
//                console_log("holi ffom if");
//                $checked = 'checked';
//                $selected = 'selected';
//            }
            //TODO get all courses that have this tag -> $count = result.
            ?>

            <div class="wrap-filter-search" >
                <label class="term-filter-search" for="certificate_<?= $i ?>">
                    <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name="certificate" data-group='<?= $title ?>' data-value="<?= $certificate ?>" name=" $certificate '[]'"  value="<?= $certificate ?>" id="certificate_<?= $i ?>">

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


            <?php }
            $i++;
        } ?>
    </div>
</div>
