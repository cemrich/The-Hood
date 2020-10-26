<?php

abstract class Layer_Meta_Box
{
    const NONCE_FIELD_NAME = 'thehood_layer_box_nonce';
    const NONCE_UPDATE_ACTION = 'thehood_layer_box_nonce_action_update';

    public static function add() {
        add_meta_box(
            'thehood_layer_tiles_box_id',
            'Tiles',
            [self::class, 'html_tiles_box'],
            'thehood_layer'
        );
        add_meta_box(
            'thehood_layer_zoom_box_id',
            'Supported Zoom Levels',
            [self::class, 'html_zoom_box'],
            'thehood_layer'
        );
        add_meta_box(
            'thehood_layer_bounding_box_id',
            'Bounding Box',
            [self::class, 'html_bounding_box'],
            'thehood_layer'
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

        if (array_key_exists('thehood_meta_attribution', $_POST)) {
            update_post_meta(
                $post_id,
                'thehood_meta_attribution',
                self::sanitize_html($_POST['thehood_meta_attribution'])
            );
        }
        if (array_key_exists('thehood_meta_tile_url', $_POST)) {
            update_post_meta(
                $post_id,
                'thehood_meta_tile_url',
                sanitize_text_field($_POST['thehood_meta_tile_url'])
            );
        }
        if (array_key_exists('thehood_meta_zoom_min', $_POST)) {
            update_post_meta(
                $post_id,
                'thehood_meta_zoom_min',
                absint($_POST['thehood_meta_zoom_min'])
            );
        }
        if (array_key_exists('thehood_meta_zoom_max', $_POST)) {
            $max_zoom = absint($_POST['thehood_meta_zoom_max']);
            $max_zoom = $max_zoom == 0 ? 18 : $max_zoom;
            update_post_meta(
                $post_id,
                'thehood_meta_zoom_max',
                $max_zoom
            );
        }

        $boundingBox = [
            'thehood_meta_bounding_min_lat',
            'thehood_meta_bounding_min_lon',
            'thehood_meta_bounding_max_lat',
            'thehood_meta_bounding_max_lon'
        ];
        foreach ( $boundingBox as $key ) {
            if (array_key_exists($key, $_POST)) {
                update_post_meta(
                    $post_id,
                    $key,
                    (float) $_POST[$key]
                );
            }
        }
    }

    public static function sanitize_html( $input ) {
        $allowed_html = array(
            'a' => array(
                'href' => array(),
            )
        );
        return wp_kses( $input, $allowed_html );
    }

    public static function html_tiles_box($post)
    {
        $attribution = get_post_meta($post->ID, 'thehood_meta_attribution', true);
        $tile_url = get_post_meta($post->ID, 'thehood_meta_tile_url', true);

        echo wp_nonce_field( self::NONCE_UPDATE_ACTION, self::NONCE_FIELD_NAME ) .
            '<table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="thehood_meta_tile_url">Tile Url</label></th>
                        <td colspan="3"><input type="text" id="thehood_meta_tile_url" name="thehood_meta_tile_url" value="' . esc_attr($tile_url) . '"></td>
                    </tr>
                    <tr>
                        <th><label for="thehood_meta_attribution">Attribution</label></th>
                        <td colspan="3"><input type="text" id="thehood_meta_attribution" name="thehood_meta_attribution" value="' . esc_attr($attribution) . '"></td>
                    </tr>
                </tbody>
            </table>';
    }

    public static function html_zoom_box($post)
    {
        $min_zoom = (int) get_post_meta($post->ID, 'thehood_meta_zoom_min', true);
        $max_zoom = (int) get_post_meta($post->ID, 'thehood_meta_zoom_max', true);
        $max_zoom = $max_zoom == 0 ? 18 : $max_zoom;

        echo wp_nonce_field( self::NONCE_UPDATE_ACTION, self::NONCE_FIELD_NAME ) .
            '<table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="thehood_meta_zoom_min">Minimum</label></th>
                        <td><input type="number" id="thehood_meta_zoom_min" name="thehood_meta_zoom_min" min="0" max="18" value="' . esc_attr($min_zoom) . '"></td>
                        <th><label for="thehood_meta_zoom_max">Maximum</label></th>
                        <td><input type="number" id="thehood_meta_zoom_max" name="thehood_meta_zoom_max" min="0" max="18" value="' . esc_attr($max_zoom) . '"></td>
                    </tr>
                </tbody>
            </table>';
    }

    public static function html_bounding_box($post)
    {
        $bounding_min_lat = (float) get_post_meta($post->ID, 'thehood_meta_bounding_min_lat', true);
        $bounding_min_lon = (float) get_post_meta($post->ID, 'thehood_meta_bounding_min_lon', true);
        $bounding_max_lat = (float) get_post_meta($post->ID, 'thehood_meta_bounding_max_lat', true);
        $bounding_max_lon = (float) get_post_meta($post->ID, 'thehood_meta_bounding_max_lon', true);
       
        echo wp_nonce_field( self::NONCE_UPDATE_ACTION, self::NONCE_FIELD_NAME ) .
            '<table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="thehood_meta_bounding_min_lat">Minimum Latitude</label></th>
                        <td><input type="number" id="thehood_meta_bounding_min_lat" name="thehood_meta_bounding_min_lat" step="any"value="' . esc_attr($bounding_min_lat) . '"></td>
                        <th><label for="thehood_meta_bounding_min_lon">Minimum Longitude</label></th>
                        <td><input type="number" id="thehood_meta_bounding_min_lon" name="thehood_meta_bounding_min_lon" step="any"value="' . esc_attr($bounding_min_lon) . '"></td>
                    </tr>
                    <tr>
                        <th><label for="thehood_meta_bounding_max_lat">Maximum Latitude</label></th>
                        <td><input type="number" id="thehood_meta_bounding_max_lat" name="thehood_meta_bounding_max_lat" step="any"value="' . esc_attr($bounding_max_lat) . '"></td>
                        <th><label for="thehood_meta_bounding_max_lon">Maximum Longitude</label></th>
                        <td><input type="number" id="thehood_meta_bounding_max_lon" name="thehood_meta_bounding_max_lon" step="any"value="' . esc_attr($bounding_max_lon) . '"></td>
                    </tr>
                </tbody>
            </table>';
    }

}

add_action('add_meta_boxes', ['Layer_Meta_Box', 'add']);
add_action('save_post', ['Layer_Meta_Box', 'save']);
