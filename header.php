<header id="header">
    <div class="title-wrapper">
        <h1>
            <a href="<?php echo home_url(); ?>/"><?php bloginfo( 'name' ); ?></a>
        </h1>
    </div>
    
    <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>

</header>