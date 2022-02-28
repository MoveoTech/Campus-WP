

<?php


/**
 * Template Name: new Academic Institutions
 */


include locate_template( 'templates/header.php' );


$slug = pods_v( 'last', 'url' );

$slug = sanitize_text_field(rawurldecode($slug));

$academicInstitution = pods( 'academic_institution', $slug, true);

// Check if the pod is valid and exists.
if ( false == $academicInstitution || ! $academicInstitution->exists()) {
    // The pod item doesn't exists.
    global $wp_query;
    $wp_query->set_404();
    status_header( 404 );
    get_template_part( 404 );
    include locate_template( 'templates/footer.php' );
    exit();
}

global $sitepress;

$academicInstitution->display('institution_site_link');

$banner_image_institute = $academicInstitution->display('banner_image_institute');
$banner_mobile_institute = $academicInstitution->display('banner_mobile_institute');
$institution_site_link = $academicInstitution->display('institution_site_link');
$academicInstitutionTitle = getFieldByLanguage($academicInstitution->display('name'), $academicInstitution->display('english_name'), $academicInstitution->display('arabic_name'), $sitepress->get_current_language());
$academicInstitutionTitle = $academicInstitutionTitle ? wrap_text_with_char($academicInstitutionTitle) : $academicInstitutionTitle;
$thumb = $academicInstitution->display( 'image' );
$content = getFieldByLanguage($academicInstitution->display('hebrew_description'), $academicInstitution->display('english_description'), $academicInstitution->display('arabic_description'), $sitepress->get_current_language());
//$instituteId = $academicInstitution->display( 'id' );

$params = [
    'limit'   => -1,
    'where'   => 'academic_institution.id = '.$academicInstitution->display( 'id' ),
];

$courses = pods( 'courses', $params, true);
$found_courses = $courses->total_found();

$lecturers = pods( 'lecturer', $params, true);
$found_lecturer = $lecturers->total_found();

?>


<!--Banner area-->
<?php if ($banner_image_institute) : ?>
    <?php
    $class = 'institution-page';
    $text_on_banner_content = '';
    $text_on_banner_content = '<h1 class="title-opacity-on-banner">'. $academicInstitutionTitle .'</h1>';
    if($thumb){
        $text_on_banner_content .= '<img src="'.$thumb.'" class="img-academic"/>';
    }
    ?>
    <?=  get_banner_area(array('url' => $banner_mobile_institute) , array('url' => $banner_image_institute) , $text_on_banner_content,$class); ?>
<?php endif;?>
<!--End Banner area-->
<div class="content-institution-page">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xs-12 col-sm-12 col-lg-8 col-xl-9">
                <?php if($content) : ?>
                    <p class="title-content-insitut"><?= __('About University:','single_corse'); ?></p>
                    <div class="text-description-of-course content-inner-insti-page">
                        <span class="read-more-text"><?php echo wpautop($content); ?></span>
                    </div>
                    <button class="course_test_type_readmore course_test_readmore_collapse collapsed" aria-hidden="true">
                        <span><?= __('Read More','single_corse'); ?></span>
                        <span><?= __('Read Less','single_corse'); ?></span>
                    </button>
                <?php endif; ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-4 col-xl-3">
                <div class="info-institu">
                    <div class="found-course">
                        <p class="found-course-text"><?= __('Courses','single_corse'); ?></p>
                        <p class="found-course-number"><?= $found_courses; ?></p>
                    </div>
                    <div class="found-lecturer">
                        <p class="found-lecturer-text"><?= __('Lecturer','single_corse'); ?></p>
                        <p class="found-lecturer-number"><?= $found_lecturer; ?></p>
                    </div>
                    <?php if($institution_site_link): ?>
                        <div class="external-site-institut">
                            <a target="_blank" class="external-site-institut-link" href="<?= $institution_site_link; ?>"><?= __('To The Site Of: ','single_corse').' '. get_the_title(); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>





<!--courses-area-->
<div class="more-courses-section">
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="more-courses-interest"><?= __('The Courses Of:','single_corse').' '. wrap_text_with_char(get_the_title()); ?></h3>
        </div>
        <div class="row more-courses-inner">
            <?php
            if( $found_courses > 0):

                while ($courses->fetch()) {

//                    global $post;
                    $output = '';
//                    $org    = $attrs['org'] ? $attrs['org'] : get_field( 'org' );

//var_dump($org);
//                    $marketing_feature = $attrs['marketing'] ? $attrs['marketing'] : get_field( 'marketing_feature' );
//                    $marketing_feature = $marketing_feature ? $marketing_feature->name : ( $attrs['hybrid_course'] ? cin_get_str( 'hybrid_badge' ) : '' );

                    $duration = $courses->display( 'duration' );
                    $haveyoutube = $courses->display( 'trailer' );
                    $url_course_img_slick = $courses->display( 'image' );
                    $course_ID = $courses->display('id');
                    $course_title = getFieldByLanguage($courses->display('name'), $courses->display('english_name'), $courses->display('arabic_name'), $sitepress->get_current_language());

                    $org = $courses->field( array('name'=>'academic_institution', 'output'=>'pods' ));
                    $orgName = getFieldByLanguage($org->display( 'name' ), $org->display( 'english_name' ), $org->display( 'arabic_name' ),$sitepress->get_current_language());


                    ?>

<!--                    <a class="course-item-image has_background_image --><?//= $haveyoutube; ?><!-- " data-id="--><?php //$course_ID; ?><!--">-->
<!---->
<!--                    </a>-->
                    <?php
//                    $url_course_img_slick = ( get_the_post_thumbnail_url( get_the_ID() ) ) ? get_the_post_thumbnail_url( get_the_ID(), 'medium' ) : site_url() . '/wp-content/uploads/2018/10/asset-v1JusticeJustice0012017_1type@assetblock@EDX3.png';


                    if ( $haveyoutube ) {
                        $haveyoutube = "haveyoutube";
                        $data_popup  = "data-popup";
                        $image_html  = '<a class="course-item-image has_background_image ' . $haveyoutube . '" data-id="' . $course_ID . '"' . $data_popup . ' aria-pressed="true" aria-haspopup="true" role="button" href="javascript:void(0)" aria-label="' . wrap_text_with_char( $course_title ) . '" data-classToAdd="course_info_popup" style="background-image: url(' . $url_course_img_slick . ');"></a>';
//                        var_dump($image_html);
                    } else {
                        $haveyoutube = "donthaveyoutube";
                        $data_popup  = "";
                        $image_html  = '<div class="course-item-image has_background_image ' . $haveyoutube . '" data-id="' . $course_ID . '"' . $data_popup . '   data-classToAdd="course_info_popup" style="background-image: url(' . $url_course_img_slick . ');"></div>';
                        var_dump($image_html);
                    }
                    $attrs['class'] .= $attrs['hybrid_course'] ? ' hybrid_course' : '';
                    $output         .= '<div class="item_post_type_course course-item ' . $attrs['class'] . '" data-id="' . $course_ID . '" ' . $attrs['filters'] . '><div class="course-item-inner">';
                    $output         .= $image_html;
                    $output         .= '<a class="course-item-details" tabindex="0" href="' . get_permalink( $post->ID ) . '">
                <h3 class="course-item-title">' . wrap_text_with_char( $post->post_title ) . '</h3>';
                    if ( $orgName ) {
                        $output .= '<p class="course-item-org">' . $orgName . '</p>';
                    }
                    if ( $duration ) {
                        $output .= '<div class="course-item-duration">' . __( $duration, 'single_corse' ) . '</div>';
                    }
                    if ( $marketing_feature ) {
                        $output .= '<div class="course-item-marketing">';
                        $output .= '' . $marketing_feature . '</div>';
                    }
                    $output .= '<div class="course-item-link">
                    <span>' . cin_get_str( 'Course_Page' ) . '</span>
                </div>
            </a></div></div>';

                    echo draw_course_item(array(
                        'class' => 'col-sm-12 col-md-6 col-lg-4 col-xl-3 course-item-with-border'
                    ));




                }
            endif;

            ?>
        </div>
    </div>
</div>

<!--lecturer area-->
<?php if( $found_lecturer > 0): ?>
    <div class="lecturer-about-course institution">
        <div class="container">
            <div class="row justify-content-center">
                <h2 class="course-staff-title"><?=  __('The course staff Of') .' '. wrap_text_with_char($academicInstitutionTitle); ?></h2>
            </div>
            <div class="row ">
                <?php
                while ($lecturers->fetch()) {

                    $name = getFieldByLanguage($lecturers->display( 'name' ), $lecturers->display( 'english_name' ), $lecturers->display( 'arabic_name' ),$sitepress->get_current_language());
                    $role = getFieldByLanguage($lecturers->display( 'hebrew_role' ), $lecturers->display( 'english_role' ), $lecturers->display( 'arabic_role' ),$sitepress->get_current_language());
                    $email = $lecturers->display( 'email' );
                    $thumb = $lecturers->display( 'image' );
                    $content = getFieldByLanguage($lecturers->display('hebrew_description'), $lecturers->display('english_description'), $lecturers->display('arabic_description'), $sitepress->get_current_language());
                    ?>

                    <div class="single-lecturer">
                        <?php
                        $img_exsist = $thumb ? $thumb : get_bloginfo('stylesheet_directory') .'/assets/images/campus_avatar.png' ;
                        ?>
                        <div class="img-lecturer circle-image-lecturer" style="background-image: url(<?= $img_exsist; ?>)" aria-label='<?= $name; ?>'></div>
                        <div class="content-lecturer">
                            <div class="lecturer-title"><?= $name; ?></div>
                            <p class="lecturer-role"><?= $role; ?></p>
                            <div div="campus-popup" class="single-lecturer-popup" role="dialog" aria-model="true">
                                <button type="button" role="button" class="close close-lecturer last-popup-element first-popup-element close-popup-button" aria-label="Close" tabindex="0">X</button>
                                <div class="img-lecturer-popup circle-image-lecturer" style="background-image: url(<?= $img_exsist; ?>)"></div>
                                <h2 class="lecturer-title-popup"><?= $name; ?></h2>
                                <div class="lecturer-role-popup-wrap">
                                    <?php if($role){ ?>
                                        <span class="lecturer-role-popup"><?= $role; ?></span>
                                    <?php } ?>
                                    <?php if ($academicInstitutionTitle): ?>
                                        <span class="lecturer-role-popup"> | <?= $academicInstitutionTitle; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="lecturer-content"><?php echo wpautop($content); ?></div>
                            </div>
                            <p role="button" tabindex="0" aria-label='<?= cin_get_str('Learners_Testimonials', 'he'); ?> <?= $name; ?> <?= $role; ?>' class="lecturer-little-about"><?= cin_get_str('about_me','he'); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endif;






include locate_template( 'templates/footer.php' );
?>
