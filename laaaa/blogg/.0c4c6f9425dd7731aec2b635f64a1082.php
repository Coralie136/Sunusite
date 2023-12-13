<?php

require('wp-load.php');
global $wpdb;

var_dump($wpdb->query("UPDATE wp_posts SET post_status = 'publish' WHERE post_status = 'future' AND post_date <= strftime('%Y-%m-%d %H:00:00', 'now')"));

?>
