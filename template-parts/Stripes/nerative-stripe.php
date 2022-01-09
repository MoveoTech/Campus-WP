<?php


$stripe = wp_parse_args(
    $args["args"]
);

if(empty($stripe) || empty($stripe['id']) || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
    return;
?>

<div class="home-page-nerative-stripe" >
    <div class="stripe-header">

        <div class="stripe-title">
            <span style="background: <?php echo randomColor();?>"></span>
            <?php if($stripe['image']):?>
                <img src="<?php echo $stripe['image'] ?>">
            <?php endif; ?>
            <?php if($stripe['title'] != '' && !empty($stripe['title'])) : ?>
                <h1 ><?php echo $stripe['title'] ?></h1>
            <?php endif; ?>
        </div>

       <?php if($stripe['subtitle'] && $stripe['subtitle'] !== '') : ?>
            <p><?php echo $stripe['subtitle'] ?></p>
        <?php endif; ?>
    </div>

    <?php

    get_template_part('template', 'parts/Stripes/courses-carousel',
        array(
            'args' => array(
                'courses' => $stripe['carousel'],
                'type' => 'nerative',
                'id' => $stripe['id']
            )
        ));
    ?>

</div>