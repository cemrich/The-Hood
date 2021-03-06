<?php

abstract class Location_Post
{
    const LOCATION_POST_TYPE = 'thehood_location';

    public static function init() {
        register_post_type(self::LOCATION_POST_TYPE,
            array(
                'labels'                => array(
                    'name'                  => __('Locations', 'textdomain'),
                    'singular_name'         => __('Location', 'textdomain'),
                ),
                'public'                => true,
                'has_archive'           => false,
                'hierarchical'          => false,
                'rewrite'               => array('slug' => 'locations'),
                'supports'              => array('title', 'editor', 'revisions', 'custom-fields'),
                'can_export'            => true,
                'capability_type'       => self::LOCATION_POST_TYPE,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'show_in_nav_menus'     => true,
                'show_in_admin_bar'     => true,
                'show_in_rest'          => true,
                'menu_icon'             => 'dashicons-location',
                'taxonomies'            => array('category'),
                'map_meta_cap'          => true
            )
        );
    }
    
    public static function alterQuery($query) {
        if ( !is_admin() && is_category() &&  $query->is_main_query() ) {
            $types = get_taxonomy( 'category' )->object_type;
            $query->set( 'post_type', $types );
        }

        if ( is_home() && $query->is_main_query() ) {
            $query->set( 'post_type', array( self::LOCATION_POST_TYPE ) );
        }

        return $query;
    }

}

add_action('init', ['Location_Post', 'init']);
add_action('pre_get_posts', ['Location_Post', 'alterQuery']);
