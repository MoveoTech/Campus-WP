<?php
$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['id']) || empty($stripe['courses']) || count($stripe['courses']) < 1)
    return;
//var_dump($stripe['courses']);
?>

<div class="home-page-myCourses-stripe" style="margin: 20px 0" >
    <div class="stripe-header">
        <?php if($stripe['title'] != '' && !empty($stripe['title'])) : ?>
            <span style="background: <?php echo randomColor();?>"></span>
            <h1><?php echo $stripe['title'] ?></h1>
        <?php endif; ?>
    </div>
    <div id="myCoursesStripeId" class="myCourses-slider">
        <?php

//        if($stripe['courses'] && count($stripe['courses']) > 0):
//            foreach ($stripe['courses'] as $my_item) :
//                $academic_institution = pods( 'academic_institution', podsParams($my_item['academic_institution']));
//                $institution_name = '';
//                while ($academic_institution->fetch()):
//                    $institution_name = $academic_institution->display('name');
//                endwhile;
//                $title = $my_item['name'];
//                $thumb = $my_item['image']['url'];
//        ?>
<!--                <div class="course-stripe-item" style="display: flex;flex-direction: column">-->
<!--                    <div class="course-img" style="background-image: url(<?//= $thumb ?>);">-->
<!--                    </div>-->
<!--                    <div class="item-content">-->
<!--                        <p class="course-progress"><a href="--><?//= $url ?><!--">בואו נתחיל את הקורס >></a></p>-->
<!--                        <h3 ><a href="--><?//= $url ?><!--">--><?//= $title ?><!--</a></h3>-->
<!--                        <p class="institution-name">--><?//= $institution_name?><!--</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //endforeach;
//        endif;
//        ?>
    </div>
</div>
