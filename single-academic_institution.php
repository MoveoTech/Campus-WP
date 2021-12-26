<?php
/**
 * Created by PhpStorm.
 * User: estero
 * Date: 19/11/2018
 * Time: 13:54
 */

$innstitute_id = $post->ID;
$innstitute_id_arab = icl_object_id($innstitute_id,'post',false,'ar');
$innstitute_id_en = icl_object_id($innstitute_id,'post',false,'en');
$innstitute_id_he = icl_object_id($innstitute_id,'post',false,'he');

global $fields;
$banner_image_institute = $fields['banner_image_institute'];
$banner_mobile_institute = $fields['banner_mobile_institute'];
$institution_site_link = $fields['institution_site_link'];
$title = $fields['title_on_banner_institute'];
$title = $title ? wrap_text_with_char($title) : get_the_title();

$meta_query = array(
    'relation' => 'OR',
);
if($innstitute_id_arab){
    array_push($meta_query,array(
        'key' => 'org',
        'value' => $innstitute_id_arab,
        'compare'   => 'LIKE',
    ));
    array_push($meta_query,array(
        'key' => 'corporation_institution',
        'value' => $innstitute_id_arab,
        'compare'   => 'LIKE',
    ));
}
if($innstitute_id_he){
    array_push($meta_query,array(
        'key' => 'org',
        'value' => $innstitute_id_he,
        'compare'   => 'LIKE',
    ));
    array_push($meta_query,array(
        'key' => 'corporation_institution',
        'value' => $innstitute_id_he,
        'compare'   => 'LIKE',
    ));
}
if($innstitute_id_en){
    array_push($meta_query,array(
        'key' => 'org',
        'value' => $innstitute_id_en,
        'compare'   => 'LIKE',
    ));
    array_push($meta_query,array(
        'key' => 'corporation_institution',
        'value' => $innstitute_id_en,
        'compare'   => 'LIKE',
    ));
}

//get courses
$args_course   =   array(
    'posts_per_page'   => -1,
    'post_type'     => 'course',
    'meta_query'    => $meta_query,
    'orderby' => 'menu_order',
    'order' => 'DESC'
);
$query_course = new WP_Query($args_course);
$found_courses = $query_course->found_posts;
//get lecturer post


$meta_query = array(
    'relation' => 'OR',
    array(
        'key' => 'academic_institution',
        'value' => $post->ID,
        'compare'   => 'LIKE',
    )

);
//if($innstitute_id_arab){
//    array_push($meta_query,array(
//        'key' => 'academic_institution',
//        'value' => $innstitute_id_arab,
//        'compare'   => 'LIKE',
//    ));
//}
//if($innstitute_id_he){
//    array_push($meta_query,array(
//        'key' => 'academic_institution',
//        'value' => $innstitute_id_he,
//        'compare'   => 'LIKE',
//    ));
//}
//if($innstitute_id_en){
//    array_push($meta_query,array(
//        'key' => 'academic_institution',
//        'value' => $innstitute_id_en,
//        'compare'   => 'LIKE',
//    ));
//}
$args_lecturer   =   array(
    'posts_per_page'   => -1,
    'post_type'     => 'lecturer',
    'meta_query'    => $meta_query,
    'suppress_filters' => true
);
$query_lecturer = new WP_Query($args_lecturer);
$found_lecturer = $query_lecturer->found_posts;

?>



<!--Banner area-->
<?php if ($banner_image_institute) : ?>
    <?php
    $class = 'institution-page';
    $text_on_banner_content = '';
    $text_on_banner_content .= '<h1 class="title-opacity-on-banner">'. $title .'</h1>';
    if(get_the_post_thumbnail_url()){
        $text_on_banner_content .= '<img src="'.get_the_post_thumbnail_url().'" class="img-academic" alt="'.esc_html ( get_the_post_thumbnail_caption() ) .'"/>';
    }
    ?>
    <?=  get_banner_area( $banner_mobile_institute, $banner_image_institute , $text_on_banner_content,$class); ?>
<?php endif;?>
<!--End Banner area-->

<div class="content-institution-page">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xs-12 col-sm-12 col-lg-8 col-xl-9">
        <?php if($content = get_the_content()): ?>
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
            if( $query_course->have_posts()):

                while( $query_course->have_posts()): $query_course->the_post();
                    {
                        echo draw_course_item(array(
                            'class' => 'col-sm-12 col-md-6 col-lg-4 col-xl-3 course-item-with-border'
                        ));
                    }
            endwhile;
            endif;
            wp_reset_query();
            ?>
        </div>
    </div>
</div>

<!--lecturer area-->
<?php if( $query_lecturer->have_posts()): ?>
<div class="lecturer-about-course institution">
    <div class="container">
        <div class="row justify-content-center">
             <h2 class="course-staff-title"><?=  __('The course staff Of','single_corse') .' '. wrap_text_with_char(get_the_title($innstitute_id)); ?></h2>
        </div>
        <div class="row ">
<?php
while( $query_lecturer->have_posts()): $query_lecturer->the_post();{

    $lecturer_single_id = $query_lecturer->ID;
    $rol_single_course = get_field('role', $lecturer_single_id);
    $email_lecturer = get_field('email', $lecturer_single_id);
    $site_link = get_field('site_link', $lecturer_single_id);
    $org_lecturer = get_field('academic_institution', $lecturer_single_id);

    ?>

    <div class="single-lecturer">
        <?php
         $img_exsist = get_the_post_thumbnail_url($lecturer_single_id) ? get_the_post_thumbnail_url($lecturer_single_id, 'medium') : get_bloginfo('stylesheet_directory') .'/assets/images/campus_avatar.png' ;
        ?>
        <div class="img-lecturer circle-image-lecturer" style="background-image: url(<?= $img_exsist; ?>)" aria-label='<?= get_the_title(); ?>'></div>
        <div class="content-lecturer">
            <div class="lecturer-title"><?= get_the_title(); ?></div>
            <p class="lecturer-role"><?= $rol_single_course; ?></p>
            <div div="campus-popup" class="single-lecturer-popup" role="dialog" aria-model="true">
                <button type="button" role="button" class="close close-lecturer last-popup-element first-popup-element close-popup-button" aria-label="Close" tabindex="0">X</button>
                <div class="img-lecturer-popup circle-image-lecturer" style="background-image: url(<?= $img_exsist; ?>)"></div>
                <h2 class="lecturer-title-popup"><?= get_the_title(); ?></h2>
                <div class="lecturer-role-popup-wrap">
                    <?php if($rol_single_course){ ?>
                         <span class="lecturer-role-popup"><?= $rol_single_course; ?></span>
                    <?php } ?>
                    <?php if ($org_lecturer): ?>
                         <span class="lecturer-role-popup"> | <?= $org_lecturer->post_title; ?></span>
                    <?php endif; ?>
                </div>
                <div class="lecturer-content"><?php echo wpautop(get_the_content()); ?></div>
            </div>
            <p role="button" tabindex="0" aria-label='<?= cin_get_str('about_me'); ?> <?= get_the_title(); ?> <?= $rol_single_course; ?>' class="lecturer-little-about"><?= cin_get_str('about_me'); ?></p>
        </div>
    </div>
<?php }
endwhile; ?>
        </div>
    </div>
</div>
<!--    <div class="background-popup"></div>-->
<?php endif;
wp_reset_query();
?>


<?php add_action('wp_footer', function(){
    get_template_part('templates/event_popup');
});











