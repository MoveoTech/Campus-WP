<?php
$stripe = wp_parse_args(
    $args["args"]
);

if(empty($stripe) || empty($stripe['id']) || empty($stripe['courses']) || count($stripe['courses']) < 1 )
    return;
global $sitepress;

$courses_slice = array_slice($stripe['courses'], 0, 10);
$courses = pods( 'courses', podsParams($courses_slice));

?>

<div class="stripe-slider-slick">
        <div hidden id="<?php echo $stripe['id'] . "courses" ?>" value="<?php  print_r(json_encode($stripe['courses'])); ?>" ></div>
        <div id="<?php echo $stripe['id'] ?>" class="courses-stripe <?php echo ($stripe['type'] && $stripe['type'] == 'nerative' ) ? 'nerative-class' : '' ?>">
        <?php
        while ($courses->fetch()) {
            $title = getFieldByLanguage($courses->display( 'name' ), $courses->display( 'english_name' ), $courses->display( 'arabic_name' ),$sitepress->get_current_language());
            $institution_name = getFieldByLanguage($courses->field( 'academic_institution.name' ), $courses->field( 'academic_institution.english_name' ), $courses->field( 'academic_institution.arabic_name' ), $sitepress->get_current_language());
            $tags = $courses->field('tags');
            $thumb = $courses->display( 'image' );

//            $url = $course_item->get_url();
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
                    if(count($tags) > 0 && $tags[0] != '' ) {
                        $index = 0;
                        while ($index < 2 && $index < count($tags) && $tags[$index] != '') :
                        $tag = getFieldByLanguage($tags[$index]['name'], $tags[$index]['english_name'], $tags[$index]['arabic_name'], $sitepress->get_current_language());
                        $tag_length = mb_strlen($tag, 'utf8');
                        $class = 'regular-tag';
                        if($tag_length >= 8) $class = 'ellipsis-text';
                        ?>
                            <span class="<?php echo $class ?>" title="<?php echo $tag ?>" ><p class="<?php echo $class ?>"><?php echo $tag ?></p></span>
                            <?php
                            $index++;
                        endwhile;
                        if(count($tags) > 2){ ?>
                            <span class="extra-tags">+</span>
                    <?php } }?>
                </div>
            </div>

        <?php };?>
        </div>
    </div>

