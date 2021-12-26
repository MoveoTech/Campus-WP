<?php

//if(have_posts()) {
//    while (have_posts()) {
//        the_post();
global $fields;
        $fields = get_fields();

// Banner
if ($fields['is_muni_page'])
    get_template_part('templates/single-project/banner_muni');
else
get_template_part('templates/single-project/banner');
//slider
get_template_part('templates/single-project/top-slider');
//Description area + optional Button
if ($fields['description_show'])
get_template_part('templates/single-project/description');
// דברי אנשים
if (count($fields['quots_list']) == 2)
    get_template_part('templates/single-project/quotes');
// קומת הנעה לפעולה
if ($fields['cta_show'])
    get_template_part('templates/single-project/cta');
// Courses area
get_template_part('templates/single-project/courses');
//all courses
get_template_part('templates/single-project/all-courses');
//how it work
get_template_part('templates/single-project/how_it_work');
//faq
get_template_part('templates/single-project/faq');
//testimonials
get_template_part('templates/single-project/testimonials');
