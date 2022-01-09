<?php
$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['title']) || $stripe['title'] == '' || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
    return;

$colors = array(
        '#70C6D1',
        '#F1595A',
       '#FDCC07',
        '#46b01b',
        '#ee8e2b'
);
$rand_color = $colors[rand(0,4)];
?>

<div class="home-page-info-stripe" >
    <div class="back-img-1" ></div>
    <div class="back-img-2" ></div>
    <div class="info-stripe-header">
        <span style="background: <?php echo $rand_color?>"></span>
        <h1 ><?php echo $stripe['title'] ?></h1>
    </div>
    <div class="info-content">
        <?php
        global $sitepress;

        if($stripe['carousel'] && count($stripe['carousel']) > 0):
            foreach ($stripe['carousel'] as $info_item) :

                $title = getFieldByLanguage($info_item['title']['hebrew_title'], $info_item['title']['english_title'], $info_item['title']['arabic_title'], $sitepress->get_current_language());

                $subTitle = getFieldByLanguage($info_item['sub_title']['hebrew_sub_title'], $info_item['sub_title']['english_sub_title'], $info_item['sub_title']['arabic_sub_title'], $sitepress->get_current_language());
                ?>
                <div class="info-item" >
                    <img src="<?php echo $info_item['info_media']['url'] ?>">
                    <h1><?php echo $title ?></h1>
                    <?php if($subTitle && $subTitle !== '') :?>
                        <p ><?php echo $subTitle ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach;
        endif;
        ?>
    </div>
</div>
