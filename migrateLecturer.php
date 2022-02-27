
<div style="height: 100px"></div>
<?php



$wp_query = new WP_Query(array(
    'post_type' => 'lecturer',
    'posts_per_page' => -1,
    'post_status' => 'publish',
));

echo nl2br("number of lecturer =  $wp_query->found_posts \n"); //admin: 414,  WP_Query: 414
$posts = $wp_query->posts;


$ids = array();

foreach($posts as $result) {

    array_push($ids, array(
        "he"=>apply_filters( 'wpml_object_id', $result->ID, 'academic_institution', FALSE, 'he' ),
        "en"=>apply_filters( 'wpml_object_id', $result->ID, 'academic_institution', FALSE, 'en' ),
        "ar"=>apply_filters( 'wpml_object_id', $result->ID, 'academic_institution', FALSE, 'ar' )
    ));

}


for($i=0 ; $i <  count($ids) ; $i++)
{
    $resultHebrew = get_post($ids[$i]['he']);
    $resultEnglish = $ids[$i]['en']? get_post($ids[$i]['en']) : null;
    $resultArabic = $ids[$i]['ar']? get_post($ids[$i]['ar']) : null;
//    if($resultHebrew->ID == 8275){
    ?>

    <div class="restaurant-card" style="border: 1px solid red; min-height: 150px; padding: 50px">
        <h4>lecturer Number :</h4><p> <?php echo $i+1; ?></p>
        <h4>Herbrew :</h4><p class="name"> <?php echo $resultHebrew? $resultHebrew->ID : null; ?></p>
        <h4>English :</h4><p class="name"> <?php echo $resultEnglish? $resultEnglish->ID : null; ?></p>
        <h4>Arabic :</h4><p class="name"> <?php echo $resultArabic? $resultArabic->ID : null; ?></p>

        <h4>Herbrew Name:</h4><p class="name"> <?php echo $resultHebrew? $resultHebrew->post_title : null; ?></p>
        <h4>English Name:</h4><p class="name"> <?php echo $resultEnglish? $resultEnglish->post_title : null; ?></p>
        <h4>Arabic Name:</h4><p class="name"> <?php echo $resultArabic? $resultArabic->post_title : null; ?></p>

        <!--                <h4>ID :</h4><p class="name"> --><?php //echo $result->ID; ?><!--</p>-->
        <!--        <h4>Name : </h4><p class="name">--><?php //echo $result->post_title; ?><!--</p>-->
        <!--                <h4>Author ID :</h4><p class="name"> --><?php //echo $result->post_author; ?><!--</p>-->
        <!--                <h4>Description : </h4><p class="name">--><?php //echo $result->post_content; ?><!--</p>-->
        <!--                <h4>image : </h4><p class="name">--><?php //echo wp_get_attachment_url( get_post_thumbnail_id($result->ID), 'thumbnail' ); ?><!--</p>-->
        <!--                <h4>created : </h4><p class="name">--><?php //echo $result->post_date; ?><!--</p>-->
        <!--                <h4>modified : </h4><p class="name">--><?php //echo $result->post_modified; ?><!--</p>-->
        <!--                <h4>role :</h4><p class="name"> --><?php //echo get_post_meta($result->ID, 'role', true); ?><!--</p>-->
        <!--                <h4>Academic institution : </h4><p class="name">--><?php //echo get_post_meta($result->ID, 'academic_institution', true); ?><!--</p>-->
        <!--                <h4>Email : </h4><p class="name">--><?php //echo get_post_meta($result->ID, 'email', true); ?><!--</p>-->
    </div>

    <?php


    // get academic institution id
    $academic_institution_id = get_post_meta($resultHebrew->ID, 'academic_institution', true);
    $academic_institution = get_post($academic_institution_id);
    $name = $academic_institution->post_title;
    if(strpos($name, '"') != false)
        $name = str_replace('"','""', $name);
    $mypod = pods( 'academic_institution', array('where' => 't.name LIKE "%' . $name . '%"') );
    $PodAcademic_institution_id = $mypod->display( 'id' );





    if($PodAcademic_institution_id)
        $data = array(
            'name' => $resultHebrew->post_title,
            'english_name' => $resultEnglish ?  $resultEnglish->post_title : null,
            'arabic_name' => $resultArabic ?  $resultArabic->post_title : null,

            'author' => $resultHebrew->post_author,
            'created' => $resultHebrew->post_date,
            'modified' => $resultHebrew->post_modified,

            'hebrew_description' => $resultHebrew->post_content,
            'english_description' => $resultEnglish->post_content,
            'arabic_description' => $resultArabic->post_content,

            'hebrew_role' => get_post_meta($resultHebrew->ID, 'role', true),
            'english_role' => $resultEnglish ? get_post_meta($resultEnglish->ID, 'role', true) : null,
            'arabic_role' => $resultArabic ? get_post_meta($resultArabic->ID, 'role', true) : null,

            'email' => get_post_meta($resultHebrew->ID, 'email', true),
            'image' => get_post_thumbnail_id($resultHebrew->ID),
            'academic_institution' => $PodAcademic_institution_id,
        );
    else
        $data = array(
            'name' => $resultHebrew->post_title,
            'english_name' => $resultEnglish ?  $resultEnglish->post_title : null,
            'arabic_name' => $resultArabic ?  $resultArabic->post_title : null,

            'author' => $resultHebrew->post_author,
            'created' => $resultHebrew->post_date,
            'modified' => $resultHebrew->post_modified,

            'hebrew_description' => $resultHebrew->post_content,
            'english_description' => $resultEnglish->post_content,
            'arabic_description' => $resultArabic->post_content,

            'hebrew_role' => get_post_meta($resultHebrew->ID, 'role', true),
            'english_role' => $resultEnglish ? get_post_meta($resultEnglish->ID, 'role', true) : null,
            'arabic_role' => $resultArabic ? get_post_meta($resultArabic->ID, 'role', true) : null,

            'email' => get_post_meta($resultHebrew->ID, 'email', true),
            'image' => get_post_thumbnail_id($resultHebrew->ID),
        );

    var_dump($data);

// Add the new item now and get the new ID
    $pod = pods( 'lecturer' );
    $new_book_id = $pod->add( $data );
//    }

}




wp_reset_postdata(); ?>
