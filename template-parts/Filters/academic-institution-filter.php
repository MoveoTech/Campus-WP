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
            <p class="filterGroupTitle" ><?= $title ?></p>
            <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
        </div>
    </div>
    <div class="inputsContainer">

            <?php
            foreach ($academic_institutions as $single_academic_institution){
                $title = getFieldByLanguage($single_academic_institution->name, $single_academic_institution->english_name, $single_academic_institution->arabic_name, $sitepress->get_current_language());
                $ID = $single_academic_institution->id;
                $checked = $selected = '';
                if(in_array($ID, $get_params['institution'])){
                    $checked = 'checked';
                    $selected = 'selected';
                }
                ?>


                <div class="filterInput">
                    <label class="filterTagLabel" for="institution_<?= $ID ?>">
                        <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name="institution" data-value="<?= $ID ?>" value="<?= $title ?>" id="institution_<?= $ID ?>">
                        <div class="wrap-term-and-sum tagNameWrap">
                            <span class="term-name"><?= $title ?></span>
                        </div>
                    </label>
                </div>
            <?php }
            ?>

        </div>
</div>



