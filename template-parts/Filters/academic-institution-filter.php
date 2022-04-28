<?php
$filter = wp_parse_args(
    $args["args"]
);

if(empty($filter) || empty($filter['title']) || $filter['title'] == '' || empty($filter['academic_institutions']) || count($filter['academic_institutions']) < 1)
    return;

global $sitepress, $get_params;

$academic_institutions_array = $filter['academic_institutions'];
$filter_title = $filter['title'];
$academic_institutions = pods('academic_institution', podsFilterParams($academic_institutions_array))->data();
$choose_str = __('Choose Institution', 'single_corse');

?>

<div class="wrapEachFiltergroup">
    <div class="wrapEachFilterTag">
        <div class="buttonWrap">
            <p class="filterGroupTitle" ><?= $filter_title ?></p>
            <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
            <img class="filterVectorMobile" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/filtersMenuVectorDown.svg'?>"/>
        </div>
    </div>
    <div class="inputsContainer catalogFilters">

            <?php
            foreach ($academic_institutions as $single_academic_institution){
                $title = getFieldByLanguage($single_academic_institution->name, $single_academic_institution->english_name, $single_academic_institution->arabic_name, $sitepress->get_current_language());
                $url_title = $single_academic_institution->english_name;
                $ID = $single_academic_institution->id;
                $checked = $selected = '';
                $rand_ID = rand();
                if(in_array($ID, $get_params['institution'])){
                    $checked = 'checked';
                    $selected = 'selected';
                }
                ?>


                <div class="filterInput">
                    <label class="filterTagLabel" for="institution_<?= $rand_ID ?>">
                        <input <?= $checked ?> class="checkbox-filter-search filtersInputWeb" type="checkbox" data-name="institution" data-group='<?= $filter_title ?>' data-value="<?= $url_title ?>" value="<?= $title ?>" id="institution_<?= $rand_ID ?>">
                        <div class="wrap-term-and-sum tagNameWrap">
                            <span class="term-name"><?= $title ?></span>
                        </div>
                    </label>
                </div>
            <?php }
            ?>

        </div>
</div>



