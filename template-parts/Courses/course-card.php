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
$marketing_feature = sortTagsByOrder($course->field('marketing_tags')) ;
$url_course_img_slick = $course->display( 'image' );
$duration = $course->display( 'duration' );
$course_permalink = $course->display('permalink');
$url = getHomeUrlWithoutQuery() . 'onlinecourse/' . $course_permalink;
$haveyoutube          = $course->display( 'trailer' );
$output = '';
$attrs['class'] .= $attrs['hybrid_course'] ? ' hybrid_course' : '';
?>

<div class="item_post_type_course course-item <?= $attrs['class'] ?>" data-id="<?= $ID ?>" <?= $attrs['filters']?>>
    <div class="course-item-inner">

        <?php
        if($haveyoutube) { ?>
            <a class="course-item-image has_background_image haveyoutube " data-id="<?= $ID ?>" data-popup aria-pressed="true" aria-haspopup="true" role="button" href="javascript:void(0)" aria-label="<?= wrap_text_with_char( $title ) ?>" data-classToAdd="course_info_popup" style="background-image: url(<?= $url_course_img_slick ?>)"></a>
        <?php }
        else { ?>
            <div class="course-item-image has_background_image donthaveyoutube " data-id="<?= $ID ?>"data-classToAdd="course_info_popup" style="background-image: url(<?= $url_course_img_slick ?>)"></div>
        <?php } ?>

        <a class="course-item-details" tabindex="0" href="<?= $url ?>">
            <h3 class="course-item-title"><?= wrap_text_with_char( $title ) ?></h3>
            <?php
            if ($institution_name) : ?>
                <p class="course-item-org"><?= $institution_name ?></p>
            <?php endif; ?>

            <?php if ( $duration ) :?>
                <div class="course-item-duration"><?= __( $duration, 'single_corse' ) ?></div>
            <?php endif;

            if ( $marketing_feature ):
               $tags_array = [];
                for($i = 0; $i < count($marketing_feature); $i++ ){
                  $tag = getFieldByLanguage($marketing_feature[$i]['name'], $marketing_feature[$i]['english_name'], $marketing_feature[$i]['arabic_name'], $sitepress->get_current_language());
                    array_push($tags_array, $tag);
               }
                $tags_string = implode(', ',$tags_array);
               ?>
               <div class="course-item-marketing"><?= $tags_string ?></div>
            <?php endif; ?>

            <div class="course-item-link">
                <span><?= cin_get_str( 'Course_Page' ) ?></span>
            </div>
        </a>
    </div>
</div>




