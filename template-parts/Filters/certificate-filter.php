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
    $english_name = getFieldByLanguageFromString($certificate, 'en');
    $certificate_details = array('name' => $certificate_name, 'url_title' => $english_name);
    array_push($certificates, $certificate_details);
}


$title = $filter['title'];

?>

<div class="wrapEachFiltergroup">
    <div class="wrapEachFilterTag">
        <div class="buttonWrap">
            <p class="filterGroupTitle" ><?= $title ?></p>
            <img class="filterVector" src="<?php echo get_bloginfo('stylesheet_directory'). '/assets/images/vector-black.svg'?>"/>
        </div>
    </div>
        <div class="inputsContainer" >

        <?php $i = 0;
        foreach ($certificates as $certificate) {
            $checked = '';
            ?>

            <div class="filterInput">
                <label class="filterTagLabel" for="certificate_<?= $i ?>">
                    <input <?= $checked ?> class="checkbox-filter-search" type="checkbox" data-name="certificate" data-value="<?= $certificate ?>" name=" $certificate '[]'"  value="<?= $certificate ?>" id="certificate_<?= $i ?>">
                    <div class="wrap-term-and-sum tagNameWrap" >
                        <span class="term-name"><?= $certificate ?></span>

                    </div>
                </label>
            </div>


            <?php $i++;
        };?>
    </div>
</div>
