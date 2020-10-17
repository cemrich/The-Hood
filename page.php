<?php get_template_part('src/part_head'); ?>

<body <?php body_class(); ?>>

    <?php get_header(); ?>

    <div id="map"></div>
 
    <div id="main-wrapper">
        <main>

            
            <?php while ( have_posts() ) : the_post(); ?>
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
                <?php endwhile; ?>

        </main>
    </div>

    <?php wp_footer(); ?>
    
    

</body>
