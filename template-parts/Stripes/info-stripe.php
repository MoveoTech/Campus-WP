<?php
$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['title']) || $stripe['title'] == '' || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
    return;
?>

<div class="home-page-info-stripe" >
    <div class="info-stripe-header">
        <span></span>
        <h1 ><?php echo $stripe['title'] ?></h1>
    </div>
    <div class="info-content">
        <?php
        if($stripe['carousel'] && count($stripe['carousel']) > 0):
        foreach ($stripe['carousel'] as $info_item) :
//            var_dump($info_item['info_media']['url']);
        ?>
        <div class="info-item" >
            <img src="<?php echo $info_item['info_media']['url'] ?>">
            <h1><?php echo $info_item['title'] ?></h1>
            <?php if($info_item['subtitle'] && $info_item['subtitle'] !== '') :?>
                <p ><?php echo $info_item['subtitle'] ?></p>
            <?php endif; ?>
        </div>
        <?php endforeach;
            endif;
        ?>
    </div>
</div>
