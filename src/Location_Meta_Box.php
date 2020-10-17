<?php

abstract class Location_Meta_Box
{
    const NONCE_FIELD_NAME = 'thehood_location_box_nonce';
    const NONCE_UPDATE_ACTION = 'thehood_location_box_nonce_action_update';

    public static function add() {
        add_meta_box(
            'thehood_location_box_id',
            'Location',
            [self::class, 'html'],
            'thehood_location'
        );
    }

    public static function save($post_id)
    {
        $post = get_post( $post_id );

        // check current use permissions
        $post_type = get_post_type_object( $post->post_type );
        
        if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
            return $post_id;
        }

        // Do not save the data if autosave
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( !isset( $_POST[self::NONCE_FIELD_NAME] ) || 
            !wp_verify_nonce( $_POST[self::NONCE_FIELD_NAME], self::NONCE_UPDATE_ACTION ) 
        ) {
            return $post_id;
        }

        if (array_key_exists('thehood_meta_pos_lat', $_POST)) {
            update_post_meta(
                $post_id,
                'thehood_meta_pos_lat',
                sanitize_text_field($_POST['thehood_meta_pos_lat'])
            );
        }
        if (array_key_exists('thehood_meta_pos_lon', $_POST)) {
            update_post_meta(
                $post_id,
                'thehood_meta_pos_lon',
                sanitize_text_field($_POST['thehood_meta_pos_lon'])
            );
        }
    }

    public static function html($post)
    {
        $lat = get_post_meta($post->ID, 'thehood_meta_pos_lat', true);
        $lon = get_post_meta($post->ID, 'thehood_meta_pos_lon', true);

        // TODO: hide fields and use map as input

        echo wp_nonce_field( self::NONCE_UPDATE_ACTION, self::NONCE_FIELD_NAME ) .
            '<div id="thehood_meta_pos_map"></div>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="thehood_meta_pos_lat">Latitude</label></th>
                        <td><input type="text" id="thehood_meta_pos_lat" name="thehood_meta_pos_lat" value="' . esc_attr($lat) . '" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="thehood_meta_pos_lon">Longitude</label></th>
                        <td><input type="text" id="thehood_meta_pos_lon" name="thehood_meta_pos_lon" value="' . esc_attr($lon) . '" class="regular-text"></td>
                    </tr>
                </tbody>
            </table>';
    }

}

add_action('add_meta_boxes', ['Location_Meta_Box', 'add']);
add_action('save_post', ['Location_Meta_Box', 'save']);
