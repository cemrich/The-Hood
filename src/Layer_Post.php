<?php

abstract class Layer_Post
{
    const LAYER_POST_TYPE = 'thehood_layer';

    public static function init() {
        register_post_type(self::LAYER_POST_TYPE,
            array(
                'labels'                => array(
                    'name'                  => __('Layers', 'textdomain'),
                    'singular_name'         => __('Layer', 'textdomain'),
                ),
                'public'                => true,
                'has_archive'           => false,
                'hierarchical'          => false,
                'rewrite'               => array('slug' => 'layers'),
                'supports'              => array('title', 'custom-fields'),
                'can_export'            => true,
                'capability_type'       => 'post',
                'show_ui'               => true,
                'show_in_menu'          => true,
                'show_in_nav_menus'     => true,
                'show_in_admin_bar'     => true,
                'show_in_rest'          => true,
                'menu_icon'             => 'dashicons-images-alt'
            )
        );
    }

}

add_action('init', ['Layer_Post', 'init']);
