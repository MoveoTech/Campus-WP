<?php

/*
 * Based on includes/fields/class-acf-courses.php from
 * https://github.com/AdvancedCustomFields/acf by elliotcondon, licensed
 * under GPLv2 or later
 */

// exit if accessed directly
if (!defined('ABSPATH')) {
    exit();
}




class acf_field_courses extends acf_field {


    /*
    *  __construct
    *
    *  This function will setup the field type data
    *
    *  @type	function
    *  @date	5/03/2014
    *  @since	5.0.0
    *
    *  @param	n/a
    *  @return	n/a
    */

    function initialize() {

        // vars
        $this->name = 'relationship-courses';
        $this->label = __("Relationship courses",'acf');
        $this->category = 'relational';
        $this->defaults = array(
            'post_type'			=> array(),
            'min' 				=> 0,
            'max' 				=> 0,
            'filters'			=> array('search'),

        );

        // extra
        add_action('wp_ajax_acf/fields/relationship-courses/query',			array($this, 'ajax_query'));
        add_action('wp_ajax_nopriv_acf/fields/relationship-courses/query',	array($this, 'ajax_query'));

    }


    /*
    *  input_admin_enqueue_scripts
    *
    *  description
    *
    *  @type	function
    *  @date	16/12/2015
    *  @since	5.3.2
    *
    *  @param	$post_id (int)
    *  @return	$post_id (int)
    */




    function input_admin_enqueue_scripts() {

        wp_register_script( 'acf-courses', plugins_url(). '/acf-courses/assets/src/input.js' , array( 'jquery' ), 1.2 );
        wp_enqueue_script('acf-courses');

        // localize
        acf_localize_text(array(
            //'Minimum values reached ( {min} values )'	=> __('Minimum values reached ( {min} values )', 'acf'),
            'Maximum values reached ( {max} values )'	=> __('Maximum values reached ( {max} values )', 'acf'),
            'Loading'									=> __('Loading', 'acf'),
            'No matches found'							=> __('No matches found', 'acf'),
        ));

        do_action( 'acf/register_scripts', 1.0 );

    }




    /*
    *  ajax_query
    *
    *  description
    *
    *  @type	function
    *  @date	24/10/13
    *  @since	5.0.0
    *
    *  @param	$post_id (int)
    *  @return	$post_id (int)
    */

    function ajax_query() {

        // get choices
        $response = $this->get_ajax_query( $_POST );

        // return
        acf_send_ajax_results($response);

    }


    /*
    *  get_ajax_query
    *
    *  This function will return an array of data formatted for use in a select2 AJAX response
    *
    *  @type	function
    *  @date	15/10/2014
    *  @since	5.0.9
    *
    *  @param	$options (array)
    *  @return	(array)
    */

    function get_ajax_query( $options = array() ) {

        // defaults
        $options = wp_parse_args($options, array(
            'post_id'		=> 0,
            's'				=> '',
            'field_key'		=> '',
            'paged'			=> 1,
        ));


        // load field
        $field = acf_get_field( $options['field_key'] );
        if( !$field ) return false;



        $params = array(
            'limit' => 10,
            'page' => intval($options['paged']),
        );

        // search
        if( $options['s'] !== '' ) {
            // strip slashes (search may be integer)
            $s = wp_unslash( strval($options['s']) );

            $params += array(
                'where' => 't.name LIKE "%' . $s .'%"'
            );
        }


        $results = array();

        $CoursesPods = pods( 'courses' );
        $CoursesPods->find($params);

        while ($CoursesPods->fetch()) { // Courses Loop

            $results[] = $this->get_post_result( $CoursesPods->field('id'), $CoursesPods->field('name'));

        }

        // vars
        $response = array(
            'results'	=> $results,
            'limit'		=> 10
        );


        // return
        return $response;

    }


    /*
    *  get_post_result
    *
    *  This function will return an array containing id, text and maybe description data
    *
    *  @type	function
    *  @date	7/07/2016
    *  @since	5.4.0
    *
    *  @param	$id (mixed)
    *  @param	$text (string)
    *  @return	(array)
    */

    function get_post_result( $id, $text ) {

        // vars
        $result = array(
            'id'	=> $id,
            'text'	=> $text
        );


        // return
        return $result;

    }



    /*
    *  render_field()
    *
    *  Create the HTML interface for your field
    *
    *  @param	$field - an array holding all the field's data
    *
    *  @type	action
    *  @since	3.6
    *  @date	23/01/13
    */

    function render_field( $field ) {

        // vars
        $filters = acf_get_array( $field['filters'] );

        // filters
        $filter_count = count($filters);


        // div attributes
        $atts = array(
            'id'				=> $field['id'],
            'class'				=> "acf-relationship {$field['class']}",
            'data-min'			=> $field['min'],
            'data-max'			=> $field['max'],
            'data-s'			=> '',
            'data-paged'		=> 1,
            'data-post_type'	=> '',
        );

        ?>
        <div <?php acf_esc_attr_e($atts); ?>>

            <?php acf_hidden_input( array('name' => $field['name'], 'value' => '') ); ?>

            <?php

            /* filters */
            if( $filter_count ): ?>
                <div class="filters -f<?php echo esc_attr($filter_count); ?>">
                    <?php

                    /* search */
                    if( in_array('search', $filters) ): ?>
                        <div class="filter -search">
                            <?php acf_text_input( array('placeholder' => __("Search...",'acf'), 'data-filter' => 's') ); ?>
                        </div>
                    <?php endif;?>

                </div>
            <?php endif; ?>

            <div class="selection">
                <div class="choices">
                    <ul class="acf-bl list choices-list"></ul>
                </div>
                <div class="values">
                    <ul class="acf-bl list values-list">
                        <?php if( !empty($field['value']) ):

                            $where = "t.id IN (";
                            foreach( $field['value'] as $post_id ) {

                                $where = $where . $post_id . ",";

                            }
                            $where = substr_replace($where, ")", -1);

                            $order = "FIELD(t.id,";
                            foreach( $field['value'] as $post_id ) {
                                $order = $order . $post_id . ",";
                            }
                            $order = substr_replace($order, ")", -1);

                            $params = array(
                                'limit' => -1,
                                'where'=>$where,
                                'orderby'=> $order
                            );
                            $posts = pods( 'courses');
                            $posts->find($params);


                            while ($posts->fetch()) { // Courses Loop ?>

                                <li>
                                    <?php acf_hidden_input( array('name' => $field['name'].'[]', 'value' => $posts->field('id')) ); ?>
                                    <span data-id="<?php echo $posts->field('id'); ?>" class="acf-rel-item">
							        <?php echo acf_esc_html( $posts->field('name') ); ?>
                                        <a href="#" class="acf-icon -minus small dark" data-name="remove_item"></a>
						            </span>
                                </li>
                                <?php
                            }

                        endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }


    /*
    *  render_field_settings()
    *
    *  Create extra options for your field. This is rendered when editing a field.
    *  The value of $field['name'] can be used (like bellow) to save extra data to the $field
    *
    *  @type	action
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$field	- an array holding all the field's data
    */

    function render_field_settings( $field ) {

        // vars
        $field['min'] = empty($field['min']) ? '' : $field['min'];
        $field['max'] = empty($field['max']) ? '' : $field['max'];


        // filters
        acf_render_field_setting( $field, array(
            'label'			=> __('Filters','acf'),
            'instructions'	=> '',
            'type'			=> 'checkbox',
            'name'			=> 'filters',
            'choices'		=> array(
                'search'		=> __("Search",'acf'),
//                'post_type'		=> __("Post Type",'acf'),
            ),
        ));


        // min
        acf_render_field_setting( $field, array(
            'label'			=> __('Minimum posts','acf'),
            'instructions'	=> '',
            'type'			=> 'number',
            'name'			=> 'min',
        ));


        // max
        acf_render_field_setting( $field, array(
            'label'			=> __('Maximum posts','acf'),
            'instructions'	=> '',
            'type'			=> 'number',
            'name'			=> 'max',
        ));

    }


    /*
    *  format_value()
    *
    *  This filter is applied to the $value after it is loaded from the db and before it is returned to the template
    *
    *  @type	filter
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$value (mixed) the value which was loaded from the database
    *  @param	$post_id (mixed) the $post_id from which the value was loaded
    *  @param	$field (array) the field array holding all the field options
    *
    *  @return	$value (mixed) the modified value
    */

    function format_value( $value, $post_id, $field ) {



        // bail early if no value
        if( empty($value) ) {

            return $value;

        }

        // force value to array
        $value = acf_get_array( $value );


        // convert to int
        $value = array_map('intval', $value);


        // return
        return $value;

    }


    /*
    *  validate_value
    *
    *  description
    *
    *  @type	function
    *  @date	11/02/2014
    *  @since	5.0.0
    *
    *  @param	$post_id (int)
    *  @return	$post_id (int)
    */

    function validate_value( $valid, $value, $field, $input ){

        // default
        if( empty($value) || !is_array($value) ) {

            $value = array();

        }


        // min
        if( count($value) < $field['min'] ) {

            $valid = _n( '%s requires at least %s selection', '%s requires at least %s selections', $field['min'], 'acf' );
            $valid = sprintf( $valid, $field['label'], $field['min'] );

        }


        // return
        return $valid;

    }


    /*
    *  update_value()
    *
    *  This filter is applied to the $value before it is updated in the db
    *
    *  @type	filter
    *  @since	3.6
    *  @date	23/01/13
    *
    *  @param	$value - the value which will be saved in the database
    *  @param	$post_id - the $post_id of which the value will be saved
    *  @param	$field - the field array holding all the field options
    *
    *  @return	$value - the modified value
    */

    function update_value( $value, $post_id, $field ) {

//        return $value;
        // Bail early if no value.
        if( empty($value) ) {
            return $value;
        }

        // Format array of values.
        // - ensure each value is an id.
        // - Parse each id as string for SQL LIKE queries.
        if( acf_is_sequential_array($value) ) {
            $value = array_map('acf_idval', $value);
            $value = array_map('strval', $value);

            // Parse single value for id.
        } else {
            $value = acf_idval( $value );
        }

        // Return value.
        return $value;
    }

}




// initialize
new acf_field_courses($this->settings);
?>
