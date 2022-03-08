<?php
$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['academic_institutions']) || count($filter['academic_institutions']) < 1)
    return;

global $get_params;

$academic_institutions = $filter['academic_institutions'];
$title = $filter['title'];
$choose_str = __('Choose Institution', 'single_corse');
?>

<div class="wrap-mobile-filter-title">

    <button id="close-nav-search" class="close-nav-search" type="button"></button>
    <p class="filter-title-mobile"><?= __('Filter Courses', 'single_corse') ?></p>

    <div class="wrap-terms-group wrap-terms-institution">
        <h2 class="search-page-tax-name"><?= $title ?></h2>

        <select multiple class="sr-only selected-academic" name="academic_select[]" aria-hidden="true" tabindex="-1">
            <option><?= $choose_str ?></option>
            <?php
            foreach ($academic_institutions as $single_academic_institution){
                $title = $single_academic_institution->name;
                $ID = $single_academic_institution->id;
                $checked = $selected = '';
                if(in_array($ID, $get_params['institution'])){
                    $checked = 'checked';
                    $selected = 'selected';
                }
                ?>
                <option <?= $selected ?> class="academic-option-item" value="<?= $ID ?>"><?= $title ?></option>
            <?php } ?>
        </select>

        <button role="combobox" aria-expanded="false" data-original="<?= $choose_str ?>" type="button" class="filter_main_button dropdown_open">
            <?= $choose_str ?>
        </button>

        <div class="wrap-checkbox_institution wrap-terms-group">

            <?php
            foreach ($academic_institutions as $single_academic_institution){
                $title = $single_academic_institution->name;
                $ID = $single_academic_institution->id;
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
            <?php }
            ?>

        </div>
    </div>
    <a href="javascript: void(0);" class="clear-link" role="button" id="clear_all_filters"><?= __('Clear All', 'single_corse') ?></a>
    <a href="javascript: void(0);" class="ajax_filter_btn" role="button"><?= __('Filter Courses', 'single_corse') ?></a>
</div>
