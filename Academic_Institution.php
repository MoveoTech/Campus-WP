

<?php


/**
 * Template Name: new Academic Institutions
 */
?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
<!--[if lt IE 9]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
</div>
<![endif]-->
<?php
do_action('get_header');
get_template_part('templates/header');

// fetching info from pods
$slug = pods_v( 'last', 'url' );
$slug = sanitize_text_field(rawurldecode($slug));
$academicInstitution = pods( 'academic_institution', $slug, true);

/** single pages slugs */
$single_course_slug = 'onlinecourse/';

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
$banner_image_institute = $academicInstitution->display('banner_image_institute');
$banner_mobile_institute = $academicInstitution->display('banner_mobile_institute');
$institution_site_link = $academicInstitution->display('institution_site_link');
$academicInstitutionTitle = getFieldByLanguage($academicInstitution->display('name'), $academicInstitution->display('english_name'), $academicInstitution->display('arabic_name'), $sitepress->get_current_language());
$academicInstitutionTitle = $academicInstitutionTitle ? wrap_text_with_char($academicInstitutionTitle) : $academicInstitutionTitle;
$thumb = $academicInstitution->display( 'image' );
$content = getFieldByLanguage($academicInstitution->display('hebrew_description'), $academicInstitution->display('english_description'), $academicInstitution->display('arabic_description'), $sitepress->get_current_language());


$params = [
    'limit'   => -1,
    'where'   => 'academic_institution.id = '.$academicInstitution->display( 'id' ),
];

$academic_params = [
    'limit'   => -1,
    'where'   => '((academic_institution.id = '.$academicInstitution->display( 'id' ) . ') OR (corporation_institution.id = '.$academicInstitution->display( 'id' ). ')) AND hide_in_site = 0',];

$courses = pods( 'courses', $academic_params, true);
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
<div class="content-institution-page" id="institutionTemplate">
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
                            <a target="_blank" class="external-site-institut-link" href="<?= $institution_site_link; ?>"><?= __('To The Site Of: ','single_corse').' '. $academicInstitutionTitle; ?></a>
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
            <h3 class="more-courses-interest"><?= __('The Courses Of:','single_corse').' '. $academicInstitutionTitle; ?></h3>
        </div>
        <div class="row more-courses-inner">
            <?php
            if( $found_courses > 0):
                while ($courses->fetch()) {

                // courses info
                    $marketing_tags = $courses->display( 'marketing_tags' );
                    $course_ID = $courses->display('id');
                    $course_title = getFieldByLanguage($courses->display('name'), $courses->display('english_name'), $courses->display('arabic_name'), $sitepress->get_current_language());
                    $course_permalink = $courses->display('permalink');
                    $attrs = 'col-sm-12 col-md-6 col-lg-4 col-xl-3 course-item-with-border';
                    $duration = $courses->display( 'duration' );
                    $haveyoutube = $courses->display( 'trailer' );
                    $courseImageUrl = $courses->display( 'image' );
                    $org = $courses->field( array('name'=>'academic_institution', 'output'=>'pods' ));
                    $orgName = getFieldByLanguage($org->display( 'name' ), $org->display( 'english_name' ), $org->display( 'arabic_name' ),$sitepress->get_current_language());
                    ?>
<!--                    // displaying each course-->
                        <div class="item_post_type_course course-item <?= $attrs; ?>" data-id="<?= $course_ID; ?>" >
                            <div class="course-item-inner">
                                <?php
                                if($haveyoutube) {
                                    $haveyoutube = "haveyoutube";
                                    $data_popup = "data-popup";
                                    ?>
                                    <a class="course-item-image has_background_image <?= $haveyoutube; ?> " data-id="<?= $course_ID; ?>" <?= $data_popup; ?> aria-pressed="true" aria-haspopup="true" role="button" href="javascript:void(0)" aria-label="<?= wrap_text_with_char( $course_title ); ?>" data-classToAdd="course_info_popup" style="background-image: url(<?= $courseImageUrl; ?>)" ></a>
                              <?php  } else {
                                    $haveyoutube = "donthaveyoutube";
                                    $data_popup = "";
                                    ?>
                                    <div class="course-item-image has_background_image <?= $haveyoutube; ?>" data-id="<?= $course_ID; ?>" <?= $data_popup; ?>   data-classToAdd="course_info_popup" style="background-image: url(<?= $courseImageUrl; ?>)" ></div>
                              <?php } ?>
                                <a class="course-item-details" tabindex="0" href="<?= getHomeUrlWithoutQuery() . $single_course_slug . $course_permalink ?>">
                                    <h3 class="course-item-title"> <?= wrap_text_with_char( $course_title ) ?></h3>
                                   <?php
                                   if($orgName):  ?>
                                       <p class="course-item-org"> <?= $orgName; ?></p>
                                    <?php endIf;
                                    if($duration):  ?>
                                        <div class="course-item-duration"> <?= __( $duration, 'single_corse' ); ?></div>
                                    <?php endIf;
                                    if($marketing_tags):  ?>
                                        <div class="course-item-marketing"> <?= $marketing_tags; ?></div>
                                    <?php endIf; ?>
                                    <div class="course-item-link">
                                        <span> <?= cin_get_str( 'Course_Page' ) ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>


<?php } endif; ?>
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
do_action('get_footer');
get_template_part('templates/footer');
wp_footer();
?>
</body>
</html>?>

