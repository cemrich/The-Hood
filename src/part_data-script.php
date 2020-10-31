<?php

$is_map_interactable = $args['is_map_interactable'];

$location_query = new WP_Query( array( 'post_type' => 'thehood_location' ) );
$post_arr = array();

while ( $location_query->have_posts() ) : $location_query->the_post(); 
    $post_meta = get_post_meta($post->ID);
    $post_arr[] = (object) [
        'id' => $post->ID,
        'title' => $post->post_title,
        'content' => $post->post_content,
        'lat' => $post_meta['thehood_meta_pos_lat'][0],
        'lon' => $post_meta['thehood_meta_pos_lon'][0]
    ];
endwhile;

wp_reset_postdata();

$layer_arr = array();
$layer_query = new WP_Query( array( 'post_type' => 'thehood_layer' ) );

while ( $layer_query->have_posts() ) : $layer_query->the_post(); 
    $post_meta = get_post_meta($post->ID);
    $layer_arr[] = (object) [
        'id' => $post->ID,
        'title' => $post->post_title,
        'tileUrl' => $post_meta['thehood_meta_tile_url'][0],
        'attribution' => $post_meta['thehood_meta_attribution'][0],
        'minZoom'  => (int) $post_meta['thehood_meta_zoom_min'][0],
        'maxZoom'  => (int) $post_meta['thehood_meta_zoom_max'][0],
        'boundingBox' => [
            [ (float) $post_meta['thehood_meta_bounding_min_lat'][0], (float) $post_meta['thehood_meta_bounding_min_lon'][0] ],
            [ (float) $post_meta['thehood_meta_bounding_max_lat'][0], (float) $post_meta['thehood_meta_bounding_max_lon'][0] ]
        ]
    ];
endwhile;


$data = (object) [
    'isInteractable' => $is_map_interactable,
    'posts'          => $post_arr,
    'layers'         => $layer_arr,
    'center'         => [ Settings::get_setting( 'map_center_lat' ), Settings::get_setting( 'map_center_lon' ) ],
    'initialZoom'    => Settings::get_setting( 'initial_zoom_level' ),
    'outlineGeoJson' => Settings::get_setting( 'hood_outline_geojson' )
];

?>


<script type="text/javascript">

    var thehood_data=<?php echo json_encode($data) ?>;

</script>
