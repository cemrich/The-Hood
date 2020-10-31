<?php get_template_part('src/part_head'); ?>

<body <?php body_class(); ?>>

    <?php get_header(); ?>

    <div id="content-area">

        <div id="map"></div>
        
        <div id="main-wrapper">
            <main>
                
                <?php while ( have_posts() ) : the_post(); ?>
                    <article data-post-id="<?php the_ID() ?>">
                        <h2><?php the_title(); ?></h2><a href="#" class="btn-close">X</a>
                        <?php the_content(); ?>
                    </article>
                <?php endwhile; ?>

            </main>
        </div>

    </div>

    <?php get_template_part('src/part_data-script', null, array('is_map_interactable' => $is_map_interactable)); ?>

    <?php wp_footer(); ?>

</body>
