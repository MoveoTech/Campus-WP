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
//echo nl2br("number of courses =  $wp_query->found_posts \n"); //admin: 406,  WP_Query: 325


global $wpdb;
$results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='course'" );
//var_dump($results);
$index=1;
foreach ( $results as $result )
{?>

    <div class="restaurant-card" style="border: 1px solid red; min-height: 150px; padding: 10px">
        <h4>lecturer Number :</h4><p> <?php echo $index++; ?></p>
        <h4>ID :</h4><p class="name"> <?php echo $result->ID; ?></p>
        <h4>Name : </h4><p class="name"><?php echo $result->post_title; ?></p>
        <h4>Author ID :</h4><p class="name"> <?php echo $result->post_author; ?></p>
        <h4>Description : </h4><p class="name"><?php echo $result->post_content; ?></p>
        <h4>image : </h4><p class="name"><?php echo wp_get_attachment_url( get_post_thumbnail_id($result->ID), 'thumbnail' ); ?></p>
        <h4>created : </h4><p class="name"><?php echo $result->post_date; ?></p>
        <h4>modified : </h4><p class="name"><?php echo $result->post_modified; ?></p>
        <h4>role :</h4><p class="name"> <?php echo get_post_meta($result->ID, 'role', true); ?></p>
        <h4>Academic institution : </h4><p class="name"><?php echo get_post_meta($result->ID, 'academic_institution', true); ?></p>
        <h4>Email : </h4><p class="name"><?php echo get_post_meta($result->ID, 'email', true); ?></p>
    </div>

    <?php

    $pod = pods( 'courses' );

    $data = array(
        'name' => $result->post_title,
        'author' => $result->post_author,
        'created' => $result->post_date,
        'modified' => $result->post_modified,
        'description' => $result->post_content,
        'role' => get_post_meta($result->ID, 'role', true),
        'email' => get_post_meta($result->ID, 'email', true),
        'image' => get_post_thumbnail_id($result->ID)

    );

    // Add the new item now and get the new ID
//    $new_book_id = $pod->add( $data );

}

wp_reset_postdata(); ?>
