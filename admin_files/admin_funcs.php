<?php

function campus_enqueue_admin()
{
    wp_enqueue_style( 'admin_css_campus', get_bloginfo('stylesheet_directory') . '/admin_files/admin_css.css' );
    wp_enqueue_script('admin_js_campus', get_bloginfo('stylesheet_directory') . '/admin_files/admin.js',array(), '1.1');
    wp_enqueue_script('new_admin_js_campus', get_bloginfo('stylesheet_directory') . '/admin_files/newAdmin.js',array(), '1.0');
    wp_localize_script('admin_js_campus', 'admin_vars', array(
            'admin_ajax' => admin_url('admin-ajax.php')
        )
    );
}
add_action( 'admin_enqueue_scripts', 'campus_enqueue_admin' );

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Courses Index Page Settings',
        'menu_slug' 	=> 'courses_index_settings',
        'capability' 	=> 'edit_posts',
        'parent_slug'   => 'edit.php?post_type=course',
        'post_id'       => 'courses_index_settings'
    ));
}

function acf_terms_list_func( $field )
{
    global $sitepress;
    $current_lang = $sitepress->get_current_language();
    $default_lang = $sitepress->get_default_language();
    $sitepress->switch_lang($default_lang);

    echo "<div class='acf_terms_list_wrap'>";
    $val = $field['value'];
    if($val) {
        $obj = json_decode($val);
        $terms = get_terms(array(
            'taxonomy' => $obj->tax,
            'hide_empty' => false
        ));
        $default_options = '';
        if (strpos($field['wrapper']['class'], 'campus_manual_order_filter_items') > -1) {
            // In manual order - the items are in different selects
            foreach ($terms as $term) {
                $id = $term->term_id;
                $name = $term->name;
                $default_options .= "<option value='$id'>$name</option>";
            }

            $index = 1;
            $count = count($obj->items);
            $remove_disabled = $count == 1 ? 'disabled' : '';

            foreach ($obj->items as $item) {
                $output = str_replace("value='$item'", "value='$item' selected", $default_options);
                $select = "<select id='admin_acf_manual_order_select' data-tax='{$obj->tax}'>
                <option>- Select -</option>
                $output
            </select>";
                $disableds = array(
                    'remove' => $remove_disabled,
                    'before' => $index == 1 ? 'disabled' : '',
                    'after' => $index == $count ? 'disabled' : '',
                );
                echo admin_acf_manual_order_html_func($select, $disableds);
                $index++;
            }
        } else {
            // In automatic order - there is only one multiple select field
            foreach ($terms as $term) {
                $id = $term->term_id;
                $name = $term->name;
                $selected = in_array($id, $obj->items) ? 'selected' : '';
                $default_options .= "<option value='$id' $selected>$name</option>";
            }
            echo "<select class='admin_acf_auto_order_select' data-tax='{$obj->tax}' multiple data-bye>
        $default_options
       </select>";
        }
    }else{
        echo "<div style='direction: rtl; text-align: left;'>יש לבחור Taxonomy תחילה</div>";
    }

    echo "</div>";
    $sitepress->switch_lang($current_lang);
}
add_action( 'acf/render_field/name=terms_list', 'acf_terms_list_func', 10, 1 );

function acf_campus_order_academic_institutions_list_func( $field )
{
    global $sitepress;
    $current_lang = $sitepress->get_current_language();
    $default_lang = $sitepress->get_default_language();
    $sitepress->switch_lang($default_lang);

    echo "<div class='acf_terms_list_wrap'>";
    $items = get_posts(array(
        'post_type' => 'academic_institution',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'suppress_filters' => false
    ));
    $default_options = '';
    // In manual order - the items are in different selects
    foreach ($items as $item) {
        $id = $item->ID;
        $name = $item->post_title;
        $default_options .= "<option value='$id'>$name</option>";
    }

    $val = $field['value'];
    if($val) {
        $obj = json_decode($val);
        $index = 1;
        $count = count($obj->items);
        $remove_disabled = $count == 1 ? 'disabled' : '';

        foreach ($obj->items as $item) {
            $output = str_replace("value='$item'", "value='$item' selected", $default_options);
            $select = "<select id='admin_acf_manual_order_select' data-post_type='academic_institution'>
                <option>- Select -</option>
                $output
            </select>";
            $disableds = array(
                'remove' => $remove_disabled,
                'before' => $index == 1 ? 'disabled' : '',
                'after' => $index == $count ? 'disabled' : '',
            );
            echo admin_acf_manual_order_html_func($select, $disableds);
            $index++;
        }
    }else {

        $select = "<select id='admin_acf_manual_order_select' data-post_type='academic_institution'>
                <option>- Select -</option>
                $default_options
            </select>";
        $disableds = array(
            'remove' => 'disabled',
            'before' => 'disabled',
            'after' => 'disabled',
        );
        echo admin_acf_manual_order_html_func($select, $disableds);
    }
    echo "</div>";
    $sitepress->switch_lang($current_lang);
}
add_action( 'acf/render_field/name=campus_order_academic_institutions_list', 'acf_campus_order_academic_institutions_list_func', 10, 1 );


function admin_acf_manual_order_filter_func(){
    global $sitepress;
    $default_lang = $sitepress->get_default_language();
    $sitepress->switch_lang($default_lang);

    $tax = $_POST['tax'];
    $terms = get_terms(array(
        'taxonomy' => $tax,
        'hide_empty' => false
    ));
    $output = '';
    foreach($terms as $term){
        $id = $term->term_id;
        $name = $term->name;
        $output .= "<option value='$id'>$name</option>";
    }
    if($_POST['type'] == 'manual') {
        $select = "<select class='admin_acf_manual_order_select' data-tax='$tax'>
        <option value=''>- Select -</option>
        $output
    </select>";
        $disableds = array(
            'remove' => 'disabled',
            'before' => 'disabled',
            'after' => 'disabled',
        );
        echo admin_acf_manual_order_html_func($select, $disableds);
    }else{

        echo "<select class='admin_acf_auto_order_select' data-tax='$tax' multiple data-hello>
        $output
       </select>";
    }
    die();
}
add_action('wp_ajax_admin_acf_manual_order_filter', 'admin_acf_manual_order_filter_func');

function admin_acf_manual_order_html_func($select, $disableds){
    return "<div class='acf_terms_list_each'>
        <div class='acf_terms_list_select_wrap'>
            $select
        </div>
        <button type='button' class='acf_terms_list_add'>+</button>
        <button type='button' class='acf_terms_list_remove' {$disableds['remove']}>-</button>
        <button type='button' class='acf_terms_list_reorder_before' {$disableds['before']}>up</button>
        <button type='button' class='acf_terms_list_reorder_after' {$disableds['after']}>down</button>
    </div>";
}

add_filter('manage_edit-event_columns', 'post_id_column_title', 1);
add_action( 'manage_event_posts_custom_column', 'post_id_column_content', 10, 2 );
function post_id_column_title($columns) {
    $offset = 3;
    $newArray = array_slice($columns, 0, $offset, true) +
        array('campus_post_id' => 'Event ID') +
        array_slice($columns, $offset, NULL, true);
    return $newArray;
}
function post_id_column_content( $column_name, $post_id ) {
    if ( 'campus_post_id' != $column_name )
        return;
    global $post;
    echo $post->ID;

}

function refresh_site_json_func()
{
    $output_arr = array();
    global $lang_strings;
    $lang_strings = get_langs_json_object();

    global $sitepress, $post;
    $sitepress->switch_lang('he');

    // הכנת מערך של מזהי התגיות בכל השפות כדי לחסוך שליפות חוזרות עבור כל קורס/אירוע
    $all_terms_arr = array();
    $terms = get_terms(array(
        'taxonomy' => 'tag_filter'
    ));
    foreach($terms as $term){
        $en = icl_object_id($term->term_id, 'tag_filter', false,'en');
        $ar = icl_object_id($term->term_id, 'tag_filter', false,'ar');
        $all_terms_arr[$term->term_id] = array(
            'en' => $en,
            'ar' => $ar
        );
    }

//    // הכנת מערך של מוסדות לימודיים
//    $all_orgs_arr = array();
//    $orgs_from_db = get_posts(array(
//        'post_type' => 'academic_institution',
//        'posts_per_page' => -1,
//        'suppress_filters' => false
//    ));
//    foreach($orgs_from_db as $he_org_obj){
//        $id = $he_org_obj->ID;
//        $en = icl_object_id($id, 'academic_institution', false,'en');
//        $ar = icl_object_id($id, 'academic_institution', false,'ar');
//
//        $all_orgs_arr[$id]['he'] = $he_org_obj;
//        $all_orgs_arr[$id]['en'] = $en ? get_post($en) : $he_org_obj;
//        $all_orgs_arr[$id]['ar'] = $en ? get_post($ar) : $he_org_obj;
//    }
//
//    // הכנת מערך של תגיות מרקטינג
//    $all_marketing_arr = array();
//    $terms = get_terms(array(
//        'taxonomy' => 'marketing'
//    ));
//    foreach($terms as $term){
//        $en = icl_object_id($term->term_id, 'marketing', false,'en');
//        $ar = icl_object_id($term->term_id, 'marketing', false,'ar');
//        $all_marketing_arr[$term->term_id] = array(
//            'he' => $term->term_id,
//            'en' => $en,
//            'ar' => $ar
//        );
//    }

    $args = array(
        'post_type' => array('course', 'event'),
        'posts_per_page' => -1,
        'exclude_hidden_courses' => true,
        'orderby' => 'menu_order',
        'order' => 'DESC',
        'post_status' => 'publish'
    );
    $posts = new WP_Query($args);

//    print_r($posts);

    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();


            // Item Date
            $end_date = get_field('enrollment_end');
            $end_date = $end_date ? get_course_strtotime($end_date) : '';

            // Item tags
            $terms_tags_filter = wp_get_post_terms($post->ID, 'tag_filter', array('fields' => 'ids'));
            $str_he = $str_en = $str_ar = ',all,';
            foreach ($terms_tags_filter as $tag) {
                $str_he .= $tag . ',';
                $str_en .= $all_terms_arr[$tag]['en'] .',';
                $str_ar .= $all_terms_arr[$tag]['ar'] .',';
            }

//            $post = get_post($post->ID);
//            setup_postdata($post);
//
//            $func_name = 'draw_'. $post->post_type .'_item';
//
//            $org = get_field('org');
//            $marketing_feature = get_field('marketing_feature');
//
//            $htmls = array();
//            foreach(array('ar', 'en', 'he') as $lang){
//                $field = 'str_'. $lang;
//                $attrs = array(
//                    'filters' => 'data-filter="' . $$field . '" data-org="'. $org->ID .'" data-lang="'. $lang .'" ',
//                    'class' => ' ',
//                    'org' => $all_orgs_arr[$org->ID][$lang],
//                    'marketing' => $all_marketing_arr[$marketing_feature->term_id][$lang]
//                );
//                $sitepress->switch_lang($lang);
//                $htmls[$lang] = $func_name($attrs);
//            }


            $my_arr = array(
                'ID' => $post->ID,
                'post_type' => $post->post_type,
                'enrollment_end' => $end_date,
                'tags' => array(
                    'he' => $str_he,
                    'en' => $str_en,
                    'ar' => $str_ar,
                ),
//                'html' => $htmls
            );
            $output_arr[$post->ID] = $my_arr;
        }
    }
    $json_output = json_encode($output_arr);

    $upload_dir = wp_get_upload_dir(); // set to save in the /wp-content/uploads folder
    $path = $upload_dir['basedir'];
    $new_json_path = $path . '/courses_json.json';

    // Save the old JSON with suffix before save the new JSON
    rename ($new_json_path, $new_json_path. '.back');

    // Save the new JSON in the old name
    $f = fopen($new_json_path, "w"); //if json file doesn't gets saved, comment this and uncomment the one below
    fwrite($f, $json_output);
    fclose($f);

    echo 'done';
    die();
}
add_action( 'wp_ajax_refresh_site_json', 'refresh_site_json_func' );


/* Your code to add menu on admin bar */

add_action('admin_bar_menu', 'add_item', 100);

function add_item( $admin_bar ){
    global $pagenow;
    if(is_admin())
        $admin_bar->add_menu( array( 'id'=>'recreate_json','title'=>'<span style="direction: rtl; display: inline-block;">ריענון JSON קורסים</span>','href'=>'#' ) );
}

/* Here you trigger the ajax handler function using jQuery */

add_action( 'admin_footer', 'cache_purge_action_js' );

function cache_purge_action_js() { ?>
    <script type="text/javascript" >
        jQuery("li#wp-admin-bar-recreate_json .ab-item").on( "click", function(e) {
            e.preventDefault();
            if(window.confirm('האם ברצונך לבצע ריענון של JSON הקורסים?')) {
                var data = {
                    'action': 'refresh_site_json',
                };

                /* since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php */
                jQuery.ajax({
                    url: ajaxurl,
                    data: data,
                    method: 'POST'
                }).done(function (response) {
                    alert(response);
                }).fail(function(response, errorCode, errorMsg){
                    console.log(errorMsg);
                    alert('אירעה שגיאה - ' + errorCode + '. ראו בקונסול את פירוט השגיאה');
                });
            }
        });
    </script> <?php
}

function pods_RELPODNAME_pick_data($data, $name, $value, $options, $pod, $id){
    if ($name == "pods_field_tags" || $name == "pods_field_marketing_tags") {
        foreach ($data as $dataid => &$value) {
            if($dataid){
                $p = pods('tags', $dataid);
                $name = $p->display('name');
                $relfield = $p->display('group');
                $single = $p->display('single_multiple');

                if($single == 'Single')
                    $value = $name . ' - ' . $relfield;
                else
                    $value = $name;

            }
        }
    }
    return $data;
}

add_filter('pods_field_pick_data', 'pods_RELPODNAME_pick_data', 1, 6);


function pods_import_files(){

    // parameters - page title, menu title, capability, slog, function that comunicate with that function, icon, position in the menu
    add_menu_page('Import Courses', 'Import Courses', 'administrator', 'pods_import_files', 'import_courses_file', '', 60);

//    add_submenu_page('lapizzeria_options', 'Reservations', 'Reservations', 'administrator' , 'lapizzeria_reservation','lapizzeria_reservation' );
}
add_action('admin_menu','pods_import_files');

function import_courses_settings(){

    // Google maps group
    register_setting('import_courses_file','import_file');
//    register_setting('import_courses_file','lapizzeria_gmap_longitude');
//    register_setting('import_courses_file','lapizzeria_gmap_zoom');
//    register_setting('import_courses_file','lapizzeria_gmap_apikey');

    //Information group
//    register_setting('lapizzeria_options_info', 'lapizzeria_location');
//    register_setting('lapizzeria_options_info', 'lapizzeria_phonenumber');


}
add_action('init','import_courses_settings');

function import_courses_file() {
    if ( empty( $_FILES ) ){
        ?>
        <div>
            <h2>Upload a csv file here to import categories</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('csv-import'); ?>

                <label for="file">Filename:</label>
                <input type="file" name="file" id="file"><br>
                <input type="submit" name="save" value="save">
            </form>
        </div>
    <?php }
    else{
        if ( ! function_exists( 'wp_handle_upload' ) )
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        $uploadedfile = $_FILES['file'];
        $upload_overrides = array( 'test_form' => false );
        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
        if ( $movefile ) {
            echo "File is valid, and was successfully uploaded.\n";
//var_dump($movefile['file']);
//            $csv = array_map('str_getcsv', file( $movefile['file'] ) );
            my_import_csv($movefile['file']);
            // the file should be a csv of categories.
//            $cnt =0;
//            foreach($csv as $row){
//                $my_cat = array('cat_name' => $row[0], 'category_description' => $row[1], 'category_nicename' => $row[2], 'category_parent' => '');
//                // Create the category
//                $my_cat_id = wp_insert_category($my_cat);
//
//                if($my_cat_id > 0)
//                    $cnt++;
//            }

//            echo "$cnt categories added";

            // here you can do some stuff with this
        } else {
            echo "Possible file upload attack!\n";
        }
    }
}

//function import_courses_file(){
//    if ( empty( $_FILES ) ){
//        ?>
<!--        <div>-->
<!--            <h2>Upload a file here</h2>-->
<!--            <form action="" method="post" enctype="multipart/form-data">-->
<!--                --><?php //wp_nonce_field('csv-import'); ?>
<!---->
<!--                <label for="file">Filename:</label>-->
<!--                <input type="file" name="file" id="file"><br>-->
<!--                <input type="submit" name="save" value="save">-->
<!--            </form>-->
<!--        </div>-->
<!--    --><?php //}
//    else{
//        if ( ! function_exists( 'wp_handle_upload' ) )
//            require_once( ABSPATH . 'wp-admin/includes/file.php' );
//        $uploadedfile = $_FILES['file'];
//        $upload_overrides = array( 'test_form' => false );
//        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
//        if ( $movefile ) {
//            var_dump( $movefile );
//            echo "File is valid, and was successfully uploaded.\n";
//
//            var_dump( $uploadedfile );
//            my_import_csv($uploadedfile);
//            // here you can do some stuff with this
//        } else {
//            echo "Possible file upload attack!\n";
//        }
//    }
//}



//function import_courses_file(){  ?>
<!--    <div>-->
<!--        <h1>Import</h1>-->
<!--    <form action="" enctype="multipart/form-data" method="post">-->
<!---->
<!--        --><?php
//    settings_fields('import_courses_file');
//    do_settings_sections('import_courses_file');
////        $file = include  'pods_export_test.csv';
////        my_import_csv($file);
//
//  ?>
<!---->
<!--    <input type="file" name='import_file' id='import_file' value="--><?php //echo esc_attr(get_option('import_file')); ?><!--" >-->
<!--<input type="submit" name="action" value="submit_content">-->
<!---->
<!--    </form>-->
<!--    </div>-->
<!---->
<?php
//
//}

//add_action( 'wp_ajax_nopriv_submit_content', 'my_submission_processor' );
//add_action( 'wp_ajax_submit_content', 'my_submission_processor' );

//function my_submission_processor(){
//    console_log("hola");
//    console_log($_POST);
//}
/**
 * Import CSV example for Pods
 *
 *
 * @param string $file File location
 *
 *
 * @return true|WP_Error Returns true on success, WP_Error if there was a problem
 */

//$file = include 'pods_export_test.csv';
//console_log($file);
function my_import_csv($file)
{

//    if (!is_readable($file)) {
//        return new WP_Error('', sprintf('Can\'t read file: %', $file));
//    }
//    var_dump($file);
    if (!function_exists('pods_migrate')) {
        return new WP_Error('', 'pods_migrate function not found');
    }
    /**
     * @var $migrate \PodsMigrate
     */
    $migrate = pods_migrate();
    $contents = file_get_contents($file);

    $parsed_data = $migrate->parse_sv($file, ',');
    $pod = pods('courses'); // @todo Update to your pod name

    if (!empty($parsed_data['items'])) {
        $total_found = count($parsed_data['items']);

//        console_log($parsed_data['items']);
        foreach ($parsed_data['items'] as $row) {

            // Do what you want with $row
            // $row has the column names from the first row of the CSV
            // Example: $row['column heading 1']
            // Example: $row['user_email']
            $data = array(
                'some_field' => $row['some_field'],
            );
            $new_item_id = $pod->add($data);
        }
    } else {
        return new WP_Error('', 'No items to import.');
    }
    return true;
}

$data = PodsMigrate::get_data_from_file( $assoc_args['csv-path'] );
