<?php

$innstitute_id = $post->ID;
$innstitute_id_arab = icl_object_id($innstitute_id, 'post', false, 'ar');
$innstitute_id_en = icl_object_id($innstitute_id, 'post', false, 'en');
$innstitute_id_he = icl_object_id($innstitute_id, 'post', false, 'he');

global $fields;

$banner_image_institute = $fields['banner_image_institute'];
$banner_mobile_institute = $fields['banner_mobile_institute'];
$institution_site_link = $fields['institution_site_link'];

$meta_query = array(
    'relation' => 'OR',
);
if ($innstitute_id_arab) {
    array_push($meta_query, array(
        'key' => 'assimilation_organizations',
        'value' => $innstitute_id_arab,
        'compare' => 'LIKE',
    ));
}
if ($innstitute_id_he) {
    array_push($meta_query, array(
        'key' => 'assimilation_organizations',
        'value' => $innstitute_id_he,
        'compare' => 'LIKE',
    ));
}
if ($innstitute_id_en) {
    array_push($meta_query, array(
        'key' => 'assimilation_organizations',
        'value' => $innstitute_id_en,
        'compare' => 'LIKE',
    ));
}

//get courses
$args_course = array(
    'posts_per_page' => -1,
    'post_type' => 'h_course',
    'meta_query' => $meta_query,
    'orderby' => 'menu_order',
    'order' => 'DESC'
);
$query_course = new WP_Query($args_course);
$found_courses = $query_course->found_posts;

$banner_content = '';
if ($fields['banner_logo']) {
    $banner_content = '<span class="img_wrap"><img src="' . $fields['banner_logo']['url'] . '" alt="' . $fields['banner_logo']['alt'] . '"/></span>';
}
$title = $fields['title_on_banner_institute'];
$title = $title ? wrap_text_with_char($title) : $post->post_title;
$banner_content .= "<h1 id='hybrid_banner_h1'>" . $title . "</h1>";
$banner_content .= "<div id='hybrid_banner_content'>{$fields['banner_content']}</div>";
$banner_content .= "<div id='hybrid_inst_banner_img'><img src='{$fields['ins_icon']}' alt='{$post->post_title}' /></div>";

$args = array(
    'banner_image_desktop' => $fields['banner_image_institute'],
    'banner_image_mobile' => $fields['banner_mobile_institute'],
    'content' => $banner_content,
    'bg_color' => 'light_blue'
);

set_query_var('banner_args', $args);
get_template_part('templates/banner', 'half_img');
$count_lecturers_list = $fields['lecturers_list'] ? count($fields['lecturers_list']) : 0;
$count_trainers_list = $fields['trainers_list'] ? count($fields['trainers_list']) : 0;
?>

    <div id="h_inst_content_floor">
        <div class="container">
            <div class="row justify-content-between">
                <div id="h_inst_content" class="h_inst_content_col col-xs-12 col-sm-12 col-lg-6">
                    <?php echo wpautop(get_the_content()); ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-5 h_inst_content_col">
                    <div class="info-institu">
                        <div class="found-course">
                            <p class="h_institution_num_desc"><?= cin_get_str('num_of_courses_title'); ?></p>
                            <p class="found-course-number h_institution_num"><?= $found_courses; ?></p>
                        </div>
                        <div class="found-lecturer">
                            <p class="h_institution_num_desc"><?= cin_get_str('num_of_lecturers_title'); ?></p>
                            <p class="found-lecturer-number h_institution_num"><?= $count_lecturers_list; ?></p>
                        </div>
                        <div class="found-trainers">
                            <p class="h_institution_num_desc"><?= cin_get_str('num_of_trainers_title'); ?></p>
                            <p class="found-lecturer-number h_institution_num"><?= $count_trainers_list; ?></p>
                        </div>
                        <?php if ($institution_site_link): ?>
                            <div class="external-site-institut">
                                <a target="_blank" class="external-site-institut-link"
                                   href="<?= $institution_site_link; ?>"><?= __('To The Site Of: ', 'single_corse') . ' ' . get_the_title(); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--courses-area-->
    <div id="hybrid_inst_courses">
        <div class="container">
            <div class="row justify-content-center">
                <h2 class="more-courses-interest"><?= __('The Courses Of:', 'single_corse') . ' ' . wrap_text_with_char(get_the_title()); ?></h2>
            </div>
            <div class="row more-courses-inner">
                <?php
                if ($query_course->have_posts()):

                    while ($query_course->have_posts()): $query_course->the_post();
                        {
                            echo draw_course_item(array(
                                'class' => 'col-sm-12 col-md-6 col-lg-4 col-xl-3 course-item-with-border',
                                'hybrid_course' => true
                            ));
                        }
                    endwhile;
                endif;
                wp_reset_query();
                ?>
            </div>
            <?php
            $more = cin_get_str('hybrid_more_courses_btn');
            if ($query_course->found_posts > 8) {
                echo "<a data-color='lightblue' class='hybrid_more_courses_btn new_design_btn d-none d-md-inline-block' href='javascript: void(0);'>$more</a>";
            }
            if ($query_course->found_posts > 4) {
                echo "<a data-color='lightblue' class='hybrid_more_courses_btn new_design_btn d-md-none' href='javascript: void(0);'>$more</a>";
            }
            ?>
        </div>
    </div>


<?php add_action('wp_footer', function () {
    get_template_part('templates/event_popup');
});











