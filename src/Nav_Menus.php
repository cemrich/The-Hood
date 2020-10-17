<?php

abstract class Nav_Menus
{
    public static function register() {
        register_nav_menus(
            array(
                'header-menu' => __( 'Header Menu' )
            )
        );
    }

}

add_action( 'init', [ 'Nav_Menus', 'register' ] );