<?php
$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['id']) || empty($stripe['courses']) || count($stripe['courses']) < 1)
    return;
//var_dump($stripe['courses']);
?>

<div class="home-page-myCourses-stripe" style="margin: 20px 0" >
    <div class="stripe-container">
        <div class="stripe-header">
            <?php if($stripe['title'] != '' && !empty($stripe['title'])) : ?>
                <span style="background: <?php echo randomColor();?>"></span>
                <h1><?php echo $stripe['title'] ?></h1>
            <?php endif; ?>
        </div>
        <div id="myCoursesStripeId" class="myCourses-slider">
    </div>
    </div>
</div>
