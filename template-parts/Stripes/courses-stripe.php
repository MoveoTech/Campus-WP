<?php

$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['id']) || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
    return;
global $sitepress;
$current_language = $sitepress->get_current_language();

$courses_url = home_url('/catalog/?stripe_id=') . $stripe['id'];

$count_show = __('Show all', 'Stripes');
$count_courses = __('Courses', 'Stripes');
$count_number = count($stripe['carousel']);

/** translate numbers to arabic */
if($current_language == 'ar'){
    $count_number = getArabicNumbers($count_number);
}

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
        <div class="show-all-courses"><a href="<?php echo $courses_url ?>"><p id="count_<?= $stripe['id']  ?>"> <?php echo $count_show ." ". $count_number ." ". $count_courses ?></p></a></div>
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
