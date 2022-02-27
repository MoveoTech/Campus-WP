
<div style="height: 100px"></div>
<?php

$wp_query = new WP_Query(array(
    'post_type' => 'academic_institution',
    'posts_per_page' => -1,
    'post_status' => 'publish',
));
echo nl2br("number of courses =  $wp_query->found_posts \n"); //admin: 406,  WP_Query: 325
$posts = $wp_query->posts;

$hebrew_ids = array();
$english_ids = array();
$arabic_ids = array();

foreach($posts as $result) {

    $translated1 = apply_filters( 'wpml_object_id', $result->ID, 'academic_institution', FALSE, 'he' );
    if ($translated1){
        array_push($hebrew_ids, $translated1);
    }

    $translated2 = apply_filters( 'wpml_object_id', $result->ID, 'academic_institution', FALSE, 'en' );
    if ($translated2){
        array_push($english_ids, $translated2);
    }
    $translated3 = apply_filters( 'wpml_object_id', $result->ID, 'academic_institution', FALSE, 'ar' );
    if ($translated3){
        array_push($arabic_ids, $translated3);
    }
}

for($i=0 ; $i <  count($hebrew_ids) ; $i++)
{
    $result = get_post($hebrew_ids[$i]);
    $resultEnglish = get_post($english_ids[$i]);
    $resultArabic = get_post($arabic_ids[$i]);

    ?>
    <div class="restaurant-card" style="border: 1px solid red; min-height: 150px; padding: 10px">
        <h4>academic institution Number :</h4><p> <?php echo $index++; ?></p>
        <h4>ID :</h4><p class="name"> <?php echo $result->ID; ?></p>
        <h4>Author ID :</h4><p class="name"> <?php echo $result->post_author; ?></p>
        <h4>Name : </h4><p class="name"><?php echo $result->post_title; ?></p>
        <h4>Name : </h4><p class="name"><?php echo $resultEnglish->post_title; ?></p>
        <h4>Name : </h4><p class="name"><?php echo $resultArabic->post_title; ?></p>
        <h4>PermaLink : </h4><p class="name"><?php echo get_permalink($result->ID); ?></p>

        <h4>created : </h4><p class="name"><?php echo $result->post_date; ?></p>
        <h4>modified : </h4><p class="name"><?php echo $result->post_modified; ?></p>
        <h4>Description : </h4><p class="name"><?php echo $result->post_content; ?></p>
        <h4>image : </h4><p class="name"><?php echo wp_get_attachment_url( get_post_thumbnail_id($result->ID), 'thumbnail' ); ?></p>
        <h4>edx_id :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'edx_id', true); ?></p>
        <h4>institution_site_link : </h4><p class="name"><?php echo get_post_meta($result->ID, 'institution_site_link', true); ?></p>
        <h4>banner_image_institute :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'banner_image_institute', true); ?></p>
        <h4>banner_mobile_institute :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'banner_mobile_institute', true); ?></p>

    </div>

    <?php



    $pod = pods( 'academic_institution' );

    $link = explode( '/', get_permalink($result->ID) );

    $data = array(
        'name' => $result->post_title,
        'english_name' => $resultEnglish->post_title,
        'arabic_name' => $resultArabic->post_title,
        'author' => $result->post_author,
        'created' => $result->post_date,
        'modified' => $result->post_modified,
        'permalink' => $link[count($link)-2],
        'hebrew_description' => $result->post_content,
        'english_description' => $resultEnglish->post_content,
        'arabic_description' => $resultArabic->post_content,
        'edx_id' => get_post_meta($result->ID, 'edx_id', true),
        'institution_site_link' => get_post_meta($result->ID, 'institution_site_link', true),
        'image' => get_post_thumbnail_id($result->ID),
        'hebrew_title_on_banner' => get_post_meta($result->ID, 'title_on_banner_institute', true),
        'english_title_on_banner' => get_post_meta($resultEnglish->ID, 'title_on_banner_institute', true),
        'arabic_title_on_banner' => get_post_meta($resultArabic->ID, 'title_on_banner_institute', true),
        'banner_image_institute' => intval(get_post_meta($result->ID, 'banner_image_institute', true)),
        'banner_mobile_institute' => intval(get_post_meta($result->ID, 'banner_mobile_institute', true)),

    );


    var_dump($data);

// Add the new item now and get the new ID
    $academic_institution = $pod->add( $data);

    $data = pods("courses", $academic_institution);
    $newPermalink = $data->display('permalink');

    wp_update_post( array(
        'ID' => $result->ID,
        'post_name' => $newPermalink
    ));

}









//global $wpdb;
//$results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='academic_institution'" ); // AND `post_title`='Sapir College'
//
//$hebrew_ids = array();
//$english_ids = array();
//$arabic_ids = array();
//$language_ids = array();
//
//
//$unique_hebrew_ids = array_unique($hebrew_ids);
//$unique_english_ids = array_unique($english_ids);
//$unique_arabic_ids = array_unique($arabic_ids);
//
//var_dump($unique_hebrew_ids);
//print_r("----------------------");
//print_r($unique_english_ids);
//
//print_r("----------------------\r\n ");
//print_r($unique_arabic_ids);
//
//
//
//$index=1;
//
////for($i=0 ; $i <  count($unique_hebrew_ids) ; $i++)
//for($i=0 ; $i <  0 ; $i++)
//{
//
//    $result = get_post($unique_hebrew_ids[$i]);
//    $resultEnglish = get_post($unique_english_ids[$i]);
//    $resultArabic = get_post($unique_arabic_ids[$i]);
//
//}




wp_reset_postdata(); ?>
