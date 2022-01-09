<?php


$stripe = wp_parse_args(
    $args["args"]
);

if(empty($stripe) || empty($stripe['id']) || empty($stripe['title']) || $stripe['title'] == '' || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
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

<div class="home-page-nerative-stripe" >
    <div class="stripe-header">

        <div class="stripe-title">
            <span style="background: <?php echo $rand_color?>"></span>
            <?php if($stripe['image']):?>
                <img src="<?php echo $stripe['image'] ?>">
            <?php endif; ?>
            <h1 ><?php echo $stripe['title'] ?></h1>
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