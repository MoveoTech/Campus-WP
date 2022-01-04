<?php

//create a custom taxonomy name it "type" for your posts
function create_custom_objects() {
    create_tax('faqs_category',  __('Category', 'post_types'), __('Categories', 'post_types'), array('faq'));
    create_tax('lecturer_category', 'Category', 'Categories', array('lecturer'));
    create_tax('academic_institution', 'Category', 'Categories', array('academic_institution'));
    create_tax('testimonials-cat', 'Testimonial Category', 'Testimonials Categories', array('testimonials'));
    create_tax('course_duration', 'Duration of the course', 'Durations', array('course'));
    create_tax('certificate', 'Certificate', 'Certificates', array('course'));
    create_tax('marketing', 'Marketing', 'Marketing', array('course'));
    //create_tax('level_id', 'Level', 'Levels', array('course'));
    create_tax('subject', 'Subject', 'Subjects', array('course'));
    create_tax('availability', 'Availability', 'Availability', array('course'));
    create_tax('language', 'Language', 'languages', array('course'));
    create_tax('tags_course', 'Tags course', 'Tags courses', array('course'));
    create_tax('areas_of_knowledge', 'Learning Target', 'Learning Target', array('course'));
    create_tax('tag_filter', 'Tag Filter', 'Tags Filter', array('course', 'event'));
    create_tax('age_strata', 'Age strata', 'Age strata', array('course'));
    create_tax('tags_knowledge', 'Tags knowledge', 'Tags knowledge', array('course'));
    create_tax('skill', 'Skill', 'Skills', array('course'));

    register_taxonomy('event_type',array('event'), array(
        'labels' => get_tax_labeles_for_registration('Event Type', 'Event Types'),
        'show_ui'                    => true,
        'show_in_quick_edit'         => false,
        'meta_box_cb'                => false,
    ));
    register_taxonomy('event_producer',array('event'), array(
        'labels' => get_tax_labeles_for_registration('Event Producer', 'Event Producers'),
        'show_ui'                    => true,
        'show_in_quick_edit'         => false,
        'meta_box_cb'                => false,
    ));



    create_post_types(array(
        'name' => 'event',
        'label' => __('Event', 'post_types'),
        'labels' => __('Events', 'post_types'),
        'page_attributes' => true,
        'icon' => 'dashicons-calendar-alt',
        'archive' => true
    ));
    create_post_types(array(
        'name' => 'course',
        'label' => __('Course', 'post_types'),
        'labels' => __('Courses', 'post_types'),
        'page_attributes' => true,
        'icon' => false,
        'archive' => true
    ));
    create_post_types(array(
        'name' => 'project',
        'label' => 'Project',
        'labels' => 'Projects',
        'icon' => false
    ));
    create_post_types(array(
        'name' => 'faq',
        'label' => 'Faq',
        'labels' => 'Faqs',
        'icon' => 'dashicons-edit-large'
    ));
    create_post_types(array(
        'name' => 'lecturer',
        'label' => 'Lecturer',
        'labels' => 'Lecturers',
        'icon' => 'dashicons-businessman'
    ));
    create_post_types(array(
        'name' => 'academic_institution',
        'label' => __('Academic Institution', 'post_types'),
        'labels' =>__('Academic Institutions', 'post_types'),
        'icon' => 'dashicons-bank'
    ));
    create_post_types(array(
        'name' => 'testimonials',
        'label' => 'Testimonial',
        'labels' => 'Testimonials',
        'icon' => 'dashicons-editor-quote'
    ));

    /* Hybrid courses */
    create_post_types(array(
        'name' => 'h_course',
        'label' => __('Hybrid Course', 'post_types'),
        'labels' => __('Hybrid Courses', 'post_types'),
        'page_attributes' => true,
        'icon' => 'dashicons-welcome-learn-more'
    ));
    create_post_types(array(
        'name' => 'hybrid_institution',
        'label' => __('Assimilation organization', 'post_types'),
        'labels' =>__('Assimilation organizations', 'post_types'),
        'icon' => 'dashicons-admin-home'
    ));
}

add_action( 'init', 'create_custom_objects', 0 );
/**
 * End Adding post type of faq
 */

function create_post_types($attrs){

    extract($attrs);

    $labels = array(
        'name'                => $label,
        'singular_name'       => $label,
        'menu_name'           => $labels,
        'parent_item_colon'   => 'Parent '. $label,
        'all_items'           => 'All '. $labels,
        'view_item'           => 'View '. $label,
        'add_new_item'        => 'Add New '. $label,
        'edit_item'           => 'Edit '. $label,
        'update_item'         => 'Update '. $label,
        'search_items'        => 'Search '. $label,
    );
    $page_attributes = $page_attributes ? 'page-attributes' : null;
    $args = array(
        'label'               => $label,
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', $page_attributes),
        'public'              => true,
        'hierarchical'        => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'has_archive'         => $archive,
        'can_export'          => true,
        'exclude_from_search' => false,
        'yarpp_support'       => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon'        => $icon
    );
    register_post_type( $name, $args );
}
function create_tax($name, $label, $labels, $post_types){
    register_taxonomy($name,$post_types, array(
        'labels' => get_tax_labeles_for_registration($label, $labels),
        'show_ui' => true
    ));
}
function remove_cuttax_metaboxes() {
    $post_type = 'course';
    remove_meta_box( 'tagsdiv', $post_type, 'side' );

}
add_action( 'admin_menu' , 'remove_cuttax_metaboxes', 100 );

function get_tax_labeles_for_registration($label, $labels){
    $labels = array(
        'name' => $labels,
        'singular_name' => $label,
        'search_items' =>  'Search '. $labels,
        'all_items' => 'All '.$labels,
        'parent_item' => 'Parent '. $label,
        'parent_item_colon' => 'Parent '. $label .':',
        'edit_item' => 'Edit '. $label,
        'update_item' => 'Update '. $label,
        'add_new_item' => 'Add New '. $label,
        'new_item_name' => 'New '. $label .' Name',
        'menu_name' => $labels,
    );
    return $labels;
}




function stripes_custom_post_type() {
    $labels = array(
        'name'               => __( 'Stripes' ),
        'singular_name'      => __( 'Stripe' ),
        'menu_name'          => __( 'Stripes' ),
        'all_items'          => __( 'All Stripes' ),
        'view_item'          => __( 'View Stripe' ),
        'add_new_item'       => __( 'Add New Stripe' ),
        'add_new'            => __( 'Add New' ),
        'edit_item'          => __( 'Edit Stripe' ),
        'update_item'        => __( 'Update Stripe' ),
        'search_items'       => __( 'Search Stripe' ),
        'not_found'          => __( 'Not Found' ),
        'not_found_in_trash' => __( 'Not found in Trash' )
    );

    $args = array(
        'label'               => __( 'stripes' ),
        'description'         => __( 'Available stripes' ),
        'labels'              => $labels,
        'supports'            => array(
            'title',
            'excerpt',
            'author',
            'revisions',
            'custom-fields'
        ),
        'public'              => false,
        'hierarchical'        => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_icon'           => 'dashicons-list-view',
        'has_archive'         => false,
        'can_export'          => false,
        'exclude_from_search' => false,
        'yarpp_support'       => true,
        'taxonomies'          => array( 'stripes_types' ),
        'publicly_queryable'  => true,
    );
    register_post_type( 'stripes', $args );
}
add_action( 'init', 'stripes_custom_post_type', 0 );
