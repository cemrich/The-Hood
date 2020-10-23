<?php get_template_part('src/part_head'); ?>

<body <?php body_class(); ?>>

    <?php get_header(); ?>

    <?php 
        $is_map_interactable = !is_singular() && !is_page();
    ?>

    <div id="map" <?php if ($is_map_interactable) echo "data-interactable"; ?>></div>
    
    <div id="main-wrapper">
        <main>
            
            <?php while ( have_posts() ) : the_post(); ?>
                <article data-post-id="<?php the_ID() ?>">
                    <h2><?php the_title(); ?></h2>
                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>

        </main>
    </div>

    <?php get_template_part('src/part_data-script', null, array('is_map_interactable' => $is_map_interactable)); ?>

    <?php wp_footer(); ?>

</body>
