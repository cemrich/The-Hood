<?php

wp_enqueue_style('style', get_template_directory_uri().'/style.css');
wp_enqueue_style('map-style', get_template_directory_uri().'/css/map.css');
//wp_enqueue_script('data', get_template_directory_uri().'/js/data.php');

wp_enqueue_style('leaflet-style', get_template_directory_uri().'/vendor/leaflet/leaflet.css');
wp_enqueue_script('leaflet-script', get_template_directory_uri().'/vendor/leaflet/leaflet.js', null, false, true);

wp_enqueue_script('script', get_template_directory_uri().'/js/script.js', null, false, true);


wp_head();

//get_header();

echo '<div id="map"></div>';

//get_sidebar();
//get_footer();

get_template_part('data-script');

wp_footer();