<?php
/**
 * Template Name: Migrate Lecturer
 */
?>
<div style="height: 100px"></div>
<?php


global $wpdb;
$results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='lecturer'" ); // AND `post_title`='מוריה מרינה וקנין'

$hebrew_ids = array();
foreach ( $results as $result )
{
    $translated = apply_filters( 'wpml_object_id', $result->ID, 'lecturer', FALSE, 'he' );
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
        <h4>lecturer Number :</h4><p> <?php echo $index++; ?></p>
        <!--        <h4>ID :</h4><p class="name"> --><?php //echo $result->ID; ?><!--</p>-->
        <h4>Name : </h4><p class="name"><?php echo $result->post_title; ?></p>
        <!--        <h4>Author ID :</h4><p class="name"> --><?php //echo $result->post_author; ?><!--</p>-->
        <!--        <h4>Description : </h4><p class="name">--><?php //echo $result->post_content; ?><!--</p>-->
        <!--        <h4>image : </h4><p class="name">--><?php //echo wp_get_attachment_url( get_post_thumbnail_id($result->ID), 'thumbnail' ); ?><!--</p>-->
        <!--        <h4>created : </h4><p class="name">--><?php //echo $result->post_date; ?><!--</p>-->
        <!--        <h4>modified : </h4><p class="name">--><?php //echo $result->post_modified; ?><!--</p>-->
        <!--        <h4>role :</h4><p class="name"> --><?php //echo get_post_meta($result->ID, 'role', true); ?><!--</p>-->
        <!--        <h4>Academic institution : </h4><p class="name">--><?php //echo get_post_meta($result->ID, 'academic_institution', true); ?><!--</p>-->
        <!--        <h4>Email : </h4><p class="name">--><?php //echo get_post_meta($result->ID, 'email', true); ?><!--</p>-->
    </div>

    <?php


    $academic_institution_id = get_post_meta($result->ID, 'academic_institution', true);
    $academic_institution = get_post($academic_institution_id);
    $name = $academic_institution->post_title;

//    if($academic_institution_id)
//        echo "academic_institution_id".$academic_institution_id;
//
//    if($name)
//        echo "name".$name;

    $params = array(
        'where' => 't.name LIKE "%' . $name . '%"'
    );
    $mypod = pods( 'academic_institution', $params );

    $PodAcademic_institution_id = $mypod->display( 'id' );

//    if($PodAcademic_institution_id)
//        echo $PodAcademic_institution_id;
//    else
//        echo "no Pod Academic institution id";


    $pod = pods( 'lecturer' );


    if($PodAcademic_institution_id)
        $data = array(
            'name' => $result->post_title,
            'author' => $result->post_author,
            'created' => $result->post_date,
            'modified' => $result->post_modified,
            'hebrew_description' => $result->post_content,
            'hebrew_role' => get_post_meta($result->ID, 'role', true),
            'email' => get_post_meta($result->ID, 'email', true),
            'image' => get_post_thumbnail_id($result->ID),
            'academic_institution' => $PodAcademic_institution_id,
        );
    else
        $data = array(
            'name' => $result->post_title,
            'author' => $result->post_author,
            'created' => $result->post_date,
            'modified' => $result->post_modified,
            'hebrew_description' => $result->post_content,
            'hebrew_role' => get_post_meta($result->ID, 'role', true),
            'email' => get_post_meta($result->ID, 'email', true),
            'image' => get_post_thumbnail_id($result->ID),
        );



    var_dump($data);
// Add the new item now and get the new ID

    $params = array(
        'where' => 't.name LIKE "%' . $name . '%"'
    );
    $mypod = pods( 'lecturer', $params );
    if($mypod){
        $new_book_id = $pod->add( $data );
        echo "<h1>NEW LUCTURER ID : $new_book_id</h1>";
    }



}

wp_reset_postdata(); ?>
