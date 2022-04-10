
<div style="height: 100px"></div>
<?php



$wp_query = new WP_Query(array(
    'post_type' => 'testimonials',
    'posts_per_page' => -1,
    'post_status' => 'publish',
));

echo nl2br("number of testimonials =  $wp_query->found_posts \n");
$posts = $wp_query->posts;


$ids = array();

foreach($posts as $result) {

    array_push($ids, array(
        "he"=>apply_filters( 'wpml_object_id', $result->ID, 'testimonials', FALSE, 'he' ),
        "en"=>apply_filters( 'wpml_object_id', $result->ID, 'testimonials', FALSE, 'en' ),
        "ar"=>apply_filters( 'wpml_object_id', $result->ID, 'testimonials', FALSE, 'ar' )
    ));

}
$arabicCount = 1;
$englishCount = 1;
for($i=0 ; $i <  count($ids) ; $i++)
{
    if($ids[$i]['ar'])
        $arabicCount++;
    if($ids[$i]['en'])
        $englishCount++;

}
echo nl2br("arabicCount of testimonials =  $arabicCount \n");
echo nl2br("englishCount of testimonials =  $englishCount \n");

$jsons= array();

for($i=0 ; $i <  count($ids) ; $i++)
{
    $resultHebrew = get_post($ids[$i]['he']);
    $resultEnglish = $ids[$i]['en']? get_post($ids[$i]['en']) : null;
    $resultArabic = $ids[$i]['ar']? get_post($ids[$i]['ar']) : null;
//    if($resultHebrew->ID == 8275){
    ?>

    <div class="restaurant-card" style="border: 1px solid red; min-height: 150px; padding: 50px">
        <h4>testimonials Number :</h4><p> <?php echo $i+1; ?></p>
        <h4>Herbrew :</h4><p class="name"> <?php echo $resultHebrew? $resultHebrew->ID : null; ?></p>
        <h4>English :</h4><p class="name"> <?php echo $resultEnglish? $resultEnglish->ID : null; ?></p>
        <h4>Arabic :</h4><p class="name"> <?php echo $resultArabic? $resultArabic->ID : null; ?></p>

        <h4>Herbrew Name:</h4><p class="name"> <?php echo $resultHebrew? $resultHebrew->post_title : null; ?></p>
        <h4>English Name:</h4><p class="name"> <?php echo $resultEnglish? $resultEnglish->post_title : null; ?></p>
        <h4>Arabic Name:</h4><p class="name"> <?php echo $resultArabic? $resultArabic->post_title : null; ?></p>

        <h4>created : </h4><p class="name"><?php echo $result->post_date; ?></p>
        <h4>modified : </h4><p class="name"><?php echo $result->post_modified; ?></p>

        <h4>Herbrew Description : </h4><p class="name"><?php echo $resultHebrew? $resultHebrew->post_content : null; ?></p>
        <h4>English Description : </h4><p class="name"><?php echo $resultEnglish? $resultEnglish->post_content : null; ?></p>
        <h4>Arabic Description : </h4><p class="name"><?php echo $resultArabic? $resultArabic->post_content : null; ?></p>

        <h4>image : </h4><p class="name"><?php echo wp_get_attachment_url( get_post_thumbnail_id($resultHebrew->ID), 'thumbnail' ); ?></p>

    </div>
    <?php


    $data = array(
        'name' => $resultHebrew->post_title,
        'english_name' => $resultEnglish ?  $resultEnglish->post_title : "",
        'arabic_name' => $resultArabic ?  $resultArabic->post_title : "",

        'created' => $resultHebrew->post_date,
        'modified' => $resultHebrew->post_modified,

        'hebrew_description' => $resultEnglish ? $resultHebrew->post_content : "",
        'english_description' => $resultEnglish ? $resultEnglish->post_content : "",
        'arabic_description' => $resultEnglish ? $resultArabic->post_content : "",

        'image' => get_post_thumbnail_id($resultHebrew->ID),
    );

    var_dump($data);


    // Add the new item now and get the new ID
//        $pod = pods( 'testimonial' );
//        $new_book_id = $pod->add( $data );
    //    }

}

//    echo json_encode($jsons, JSON_UNESCAPED_UNICODE);

wp_reset_postdata(); ?>
