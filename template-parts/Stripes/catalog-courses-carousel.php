<?php
$stripe = wp_parse_args(
    $args["args"]
);

//if(empty($stripe) || empty($stripe['id']) || empty($stripe['courses']) || count($stripe['courses']) < 1 )
//    return;
global $sitepress;

//$courses_slice = array_slice($stripe['courses'], 0, 12);
//console_log(podsParams($stripe['courses']));
//console_log($stripe['courses']);
$courses = pods('courses', podsParams($stripe['courses']));
//console_log($courses_slice);

?>

<div class="coursesContainer">
    <div hidden id="<?php echo $stripe['id'] . "courses" ?>" value="<?php  print_r(json_encode($stripe['courses'])); ?>" ></div>
    <div id="<?php echo $stripe['id'] ?>" class="catalog-courses-stripe <?php echo ($stripe['type'] && $stripe['type'] == 'nerative' ) ? 'nerative-class' : '' ?>">
    <?php
    while ($courses->fetch()) {
        $title = getFieldByLanguage($courses->display('name'), $courses->display('english_name'), $courses->display('arabic_name'), $sitepress->get_current_language());
        $institution_name = getFieldByLanguage($courses->field('academic_institution.name'), $courses->field('academic_institution.english_name'), $courses->field('academic_institution.arabic_name'), $sitepress->get_current_language());
        $tags = sortTagsByOrder($courses->field('marketing_tags'));
        $thumb = $courses->display('image');
        $duration = $courses->display('duration');
        $id = $courses->display('ID');
        $course_permalink = $courses->display('permalink');
        $site_url = get_current_url();
        $url = $site_url . 'course/' . $course_permalink;
        ?>
        <div id="<?php echo $id . $stripe['id'] ?>" class="course-stripe-item " >

            <div class="course-img" style="background-image: url(<?= $thumb ?>);">
                  <a href="<?= $url ?>"></a>
                <span class="info-button"></span>
            </div>
            <div class="item-content">
                <h3 ><a href="<?= $url ?>"><?= $title ?></a></h3>
                <?php if ($institution_name) : ?>
                    <p><?= $institution_name?></p>
                <?php endif; ?>
            </div>
            <div class="tags-div">
                <?php
                if (count($tags) > 0 && $tags[0] != '') {
                    $index = 0;
                    while ($index < 2 && $index < count($tags) && $tags[$index] != '') :
                        $tag = getFieldByLanguage($tags[$index]['name'], $tags[$index]['english_name'], $tags[$index]['arabic_name'], $sitepress->get_current_language());
                        $tag_length = mb_strlen($tag, 'utf8');
                        $class = 'regular-tag';

                        if ($tag_length >= 8) {
                            $class = 'ellipsis-text';
                        } ?>
                        <?php if ($index == 1) { ?>
                            <span class="<?php echo $class ?> tag-2"><p class="<?php echo $class ?>"><?php echo $tag ?></p></span>
                        <?php } else { ?>
                            <span class="<?php echo $class ?>"><p class="<?php echo $class ?>"><?php echo $tag ?></p></span>
                        <?php } $index++;
                    endwhile;
                    if (count($tags) > 2) { ?>
                    <span class="extra-tags">+</span>
                    <?php }
                    if (count($tags) >= 2) { ?>
                    <span class="extra-tags-mobile">+</span>
                    <?php }
                }?>
            </div>
            <div class="course-item-hover <?php echo $id . $stripe['id'] ?>">
               <a href="<?= $url ?>">
                    <div class="course-img" style="background-image: url(<?= $thumb ?>);">
                    </div>
                    <div class="item-content">
                        <h3 ><?= $title ?></h3>
                        <?php if ($institution_name) : ?>
                            <p><?= $institution_name?></p>
                        <?php endif; ?>
                    </div>
                    <div class="tags-div">
                        <?php
                        if (count($tags) > 0 && $tags[0] != '') {
                            $index = 0;
                            while ($index < count($tags) && $tags[$index] != '') :
                                $tag = getFieldByLanguage($tags[$index]['name'], $tags[$index]['english_name'], $tags[$index]['arabic_name'], $sitepress->get_current_language());

                                $tag_length = mb_strlen($tag, 'utf8');
                                $class = 'regular-tag';

                                if ($tag_length >= 26) {
                                    $class = 'ellipsis-text';
                                } ?>
                                <span class="<?php echo $class ?>" title="<?php echo $tag ?>"><p class="<?php echo $class ?>"><?php echo $tag ?></p></span>
                                <?php
                                $index++;
                            endwhile;
                        }?>
                    </div>
                    <div class="course-details">
                        <span><?php echo $duration ?></span>
                    </div>
                </a>
            </div>
            <?php get_template_part(
                'templates/mobileCourse',
                'popup',
                array(
                    'args' => array(
                        'image' => $thumb,
                        'title' => $title,
                        'institution' => $institution_name,
                        'tags' => $tags,
                        'duration' => $duration,
                        'id' => $id . $stripe['id'],
                        'url' => $url
                    )
                )
            ) ?>

        </div>

    <?php };?>
<!--        end of while-->
    </div>
<!--    end of div catalog courses stripe-->
</div>
