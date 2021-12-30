

<?php


/**
 * Template Name: new Academic Institutions
 */

//get_header();

//include locate_template( 'templates/header.php' );



echo "asdasd";

echo "This is a car detail page for : " . pods_v( 'last', 'url' );

//get current item name
$slug = pods_v( 'last', 'url' );
//get current pod name
$pod_name = pods_v( 0, 'url');
//get pods object
$pods = pods( $pod_name, $slug );
echo "<br>";

var_dump($slug);
echo "<br>";

var_dump($pod_name);
echo "<br>";

var_dump($pods);
echo "<br>";


//get_footer();