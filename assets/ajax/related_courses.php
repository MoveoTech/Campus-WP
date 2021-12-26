<?php
$docroot = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
require_once($docroot.'/wp-load.php');


$current_lang = fixXSS($_POST['lang']);
global $sitepress;
$sitepress->switch_lang($current_lang);

global $lang_strings;
$lang_strings = get_langs_json_object();

$post_id = $_POST['post_id'];

$subject_of_daat = $fields['subject_of_daat'];
$language_course = $fields['language_course'];
$knowledge = $fields['knowledge'];

$tax_query = array('relation' => 'AND');
if ($subject_of_daat) {
    $arr = array('relation' => 'OR');
    foreach ($subject_of_daat as $item) {
        $arr[] = array(
            'taxonomy' => 'subject',
            'field' => 'term_id',
            'terms' => $item->term_id,
        );
    }
    $tax_query[] = $arr;
}
if ($knowledge) {
    $arr = array('relation' => 'OR');
    foreach ($knowledge as $item) {
        $arr[] = array(
            'taxonomy' => 'areas_of_knowledge',
            'field' => 'term_id',
            'terms' => $item->term_id,
        );
    }
    $tax_query[] = $arr;
}
if ($language_course->term_id) {
    $meta_query[] = array(
        'key' => 'language_course',
        'value' => $language_course->term_id,
        'compare' => '='
    );
}
$more_courses_args = array(
    'post_type' => 'course',
    'orderby' => 'rand',
    'tax_query' => $tax_query,
    'meta_query' => $meta_query,
    'posts_per_page' => 4,
    'post__not_in' => array($post->ID),

);
$query = new WP_Query($more_courses_args);
//        print_r($query);
$posts = $query->posts;
echo "<pre class='debug_for_chaya hidden'>";
echo "<h3>בדיקה שלב ראשון</h3>";
//print_r($posts);
echo "</pre>";
if ($query->found_posts < 4) {
    $more_courses_args['tax_query']['relation'] = 'OR';

    $ids = array($post->ID);
    foreach ($query->posts as $item) {
        $ids[] = $item->ID;
    }
    $more_courses_args['post__not_in'] = $ids;

    $more_courses_args['posts_per_page'] = 4 - $query->found_posts;
    $new_query = new WP_Query($more_courses_args);
    $query->posts = array_merge($query->posts, $new_query->posts);
    echo "<pre class='debug_for_chaya hidden'>";
    echo "<h3>בדיקה שלב שני - אחרי מיזוג עם הפוסטים מהשלב הקודם</h3>";
//    print_r($posts);
    echo "</pre>";

    if (count($query->posts) < 4) {
        $ids = array($post->ID);
        foreach ($query->posts as $item) {
            $ids[] = $item->ID;
        }
        $more_courses_args['post__not_in'] = $ids;

        unset($more_courses_args['tax_query']);
        unset($more_courses_args['meta_query']);

        $more_courses_args['posts_per_page'] = 4 - count($query->posts);
        $new_query = new WP_Query($more_courses_args);
        $query->posts = array_merge($query->posts, $new_query->posts);
    }
}
global $post;

$output = '';

while ($query->have_posts()) : $query->the_post();
    $output .= draw_course_item(array(
        'class' => 'col-sm-12 col-md-6 col-lg-4 col-xl-3 course-item-with-border'
    ));
endwhile;

if($current_lang != 'he') {
    $output = str_replace('/course/', '/'. $current_lang .'/course/', $output);
}

echo $output;
wp_reset_query();