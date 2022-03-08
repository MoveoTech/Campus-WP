<?php
$filtersList = wp_parse_args(
    $args["args"]
);

if(empty($filtersList) || empty($filtersList['academic_filter']))
    return;

global $get_params;
$academic_filters = $filtersList['academic_filter'];


//if(in_array($ID, $get_params['institution'])){
//    $checked = 'checked';
//    $selected = 'selected';
//}
?>
<!-- <div class="wrap-filter-search">-->
<!--    <label class="term-filter-search" for="institution_--><?//= $ID ?><!--">-->
<!--        <input --><?//= $checked ?><!-- class="checkbox-filter-search" type="checkbox" data-name="institution" data-value="--><?//= $ID ?><!--" value="--><?//= $ID ?><!--" id="institution_--><?//= $ID ?><!--">-->
<!--        <div class="wrap-term-and-sum">-->
<!--            <span class="term-name">--><?//= $title ?><!--</span>-->
<!--        </div>-->
<!--    </label>-->
<!--</div>-->


<?php
if($academic_filters) {
$choose_str = __('Choose Institution', 'single_corse');
?>
<div class="wrap-terms-group wrap-terms-institution">
    <h2 class="search-page-tax-name"><?= $academic_name ?></h2>
    <select multiple class="sr-only selected-academic" name="academic_select[]" aria-hidden="true" tabindex="-1">
        <option><?= $choose_str ?></option>
        <?php
        foreach ($academic_filters as $single_academic_filter){
            $title = $single_academic_filter->name;
            $ID = $single_academic_filter->id;
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
        foreach ($academic_filters as $single_academic_filter){
            $title = $single_academic_filter->name;
            $ID = $single_academic_filter->id;
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


       <?php } ?>
    </div>
</div>

<?php }?>

