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
        'title' => $post->post_title
    ];
endwhile;


$data = (object) [
    'isInteractable' => $is_map_interactable,
    'posts'        => $post_arr,
    'layers'       => $layer_arr,
    'center'       => [49.85672, 8.63896],
    'initialZoom'  => Settings::get_setting( 'initial_zoom_level' )
];

?>


<script type="text/javascript">

    var thehood_data=<?php echo json_encode($data) ?>;

</script>
