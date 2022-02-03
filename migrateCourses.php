<?php
/**
 * Template Name: Migrate Courses
 */
?>
<div style="height: 100px"></div>
<?php

//$wp_query = new WP_Query(array(
//    'post_type' => 'course',
//    'posts_per_page' => -1,
//    'post_status' => 'publish',
//));
//echo nl2br("number of courses =  $wp_query->found_posts \n"); //admin: 377,  WP_Query: 377


global $wpdb;
$results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='course'" );
//var_dump($results);
$index=1;
foreach ( $results as $result )
{
//    if($result->ID == "43727"):
    if(false):

        ?>


        <div class="restaurant-card" style="border: 1px solid red; min-height: 150px; padding: 10px">
            <h4>lecturer Number :</h4><p> <?php echo $index++; ?></p>
            <h4>ID :</h4><p class="name"> <?php echo $result->ID; ?></p>
            <h4>Name : </h4><p class="name"><?php echo $result->post_title; ?></p>
            <h4>PermaLink : </h4><p class="name"><?php echo get_permalink($result->ID); ?></p>
            <h4>created : </h4><p class="name"><?php echo $result->post_date; ?></p>
            <h4>modified : </h4><p class="name"><?php echo $result->post_modified; ?></p>
            <h4>Author ID :</h4><p class="name"> <?php echo $result->post_author; ?></p>
            <h4>Description : </h4><p class="name"><?php echo $result->post_content; ?></p>
            <h4>Excerpt : </h4><p class="name"><?php echo $result->post_excerpt; ?></p>
            <h4>Meta Keywords : </h4><p class="name"><?php echo get_post_meta($result->ID, 'meta_keywords', true); ?></p>

            <br>
            <h1 style="color: red">--------------------------</h1>
            <br>


            <h4>image : </h4><p class="name"><?php echo wp_get_attachment_url( get_post_thumbnail_id($result->ID), 'thumbnail' ); ?></p>
            <h4>Meta Keywords : </h4><p class="name"><?php echo get_post_meta($result->ID, 'course_banner', true); ?></p>
            <h4>Meta Keywords : </h4><p class="name"><?php echo get_post_meta($result->ID, 'banner_for_mobile_course', true); ?></p>


            <br>
            <h1 style="color: red">--------------------------</h1>
            <br>


            <h4>Course ID edX :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'course_id_edx', true); ?></p>
            <h4>Trailer :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'course_video', true); ?></p>
            <h4>Title on banner :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'title_on_banner_course', true); ?></p>
            <h4>Start Date :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'start', true); ?></p>
            <h4>End Date :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'end', true); ?></p>
            <h4>Duration :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'duration', true); ?></p>
            <h4>Price :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'price', true); ?></p>
            <h4>External link :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'external_link', true); ?></p>
            <h4>Course Products :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'description', true); ?></p>


            <h4>lecturer :</h4><p class="name"> <?php var_dump(get_post_meta($result->ID, 'lecturer', true)); ?></p>
            <h4>Testimonials :</h4><p class="name"> <?php var_dump(get_post_meta($result->ID, 'testimonial', true)); ?></p>
            <h4>Institution :</h4><p class="name"> <?php var_dump(get_post_meta($result->ID, 'org', true)); ?></p>
            <h4>Corporation institution :</h4><p class="name"> <?php var_dump(get_post_meta($result->ID, 'corporation_institution', true)); ?></p>

            <!-- certificate -->
            <?php
            $certificate_id  =get_post_meta($result->ID, 'certificate', true);
            $certificate = get_term( $certificate_id );
            ?>
            <h4>certificate</h4><p class="name"> <?php echo $certificate->name; ?></p>
            <h4>certificate Pod : </h4><p class="name"> <?php echo getCertificate($certificate->name); ?></p>

            <!-- Pacing -->
            <h4>Pacing : </h4><p class="name"> <?php echo get_post_meta($result->ID, 'pacing', true); ?></p>
            <h4>Pacing Pod : </h4><p class="name"> <?php echo getPacing(get_post_meta($result->ID, 'pacing', true)); ?></p>

            <!-- Language -->
            <?php
            $language_id  =get_post_meta($result->ID, 'language_course', true);
            $language = get_term( $language_id );
            echo $language->taxonomy;
            ?>
            <h4>Language</h4><p class="name"> <?php echo $language->name; ?></p>
            <h4>Language Pod : </h4><p class="name"> <?php echo getLanguage($language->name); ?></p>

            <!-- Subtitle Language -->
            <br style="color: gold">
            <?php
            $subTitleLanguage_id  =get_post_meta($result->ID, 'subtitle_lang', true);
            $subTitleLanguages = array();
            $subTitleLanguagesPod = array();
            if($subTitleLanguage_id):
                foreach ($subTitleLanguage_id as $lang):
                    $subTitleLanguage = get_term( $lang );
                    array_push($subTitleLanguages, $subTitleLanguage->name);
                    array_push($subTitleLanguagesPod, getLanguage($subTitleLanguage));

                    echo $subTitleLanguage->name;
                endforeach;
            endif;
            ?>
            <h4>Sub Title Language</h4><p class="name"> <?php var_dump($subTitleLanguages); ?></p>
            <h4>Sub Title Language Pod : </h4><p class="name"> <?php var_dump($subTitleLanguagesPod); ?></p>

            <h4>Syllabus Link :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'syllabus', true); ?></p>
            <h4>Mobile Available :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'mobile_available', true); ?></p>
            <h4>Enrollment start :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'enrollment_start', true); ?></p>
            <h4>Enrollment end :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'enrollment_end', true); ?></p>
            <h4>Hide in site :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'campus_hide_in_site', true); ?></p>
            <h4>קוד javaScript :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'js_code', true); ?></p>

            <h4>Order :</h4><p class="name"> <?php echo get_post_field( 'menu_order', $result->ID, true ); ?></p>

            <!-- Order -->

        </div>


    <?php

    endif;


    $PodslecturerArray = getPodslecturerArray($result->ID);
    $PodsTestimonialArray = getPodsTestimonialArray($result->ID);
    $PodAcademic_institution_id = getPodsAcademicInstitution($result->ID);
    $PodCorporation_institution_id = getPodsCorporationInstitutionArray($result->ID);


    $link = explode( '/', get_permalink($result->ID) );
//    echo "<br>";
//    echo "<br>";
//    echo "<br>";
//
//    echo $result->post_title;
//    echo "<br>";
//    echo $link[count($link)-2];
//    echo "<br>";

    $data = array(
        'name' => $result->post_title,
        'permalink' => $link[count($link)-2],
        'created' => $result->post_date,
        'modified' => $result->post_modified,
        'author' => $result->post_author,
        'description' => $result->post_content,
        'excerpt' => $result->post_excerpt,
        'meta_keywords' => get_post_meta($result->ID, 'meta_keywords', true),

        'image' => get_post_thumbnail_id($result->ID),
        'banner_image' => get_post_meta($result->ID, 'course_banner', true),
        'banner_image_for_mobile' => get_post_meta($result->ID, 'banner_for_mobile_course', true),

        'course_id_edx' => get_post_meta($result->ID, 'course_id_edx', true),
        'trailer' => get_post_meta($result->ID, 'course_video', true),
        'title_on_banner' => get_post_meta($result->ID, 'title_on_banner_course', true),
        'start_date' => get_post_meta($result->ID, 'start', true),
        'end_date' => get_post_meta($result->ID, 'end', true),
        'duration' => get_post_meta($result->ID, 'duration', true),
        'price' => get_post_meta($result->ID, 'price', true),
        'external_link' => get_post_meta($result->ID, 'external_link', true),
        'course_products' => get_post_meta($result->ID, 'description', true),

        'lecturer' => $PodslecturerArray,
        'testimonial' => $PodsTestimonialArray,
        'institution' => $PodAcademic_institution_id,
        'corporation_institution' => $PodCorporation_institution_id,

        'pacing' => getPacing(get_post_meta($result->ID, 'pacing', true)),
        'language' => getLanguage($language),
        'subtitle_language' => $subTitleLanguagesPod,

        'certificate' => getCertificate($certificate),

        'syllabus_link' => get_post_meta($result->ID, 'syllabus', true),
        'mobile_available' => get_post_meta($result->ID, 'mobile_available', true),
        'enrollment_start' => get_post_meta($result->ID, 'enrollment_start', true),
        'enrollment_end' => get_post_meta($result->ID, 'enrollment_end', true),
        'hide_in_site' => get_post_meta($result->ID, 'campus_hide_in_site', true),
        'javascript_code' => get_post_meta($result->ID, 'js_code', true),

        'order' => get_post_field( 'menu_order', $result->ID, true )



    );

//    var_dump($data);

//    if($result->ID == "43727"){


        $pod = pods( 'courses' );

        $CourseID = $pod->add( $data );

        $data = pods("courses", $CourseID);
        $newPermalink = $data->display('permalink');
        wp_update_post( array(
            'ID' => $result->ID,
            'post_name' => $newPermalink
        ));


//    }





}




function getPacing($pacing)
{
    if($pacing == "self")
        return 'עצמי , self  , ذاتي';

    if($pacing == "instructor")
        return 'מונחה , instructor  , مُوَجَّه';

    return null;
}

function getLanguage($lang)
{
    if($lang && $lang->name){

        if($lang->name == "אנגלית")
            return 'אנגלית , English  , الانجليزيه';

        if($lang->name == "ערבית")
            return 'ערבית , Arabic  , العربيه';

        if($lang->name == "עברית")
            return 'עברית , Hebrew  , العبرية';
    }
    return null;
}

function getPodslecturerArray($postId)
{

    $lecturerArray = get_post_meta($postId, 'lecturer', true);
    $PodslecturerArray = array();
    if($lecturerArray) :
        foreach ($lecturerArray as $id):

            $lecturer = get_post($id);
            $name = $lecturer->post_title;

            if(strpos($name, '"') != false)
                $name = str_replace('"','""', $name);

            $mypod = pods( 'lecturer', array('where' => 't.name LIKE "%' . $name . '%" or t.english_name LIKE "%' . $name . '%" or t.arabic_name LIKE "%' . $name . '%"') );
            $Pod_lecturer_id = $mypod->display( 'id' );
            array_push($PodslecturerArray, $Pod_lecturer_id);

        endforeach;
    endif;
    return $PodslecturerArray;
}

function getPodsTestimonialArray($postId)
{

    $testimonialArray = get_post_meta($postId, 'testimonial', true);
    $PodstestimonialArray = array();
    if($testimonialArray):
        foreach ($testimonialArray as $id):

            $testimonial = get_post($id);
            $name = $testimonial->post_title;
    //        var_dump($name);

            if(strpos($name, '"') != false)
                $name = str_replace('"','""', $name);

            $mypod = pods( 'testimonial', array('where' => 't.name LIKE "%' . $name . '%" or t.english_name LIKE "%' . $name . '%" or t.arabic_name LIKE "%' . $name . '%"') );
            $Pod_testimonial_id = $mypod->display( 'id' );
            array_push($PodstestimonialArray, $Pod_testimonial_id);

        endforeach;
    endif;
    return $PodstestimonialArray;
}

function getPodsAcademicInstitution($postId)
{

    $academic_institution_id = get_post_meta($postId, 'org', true);
    $academic_institution = get_post($academic_institution_id);
    $name = $academic_institution->post_title;
    if(strpos($name, '"') != false)
        $name = str_replace('"','""', $name);
    $mypod = pods( 'academic_institution', array('where' => 't.name LIKE "%' . $name . '%" or t.english_name LIKE "%' . $name . '%" or t.arabic_name LIKE "%' . $name . '%"') );

    $PodAcademic_institution_id = $mypod->display( 'id' );

    return $PodAcademic_institution_id;
}


function getPodsCorporationInstitutionArray($postId)
{

    $academicInstitutionArray = get_post_meta($postId, 'corporation_institution', true);
    $podAcademicInstitutionArray = array();
    if($academicInstitutionArray) :
        foreach ($academicInstitutionArray as $id):

            $academic_institution = get_post($id);
            $name = $academic_institution->post_title;

            if(strpos($name, '"') != false)
                $name = str_replace('"','""', $name);

            $mypod = pods( 'academic_institution', array('where' => 't.name LIKE "%' . $name . '%" or t.english_name LIKE "%' . $name . '%" or t.arabic_name LIKE "%' . $name . '%"') );
            $PodAcademic_institution_id = $mypod->display( 'id' );
            array_push($podAcademicInstitutionArray, $PodAcademic_institution_id);

        endforeach;
    endif;
    return $podAcademicInstitutionArray;
}



function getCertificate($certificate)
{

    if($certificate && $certificate->name){
        if($certificate->name == "אין תעודה")
            return 'אין תעודה , No certificate  , لا يحتوي على شهادة';

        if($certificate->name == "כולל תעודה בקמפוסIL")
            return 'כולל תעודה בקמפוסIL , Contains a certificate on Campus IL  , يحتوي على شهادة في كامبوس';

        if($certificate->name == "קרדיט בכפוף לבחינה במוסד")
            return 'קרדיט בכפוף לבחינה במוסד , Credit subject to university exam , يوجد شهادة , لكن يتوجّب اجتياز امتحان في المعهد التعليمي';

        if($certificate->name == "תעודה בתוספת תשלום")
            return 'תעודה בתוספת תשלום , Verified payed for Certificate of an external education system  , برسوم-اضافيّة';

    }
    return null;
}

wp_reset_postdata(); ?>
