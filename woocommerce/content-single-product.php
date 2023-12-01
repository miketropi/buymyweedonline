<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;?> 

       
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js"></script> 
    
<?php
/** 
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
    <?php
if (function_exists('yoast_breadcrumb') && !is_product_category()) {
    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
}
?>



	
	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
    add_action( 'woocommerce_before_single_product_summary' , 'bmwo_progress_chart_wrapper', 10);
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_short_description_top', 20 );
		add_action( 'woocommerce_single_product_summary' , 'bmwo_Trust_builders_wrapper', 30);
       add_action( 'woocommerce_single_product_summary' , 'after_addtocart_safety_wrapper', 41);
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 35
	 * @hooked woocommerce_output_related_products - 20
	 */
     add_action( 'woocommerce_after_single_product_summary' , 'happy_customr_reviews_section', 11);
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php 
 /****** Shortcode Last Category Section **********/   

function happy_customr_reviews_section() { 
 // Check if there are any reviews for the product
$comments = get_comments(array(
    'post_id' => get_the_ID(), // Get the current product's ID
    'status' => 'approve', // Check for approved comments (reviews)
));

if (!empty($comments)) {
    echo '<div id="reviews-bottom">';  
    echo '<h2 class="reviews-slider-heading">Don’t just take our word for it</h2>';
    echo '<p class="happy-customr-reviews"><img class="happy-customer-home-img" src="/wp-content/uploads/2023/03/five-star.png" alt="review" width="93" height="19"><span class="sub-happy-customer-home">See what our happy customers had to say</span></p>';
    echo do_shortcode('[srfw_usetemplate tid="2"]'); // Display the reviews using the shortcode
    echo '</div>';
 }   
         
 }
 /****** Shortcode Last Category Section **********/   

  
   
     

 function after_addtocart_safety_wrapper() { 
	echo '<div class="desk-product-cart-wrapper">';
    echo '<div class="img-product-cart-wrapper">';
    echo '<img src="/wp-content/uploads/2019/01/canadapost-icon-300x300.png">';
    echo '</div>';
    echo '<div class="img-product-cart-wrapper-2">';
    echo '<img src="/wp-content/uploads/2019/01/interac-email-transfer-logo-1-300x300.png">';
    echo '</div>';
    echo '<div class="after-cart-btn after-add-cart"><img src="/wp-content/uploads/2023/04/lock-12.png"><span>your safety is our priority</span><p class="iproduct-cart-para">At this time we ONLY accept Interac email transfer payments.</p></div>';
   
    echo '</div>';
}


function bmwo_progress_chart_wrapper() { 
$post = get_post();
$terms = get_the_terms($post->ID, 'thc');
$term = $terms[0];?>
   
<div class="bmwo-progress-col-int tabcontent" id="products_ingredients">
<div class="bmwo-progress-bar-container">
<?php if($term != ''): ?>
 <div class="bmwo-progress thc products_ingredients_cbd_thc">
   <div class="bmwo-progress-bar bmwo-progress-bar chart chart-thc" data-percent="<?php echo $term->name; ?>"><span class="strain-value"><?php echo  $term->name; ?></span><br/><span class="strain-name"><?php echo "THC" ?></span></div>
    </div>
   <?php endif ?>

    <?php if( have_rows('products_ingredients') ): ?>
    <?php while( have_rows('products_ingredients') ): the_row(); ?>
    
   <?php if(get_sub_field('2_ingredients_value',get_the_ID()) != ''): 
    $value = get_sub_field('2_ingredients_value',get_the_ID()); 
	$name = get_sub_field('2_ingredients_value',get_the_ID());
?>
   
  <div class="bmwo-progress thc products_ingredients_cbd_thc">
   <div class="bmwo-progress-bar bmwo-progress-bar chart chart-thc" data-percent="<?php echo $value; ?>"><span class="strain-value"><?php echo  $value; ?>%</span><br/><span class="strain-name"><?php echo "CBD" ?></span></div>
    </div>
   
    <?php endif ?>
      <?php endwhile;
    endif; ?>
        
          </div>
       </div>
  
<?php } ?>


<?php
function bmwo_Trust_builders_wrapper() { 
    
 		echo '<div class="happiness-guaranteed Trust_builders" >';
        echo '<div class="First-col">';
        echo '<p><img src="/wp-content/uploads/2023/04/lock-14-2.png"/><span>secure payments</span></p>';
        echo '</div>';  
        echo '<div class="First-col scnd-col">';
        echo '<p><img src="/wp-content/uploads/2023/04/truck-5-1.png"/><span>free delivery over $149</span></p>';
        echo '</div>';  
    	echo '<div class="First-col four-col">';
        echo '<p><img src="/wp-content/uploads/2023/04/smile-3-1.png"/><span>happiness guaranteed</span></p>';
    		
        echo '</div>'; 
    
   echo '</div>'; 
}
?>
    
     <?php 
function woocommerce_short_description_top() {    
global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
 echo $short_description; 
}


?>



		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Add a Review', 'woocommerce' ), get_the_title() ),
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);

				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'label'    => __( 'Name', 'woocommerce' ),
						'type'     => 'text',
						'value'    => $commenter['comment_author'],
						'required' => $name_email_required,
					),
					'email'  => array(
						'label'    => __( 'Email', 'woocommerce' ),
						'type'     => 'email',
						'value'    => $commenter['comment_author_email'],
						'required' => $name_email_required,
					),
				);

				$comment_form['fields'] = array();

				foreach ( $fields as $key => $field ) {
					$field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
					$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

					if ( $field['required'] ) {
						$field_html .= '&nbsp;<span class="required">*</span>';
					}

					$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

					$comment_form['fields'][ $key ] = $field_html;
				}

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

				if ( wc_review_ratings_enabled() ) {
					$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
					</select></div>';
				}

				$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>