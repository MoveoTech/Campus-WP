<?php
/**
 * Template Name: Migrate Academic Institution
 */
?>
<div style="height: 100px"></div>
<?php

global $wpdb;
$results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='academic_institution'" ); // AND `post_title`='Sapir College'

$hebrew_ids = array();
foreach ( $results as $result )
{
    $translated = apply_filters( 'wpml_object_id', $result->ID, 'academic_institution', FALSE, 'he' );
    if ($translated){
        array_push($hebrew_ids, $translated);
    }
}
$unique_hebrew_ids = array_unique($hebrew_ids);

$index=1;

foreach ( $unique_hebrew_ids as $hebrew_id )
{
    $result = get_post($hebrew_id);
    ?>
    <div class="restaurant-card" style="border: 1px solid red; min-height: 150px; padding: 10px">
        <h4>academic institution Number :</h4><p> <?php echo $index++; ?></p>
        <h4>ID :</h4><p class="name"> <?php echo $result->ID; ?></p>
        <h4>Author ID :</h4><p class="name"> <?php echo $result->post_author; ?></p>
        <h4>Name : </h4><p class="name"><?php echo $result->post_title; ?></p>
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

    $data = array(
        'name' => $result->post_title,
        'author' => $result->post_author,
        'created' => $result->post_date,
        'modified' => $result->post_modified,
        'hebrew_description' => $result->post_content,
        'edx_id' => get_post_meta($result->ID, 'edx_id', true),
        'institution_site_link' => get_post_meta($result->ID, 'institution_site_link', true),
        'image' => get_post_thumbnail_id($result->ID),
        'hebrew_title_on_banner' => get_post_meta($result->ID, 'title_on_banner_institute', true),
        'banner_image_institute' => intval(get_post_meta($result->ID, 'banner_image_institute', true)),
        'banner_mobile_institute' => intval(get_post_meta($result->ID, 'banner_mobile_institute', true)),

    );

//    var_dump($data);

// Add the new item now and get the new ID
//    $academic_institution = $pod->add( $data);

}



print_r(array_unique($hebrew_ids));

print_r();
var_dump("translate count = ".count(array_unique($hebrew_ids))); //63
var_dump("hebrew = ".$hebrew);


wp_reset_postdata(); ?>
