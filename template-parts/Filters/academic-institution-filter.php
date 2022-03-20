<?php
$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['academic_institutions']) || count($filter['academic_institutions']) < 1)
    return;

global $get_params;

$academic_institutions_array = $filter['academic_institutions'];
$title = $filter['title'];
$academic_institutions = pods('academic_institution', podsFilterParams($academic_institutions_array))->data();
$choose_str = __('Choose Institution', 'single_corse');

?>

<div class="wrapEachFiltergroup">
    <div class="wrapEachFilterTag">
        <div class="buttonWrap">
            <p class="filterGroupTitle" ><?= $title ?></p>
            <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
        </div>
    </div>
    <div class="inputsContainer">

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

                <div class="filterInput">
                    <label class="term-filter-search" for="institution_<?= $ID ?>">
                        <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name="institution" data-value="<?= $ID ?>" value="<?= $title ?>" id="institution_<?= $ID ?>">
                        <div class="wrap-term-and-sum">
                            <span class="term-name"><?= $title ?></span>
                        </div>
                    </label>
                </div>
            <?php }
            ?>

        </div>

<!--    <a href="javascript: void(0);" class="clear-link" role="button" id="clear_all_filters">--><?//= __('Clear All', 'single_corse') ?><!--</a>-->
<!--    <a href="javascript: void(0);" class="ajax_filter_btn" role="button">--><?//= __('Filter Courses', 'single_corse') ?><!--</a>-->
</div>



