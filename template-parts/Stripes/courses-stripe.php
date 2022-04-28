<?php

$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['id']) || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
    return;

$courses_url = home_url('/catalog') ;

?>

<div class="home-page-courses-stripe">
    <div class="stripe-container">
        <div class="stripe-header">
        <div class="header-title">
            <?php if($stripe['title'] != '' && !empty($stripe['title'])) : ?>
            <h1><?php echo $stripe['title'] ?></h1>
            <?php endif; ?>

            <?php if($stripe['subtitle'] && $stripe['subtitle'] !== '') : ?>
                <p><?php echo $stripe['subtitle'] ?></p>
            <?php endif; ?>
        </div>
        <div class="show-all-courses"><a href="<?php echo $courses_url ?>"><p> <?php echo more_courses_text($stripe['carousel']) ?></p></a></div>
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
</div>
