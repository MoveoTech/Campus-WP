<?php
require_once 'inc/classes/Course_stripe.php';
//$fields = get_fields();

global $site_settings, $fields;

$hero_image = $fields['hero_image'];
$hero_image_mobile = $fields['hero_image_mobile'];
$hero_title = ($fields['hero_title']);
$hero_subtitle =  $fields['hero_subtitle'];

$banner = $fields['banner'];
$banner_for_mobile = $fields['banner_fore_mobile'];
$academic_institutions = $fields['academic_institution'];
$text_on_banner = ($fields['text_on_banner']);
$link_name = $fields['link_name'];
$link_url = $fields['link_url'];
$categories = $fields['category'];
$title_campus_school = $fields['title_campus_school'];
$coffs_schools = $fields['coffs_school'];
//$text_on_button_coffs = $fields['text_on_button_coffs'];


$choose_testimonials = $fields['choose_testimonials'];
$testimonials_title = $fields['testimonials_title'];
$faq_title = $fields['faq_title'];
$faq = $fields['faq'];
$more_faq_link = $fields['more_faq_link'];
$title_course_section = $fields['title_course_section'];
$courses_filter_term = $fields['courses_filter_term_home'];

$video_boxes = $fields['video_boxes'];
$how_it_works_title = $fields['how_it_works_title'];

$choose_event = $fields['choose_event'];

/* Carousel */
$stripe = $fields['new_stripe'];
$info_stripe = $fields['info_stripe'];
$academic_institutions_stripe = $fields['academic_institutions'];
$tags_stripe = $fields['tags_stripe'];
//$carousel = $fields['carousel'];

?>

<!--Banner area-->
<?php if ($hero_image) : ?>
    <?php
    $class = 'home';
    $title = str_replace('%', '<span class="span-brake"></span>', $hero_title);
    $text_on_banner_content = '';
    $text_on_banner_content .= '<h1>'. $title .'</h1>';
    ?>
<!--    --><?//=  get_banner_area( $banner_for_mobile, $banner , $text_on_banner_content, $class); ?>
    <div class="hero-banner" >
        <div class="banner-image" >
            <img class="desktop-banner" src="<?= $hero_image['url'] ?>" >
            <img class="mobile-banner" src="<?= $hero_image_mobile['url'] ?>" >
            <div class="container" >
                <div class="text-on-banner">
                    <h1><?=$hero_title?></h1>
                    <h5><?=$hero_subtitle?></h5>
                </div>
                <?= get_template_part('templates/hero', 'search') ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--End Banner area-->

<!--Test Stripe-->
<!-- Tags Stripe -->
<?php if($tags_stripe):
    get_template_part('template', 'parts/Stripes/tags-stripe',
    array(
            'args' => array(
                'title' => $tags_stripe[0]['title'],
                'tags' => $tags_stripe[0]['tags'],
            )
    ));
 endif; ?>
<!-- end tags stripe -->


<!--Nerative Stripe -->
<?php if ($stripe) :
//    foreach ($stripe as $carousel):
    $carousel = $stripe[0];
    $id = uniqid();
        get_template_part('template', 'parts/Stripes/nerative-stripe',
            array(
                'args' => array(
                    'id' => $id,
                    'image' => $carousel['logo']['url'],
                    'title' => $carousel['carousel_title'],
                    'subtitle' => $carousel['carousel_subtitle'],
                    'carousel' => $carousel['carousel'],
                )
            ));
//    endforeach;
endif; ?>
<!-- end nerative stripe -->

<!--academic institution slider-->
<?php if($academic_institutions_stripe) :
    get_template_part('template', 'parts/Stripes/academic-institution-stripe',
        array(
            'academic_institutions_stripe' => $academic_institutions_stripe,
        ));
endif; ?>
<!--end academic institution slider-->

<!-- Courses Stripe -->
<?php if ($stripe) :
//    foreach ($stripe as $carousel):
    $carousel = $stripe[1];
    $id = uniqid();
    get_template_part('template', 'parts/Stripes/courses-stripe',
        array(
            'args' => array(
                'id' => $id,
                'title' => $carousel['carousel_title'],
                'subtitle' => $carousel['carousel_subtitle'],
                'carousel' => $carousel['carousel'],
            )
        ));
//    endforeach;
endif; ?>
<!-- end courses stripe -->

<!-- Info Stripe -->
<?php if ($info_stripe) :
    foreach ($info_stripe as $carousel):
        get_template_part('template', 'parts/Stripes/info-stripe',
            array(
                'args' => array(
                    'title' => $carousel['info_title'],
                    'carousel' => $carousel['carousel']
                )
            ));
    endforeach;
endif; ?>
<!-- end info stripe -->

<?php //if ($categories) : ?>
<!--    <div class="category-section">-->
<!--        <div class="container">-->
<!--            <div class="row category-inner">-->
<!--                --><?php //foreach ($categories as $category) {
//                    ;?>
<!--                    <a href="--><?php //echo $category['link']; ?><!--" class="item-category col-sm-12 col-md-4">-->
<!--                        <img src="--><?php //echo $category['icon']; ?><!--">-->
<!--                        <h3 aria-level="2">--><?php //echo $category['title']; ?><!--</h3>-->
<!--                        <p>--><?php //echo $category['sub_title']; ?><!--</p>-->
<!--                        <div>--><?//= $category['add_name_of_link_category']; ?><!--</div>-->
<!--                    </a>-->
<!--                --><?php // } ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php //endif; ?>
<?php
/*
$date_now = date('Y-m-d');
echo "<div style='display: none;' data-hanniek>11111</div>";
$args_front = array(
    'post_type' => array('course', 'event'),
    'posts_per_page' => 54,
    'exclude_hidden_courses' => true,
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key' => 'event_date',
            'compare' => 'EXISTS'
        ),
        array(
            'relation' => 'AND',
            array(
                'key' => 'event_date',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'relation' => 'OR',
                array(
                    'key' => 'enrollment_end',
                    'compare' => '>=',
                    'value' => $date_now,
                    'type' => 'DATE'
                ),
                array(
                    'key' => 'enrollment_end',
                    'value' => '',
                    'compare' => '='
                )
            ),
        )
    ),
    'orderby' => 'menu_order',
    'order' => 'DESC'
);
?>
<?= get_filtered_courses($courses_filter_term,$title_course_section,$args_front);
 */

$upload_dir = wp_get_upload_dir(); // set to save in the /wp-content/uploads folder

echo "<div style='display: none;'>";
$json = file_get_contents($upload_dir['basedir'].'/courses_json.json');
print_r($json);
echo '</div>';
global $sitepress;
$current_lang = $sitepress->get_current_language();

if ($json) {
    $all_items = json_decode($json, true);
    $date_now = strtotime(date('Y-m-d'));
    $courses_output = '';

    foreach ($all_items as $ID => $item) {
        if ($item['enrollment_end'] == '' || $item['enrollment_end'] >= $date_now) {
            $post = get_post($ID);
            setup_postdata($post);
            $attrs = array(
                'filters' => 'data-hello="1" data-filter="' . $item['tags'][$current_lang] . '" data-status="'. $post->post_status .'" ',
                'class' => ' '
            );
            $func_name = 'draw_'. $item['post_type'] .'_item';
            $courses_output .= $func_name($attrs);
        }
    }
    wp_reset_query();
}

echo str_replace('REPLACEME', $courses_output, get_filtered_courses_masc($courses_filter_term, $title_course_section));
?>
<!--academic institution slider-->
<?php if ($fields['display_campus_school']) : ?>
    <?php if ($title_campus_school) {
        echo '<div style="display: none; ">';
        $bg_img = $fields['school_1st_floor_bg_img'];
        $bg_img = $bg_img ? "background-image: url($bg_img);" : '';
        $bg_color = $fields['school_1st_floor_bg_color'];
        echo '</div>';
        ?>
        <div class="campus-section" id="hp_school_1st" style="background-color: <?= $bg_color; ?>; <?= $bg_img; ?>">
            <div class="container">
                <div class="justify-content-center align-items-center title-campus-section">
                    <h3 aria-level="2" class="main-title-school"><?php echo $title_campus_school; ?></h3>
                    <div class="campus-title-scholl-img" style="background-image: url(<?= get_bloginfo('stylesheet_directory') . '/assets/images/sprite.png'; ?>)"></div>
                </div>
                <div class="school-items row justify-content-center">
                    <?php foreach ($coffs_schools as $coffs_school) {
                        $tax_obj = get_term_by('id', $coffs_school->term_id, 'tags_course');
                        $field_tax = get_fields($tax_obj);

                        if (ICL_LANGUAGE_CODE =='en') {
                            $name = $coffs_school->name;
                            $description = $coffs_school->description;
                            $text_on_button_coffs = $field_tax['text_on_button_home_page_en'];
                        } else if (ICL_LANGUAGE_CODE =='he') {
                            $name = $field_tax['translate_title_hebrew'];
                            $description = $field_tax['translate_description_hebrew'];
                            $text_on_button_coffs =  $field_tax['text_on_button_home_page_he'];
                        } else {
                            $name = $field_tax['translate_title_arab'];
                            $description = $field_tax['translate_description_arab'];
                            $text_on_button_coffs = $field_tax['text_on_button_home_page_arab'];
                        }
                        ?>
                        <div class="col-sm-12 col-md-4">
                            <div class="school-item">
                                <div class="school-item-text-wrap">
                                    <h4 aria-level="3" class=""><?php echo $name; ?></h4>
                                    <p><?php echo $description;  ?></p>
                                </div>
                                <?php
                                if (isset($_GET['lang'])) {
                                    $term_id = '&termid=';
                                } else {
                                    $term_id = '?termid=';
                                }
                                ?>
                                <a href="<?= get_post_type_archive_link('course') . $term_id .$coffs_school->term_id ; ?>" aria-label="<?= $text_on_button_coffs ?>- <?= $name ?>"><?= $text_on_button_coffs; ?></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php endif; ?>
<?php if (isset($fields['display_2nd_campus_school']) && $fields['display_2nd_campus_school']) :
    echo '<div style="display: none; ">';
    $first_line = $fields['additional_target_audiences_title'];
    $second_line = $fields['additional_target_audiences_content'];
    $third_line = $fields['join_details'];
    $link = $fields['email_school'];
    $link_text = $fields['email_school_text'];
    $link_text = $link_text ? $link_text : $link;
    $bg_img = $fields['school_2nd_floor_bg_img'];
    $bg_img = $bg_img ? "background-image: url($bg_img);" : '';
    $bg_color = $fields['school_2nd_floor_bg_color'];
    echo '</div>';
    ?>
<div class="campus-section" id="hp_school_2nd" style="background-color: <?= $bg_color; ?>; <?= $bg_img; ?>">
    <div class="container">
        <div class="row justify-content-center more-info">
            <div class="col-sm-12 col-md-6">
                <div class="item">
                    <span class="more-info-title"><?php echo $first_line; ?></span>
                    <p class="info"><?php echo $second_line; ?></p>
                    <p class="join"><?php echo $third_line; ?></p>
                    <a href="<?= $link; ?>" target="_blank" class="email-info copy-to-clipboard" aria-label="<?= $link_text ?>- <?= $first_line ?>"><?php echo $link_text; ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!--academic institution slider-->
<?php if ($how_it_works_title) : ?>
    <?= get_how_it_works($how_it_works_title, $video_boxes);?>
<?php endif; ?>
<?php if ($faq) : ?>
    <!--faq section-->
    <?= get_faq($faq_title, $faq, $more_faq_link); ?>
    <!--faq section-->
<?php endif; ?>
<?php if ($choose_testimonials) : ?>
    <div class="testimonials-slider-section">
        <div class="container">
            <h3 aria-level="2" class="title-section"><?php echo $testimonials_title; ?></h3>
            <label for="right-button-slider-testimonials" class="sr-only"><?php _e('next recommendation', 'single_corse')?></label>
            <label for="left-button-slider-testimonials" class="sr-only"><?php _e('previous recommendation', 'single_corse')?></label>
            <div class="testimonials-slider" id="testimonials-slider-slick">
                <?php
                foreach ($choose_testimonials as $choose_testimonial) {
                    $testimonial_id = $choose_testimonial->ID;
                    $role = get_field('role', $testimonial_id);
                    $academic_institution =  get_field('academic_institution', $testimonial_id)
                    ?>
                    <div class="item-testimonials">
                        <div class="item-testimonials-inner">
                            <div class="img-testimonials">
                                <?php  $img_exsist = get_the_post_thumbnail_url($testimonial_id) ? get_the_post_thumbnail_url($testimonial_id, 'medium') : get_bloginfo('stylesheet_directory') .'/assets/images/campus_avatar.png' ;?>
                                <div class="img-testimonials-inner" style="background-image: url(<?= $img_exsist ?>)"></div>
                            </div>
                            <div class="content-item-testimonials">
                                <h3 class="name-testimonial"><?php echo $choose_testimonial->post_title; ?></h3>
                                <p class="roll-testimonial"><?php echo $role ." | " . $academic_institution ?></p>
                                <?php $img_testimonial = get_bloginfo('stylesheet_directory') . '/assets/images/quotesmall.png'; ?>
                                <div class="img-quotesmall" style="background-image: url(<?= $img_testimonial ?>)" class="quotesmall"></div>
                                <div class="excerpt-testimonial"><?php echo $choose_testimonial->post_content; ?></div>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php add_action('wp_footer', function () {
    get_template_part('templates/event_popup');
});
