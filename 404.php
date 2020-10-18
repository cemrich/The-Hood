<?php wp_enqueue_style('style', get_template_directory_uri().'/style.css'); ?>

<head>
    <title><?php wp_title(); ?></title>
    <?php wp_head() ?>
</head>

<body <?php body_class(); ?>>

    <?php get_header(); ?>

    <div id="main-wrapper">
        <main>
            <article>
                <h2>404</h2>
                <p>Die Seite konnte leider nicht gefunden werden.</p>
            </article>
        </main>
    </div>

    <?php wp_footer(); ?>

</body>
