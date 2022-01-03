<?php
$courses = wp_parse_args(
    $args["courses_stripe"]
);

?>
    <div id="stripe-slider-slick">

<!--    --><?php //foreach ($courses_stripe as $courses) :?>

        <div hidden id="courses-ids" value="<?php  print_r(json_encode($courses)); ?>" ></div>
        <div id="courses-stripe" class="courses-stripe">
        <?php
        $size =  sizeof($courses) < 5 ? sizeof($courses) : 5;
//                $size =  sizeof($courses) < 10 ? sizeof($courses) : 10;
        for($i = 0; $i < $size; $i++) {
            $course_item = new Course_stripe($courses[$i]); // New Class
            $title = $course_item->get_title();
            $institution_name = $course_item->get_institution_name();
            $tags = $course_item->get_tags();
            $tags_arr = explode(', ', $tags);
            $thumb = $course_item->get_img_url();
//                    $url = $course_item->get_url();
            ?>
            <div class="course-stripe-item" >
                <div class="course-img" style="background-image: url(<?= $thumb ?>);">
                </div>
                <div class="item-content"">
                <h3 ><a href="<?= $url ?>"><?= $title ?></a></h3>
                <p ><?= $institution_name?></p>
            </div>
            <div class="tags-div">
                <?php
                $index = 0;
                while ($index < 2) : ?>
                    <span><?= $tags_arr[$index] ?></span>
                    <?php
                    $index++;
                endwhile;
                if(sizeof($tags_arr) > 2){ ?>
                    <span class="extra-tags">+</span>
                <?php } ?>

            </div>
            </div>

        <?php };?>
        </div>
<!--    --><?php //endforeach; ?>
    </div>
