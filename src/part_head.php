<?php 

wp_enqueue_style('leaflet-style', get_template_directory_uri().'/vendor/leaflet/leaflet.css');
wp_enqueue_script('leaflet-script', get_template_directory_uri().'/vendor/leaflet/leaflet.js', null, false, true);

wp_enqueue_style('map-style', get_template_directory_uri().'/css/map.css');
wp_enqueue_style('style', get_template_directory_uri().'/style.css');

wp_enqueue_script('script', get_template_directory_uri().'/js/script.js', null, false, true);

?>


<head>
    <title><?php wp_title(); ?></title>

    <style>
        :root {
            --thehood-primary: <?php echo Settings::get_setting( 'color_primary' ) ?>;
            --thehood-primary-dark: <?php echo Settings::get_setting( 'color_primary_dark' ) ?>;
        }
    </style>

    <?php wp_head() ?>

</head>
