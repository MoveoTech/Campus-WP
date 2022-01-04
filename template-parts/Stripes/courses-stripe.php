<?php

$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['id']) || empty($stripe['title']) || $stripe['title'] == '' || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
    return;
?>

<div class="home-page-courses-stripe">
    <div class="stripe-header">
        <h1><?php echo $stripe['title'] ?></h1>
        <?php if($stripe['subtitle'] && $stripe['subtitle'] !== '') : ?>
            <p><?php echo $stripe['subtitle'] ?></p>
        <?php endif; ?>
    </div>

    <?php

    get_template_part('template', 'parts/Stripes/courses-carousel',
        array(
            'args' => array(
                'courses' => $stripe['carousel'],
                'id' => $stripe['id'],
            )
        ));
    ?>

</div>