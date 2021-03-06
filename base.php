<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

global $site_settings, $fields;
$site_settings = get_fields('options');
$fields = get_fields();

$lang_strings = get_langs_json_object();
?>


<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
<!--[if lt IE 9]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
</div>
<![endif]-->
<?php
do_action('get_header');
get_template_part('templates/header');
?>
<div class="wrap" role="document">
    <div class="content">
        <main role="main">
            <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
    </div><!-- /.content -->
</div><!-- /.wrap -->
<?php
do_action('get_footer');
get_template_part('templates/footer');
wp_footer();
?>
</body>
</html>
