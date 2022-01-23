<?php
    $course = wp_parse_args(
        $args["args"]
    );

    $id = $course['id'];
    $thumb = $course['image'];
    $title = $course['title'];
    $institution_name = $course['institution'];
    $tags = $course['tags'];
    $duration = $course['duration'];

    global $sitepress;
?>

<div class="course-popup-modal mobile-course-popup<?php echo $id ?>">
    <div class="popup-header">
        <span class="course-popup-close<?php echo $id ?> close">&times;</span>
    </div>
    <div class="course-content">
        <div class="course-img" style="background-image: url(<?= $thumb ?>);">
        </div>
        <div class="course-details">
            <div class="course-header">
                <h3 ><a href="<?= $url ?>"><?= $title ?></a></h3>
                <p><?= $institution_name?></p>
            </div>
            <div class="tags-div">
                <?php
                if(count($tags) > 0 && $tags[0] != '' ) {
                    $index = 0;
                    while ( $index < count($tags) && $tags[$index] != '') :
                        $tag = getFieldByLanguage($tags[$index]['name'], $tags[$index]['english_name'], $tags[$index]['arabic_name'], $sitepress->get_current_language());

                        $tag_length = mb_strlen($tag, 'utf8');
                        $class = 'regular-tag';

                        if($tag_length >= 26) $class = 'ellipsis-text'; ?>
                        <span class="<?php echo $class ?>" title="<?php echo $tag ?>"><p class="<?php echo $class ?>"><?php echo $tag ?></p></span>
                        <?php
                        $index++;
                    endwhile; }?>
            </div>
            <div class="details">
                <span><?php echo $duration ?></span>
            </div>
        </div>
    </div>
    <div class="popup-footer">
        <a href="<?php echo $url ?>">
            <span>מעבר לקורס</span>
        </a>
    </div>
</div>