<?php

    acf_add_local_field_group(array(
        'key' => 'group_619dc573f3491',
        'title' => 'Meta Keywords',
        'fields' => array(
            array(
                'key' => 'field_619dc57d841d7',
                'label' => 'Keywords',
                'name' => 'meta_keywords',
                'type' => 'text',
                'instructions' => 'יש להפריד בין מילות מפתח באמצעות פסיק.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'course',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
