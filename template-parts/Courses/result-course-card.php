<?php
$courseDetails = wp_parse_args(
    $args["args"]
);
if(empty($courseDetails) || empty($courseDetails['course']))
    return;
$attrs = $courseDetails['attrs'];
$course = $courseDetails['course'];

global $sitepress;

/** single pages slugs */
$single_course_slug = 'onlinecourse/';

$ID = $course->display('id');
$title = getFieldByLanguage($course->display( 'name' ), $course->display( 'english_name' ), $course->display( 'arabic_name' ),$sitepress->get_current_language());
$institution_name = getFieldByLanguage($course->field( 'academic_institution.name' ), $course->field( 'academic_institution.english_name' ), $course->field( 'academic_institution.arabic_name' ), $sitepress->get_current_language());
$marketing_feature = $course->field('marketing_tags') ;
$thumb = $course->display( 'image' );
$duration = $course->display( 'duration' );
$course_permalink = $course->display('permalink');
$site_url = getHomeUrlWithoutQuery();
$url = $site_url . $single_course_slug . $course_permalink;
$attrs['class'] .= $attrs['hybrid_course'] ? ' hybrid_course' : '';
?>
<div class="courseResultCard" data-id="<?= $ID ?>" id="<?= $ID ?>">
    <div class="courseImage" style="background-image: url(<?= $thumb ?>);">
        <a href="<?= $url ?>"></a>
        <span class="info-button"></span>
        </div>
    <div class="itemContent">
    <h3 ><a href="<?= $url ?>"><?= $title ?></a></h3>
    <?php
    if($institution_name) {?>
        <p class="institutionName"><?= $institution_name ?> </p>
    <?php } ?>

        <?php
        if ( $marketing_feature ):?>
        <div class="tagsDiv">
        <?php
        if (count($marketing_feature) >= 3) {

            $i=0;
            foreach ($marketing_feature as $tagInfo){
                $tag = getFieldByLanguage($tagInfo['name'], $tagInfo['english_name'], $tagInfo['arabic_name'], $sitepress->get_current_language());
                $i++;
                if($i<=2){
                ?>
                <span class='courseTag'><p><?= $tag ?></p></span> <?php
            } else {
                    ?>
                    <span class='courseTag hiddenCourseTagMobile'><p><?= $tag ?></p></span> <?php
                }

            }?>
            <span class="courseTag extra-tags plusTag">+</span>

            <?php } else{
            $tags_array = [];
            foreach ($marketing_feature as $tagInfo) {
                $tag = getFieldByLanguage($tagInfo['name'], $tagInfo['english_name'], $tagInfo['arabic_name'], $sitepress->get_current_language());?>
                <span class='courseTag'><p><?= $tag ?></p></span>
            <?php }
        } ?>
        </div>
        <?php endif; ?>
    <p class="courseDuration"><?= $duration ?></p>
    </div>
    <?php get_template_part(
        'templates/mobileCourse',
        'popup',
        array(
            'args' => array(
                'image' => $thumb,
                'title' => $title,
                'institution' => $institution_name,
                'tags' => $marketing_feature,
                'duration' => $duration,
                'id' => $ID,
                'url' => $url
            )
        )
    ) ?>
</div>



