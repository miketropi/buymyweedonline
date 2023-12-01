<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
    <?php
if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<div class="breadcrumb">', '</div>');
}
?>
<header class="woocommerce-products-header">
    
    <div class="woocommerce-products-header-main">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>
</div>

<?php
$term = get_queried_object();        
$taxonomy_id = get_queried_object_id(); ?>
 <h2 class="faqblock-sub-category"><?php echo get_field('sub_category _title', $term);?></h2>  
<?php
$sub_category_tabs = 'sub_category_tabs';
$category_tabs_post_meta = get_term_meta($taxonomy_id, $sub_category_tabs, true);
$category_tabs_count = intval(get_term_meta($taxonomy_id, $sub_category_tabs, true));
if($category_tabs_count){?>
 <div class="sub_category_tabs">
    <?php
    for ($i=0; $i<$category_tabs_count; $i++) {
      $sub_value3 = get_term_meta($taxonomy_id, $sub_category_tabs.'_'.$i.'_'.'sub_category_name', true);
      $sub_answer3 = get_term_meta($taxonomy_id, $sub_category_tabs.'_'.$i.'_'.'sub_category_link', true);
   ?>
  	<a class="faq-heading" href="<?php echo $sub_answer3;?>"><?php echo $sub_value3;?></a>
   <?php
    }?>
   </div>         
<?php
 }
?>     
   
 <h2 class="faqblock-sub-category"><?php echo get_field('sub_category _title_cannabis', $term);?></h2>  
<?php
$sub_category_tabs_cannabis = 'sub_category_tabs_cannabis';
$category_tabs_cannabis_post_meta = get_term_meta($taxonomy_id, $sub_category_tabs_cannabis, true);
$category_tabs_cannabis_count = intval(get_term_meta($taxonomy_id, $sub_category_tabs_cannabis, true));
if($category_tabs_cannabis_count){?>
 <div class="sub_category_tabs">
    <?php
    for ($i=0; $i<$category_tabs_cannabis_count; $i++) {
      $sub_value2 = get_term_meta($taxonomy_id, $sub_category_tabs_cannabis.'_'.$i.'_'.'sub_category_name_cannabis', true);
      $sub_answer2 = get_term_meta($taxonomy_id, $sub_category_tabs_cannabis.'_'.$i.'_'.'sub_category_link_cannabis', true);
   ?>
  	<a class="faq-heading" href="<?php echo $sub_answer2;?>"><?php echo $sub_value2;?></a>
   <?php
    }?>
   </div>         
<?php
 }
?>       
    
        
	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
        <a href="https://buymyweedonline.cc/#home-Reviews-slider-section" class="home-Reviews-slider-category-page"><span class="Reviews-slider-category-span"><span class="rating-value">4.8</span><img style="margin-right:5px" src="/wp-content/uploads/2023/03/five-star.png" alt="star1" width="93" height="19"><span class="Reviews-slider-category-span2">Reviewed by <span  class="Reviews-slider-category-span3">thousands</span> of happy customers</span></span></a>
        
        
        
  <?php
$term = get_queried_object();

$is_true = get_field('best-sellers', $term);
if ($is_true) {

    $featured_posts = get_field('choose_product_section', $term);

    if ($featured_posts): ?>
        <div class="best_product_section_cat">
            <h2><?php echo get_field('best_selling_title', $term); ?></h2>
            <ul class="products columns-4 choose_product_section">
                <?php
                foreach ($featured_posts as $featured_post):
                    $permalink = get_permalink($featured_post);
                    $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($featured_post), 'single-post-thumbnail');
                    $title = get_the_title($featured_post);

                    // Check if the product is in stock
                   $stock_status = get_post_meta($featured_post, '_stock_status', true);
					 //var_dump($in_stock); // Debugging statement
                    if ($stock_status === 'instock'): ?>
                        <li class="best-sellers-products">
                            <a href="<?php echo esc_url($permalink); ?>">
                                <img src="<?php echo $image_url[0]; ?>" alt="Product Image">
                                <h3><?php echo esc_html($title); ?></h3>
                            </a>
                        </li>
                    <?php endif;
                endforeach; ?>
            </ul>
        </div>
    <?php endif;
}

    ?>          
        
</header>
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
		
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product' );


		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

?>
    
    
<?php
$taxonomy_id = get_queried_object_id(); 
$repeater = 'category_frequently_asked';
$post_meta = get_term_meta($taxonomy_id, $repeater, true);  
$count = intval(get_term_meta($taxonomy_id, $repeater, true));
if($count){
?>
 <div class="frequent-questions">
     <h2 class="faqblock"><?php echo get_field('faq_title', $term);?></h2> 
     <div class="Questions-heading">
  
    <div class="after-cart-btn"><img src="/wp-content/uploads/2023/04/lock-12.png" width="17" height="17" alt="lock-12-2"><span>your safety is our priority</span></div>
    <div class="frequent-icon">
    <img src="/wp-content/uploads/2017/01/canadapost-icon-300x300.png" width="80" height="80" alt="adv1">
    <img src="/wp-content/uploads/2017/01/interac-email-transfer-logo-1-300x300.png" width="80" height="80" alt="adv2">
    </div>
    </div>  
<div class="faqs-block et_pb_row">

<?php
    for ($i=0; $i<$count; $i++) {
      $sub_value = apply_filters('the_content', get_term_meta($taxonomy_id, $repeater.'_'.$i.'_'.'question', true));
      $sub_answer = apply_filters('the_content', get_term_meta($taxonomy_id, $repeater.'_'.$i.'_'.'answer', true));
    ?>
  		<h3 class="faq-heading"><?php echo $sub_value;?></h3>
         <div class="faq-desc">
			<p><?php echo $sub_answer;?></p>
  		</div>
         <?php }?>
     </div>
</div>
   <?php }?>
 <?php
   
     if ( function_exists( 'is_shop' ) && is_shop() ) {?>
         
     <div class="frequent-questions">
        <h2 class="faqblock">FAQs about Shop Page</h2>
     <div class="Questions-heading">
   
    <div class="after-cart-btn"><img src="/wp-content/uploads/2023/04/lock-12.png" width="17" height="17" alt="lock-12-2"><span>your safety is our priority</span></div>
    <div class="frequent-icon">
    <img src="/wp-content/uploads/2017/01/canadapost-icon-300x300.png" width="80" height="80" alt="adv1">
    <img src="/wp-content/uploads/2017/01/interac-email-transfer-logo-1-300x300.png" width="80" height="80" alt="adv2">
    </div>
    </div>
 <div class="faqs-block et_pb_row">
<h3 class="faq-heading">How do I become a member?</h3>
<div class="faq-desc"><p>Becoming a member is free and easy. All you have to do is prove you are over the age of 19 and that you live in Canada. <a href="/my-account/">Register now for free!</a></p></div>

<h3 class="faq-heading">How can I order?</h3>
<div class="faq-desc"><p><Sign up for a free account and then place your order online. Alternatively, you can send us an email or talk to us on live chat. Our live chat is 24/7/365 and we will be happy to help you fulfill your order.&nbsp;<a href="/how-to-order/">Click here</a> for a video and step by step details on how to order.</p></div>

<h3 class="faq-heading">Who is eligible to purchase on your site?</h3>
<div class="faq-desc"><p>Only qualified clients over the age of 19 who live in Canada are able to purchase medical marijuana through our site. There are absolutely no exceptions to this rule.</p></div>

<h3 class="faq-heading">How can I trust you?</h3>
<div class="faq-desc"><p>While there are a number of scammers on the internet who claim to sell legal weed, we can assure you we aren’t one of them. We have spent years building a solid reputation amongst medical patients and strongly support the use of medical marijuana. We understand the needs of medical patients that may have trouble purchasing their medicine from a dispensary for any number of reasons and believe they shouldn’t be forced to have to buy illegally on the streets. We have made the decision to offer full access to our site to medical patients in Canada so they may have safe access to their medicine at any time.</p></div>

<div class="clear"></div>
</div>
  
</div> 
    <?php
} 
 echo do_shortcode('[bottom_signup_newsletter]');

get_footer( 'shop' );
?>
    
 <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [<?php
   $taxonomy_id = get_queried_object_id(); 
	$repeater = 'category_frequently_asked';
	$post_meta = get_term_meta($taxonomy_id, $repeater, true);  
	$count = intval(get_term_meta($taxonomy_id, $repeater, true));
     for ($i=0; $i<$count; $i++) {
      $sub_value = apply_filters('the_content', get_term_meta($taxonomy_id, $repeater.'_'.$i.'_'.'question', true));
      $sub_answer = apply_filters('the_content', get_term_meta($taxonomy_id, $repeater.'_'.$i.'_'.'answer', true));
    ?>
    
        {
          "@type": "Question",
          "name": "<?php echo $sub_value; ?>",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<?php echo $sub_answer; ?>"
          }
        }<?php } ?>
        
  ]
}
</script>