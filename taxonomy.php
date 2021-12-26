<?php
global $wp_query, $current_tax;
$current_tax = $wp_query->queried_object;
?>
<?php get_template_part('archive', 'course'); ?>