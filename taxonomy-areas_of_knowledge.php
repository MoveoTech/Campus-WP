<?php
/**
 * Created by PhpStorm.
 * User: estero
 * Date: 07/11/2018
 * Time: 12:16
 */

global $wp_query, $fields;
$current_tax = $wp_query->queried_object;
$fields = get_fields($current_tax);
//banner
$banner = $fields['banner'];
$text_on_banner = $fields['text_on_banner'];
$banner_mobile = $fields['banner_mobile'];

//academic institutions
$academic_institutions = $fields['academic_institution'];

//Faq
$faq_title =  $fields['faq_title'];
$faq =  $fields['faq'];
$more_faq_link = $fields['more_faq_link'];

//How it works
$video_boxes =$fields['video_boxes'];
$how_it_works_title = $fields['how_it_works_title'];

//More Info
$image_lobby_info = $fields['image_lobby_info'];
$title_lobby_info = $fields['title_lobby_info'];
$short_text_lobby_info = $fields['short_text_lobby_info'];
$text_on_link_lobby_info = $fields['text_on_link_lobby_info'];
$link_url_lobby_info = $fields['link_url_lobby_info'];

//Testimonials_lobby
$testimonials_title_lobby = $fields['testimonials_title_lobby'];
$choose_testimonials_lobby = $fields['choose_testimonials_lobby'];

//course filter
$title_course_section = ($fields['title_course_section']) ? $fields['title_course_section'] : '';
$courses_filter_term_home = ($fields['courses_filter_term_home']) ? $fields['courses_filter_term_home'] : '';
?>


<?php if ($banner) :
    $class = 'lobby-knowlwdge';
?>
        <?php  $title = str_replace('%' , '<span class="span-brake"></span>' ,$text_on_banner );
        $text_on_banner_content = '<h1>' . $title .'</h1>';
        ?>

<?=  get_banner_area( $banner_mobile, $banner , $text_on_banner_content ,$class); ?>
<?php endif; ?>
<!--academic institution slider-->
<?php if ($academic_institutions) : ?>
    <?= get_academic_institution_slider($academic_institutions); ?>
<?php endif; ?>
<!--end academic institution slider-->

<!--Courses Filter-->
<?php
//print_r($wp_query);
$date_now = date('Y-m-d');
$args_knowlegde = array(
    'post_type'         => 'course',
    'posts_per_page' => -1,
    'meta_query' 		=> array(
        'relation' 			=> 'OR',
        array(
            'key'			=> 'enrollment_end',
            'compare'		=> '>=',
            'value'			=> $date_now,
            'type'			=> 'DATE'
        ),
        array(
            'key'			=> 'enrollment_end',
            'value'         => '',
            'compare'       => '='
        ),
    ),
    'orderby' => 'menu_order',
    'order' => 'DESC'
);
$langs = array('he', 'en', 'ar');
$posts = array();
global $sitepress;
$current_lang = ICL_LANGUAGE_CODE;
foreach($langs as $lang){
    $id = apply_filters( 'wpml_object_id', $current_tax->term_id, 'areas_of_knowledge', false, $lang );
    $tax_query = array(
        'relation' 			=> 'OR',
        array(
            'taxonomy'  => 'areas_of_knowledge',
            'field'     => 'term_id',
            'terms'     => $id
        )
    );
    $args_knowlegde['tax_query'] = $tax_query;
    $sitepress->switch_lang($lang);
    $items = get_posts($args_knowlegde);
    $posts = array_merge($posts, $items);
}
$sitepress->switch_lang($current_lang);
echo get_filtered_courses($courses_filter_term_home, $title_course_section, null, $posts);


?>
<!--End Courses Filter-->

<!--more info-->
<div class="more-info-lobby">
    <div class="container">
        <div class="more-info-lobby-inner">
            <?php if($image_lobby_info): ?>
            <div class="image_lobby_info">
                <div class="image_lobby_info-inner" style="background-image: url(<?= $image_lobby_info['url'] ?>)"></div>
            </div>
            <?php endif ?>
            <?php if($title_lobby_info): ?>
            <div class="title_lobby_info">
                <h6 class="title_lobby_info-inner" role="heading" aria-level="3"><?= $title_lobby_info ?></h6>
            </div>
            <?php endif ?>
            <?php if($short_text_lobby_info): ?>
            <div class="short_text_lobby_info">
                <p class="short_text_lobby_info-inner"><?= $short_text_lobby_info; ?></p>
            </div>
            <?php endif ?>
            <?php if($link_url_lobby_info): ?>
            <div class="link_url_lobby_info">
                <a class="link_url_lobby_info-inner" href="<?= $link_url_lobby_info ?>"><?= $text_on_link_lobby_info; ?></a>
            </div>
            <?php endif ?>
        </div>
    </div>
</div>
<!--End more info-->

<!--Testimonials lobby-->
<?php if( $choose_testimonials_lobby ): ?>
<div class="testimonials-lobby-knowledge">
    <div class="container">
        <div class="row justify-content-center testimonials-main-title-lobbby">
            <h3><?= $testimonials_title_lobby; ?></h3>
        </div>
        <div id="slick-testimonials-lobby">
            <?php foreach ($choose_testimonials_lobby as $choose_testimonial_lobby) :
                $testimonials_lobby_id = $choose_testimonial_lobby->ID;
                $testimonials_lobby_img = get_the_post_thumbnail_url($testimonials_lobby_id);
                $role = get_field('role', $testimonials_lobby_id);
                $academic_institution =  get_field('academic_institution', $testimonials_lobby_id);
            ?>
            <div class="wrap-item-tesimonials-lobby">
                <div class="testimonials-lobby-item">
                    <div class="img-testimonials-lobby">
                        <img src="<?= $testimonials_lobby_img ;?>" alt="">
                    </div>
                    <div class="content-testimonials-lobby">
                        <div class="testimonials_loby_content-inner"><?= $choose_testimonial_lobby->post_content; ?></div>
                        <div class="wrap-testimonial-names">
                            <div class="testimonials_loby_title"><?= $choose_testimonial_lobby->post_title; ?></div>
                            <span class="role-lobby-testimonials"><?= $role; ?> |</span>
                            <span class="academic_institution-lobby-testimonials"><?= $academic_institution; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<!--End Testimonials lobby-->

<!--how it works-->
<?php if ($how_it_works_title) : ?>
    <?= get_how_it_works($how_it_works_title , $video_boxes);?>
<?php endif; ?>
<!--End how it works-->

<?php if( $faq ): ?>
    <!--faq section-->
    <?= get_faq($faq_title, $faq ,$more_faq_link); ?>
    <!--End faq section-->
<?php endif; ?>

<?php add_action('wp_footer', function(){
    get_template_part('templates/event_popup');
});
