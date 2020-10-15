<?php

// TODO: display only posts from loaded page
$args = array( 
    'post_type' => 'thehood_location', 
    'post_status' => 'publish', 
    'nopaging' => true 
);
$query = new WP_Query($args);
$posts = $query->get_posts();

$arr = array();

foreach ($posts as $post) {
    $post_meta = get_post_meta($post->ID);
    $arr[] = (object) [
        'id' => $post->ID,
        'content' => $post->post_content,
        'lat' => $post_meta['thehood_meta_pos_lat'][0],
        'lon' => $post_meta['thehood_meta_pos_lon'][0]
    ];
}

?>


<script type="text/javascript">

    var thehood_data=<?php echo json_encode($arr) ?>;

</script>
