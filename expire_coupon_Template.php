<?php 
 
   /*
   Template name: Expired Coupon Template 
   */
?>
    
<?php   
require_once('wp-load.php');
$args = array(
    'post_type' => 'shop_coupon',
    'posts_per_page' => 250, // Limit to 1000 coupons per page
    'paged' => 4, // Start on page 1
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key' => 'date_expires',
            'value' => current_time('mysql'),
            'compare' => '<',
            'type' => 'DATETIME'
        )
    )
);

$deleted_coupons = array(); // Array to store deleted coupons

$coupons = get_posts($args);

foreach ($coupons as $coupon) {
    if (wp_delete_post($coupon->ID, true)) { // If post is successfully deleted
        $deleted_coupons[] = $coupon->ID; // Add post ID to deleted coupons array
    }
}

// Display list of deleted coupons
if (!empty($deleted_coupons)) {
    echo '<ul>';
    foreach ($deleted_coupons as $coupon_id) {
        echo '<li>' . $coupon->post_title . '</li>';
    }
    echo '</ul>';
} else {
    echo 'No coupons deleted.';
}