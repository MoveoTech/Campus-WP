<?php
$courseDetails = wp_parse_args(
    $args["args"]
);
if(empty($courseDetails) || empty($courseDetails['course']))
    return;
$attrs = $courseDetails['attrs'];
$course = $courseDetails['course'];

global $sitepress;
$ID = $course->display('id');
$title = getFieldByLanguage($course->display( 'name' ), $course->display( 'english_name' ), $course->display( 'arabic_name' ),$sitepress->get_current_language());
$institution_name = getFieldByLanguage($course->field( 'academic_institution.name' ), $course->field( 'academic_institution.english_name' ), $course->field( 'academic_institution.arabic_name' ), $sitepress->get_current_language());
$marketing_feature = $course->field('marketing_tags') ;
$url_course_img_slick = $course->display( 'image' );
$duration = $course->display( 'duration' );
$course_permalink = $course->display('permalink');
$site_url = getHomeUrlWithoutQuery();
$url = $site_url . 'course/' . $course_permalink;
$attrs['class'] .= $attrs['hybrid_course'] ? ' hybrid_course' : '';
?>
<div class="courseResultCard" data-id="<?= $ID ?>">
    <div class="courseImage" style="background-image: url(<?= $url_course_img_slick ?>);">
        <a href="<?= $url ?>"></a>
        </div>
    <div class="itemContent">
    <h3 ><a href="<?= $url ?>"><?= $title ?></a></h3>
    <?php
    if($institution_name) {?>
        <p class="institutionName"><?= $institution_name ?> </p>
    <?php } ?>
    <div class="tagsDiv">
        <?php
        if ( $marketing_feature ):
            $tags_array = [];
            foreach ($marketing_feature as $tagInfo) {
                $tag = getFieldByLanguage($tagInfo['name'], $tagInfo['english_name'], $tagInfo['arabic_name'], $sitepress->get_current_language());?>
                <span class='courseTag'><p><?= $tag ?></p></span>
        <?php } ?>
        <?php endif; ?>
    </div>
    <p class="courseDuration"><?= $duration ?></p>
    </div>
</div>


