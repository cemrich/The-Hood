<?php

include 'src/settings.php';
include 'src/Location_Meta_Box.php';
include 'src/Location_Post.php';
include 'src/Layer_Meta_Box.php';
include 'src/Layer_Post.php';
include 'src/Nav_Menus.php';
include 'src/Customizer.php';


function add_body_classes($classes) {
    global $is_map_interactable;
    $is_map_interactable = !is_singular() && !is_page();

    if ($is_map_interactable) {
        $classes[] = 'interactable-map';
    }
    return $classes;
}

add_filter('body_class','add_body_classes');


function admin_scripts_and_styles() {
    wp_enqueue_script('admin-scripts', get_template_directory_uri().'/js/admin.js');
    wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
    wp_enqueue_style('leaflet-style', get_template_directory_uri().'/vendor/leaflet/leaflet.css');
    wp_enqueue_script('leaflet-script', get_template_directory_uri().'/vendor/leaflet/leaflet.js', null, false, true);
}


add_action('admin_enqueue_scripts', 'admin_scripts_and_styles');
