<?php
if( function_exists('acf_add_local_field_group') ):

    include locate_template('lib/field_groups/courses_index_settings.php');
    include locate_template('lib/field_groups/events_settings.php');
    include locate_template('lib/field_groups/post_type-course.php');
    include locate_template('lib/field_groups/post_type-event.php');
    include locate_template('lib/field_groups/post_type-h_course.php');
    include locate_template('lib/field_groups/post_type-hybrid_institution.php');
    include locate_template('lib/field_groups/post_type-institution.php');
    include locate_template('lib/field_groups/post_type-project.php');
    include locate_template('lib/field_groups/home_page.php');
    include locate_template('lib/field_groups/tax-events_type.php');
    include locate_template('lib/field_groups/tax-learning_target.php');
    include locate_template('lib/field_groups/tax-tags_course.php');
    include locate_template('lib/field_groups/site_settings.php');
    include locate_template('lib/field_groups/meta-keywords.php');
    include locate_template('lib/field_groups/contact_us.php');

endif;
