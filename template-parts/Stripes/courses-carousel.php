<?php
$stripe = wp_parse_args(
    $args["args"]
);

if(empty($stripe) || empty($stripe['id']) || empty($stripe['courses']) || count($stripe['courses']) < 1 )
    return;
?>

<div class="stripe-slider-slick">
        <div hidden id="<?php echo $stripe['id'] . "courses" ?>" value="<?php  print_r(json_encode($stripe['courses'])); ?>" ></div>
        <div id="<?php echo $stripe['id'] ?>" class="courses-stripe <?php echo ($stripe['type'] && $stripe['type'] == 'nerative' ) ? 'nerative-class' : '' ?>">
        <?php
        $size =  count($stripe['courses']) < 10 ? count($stripe['courses']) : 10;
        for($i = 0; $i < $size; $i++) {
            $course_item = new Course_stripe($stripe['courses'][$i]); // New Class
            $title = $course_item->get_title();
            $institution_name = $course_item->get_institution_name();
            $tags = $course_item->get_tags();
            $tags_arr = explode(', ', $tags);
            $thumb = $course_item->get_img_url();
//                    $url = $course_item->get_url();
            ?>
            <div class="course-stripe-item " >
                <div class="course-img" style="background-image: url(<?= $thumb ?>);">
                </div>
                <div class="item-content">
                    <h3 ><a href="<?= $url ?>"><?= $title ?></a></h3>
                    <p><?= $institution_name?></p>
                </div>
                <div class="tags-div">
                    <?php
                    if(count($tags_arr) > 0 && $tags_arr[0] !== '') {
                        $index = 0;
                        while ($index < 2 && $index < count($tags_arr)) : ?>
                            <span><?= $tags_arr[$index] ?></span>
                            <?php
                            $index++;
                        endwhile;
                        if(count($tags_arr) > 2){ ?>
                            <span class="extra-tags">+</span>
                    <?php } }?>
                </div>
            </div>

        <?php };?>
        </div>
    </div>

