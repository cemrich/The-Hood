<?php get_template_part('src/part_head'); ?>

<body <?php body_class(); ?>>

    <?php get_header(); ?>

    <div id="map"></div>

    <?php get_template_part('src/part_data-script'); ?>
    <?php wp_footer(); ?>

</body>
