<?php
$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
    return;

?>

<div class="home-page-info-stripe" >
    <div class="back-img-1" ></div>
    <div class="back-img-2" ></div>
    <div class="stripe-container">
        <?php if($stripe['title'] != '' && !empty($stripe['title'])) : ?>
            <div class="info-stripe-header">
                <span style="background: <?php echo randomColor();?>"></span>
                    <h1 ><?php echo $stripe['title'] ?></h1>
            </div>
        <?php endif; ?>
        <div class="info-content">
        <?php
        global $sitepress;

        if($stripe['carousel'] && count($stripe['carousel']) > 0):
            foreach ($stripe['carousel'] as $info_item) :

                $title = getFieldByLanguage($info_item['title']['hebrew_title'], $info_item['title']['english_title'], $info_item['title']['arabic_title'], $sitepress->get_current_language());

                $subTitle = getFieldByLanguage($info_item['sub_title']['hebrew_sub_title'], $info_item['sub_title']['english_sub_title'], $info_item['sub_title']['arabic_sub_title'], $sitepress->get_current_language());

                $url = $info_item['link'];

                $media = getMediaType($info_item);
                ?>
                <div class="info-item" >
                    <a href="<?php echo $url ?>">
                        <?php if($media['image']) : ?>
                            <img src="<?php echo $media['image'] ?>" />
                        <?php endif; ?>

                        <?php if($media['embeded_media']) :
                            $videoId = substr($media['embeded_media'], 30);
                            ?>
                            <div class="open-iframe you-tube-video" data-url="<?php echo $media['embeded_media'] ?>" style="background-image: url('https://img.youtube.com/vi/<?= $videoId ?>/mqdefault.jpg')"></div>
                        <?php endif; ?>

                        <h1><?php echo $title ?></h1>
                        <?php if($subTitle && $subTitle !== '') :?>
                            <p ><?php echo $subTitle ?></p>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach;
        endif;
        ?>
    </div>
    </div>
</div>




