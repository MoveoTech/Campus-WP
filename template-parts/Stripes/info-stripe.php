<?php
$info = wp_parse_args(
    $args["info"]
);
if(empty($info) )
    return;
?>

<div class="home-page-info-stripe" >
    <div class="info-stripe-header">
        <span></span>
        <h1 ><?php echo $info['info_title'] ?></h1>
    </div>
    <div class="info-content">
        <?php
        foreach ($info['carousel'] as $info_item) :
//            var_dump($info_item['info_media']['url']);
        ?>
        <div class="info-item" >
            <img src="<?php echo $info_item['info_media']['url'] ?>">
            <h1><?php echo $info_item['title'] ?></h1>
            <p ><?php echo $info_item['subtitle'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
