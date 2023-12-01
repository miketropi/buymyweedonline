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
echo yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );

?>
<header class="woocommerce-products-header">
    
    <div class="woocommerce-products-header-main">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>
</div>
	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
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
			global $product;

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
$term = get_queried_object();

$old_long_description = get_field('brand_bottom_decription', $term );
echo "<div class='bottom-description-brand'>" . $old_long_description . "</div>";


if( have_rows('brand_pro_category_faq' , $term) ):?>    
 
 <div class="frequent-questions">
     <h2 class="faqblock"><?php echo get_field('brand_faq_title', $term);?></h2> 
     <div class="Questions-heading">
  
    <div class="after-cart-btn"><img src="/wp-content/uploads/2023/04/lock-12.png" width="17" height="17" alt="lock-12-2"><span>your safety is our priority</span></div>
    <div class="frequent-icon">
    <img src="/wp-content/uploads/2017/01/canadapost-icon-300x300.png" width="80" height="80" alt="adv1">
    <img src="/wp-content/uploads/2017/01/interac-email-transfer-logo-1-300x300.png" width="80" height="80" alt="adv2">
    </div>
    </div>  
<div class="faqs-block et_pb_row">

<?php
    while( have_rows('brand_pro_category_faq', $term) ) : the_row();
        $sub_value = get_sub_field('question', $term);
 		$sub_answer = get_sub_field('answer', $term);?>
  		<h3 class="faq-heading"><?php echo $sub_value;?></h3>
         <div class="faq-desc">
			<p><?php echo $sub_answer;?></p>
  		</div>
                <?php
    endwhile;?>
        
<?php
endif;
?>
</div>
</div>
    
  
 <?php
get_footer( 'shop' );
?>
    
 <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
   <?php $term = get_queried_object();
     if( have_rows('brand_pro_category_faq', $term) ): ?>
     <?php $row_count = 0; $total_rows = count(get_field('brand_pro_category_faq', $term)); ?>
      <?php while( have_rows('brand_pro_category_faq', $term) ): the_row(); ?>
        {
          "@type": "Question",
          "name": "<?php echo get_sub_field('question', $term); ?>",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<?php echo get_sub_field('answer', $term); ?>"
          }
        }<?php $row_count++; if ($row_count < $total_rows) echo ','; ?>
        
      <?php endwhile; ?>
    <?php endif; ?>
  ]
}
</script>