<?php
function get_current_lang(){
    return ICL_LANGUAGE_CODE;
}

function get_langs_json_object(){
    $json = file_get_contents(get_stylesheet_directory().'/langs.json');
    return json_decode($json, true);
}

function cin_get_str($id, $lang = null){
    global $lang_strings;
    if(!$lang) {
        if ($lang = get_current_lang()) {

        } else
            $lang = 'he';
    }
    return $lang_strings[$id][$lang];
}

function cin_get_str_by_lang($id, $lang){
    global $lang_strings;
    return $lang_strings[$id][$lang];
}


function languages_admin_page()
{
    add_menu_page(
        'תרגומים',
        'תרגומים',
        'edit_posts',
        'translate_strings',
        'languages_admin_page_func',
        'dashicons-calendar-alt',
        24
    );
}
add_action('admin_menu', 'languages_admin_page');

function languages_admin_page_func() {
    $strings = get_langs_json_object();

    $languages_list = array(
        'he' => 'עברית',
        'en' => 'אנגלית',
		'ar' => 'ערבית',
    )
    ?>
    <div class="wrap" id="languages_admin_page_wrap">
        <div class="container">
            <h1>עריכת תרגומים</h1>
            <form id="languages_admin_form">
                <table id="languages_table">
                    <thead>
                    <th></th>
                    <?php foreach($languages_list as $lang){
                        echo "<th>$lang</th>";
                    } ?>
                    <th></th>
                    </thead>
                    <tbody>
                    <?php foreach($strings as $id =>$row){
                        echo "<tr data-id='$id'>";
                        echo "<td style='width: 400px;'><input type='text' name='$id-str' data-lang='str' value='{$row['str']}' readonly style='width: 100%; direction: rtl;' /></td>";
                        foreach($languages_list as $lang_id => $lang_name){
                            $value = $row[$lang_id];
                            echo "<td><input type='text' name='$id-$lang_id' data-lang='$lang_id' value='$value' placeholder='טקסט ב$lang_name' /></td>";
                        }
                        echo "<td><button type='button' value='save_row-$id' name='save_row-$id'>שמירת שורה</button></td>";
                        echo "</tr>";
                    } ?>
                    </tbody>
                </table>
                <button type="submit">שמירת הטופס המלא</button>
            </form>
        </div>
    </div>
    <style>
        #languages_table td:nth-child(2), #languages_table td:nth-child(3), #languages_table td:nth-child(4){
            width: 300px;
        }
        #languages_table input{
            width: 100%;
        }
    </style>
    <script>
        jQuery('body').on('click', '#languages_admin_form table button', function(e){
            e.preventDefault();
            var $parent = jQuery(this).closest('tr');
            var id = $parent.attr('data-id');
            var data = [];
            $parent.find('input[type = "text"]').each(function () {
                data.push({name: jQuery(this).attr('data-lang'), value: jQuery(this).val()});
            });

            data.push({name: 'submit', value: id});
            send_lang_form(data);
        });

        jQuery('body').on('submit', '#languages_admin_form', function(e){
            e.preventDefault();
            var $this = jQuery(this);
            var data = $this.serializeArray();
            data.push({name: 'submit', value: 'all'});
            send_lang_form(data);
        });

        function send_lang_form(data) {
            // data.push({'action': 'languages_admin_form_save'});
            data.push({name: 'action', value: 'languages_admin_form_save'});

            jQuery.ajax({
                url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                data: data,
                type: "POST"
            }).done(function (data) {
                if(data)
                    alert('קרתה שגיאה בתהליך השמירה.');
                else
                    alert('השמירה התבצעה בהצלחה.');
            });
        }
    </script>
    <?php
}

function languages_admin_form_save_func() {
    // $data = json_encode($posts);

    if ( $_POST['submit'] == 'all' ) { // שמירת כל הטופס
        unset( $_POST['action'], $_POST['submit'] );

        $arr = array();
        foreach ( $_POST as $row => $value ) {
            $row_arr                           = explode( '-', $row );
            $arr[ $row_arr[0] ][ $row_arr[1] ] = $value;
        }

        $json = json_encode( $arr );
    } else { // שמירת שורה ספציפית
        $id = $_POST['submit'];
        unset( $_POST['action'], $_POST['submit'] );

        $strings        = get_langs_json_object();
        $strings[ $id ] = $_POST;

        $json = json_encode( $strings, JSON_PRETTY_PRINT);
    }
    $save_path = get_stylesheet_directory().'/langs.json';

    $f = @fopen( $save_path , "w" ) or die(print_r(error_get_last(),true));
//    $f = fopen( $save_path, "w" ); //if json file doesn't gets saved, comment this and uncomment the one below
    fwrite( $f, $json );
    fclose( $f );
    die();
}
add_action( 'wp_ajax_languages_admin_form_save', 'languages_admin_form_save_func' );
//add_action( 'wp_ajax_nopriv_languages_admin_form_save', 'languages_admin_form_save_func' );
