<?php

$arr = array();

while ( have_posts() ) : the_post(); 
    $post_meta = get_post_meta($post->ID);
    $arr[] = (object) [
        'id' => $post->ID,
        'title' => $post->post_title,
        'content' => $post->post_content,
        'lat' => $post_meta['thehood_meta_pos_lat'][0],
        'lon' => $post_meta['thehood_meta_pos_lon'][0]
    ];
endwhile; 

?>


<script type="text/javascript">

    var thehood_data=<?php echo json_encode($arr) ?>;

</script>
