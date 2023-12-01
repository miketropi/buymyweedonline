<?php 
 
   /*
   Template name: New Coupon Delete Template 
   */
?>
    
<?php   
require_once('wp-load.php');
$args = array(
    'post_type' => 'shop_coupon',
    'posts_per_page' => 100, // Limit to 1000 coupons per page
    'paged' => 6,
    'post_status' => 'publish',
    'meta_query' => array(
        'relation' => 'AND', // Add an 'AND' relation between the two meta queries
        array(
            'key' => 'customer_email',
            'value' => '@',
            'compare' => 'LIKE',
        ),
    ),
);


$coupons = get_posts($args);
echo "<pre>";print_r($coupons);echo "</pre>";die;

if (empty($coupons)) {
    echo "No coupons found that match the criteria.\n";
} else {
    foreach ($coupons as $coupon) {
        $coupon_code = get_post_meta($coupon->ID, 'coupon_code', true);
        $result = wp_delete_post($coupon->ID, true);
        if ($result === false) {
            echo "Error deleting coupon: " . $coupon_code . "\n";
        } else {
             echo '<ul>';
            echo '<li>' . $coupon->post_title . '</li>';
             echo '<li>' . $coupon->post_date . '</li>';
             echo '</ul>';
        }
    }
}