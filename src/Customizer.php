<?php

abstract class Customizer
{
    public static function register( $wp_customize ) {
        $wp_customize->add_setting( 'color_primary', array(
            'default' => '#006ab6',
            'sanitize_callback' => 'sanitize_hex_color',  
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'refresh'
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_primary', array(
            'label' => __( 'Primärfarbe', 'theme_textdomain' ),
            'section' => 'colors',
        ) ) );

        $wp_customize->add_setting( 'color_primary_dark', array(
            'default' => '#005a87',
            'sanitize_callback' => 'sanitize_hex_color',  
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'refresh'
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_primary_dark', array(
            'label' => __( 'Primärfarbe (Dunkel)', 'theme_textdomain' ),
            'section' => 'colors',
        ) ) );
    }
}

add_action( 'customize_register', [ 'Customizer', 'register' ] );
