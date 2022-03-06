<?php
$filtersList = wp_parse_args(
    $args["args"]
);

if(empty($filtersList) || empty($filtersList['academic_filter']))
    return;

global $get_params;
$academic_filter = $filtersList['academic_filter'];
$title = $academic_filter->name;
$ID = $academic_filter->id;
$checked = $selected = '';

if(in_array($ID, $get_params['institution'])){
    $checked = 'checked';
    $selected = 'selected';
}
?>
 <div class="wrap-filter-search">
    <label class="term-filter-search" for="institution_<?= $ID ?>">
        <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name="institution" data-value="<?= $ID ?>" value="<?= $ID ?>" id="institution_<?= $ID ?>">
        <div class="wrap-term-and-sum">
            <span class="term-name"><?= $title ?></span>
        </div>
    </label>
</div>



