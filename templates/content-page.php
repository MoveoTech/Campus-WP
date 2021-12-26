<?php

global $fields;

$banner_image_general = $fields['banner_image_general'];
$banner_mobile_general = $fields['banner_mobile_general'];
$title_boxes_general = $fields['title_boxes_general'];
$boxes_general = $fields['boxes_general'];

?>


<!--Banner area-->
<?php if ($banner_image_general) : ?>
<?php
$class = 'general';
$text_on_banner_content = '';
$text_on_banner_content .= '<h1 class="title-opacity-on-banner">'. get_the_title($post->ID) .'</h1>';
?>
<?=  get_banner_area( $banner_mobile_general, $banner_image_general , $text_on_banner_content,$class); ?>
<?php endif; ?>
<!--End Banner area-->

<div class="container">
    <div class="container">
        <div class="row general-page">
            <div class="col-12 col-md-3 col-lg-2 sidebar-general">
                <?php
                if (has_nav_menu('sidebar_menu')) :
                    wp_nav_menu(['theme_location' => 'sidebar_menu', 'menu_class' => 'sidebar_menu']);
                endif;
                ?>
            </div>
            <div class="col-12 col-md-9 col-lg-10">
                <div class="content-general">
                    <div class="conntent-general-inner">
                        <?php echo wpautop(get_the_content()); ?>
                    </div>
                <div class="more-info-general-wrap">
                    <div class="row more-info-general">
                        <h3 class="title_boxes_general"><?= $title_boxes_general; ?></h3>
                        <?php if($boxes_general): ?>
                        <?php foreach ($boxes_general as $box_general): ?>
                            <div class="col-12 more-info-box">
                                <div class="row align-items-center">
                                        <div class="d-flex align-items-center justify-content-center image-general">
                                            <img src="<?= $box_general['image_general']; ?>">
                                        </div>
                                    <div class="content-boxes-general">
                                        <div class="content-boxes-general-inner"><?= $box_general['text_general']; ?></div>
                                        <div class="more_text_general"><?= $box_general['more_text_general']; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'single_corse'), 'after' => '</p></nav>']); ?>
