<?php

abstract class Settings
{
    private static $defaults = array(
        'initial_zoom_level' => 17,
        'color_primary'      => '#006ab6',
        'color_primary_dark' => '#005a87',
        'map_center_lat' => 49.85672,
        'map_center_lon' => 8.63896,
    );

    public static function get_default( $key ) {
        return isset( self::$defaults[$key] ) ? self::$defaults[$key] : false;
    }

    public static function get_setting( $key ) {
        return get_theme_mod( $key, self::get_default( $key ) );
    }
}