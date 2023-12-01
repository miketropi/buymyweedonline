<?php
/*This file is part of GeneratePressChild, generatepress child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

require(get_stylesheet_directory() . '/project-pack/functions.php');

if ( ! function_exists( 'suffice_child_enqueue_child_styles' ) ) {
	function GeneratePressChild_enqueue_child_styles() {
	    // loading parent style
	    wp_register_style(
	      'parente2-style',
	      get_template_directory_uri() . '/style.css'
	    );

	    wp_enqueue_style( 'parente2-style' );
	    // loading child style
	    wp_register_style(
	      'childe2-style',
	      get_stylesheet_directory_uri() . '/style.css'
	    );
	    wp_enqueue_style( 'childe2-style');
	 }
}
add_action( 'wp_enqueue_scripts', 'GeneratePressChild_enqueue_child_styles' );

wp_enqueue_script( 'customjs', get_stylesheet_directory_uri() . '/custom.js?v='.time(), array(), false, true);
wp_enqueue_style( 'customcss', get_stylesheet_directory_uri() . '/custom.css?v='.time(), array(), false, 'all' );


if ( ! function_exists( 'custom_show_cart_total' ) ) {
	function custom_show_cart_total( $args = array() ) {
		if ( ! class_exists( 'woocommerce' ) || ! WC()->cart ) {
			return;
		}

		$defaults = array(
			'no_text' => false,
		);

		$args = wp_parse_args( $args, $defaults );

		$items_number = WC()->cart->get_cart_contents_count();

		$url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();

		printf(
			'<a href="/cart/" class="et-cart-info cart-extra">
				<img src="/wp-content/uploads/2021/09/cart-icon.png" class="custom-cart-icon"><span>%2$s</span>
			</a>',
			esc_url( $url ),
			( ! $args['no_text']
				? esc_html( sprintf(
					_nx( '%1$s', '%1$s', $items_number, 'WooCommerce items number', 'Divi' ),
					number_format_i18n( $items_number )
				) )
				: ''
			)
		);
	}
}

// create shortcode of left sidebar
add_shortcode( 'left_sidebar_shortcode', 'my_custom_sidebar' );
    function my_custom_sidebar(){
        ob_start(); 
        dynamic_sidebar( 'sidebar-2'); 
        $sidebar_left = ob_get_clean(); 
        $html = ' <div class="sidebar-content"> ' . $sidebar_left . ' </div> '; 
        return $html;
}

// Custom redirect for users after logging in
add_filter('woocommerce_login_redirect', 'bryce_wc_login_redirect');
function bryce_wc_login_redirect( $redirect ) {
     $redirect = get_page_link(540);
     return $redirect;
}


add_action('wp_head', 'redirect_to_home');
function redirect_to_home() {
    if(is_page( 540 )) {
		
		$redirect_url = home_url(); ?>
		
        <meta http-equiv="refresh" content="5; URL=<?php echo $redirect_url; ?>">
   
   <?php  }
}


if ( is_page('shop') ) {
     remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
}
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);



add_filter( 'get_the_terms', 'custom_product_cat_terms', 20, 3 );
function custom_product_cat_terms( $terms, $post_id, $taxonomy ){
    $category_ids = array( 205 );
    if( ! is_product() )
        return $terms;

    if( $taxonomy != 'product_cat' ) 
        return $terms;

    foreach( $terms as $key => $term ){
        if( in_array( $term->term_id, $category_ids ) ){
            unset($terms[$key]); 
        }
    }
    return $terms;
}



function start_wrapper_here() { // Start wrapper 

	if (is_product_category()) {  // Wrapper for a product category page

	echo '<div class="product-category-wrapper">';
	echo '<div class="product-wrapper">';
	
	}
}

 add_action(  'woocommerce_before_main_content', 'start_wrapper_here', 20  );
 
 function end_wrapper_here() { // End wrapper 

	if (is_product_category()) {  // Wrapper for a product category page

	echo '</div>';
	echo '</div>';
	
	}
}

 add_action(  'woocommerce_after_main_content', 'end_wrapper_here', 20  );


/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Example: checking if the calculator is being used for a product
 *
 * Adds a heading above the Measurement Price Calculator if enabled
 */
function sv_mpc_heading() {

	if ( ! class_exists( 'WC_Price_Calculator_Product' ) ) {
		return;
	}

	global $product;
	$measurement = WC_Price_Calculator_Product::calculator_enabled( $product );
	
	if ( $measurement ) {
		//echo '<h4>Test Heading</h4>';
	}
}
add_filter( 'woocommerce_before_add_to_cart_button', 'sv_mpc_heading', 4 );

/**
 * Check if weight is more or equal to 28 (Shipping limit)
 *
 *
 */
 
 function stock_in_grams() {
	 
	if ( ! class_exists( 'WC_Price_Calculator_Product' ) ) {
		return;
	}
	 
	$stock_in_grams = WC()->cart->cart_contents_count;
	
	if ($stock_in_grams > 28 ) {
		echo '<h4>Limit Exceeded</h4>';
	}
	
 }
 
// add_action( 'woocommerce_before_cart_contents', 'stock_in_grams' );
 
 function change_empty_cart_button_url() {
	return '/shop/';
	
}
add_filter( 'woocommerce_return_to_shop_redirect', 'change_empty_cart_button_url' );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action('woocommerce_after_checkout_billing_form', 'my_custom_checkout_div');
function my_custom_checkout_div( $checkout ) {
 echo '<div id="check"> </div>';  
}


//add_action('woocommerce_after_checkout_billing_form', 'my_custom_checkout_field');
 
/*function my_custom_checkout_field( $checkout ) {
 
    echo '<div id="my-new-field">';
 
    woocommerce_form_field( 'my_checkbox', array(
        'type'          => 'checkbox',
        'class'         => array('input-checkbox'),
        'label'         => __('We do not sell to persons under the age of 19. By puchasing from buymyweedonline.cc, you swear and affirm that you are over the age of 19:'),
        'required'  => true,
        ), $checkout->get_value( 'my_checkbox' ));
 
    echo '</div>';
}*/
 
/**
 * Process the checkout
 **/
//add_action('woocommerce_checkout_process', 'warn');
 
/*function warn() {
    global $woocommerce;

    if (!$_POST['state_warn'])
        {
         wc_add_notice( __('Please agree to Shipping related affirmation checkbox.'), 'error' );

}
 if (!$_POST['my_checkbox'])
{
         wc_add_notice( __('Please agree to Age related affirmation checkbox.'), 'error' );

}
}
 */
/**
 * Update the order meta with field value
 **/
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');
 
function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ($_POST['my_checkbox']) update_post_meta( $order_id, 'My Checkbox', esc_attr($_POST['my_checkbox']));
}



// strain attributes on single product page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_excerpt', 11 );

function shawn(){
echo "<b class='noaddcart'>This Product is already in the cart. Please go to the <a href='/cart'>cart</a> to change its quantity.</b>";
}

//-------cart order limits------//

add_action( 'woocommerce_check_cart_items', 'cldws_set_weight_requirements' );
function cldws_set_weight_requirements() {
	if( is_cart() || is_checkout() ) {
		global $product,$woocommerce;
		$st = 0;
		
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$idd=$cart_item['product_id'];
		$pro = new WC_Product( $idd );
        //echo $pro->is_type( 'simple' );

		if(has_term('shatter','product_cat', $idd)==true)
		{
			$qty= $cart_item['quantity'];
			 $_product = $cart_item['data'];
		  $weight = $_product->get_weight();
		  $total_grm = $weight*$qty;
	$st+=$total_grm;
			
		}
		else
		{
			 $qty2= $cart_item['quantity'];
			 $_product2 = $cart_item['data'];
	  $weight2 = $_product2->get_weight();
	  if($weight2!=="")
	  {
		 $total_grm2=$weight2*$qty2;
	$flowers+=$total_grm2;
		  
	  } }}

 if( $st >=29 ) {
			wc_add_notice( sprintf('<strong>%s%s is maximum Weight For Shatter Products.</strong>'
				. '<br /><b>Shatter:-</b> Current cart weight: %s%s',
				28,
				'gms',
				$st,
				'gms',
				get_permalink( wc_get_page_id( 'shop' ) )
				),
			'error'	);
		}
if( $flowers >=449 ) {
			wc_add_notice( sprintf('<strong>%s%s is maximum Weight For dried flower Products.</strong>'
				. '<br /><b>Other:-</b> Current cart weight: %s%s',
				448,
				'gms',
				$flowers,
				'gms',
				get_permalink( wc_get_page_id( 'shop' ) )
				),
			'error'	);
		}
}}

add_action('init','inventory_quantity_decimal');
 
function inventory_quantity_decimal() {

		remove_filter( 'woocommerce_stock_amount', 'intval' );
		add_filter( 'woocommerce_stock_amount', 'floatval' );

	}

 add_filter( 'woocommerce_price_trim_zeros', '__return_true' );

function custom_get_newest_products( ) {
	$argss = array(
	'post_type' => 'product',
	'posts_per_page' => 200,
	'orderby' =>'date',
'order' => 'DESC');
	
 ob_start();
$vproducts = new WP_Query( $argss );
    if($vproducts->have_posts())
	{?>
	
     <ul class="products">
        <?php while ( $vproducts->have_posts() ) : $vproducts->the_post(); 
		//$product = new WC_Product(get_the_ID());
		global $product;
		
		$postdate = get_the_time ( 'Y-m-d' );
				$postdatestamp = strtotime ( $postdate );
				
				
        if( $product->is_in_stock() && (time () - (60 * 60 * 24 * 45)) < $postdatestamp ){
					 
                    wc_get_template_part( 'content', 'product' );
				 }
       endwhile;
}
	   else {
                echo __( 'No products found' );
            }
 wp_reset_postdata();

    return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
 
}
 
add_shortcode( 'Customnew', 'custom_get_newest_products' );


 function pagination($pages = '', $range = 4)
{  
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\"> ".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}
/**************Filter Code ********/
function out_of_stock_filters()
{
	if(isset($_POST['oosfilter'])){
	$item =  $_POST['oosfilter'];
	}
	else
	{
	$item =  $_SESSION["ved"];
	}
	
	$html='<form action="" method="POST" name="results" class="et_pb_row oos_filter" style="width: 96%;"><h4>Sort By</h4>
<select name="oosfilter" id="oosfilter" class="sortby" onchange="this.form.submit()">
<option value="default" ';
if($item == 'default')
{$html.='selected="selected"';}
$html.='>Default</option>';

$html.='<option value="recent"';
if($item == 'recent')
{$html.='selected="selected"';}
$html.='>Most Recent</option>';


$html.='<option value="alphabetical"';
if($item == 'alphabetical')
{$html.='selected="selected"';}
$html.='>Title</option>';


$html.='<option value="highest_rated"';
if($item == 'highest_rated')
{$html.='selected="selected"';}
$html.='>Highest Rated</option>';

$html.='</select>
</form>';
return $html;

}

add_shortcode( 'out_of_stock_filters', 'out_of_stock_filters' );

 function cutom_loop_out_of_stock() {
	
if (isset($_SESSION["ved"])) { // if normal page load with cookie
     $count = $_SESSION["ved"];
  }
  if (isset($_POST['oosfilter'])) { //if form submitted
    setcookie('ved',$_POST['oosfilter'] , time() + (86400 * 30), "/"); 
$_SESSION["ved"]=$_POST['oosfilter'];
   $count=$_POST['oosfilter'];
 
  }
 $_SESSION["sortby"]=$count;
	global $product;
	$id=$product->get_id();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	
  switch( $count ) {

			case 'default':
			$argss = array(
						'meta_query' => array(
						array(
						'key' => '_stock_status',
						'value' => 'outofstock',
						'compare' => '='
								)
						),
						'orderby' => 'title',
						'order' => 'asc',
						'post_type' => 'product',
						'posts_per_page' => 28,
						'paged' => $paged,
						
					);
			
			break;
			/***************************************/
		case 'recent':
		$argss = array(
						'meta_query' => array(
						array(
						'key' => '_stock_status',
						'value' => 'outofstock',
						'compare' => '='
								)
						),
						'post_type' => 'product',
						'orderby' => 'date',
						'order'=>'DESC',
						'posts_per_page' => 28,
						'paged' => $paged,
						
					);
					
			break;
			/******************************************/
			case 'alphabetical':
		$argss = array(
						'meta_query' => array(
						array(
						'key' => '_stock_status',
						'value' => 'outofstock',
						'compare' => '='
								)
						),
						'post_type' => 'product',
						'orderby' => 'title',
						'order' => 'asc',
						'posts_per_page' => 28,
						'paged' => $paged,
						
					);
			
			break;
			/**************************************/
			case 'highest_rated':
			$argss = array(
						'meta_query' => array(
						array(
						'key' => '_stock_status',
						'value' => 'outofstock',
						'compare' => '='
								)
						),
						'post_type' => 'product',
						'meta_key' => '_wc_review_count',
						'orderby' => array( 'meta_value_num' => 'DESC'),
						'posts_per_page' => 28,
						'paged' => $paged,
						
					);
			
			break;
			
			/*********************************************/

			 default:
			
			$argss = array(
						'meta_query' => array(
						array(
						'key' => '_stock_status',
						'value' => 'outofstock',
						'compare' => '='
								)
						),
						'orderby' => 'title',
						'order' => 'asc',
						'post_type' => 'product',
						'posts_per_page' => 28,
						'paged' => $paged,
						
					);
			/************************************************/
			}
	
	
 ob_start();
$vproducts = new WP_Query( $argss );
    if($vproducts->have_posts())
	{
		?>
		   <ul class="products">
		<?php
		while ( $vproducts->have_posts() ) : $vproducts->the_post(); 
		//$product = new WC_Product(get_the_ID());
		
        
                    wc_get_template_part( 'content', 'product' );
				 
       endwhile;
}
	   else {
                echo __( 'No products found' );
            }
			
			?>
			</ul>
			<?php 
			 pagination($vproducts->max_num_pages);
 wp_reset_postdata();

    return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
 
}
 
add_shortcode( 'Custom_sold_out_products_loop', 'cutom_loop_out_of_stock' );



function filter_woocommerce_add_to_cart_validation( $true, $product_id, $quantity ) { 
  
   if( strpos($quantity,'.')==true)
   {
	   wc_add_notice( __( 'Decimal Quantity not allowed.', 'woocommerce' ), 'error' );
	     $true=false;
   }
    return $true; 
}; 
add_filter( 'woocommerce_add_to_cart_validation', 'filter_woocommerce_add_to_cart_validation', 10, 3 ); 



function filter_woocommerce_update_cart_validation( $true, $cart_item_key, $values, $quantity ) { 
   if( strpos($quantity,'.')==true)
   {
	   wc_add_notice( __( 'Decimal Quantity not allowed.', 'woocommerce' ), 'error' );
	     $true=false;
   }
    return $true; 
}; 
add_filter( 'woocommerce_update_cart_validation', 'filter_woocommerce_update_cart_validation', 10, 4 ); 


add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
	 global $current_user;
    get_currentuserinfo();
  $a=$current_user->roles;
  if($a[0]=='seo_guys')
  {
	echo '<style>
 #product_catdiv , #tagsdiv-product_tag , #woocommerce-product-data  {
  display: none !important;
}
  </style>';
	  
  }

}

// Add Shortcode for breadcrumb
function breadcrumbs() {
	if(!is_home()) {
		$n = '<nav class="breadcrumb">';
		$n .= '<a href="'.home_url('/').'">Home</a><span class="divider"> / </span>';
		if (is_page()) {
			$p = get_the_title();
			$n .= $p;
		}
		$n .= '</nav>';
	}
	return ($n);
}
add_shortcode( 'my_breadcrumbs', 'breadcrumbs' );


// On single product pages
add_filter( 'woocommerce_quantity_input_args', 'max_qty_input_args', 20, 2 );
function max_qty_input_args( $args, $product ) {
    $product_categories = array('max6');
    $quantity = 6;
    ## ---- The code: set maximun quantity for specific product categories ---- ##
    $product_id = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();
    if( has_term( $product_categories, 'product_cat', $product_id ) ){
        $args['max_value'] = $quantity;
    }
    return $args;
}

// remove out of stock products from best selling widget

add_filter( 'woocommerce_shortcode_products_query', function( $query_args, $atts, $loop_name ){
    if( $loop_name == 'best_selling_products' ){
        $query_args['meta_query'] = array( array(
            'key'     => '_stock_status',
            'value'   => 'outofstock',
            'compare' => 'NOT LIKE',
        ) );
    }
    return $query_args;
}, 10, 3);

// remove out of stock products from top rated widget

add_filter( 'woocommerce_shortcode_products_query', function( $query_args, $atts, $loop_name ){
    if( $loop_name == 'top_rated_products' ){
        $query_args['meta_query'] = array( array(
            'key'     => '_stock_status',
            'value'   => 'outofstock',
            'compare' => 'NOT LIKE',
        ) );
    }
    return $query_args;
}, 10, 3);

add_filter( 'woocommerce_shortcode_products_query', function( $query_args, $atts, $loop_name ){
    if( $loop_name == 'products' ){
        $query_args['meta_query'] = array( array(
            'key'     => '_stock_status',
            'value'   => 'outofstock',
            'compare' => 'NOT LIKE',
        ) );
    }
    return $query_args;
}, 10, 3);


add_action('woocommerce_after_cart_totals', 'yith_cstm_cart_message');

function yith_cstm_cart_message() {
	$total_points = YITH_WC_Points_Rewards_Earning()->calculate_points_on_cart();
	//echo $total_points;die;
echo '<div class="yith_cstm_cart_message"><h4 class="yith_cutm_cart_points_msg">If you proceed to checkout, you will earn <strong>'.$total_points.'</strong> points!</h4>
</div>'; }

add_action( 'woocommerce_check_cart_items', 'my_custom_stock_notice' );
function my_custom_stock_notice() {
	if( is_cart() || is_checkout() ) {
		global $product,$woocommerce;
		
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

			$products_in_cart = array();
			$cart_items =  WC()->cart->get_cart();
		//	echo "<pre>";print_r($cart_items);
			$i = 0;
			foreach( $cart_items as $cart ){				
			   	  $products_in_cart[$i]['product_id'] = $cart['product_id'];
			      $products_in_cart[$i]['variation_id'] = $cart['variation_id'];
			      $products_in_cart[$i]['quantity'] = $cart['quantity'];
			      $products_in_cart[$i]['name'] = implode(" / ", $cart['variation']);
			      $variation_obj = new WC_Product_variation($cart['variation_id']);
			      $products_in_cart[$i]['product_name'] = $variation_obj->get_title();
			      $products_in_cart[$i]['weight'] = $variation_obj->get_weight();
			      $products_in_cart[$i]['stock'] = $variation_obj->get_stock_quantity();
			$i++;      
			}
		}
		//echo "<pre>";print_r($products_in_cart);

		$new_array = array();

		foreach($products_in_cart as $data){
			$new_array[$data['product_id']]['product_id'] = $data['product_id'];
			$new_array[$data['product_id']]['variation_id'] = $data['variation_id'];
			$new_array[$data['product_id']]['product_name'] = $data['product_name'];
			$new_array[$data['product_id']]['name'] = $data['name'];
			$new_array[$data['product_id']]['stock'] = $data['stock'];
			if($data['weight'] == ''){
				//$new_array[$data['product_id']]['grams'] += $data['name']*$data['quantity'];
				$new_array[$data['product_id']]['grams'] += $data['quantity'];
			}else {
				$new_array[$data['product_id']]['grams'] += $data['weight']*$data['quantity'];
			}
		}

		//echo "<pre>";print_r($new_array);

		 foreach($new_array as $vari_data){
			if($vari_data['grams'] > 0 && $vari_data['stock'] != ''){				
			    if( $vari_data['grams'] > $vari_data['stock'] ) {
					wc_add_notice( sprintf('Sorry, we do not have enough "'.$vari_data['product_name'].'" in stock to fulfill your order. Please edit your cart to continue.'),'error');
				}
			} 	
		} 
	}
}

// Speed Code Start From Here


//Remove Query Strings

function remove_cssjs_ver( $src ) {
if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

//RSD Links
remove_action( 'wp_head', 'rsd_link' ) ;


//Disable Emoticons

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//Remove Shortlink

remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);


//Disable Embeds

function disable_embed(){
wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'disable_embed' );

//Disable XML-RPC

add_filter('xmlrpc_enabled', '__return_false');


//Hide WordPress Version

remove_action( 'wp_head', 'wp_generator' ) ;

//Remove WLManifest Link

remove_action( 'wp_head', 'wlwmanifest_link' ) ;


//Disable Self Pingback

function disable_pingback( &$links ) {
 foreach ( $links as $l => $link )
 if ( 0 === strpos( $link, get_option( 'home' ) ) )
 unset($links[$l]);
}
add_action( 'pre_ping', 'disable_pingback' );




//Heartbeat


add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
wp_deregister_script('heartbeat');
}

//Disable Dashicons on Front-end

function wpdocs_dequeue_dashicon() {
        if (current_user_can( 'update_core' )) {
            return;
        }
        wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );

add_filter( 'generate_typography_default_fonts', function( $fonts ) {
    $fonts[] = 'Lato';
	$fonts[] = 'Montserrat';
    return $fonts;
} );

//Disable Contact Form 7 JS/CSS

add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );



/* Increase Woocommerce Variation Threshold */
function wc_ajax_variation_threshold_modify( $threshold, $product ){
  $threshold = '200';
  return  $threshold;
}
add_filter( 'woocommerce_ajax_variation_threshold', 'wc_ajax_variation_threshold_modify', 10, 2 );


// Displaying quantity setting fields on admin product pages
add_action( 'woocommerce_product_options_pricing', 'wc_qty_add_product_field' );
function wc_qty_add_product_field() {
    global $product_object;

    $values = $product_object->get_meta('_qty_args');

    echo '</div><div class="options_group quantity hide_if_grouped">
    <style>div.qty-args.hidden { display:none; }</style>';

    woocommerce_wp_checkbox( array( // Checkbox.
        'id'            => 'qty_args',
        'label'         => __( 'Quantity settings', 'woocommerce' ),
        'value'         => empty($values) ? 'no' : 'yes',
        'description'   => __( 'Enable this to show and enable the additional quantity setting fields.', 'woocommerce' ),
    ) );

    echo '<div class="qty-args hidden">';

    woocommerce_wp_text_input( array(
            'id'                => 'qty_min',
            'type'              => 'number',
            'label'             => __( 'Minimum Quantity', 'woocommerce-max-quantity' ),
            'placeholder'       => '',
            'desc_tip'          => 'true',
            'description'       => __( 'Set a minimum allowed quantity limit (a number greater than 0).', 'woocommerce' ),
            'custom_attributes' => array( 'step'  => 'any', 'min'   => '0'),
            'value'             => isset($values['qty_min']) && $values['qty_min'] > 0 ? (int) $values['qty_min'] : 0,
    ) );

    woocommerce_wp_text_input( array(
            'id'                => 'qty_max',
            'type'              => 'number',
            'label'             => __( 'Maximum Quantity', 'woocommerce-max-quantity' ),
            'placeholder'       => '',
            'desc_tip'          => 'true',
            'description'       => __( 'Set the maximum allowed quantity limit (a number greater than 0). Value "-1" is unlimited', 'woocommerce' ),
            'custom_attributes' => array( 'step'  => 'any', 'min'   => '-1'),
            'value'             => isset($values['qty_max']) && $values['qty_max'] > 0 ? (int) $values['qty_max'] : -1,
    ) );

    woocommerce_wp_text_input( array(
            'id'                => 'qty_step',
            'type'              => 'number',
            'label'             => __( 'Quantity step', 'woocommerce-quantity-step' ),
            'placeholder'       => '',
            'desc_tip'          => 'true',
            'description'       => __( 'Optional. Set quantity step  (a number greater than 0)', 'woocommerce' ),
            'custom_attributes' => array( 'step'  => 'any', 'min'   => '1'),
            'value'             => isset($values['qty_step']) && $values['qty_step'] > 1 ? (int) $values['qty_step'] : 1,
    ) );

    echo '</div>';
}

// Show/hide setting fields (admin product pages)
add_action( 'admin_footer', 'product_type_selector_filter_callback' );
function product_type_selector_filter_callback() {
    global $pagenow, $post_type;

    if( in_array($pagenow, array('post-new.php', 'post.php') ) && $post_type === 'product' ) :
    ?>
    <script>
    jQuery(function($){
        if( $('input#qty_args').is(':checked') && $('div.qty-args').hasClass('hidden') ) {
            $('div.qty-args').removeClass('hidden')
        }
        $('input#qty_args').click(function(){
            if( $(this).is(':checked') && $('div.qty-args').hasClass('hidden')) {
                $('div.qty-args').removeClass('hidden');
            } else if( ! $(this).is(':checked') && ! $('div.qty-args').hasClass('hidden')) {
                $('div.qty-args').addClass('hidden');
            }
        });
    });
    </script>
    <?php
    endif;
}

// Save quantity setting fields values
add_action( 'woocommerce_admin_process_product_object', 'wc_save_product_quantity_settings' );
function wc_save_product_quantity_settings( $product ) {
    if ( isset($_POST['qty_args']) ) {
        $values = $product->get_meta('_qty_args');

        $product->update_meta_data( '_qty_args', array(
            'qty_min' => isset($_POST['qty_min']) && $_POST['qty_min'] > 0 ? (int) wc_clean($_POST['qty_min']) : 0,
            'qty_max' => isset($_POST['qty_max']) && $_POST['qty_max'] > 0 ? (int) wc_clean($_POST['qty_max']) : -1,
            'qty_step' => isset($_POST['qty_step']) && $_POST['qty_step'] > 1 ? (int) wc_clean($_POST['qty_step']) : 1,
        ) );
    } else {
        $product->update_meta_data( '_qty_args', array() );
    }
}

// The quantity settings in action on front end
add_filter( 'woocommerce_quantity_input_args', 'filter_wc_quantity_input_args', 99, 2 );
function filter_wc_quantity_input_args( $args, $product ) {
    if ( $product->is_type('variation') ) {
        $parent_product = wc_get_product( $product->get_parent_id() );
        $values  = $parent_product->get_meta( '_qty_args' );
    } else {
        $values  = $product->get_meta( '_qty_args' );
    }

    if ( ! empty( $values ) ) {
        // Min value
        if ( isset( $values['qty_min'] ) && $values['qty_min'] > 1 ) {
            $args['min_value'] = $values['qty_min'];

            if( ! is_cart() ) {
                $args['input_value'] = $values['qty_min']; // Starting value
            }
        }

        // Max value
        if ( isset( $values['qty_max'] ) && $values['qty_max'] > 0 ) {
            $args['max_value'] = $values['qty_max'];

            if ( $product->managing_stock() && ! $product->backorders_allowed() ) {
                $args['max_value'] = min( $product->get_stock_quantity(), $args['max_value'] );
            }
        }

        // Step value
        if ( isset( $values['qty_step'] ) && $values['qty_step'] > 1 ) {
            $args['step'] = $values['qty_step'];
        }
    }
    return $args;
}

// Ajax add to cart, set "min quantity" as quantity on shop and archives pages
add_filter( 'woocommerce_loop_add_to_cart_args', 'filter_loop_add_to_cart_quantity_arg', 10, 2 );
function filter_loop_add_to_cart_quantity_arg( $args, $product ) {
    $values  = $product->get_meta( '_qty_args' );

    if ( ! empty( $values ) ) {
        // Min value
        if ( isset( $values['qty_min'] ) && $values['qty_min'] > 1 ) {
            $args['quantity'] = $values['qty_min'];
        }
    }
    return $args;
}

// The quantity settings in action on front end (For variable productsand their variations)
add_filter( 'woocommerce_available_variation', 'filter_wc_available_variation_price_html', 10, 3);
function filter_wc_available_variation_price_html( $data, $product, $variation ) {
    $values  = $product->get_meta( '_qty_args' );

    if ( ! empty( $values ) ) {
        if ( isset( $values['qty_min'] ) && $values['qty_min'] > 1 ) {
            $data['min_qty'] = $values['qty_min'];
        }

        if ( isset( $values['qty_max'] ) && $values['qty_max'] > 0 ) {
            $data['max_qty'] = $values['qty_max'];

            if ( $variation->managing_stock() && ! $variation->backorders_allowed() ) {
                $data['max_qty'] = min( $variation->get_stock_quantity(), $data['max_qty'] );
            }
        }
    }

    return $data;
}

add_filter( 'generate_site_title_output', function( $output ) {
	return sprintf(
		'<%1$s class="main-title" itemprop="headline">
			<a href="%2$s" rel="home">
				%3$s
			</a>
		</%1$s>',
		( is_front_page() ) ? 'h2' : 'p',
		esc_url( apply_filters( 'generate_site_title_href', home_url( '/' ) ) ),
		get_bloginfo( 'name' )
	);
});


/**
 * WooCommerce Product Reviews Shortcode
 */
 
   
add_shortcode( 'product_reviews', 'bbloomer_product_reviews_shortcode' );
 
function bbloomer_product_reviews_shortcode( $atts ) {
    
   if ( empty( $atts ) ) return '';
 
   if ( ! isset( $atts['id'] ) ) return '';
       
   $comments = get_comments( 'post_id=' . $atts['id'] );
    
   if ( ! $comments ) return '';
    
   $html .= '<div class="woocommerce-tabs"><div id="reviews"><ol class="commentlist">';
    
   foreach ( $comments as $comment ) {   
       if($comment_inc < 5) { 
      $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
      $html .= '<li class="review">';
      $html .= get_avatar( $comment, '60' );
      $html .= '<div class="comment-text">';
      $html .='<span class="stars-active" style="width:100%">
            <i class="fa fa-star" aria-hidden="true"></i>
            <i class="fa fa-star" aria-hidden="true"></i>
            <i class="fa fa-star" aria-hidden="true"></i>
            <i class="fa fa-star" aria-hidden="true"></i>
            <i class="fa fa-star" aria-hidden="true"></i>
        </span>';
           
      if ( $rating ) $html .= wc_get_rating_html( $rating );
      $html .= '<p class="meta"><strong class="woocommerce-review__author">';
      $html .= get_comment_author( $comment );
      $html .= '</strong></p>';
      $html .= '<div class="description">';
      $html .= $comment->comment_content;
      $html .= '</div></div>';
      $html .= '</li>';
       }
       $comment_inc++;
   }
    
   $html .= '</ol></div></div>';
    
   return $html;
}

/**
 * @snippet       Hide Out of Stock Exception @ Page
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_filter( 'pre_option_woocommerce_hide_out_of_stock_items', 'bbloomer_hide_out_of_stock_exception_page' );
 
function bbloomer_hide_out_of_stock_exception_page( $hide ) {
   if ( is_page( 21186 ) ) {
      $hide = 'no';
   }   
   return $hide;
}


function db_custom_cart_count() {

    ob_start();

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	if ( ! isset( WC()->cart ) ) {
		return;
	}

	$no_items = '';

	if ( ! WC()->cart->get_cart_contents_count() > 0 ) {
		$no_items = 'no-items';
	}

	printf(
        '<span class="et-cart-info ic-cart-header-btn">
				<img src="/wp-content/uploads/2023/06/cart.png" class="custom-cart-icon" alt="cart" width="20" height="20"><span class="cart-contents"><span class="number-of-items %1$s">%2$s</span></span></span>',
        $no_items,
        WC()->cart->get_cart_contents_count()
    );
    return ob_get_clean();
}
add_shortcode('db_cart_count', 'db_custom_cart_count');

add_shortcode( 'wc_reg_form_bbloomer', 'bbloomer_separate_registration_form' );
    
function bbloomer_separate_registration_form() {
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return;
   ob_start();
 
   do_action( 'woocommerce_before_customer_login_form' );
 
   // NOTE: THE FOLLOWING <FORM></FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
   // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY
 
   ?>
 
      <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
 
         <?php do_action( 'woocommerce_register_form_start' ); ?>
 
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
 
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
               <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>
 
         <?php endif; ?>
 
         <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
         </p>
 
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
 
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
               <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" id="reg_password" title="" autocomplete="new-password" />
            </p>
 <p class="pswd-content"><span>NOTE:</span> Must contain at least one number and one uppercase and lowercase letter, special character and at least 8 or more characters</p>
 
         <?php else : ?>
 
            <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>
 
         <?php endif; ?>
 
         <?php do_action( 'woocommerce_register_form' ); ?>
 
         <p class="woocommerce-FormRow form-row">
            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
         </p>
 
         <?php do_action( 'woocommerce_register_form_end' ); ?>
 
      </form>
 
   <?php
     
   return ob_get_clean();
 
}

function remove_wc_password_meter() {
wp_dequeue_script( 'wc-password-strength-meter' );
}
add_action( 'wp_print_scripts', 'remove_wc_password_meter', 100 );

function currentYear( $atts ){
    return date('Y');
}
add_shortcode( 'year', 'currentYear' );


// Automatically Delete Woocommerce Images After Deleting a Product
add_action( 'before_delete_post', 'delete_product_images', 10, 1 );

function delete_product_images( $post_id )
{
    $product = wc_get_product( $post_id );

    if ( !$product ) {
        return;
    }

    $featured_image_id = $product->get_image_id();
    $image_galleries_id = $product->get_gallery_image_ids();

    if( !empty( $featured_image_id ) ) {
        wp_delete_post( $featured_image_id );
    }

    if( !empty( $image_galleries_id ) ) {
        foreach( $image_galleries_id as $single_image_id ) {
            wp_delete_post( $single_image_id );
        }
    }
}


/*   Shortcode for bottom of page section before footer newsletter and category ****/

add_shortcode( 'bottom_signup_newsletter', 'your_theme_bottom_signup_newsletter');

function your_theme_bottom_signup_newsletter($content){

    $content =  '<div class="product-order-signup_newsletter">

<div class="product-order-category mnm-category-order">
        <a href="/product-category/concentrates/shatter/"><div class="third-get-fast">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/shatter-category.png" alt="shop all shatter" width="140" height="116"/></div>
            <h3>Shatter</h3>
            </div></a>
         <a href="/product-category/cannabis/"><div class="third-get-fast">
            <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/cannabis-category.png" alt="shop all cannabis" width="140" height="119"/></div>
        <h3>Cannabis</h3>
        </div></a>
        <a href="/product-category/concentrates/hash/"><div class="third-get-fast">
            <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/hash-category.png" alt="shop all hash" width="140" height="130"/></div>
            <h3>Hash</h3>
        </div></a>
        <a href="/product-category/concentrates/thc-oil/"><div class="third-get-fast">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/oil-category.png" alt="shop all thc oil" width="140" height="130"/></div>
            <h3>THC Oil</h3>
         </div></a>
        <a href="/product-category/concentrates/live-resin/"><div class="third-get-fast">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/live-resin-category.png" alt="shop all resin" width="140" height="74"/></div>
             <h3>Live Resin</h3>
        </div></a>
        <a href="/product-category/concentrates/budder-wax/"><div class="third-get-fast">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/budder-category.png" alt="shop all budder" width="140" height="105"/></div>
             <h3>Budder & Wax</h3>
         </div></a>
        <a href="/product-category/edibles/"><div class="third-get-fast">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/edibles-category.png" alt="shop all thc edibles" width="140" height="137" /></div>
             <h3>THC Edibles</h3>
         </div></a>
         <a href="/product-category/cbd-oil-for-dogs/"><div class="third-get-fast">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/pet-health-category.png"  alt="shop all CBD Oil for dogs" width="140" height="115"/></div>
             <h3>CBD Oil for Dogs</h3>
         </div></a>
    </div> 
 
<div class="slider" style="display:none;">
         <a href="/product-category/concentrates/shatter/"><div class="slide">
              <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/shatter-category.png" width="" height="" alt="shop all shatter" />
            <h3>Shatter</h3></div>
            </div></a>
       <a href="/product-category/cannabis/"><div class="slide">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/cannabis-category.png" width="" height=""  alt="shop all cannabis"/>
             <h3>Cannabis</h3></div>
         </div></a>
        <a href="/product-category/concentrates/hash/"> <div class="slide">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/hash-category.png" width="" height="" alt="shop all hash" />
            <h3>Hash</h3></div>
         </div></a>
        <a href="/product-category/concentrates/thc-oil/"><div class="slide">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/oil-category.png" width="" height=""alt="shop all THC oil"/>
             <h3>THC Oil</h3></div>
         </div></a>
        <a href="/product-category/concentrates/live-resin/"><div class="slide">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/live-resin-category.png"width="" height="" alt="shop all resin" />
             <h3>Live Resin</h3></div>
         </div></a>
         <a href="/product-category/concentrates/budder-wax/"><div class="slide">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/budder-category.png" width="" height="" alt="shop all budder" />
             <h3>Budder & Wax</h3></div>
         </div></a>
        <a href="/product-category/edibles/"><div class="slide">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/edibles-category.png" width="" height="" alt="shop all thc edibles" />
             <h3>THC Edibles</h3></div>
         </div></a>
        <a href="/product-category/cbd-oil-for-dogs/"> <div class="slide">
             <div class="mnm-bottom-img"><img src="/wp-content/uploads/2023/03/pet-health-category.png" width="" height="" alt="Shop all CBD Oil for Dogs"/>
             <h3>CBD Oil for Dogs</h3></div>
         </div></a>
    </div>';
 return $content;

}


/*   Shortcode for bottom and Top of the page section secure payments icons ****/

add_shortcode( 'secure_payments_icons', 'your_theme_secure_payments_icons');

function your_theme_secure_payments_icons($content2){

    $content2 = '<div class="product-order-category secure-icons">
    <div class="icon-containner">
        <div class="icons_third-get-fast">
             <div class="icons_bottom-img">
            <span>secure payments</span>
            </div>
            </div>
        <div class="icons_third-get-fast">
            <div class="icons_bottom-img">
        <span>free delivery over $150</span>
        </div>
        </div>
        <div class="icons_third-get-fast">
            <div class="icons_bottom-img">
            <span>always discreet packaging</span>
            </div>
        </div>
        <div class="icons_third-get-fast">
             <div class="icons_bottom-img">
            <span>happiness guaranteed</span>
            </div>
         </div>
    </div> 
 </div>
 <div class="slider1" style="display:none;">
<ul> <li><img src="/wp-content/uploads/2023/04/lock-14-2.png" style="margin-top: -2px;position: relative;" alt="secure payments" width="44" height="44"/>
            <p>secure payments</p></li>
            <li><img src="/wp-content/uploads/2023/04/truck-5-1.png" width="44" height="44" alt="free delivery"/>
       		 <p>free delivery over $150</p>	</li>
        	<li><img src="/wp-content/uploads/2023/04/package-1.png" width="44" height="44" alt="discreet packaging" />
            <p>always discreet packaging</p></li>
            <li><img src="/wp-content/uploads/2023/04/smile-3-1.png" width="44" height="44" alt="happiness guaranteed"/>
            <p>happiness guaranteed</p></li>
            <li><img src="/wp-content/uploads/2023/04/lock-14-2.png" style="margin-top: -2px;position: relative;" alt="secure payments" width="44" height="44"/>
            <p>secure payments</p></li>
            <li><img src="/wp-content/uploads/2023/04/truck-5-1.png" width="44" height="44" alt="free delivery"/>
       		 <p>free delivery over $150</p>	</li>
        	<li><img src="/wp-content/uploads/2023/04/package-1.png" width="44" height="44" alt="discreet packaging" />
            <p>always discreet packaging</p></li>
            <li><img src="/wp-content/uploads/2023/04/smile-3-1.png" width="44" height="44" alt="happiness guaranteed"/>
            <p>happiness guaranteed</p></li>
            <li><img src="/wp-content/uploads/2023/04/lock-14-2.png" style="margin-top: -2px;position: relative;" alt="secure payments" width="44" height="44"/>
            <p>secure payments</p></li>
            <li><img src="/wp-content/uploads/2023/04/truck-5-1.png" width="44" height="44" alt="free delivery"/>
       		 <p>free delivery over $150</p>	</li>
        	<li><img src="/wp-content/uploads/2023/04/package-1.png" width="44" height="44" alt="discreet packaging" />
            <p>always discreet packaging</p></li>
            <li><img src="/wp-content/uploads/2023/04/smile-3-1.png" width="44" height="44" alt="happiness guaranteed"/>
            <p>happiness guaranteed</p></li>
            </ul>
        
    </div>';
 return $content2;

}

// Enable shortcodes in menus
add_filter('wp_nav_menu_items', 'do_shortcode');



function tutsmake_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
     
    if($count=='') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function tutsmake_track_post_views ($post_id) {
    if ( !is_single() ) return;
     
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
     
    tutsmake_set_post_views($post_id);
}
 
add_action( 'wp_head', 'tutsmake_track_post_views');

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

//Set the parameters / arguments for the query
add_shortcode( 'popular_post_shortcode', 'popular_post_shortcode_blog_post' );
function popular_post_shortcode_blog_post() {
$popular_post_args = array(
    'meta_key'  => 'post_views_count', //meta key currently set
    'orderby'    => 'meta_value_num', //orderby currently set
    'order'      => 'DESC', //order currently set
    'posts_per_page' => 3 // show no. of posts
);
 
//Initialise the Query and add the arguments
$popular_posts = new WP_Query( $popular_post_args );
 
if ( $popular_posts->have_posts() ) :
?>
    <ul class="first-recent-post">
    <h2 class="widget-title">Popular Posts</h2>
        <?php
            while ( $popular_posts->have_posts() ) : $popular_posts->the_post();
            ?>
             <div class="popular-col-post">
            <div class="first-col-post">
             <?php the_post_thumbnail(); ?> 
              </div>
              <div class="sec-col-post">
              <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                                     
				</div>
                  </div>
            <?php
            endwhile;
 
            wp_reset_postdata();
        ?>
    </ul>
<?php 
endif; 
}


function woocommerce_free_shipping_progress_bar() {
    $minimum_amount = 149; // Set the minimum amount for free shipping
    $cart_subtotal = WC()->cart->subtotal; // Get the cart subtotal

    if ( $cart_subtotal < $minimum_amount ) {
        $percentage = round(  $minimum_amount - $cart_subtotal );
        $percentage1 = $cart_subtotal/1.5;
        $progress_bar = '<div class="progress-container">
    <span class="progress-text">You are <span>$' . $percentage . '</span> away from <span>Free Shipping</span></span><div class="progress-bar"><div class="progress-fill" role="progressbar" style="width: ' . $percentage1 . '%" aria-valuenow="' . $percentage1 . '" aria-valuemin="0" aria-valuemax="100"></div></div></div>';
        return $progress_bar;
    } 
    else{
     $progress_bar1 = '<div class="progress-container">
    <span class="progress-text">You  <span> got the Free Shipping</span></span><div class="progress-bar"><div class="progress-fill" role="progressbar" style="width:100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div></div>';
    }
     return $progress_bar1;
}
add_shortcode( 'free_shipping_progress_bar', 'woocommerce_free_shipping_progress_bar' );


/*** Remove schema ***/
add_action( 'generate_schema_type', 'remove_generatepress_schemas' );
function remove_generatepress_schemas() {
    remove_action( 'generate_header_item_schema', 'generate_wp_header_item_schema' );
    remove_action( 'generate_footer_item_schema', 'generate_wp_footer_item_schema' );
    remove_action( 'generate_inside_navigation_item_schema', 'generate_site_navigation_element_schema' );
}
function remove_woocommerce_breadcrumb_schema() {
    if ( is_product_category() || is_product() ) { // check if the current page is a product category or a product
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 ); // remove the breadcrumb function from the WooCommerce hook
    }
}
add_action( 'wp', 'remove_woocommerce_breadcrumb_schema' );


/***** Replace # with javascript:void(0) *********/
add_filter('walker_nav_menu_start_el', 'wpse_226884_replace_hash', 999);
/**
 * Replace # with js
 * @param string $menu_item item HTML
 * @return string item HTML
 */
function wpse_226884_replace_hash($menu_item) {
    if (strpos($menu_item, 'href="#"') !== false) {
        $menu_item = str_replace('href="#"', 'href="javascript:void(0);"', $menu_item);
    }
    return $menu_item;
}

/****** remove hatom schema on Blog page with this PHP snippet  *******/
add_filter( 'generate_is_using_hatom', '__return_false' );


function woocommerce_template_loop_product_title() {
    echo wp_kses_post( '<h3 class="woocommerce-loop-product__title">' . get_the_title() . '</h3>' );
}




/*-----W3Speedster-----*/
function w3_disable_htaccess_wepb(){
	return 1;
}
function w3speedup_after_optimization($html){
   $html = str_replace(array('https://buymyweedonline.cc/wp-content/plugins/woocommerce/assets/css/photoswipe/photoswipe.min.css'),array(''),$html);
   $html = str_replace(array('https://buymyweedonline.cc/wp-content/plugins/woocommerce/assets/css/photoswipe/default-skin/default-skin.min.css'),array(''),$html);
	$html = str_replace(array('<link rel="preload" as="style"','media="print"',"this.media='all'"),array('<link rel="" as="style"','media=""',""), $html);
	$html = str_replace(array('<LINK REL="STYLESHEET" HREF="HTTPS://CDNJS.CLOUDFLARE.COM/AJAX/LIBS/FONT-AWESOME/5.15.4/CSS/ALL.MIN.CSS" />',"<link rel='stylesheet' id='montserrat-font-css' href='https://buymyweedonline.cc/wp-content/themes/GeneratePressChild/Fonts/static/Montserrat-ExtraBold.ttf' type='text/css' media='all' />",'<link rel="preconnect" href="https://fonts.googleapis.com">','<link rel="" as="style" href="https://fonts.googleapis.com/css2?family=Lato&#038;display=swap" />','<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato&#038;display=swap" media="" onload="" />'),array('',"",'<link rel="" href="https://fonts.googleapis.com">','',''),$html);
    return $html;
}

function w3speedup_customize_critical_css($critical_css){
// $critical_css = str_replace('font-family:Lato;','',$critical_css);
$critical_css = str_replace('font-family:Montserrat;','',$critical_css);
$critical_css = str_replace('font-family:star;','',$critical_css);
$critical_css = str_replace("font-family:'FontAwesome';","",$critical_css);
$critical_css = str_replace(array("@font-face { font-family:'Montserrat';",'@font-face{font-family:"Open Sans";',"@font-face { font-family:'Lato';"),array("",'',""),$critical_css);
// $critical_css = str_replace("@font-face { font-family:'Lato';","",$critical_css);
return $critical_css;
}

function w3speedup_internal_js_customize($html,$path){
	if(strpos($path,'uag-plugin/uag-js-') !== false){	 
		$html = str_replace('document.addEventListener("DOMContentLoaded", function(){ jQuery( document ).ready( function() {','setTimeout(function(){ setTimeout(function(){',$html);	
	}
    if(strpos($path,'wp-tab-widget/js/wp-tab-widget.js') !== false){	 
		$html = str_replace('jQuery(document).ready(function() {','setTimeout(function(){ ',$html);	
	}
	return $html;
}


function custom_modify_breadcrumb_links($links) {
    // Remove the specific breadcrumb item
    if (isset($links[1]) && $links[1]['text'] === 'ONLINE MARIJUANA DISPENSARY') {
        unset($links[1]);
    }                                                              
    return $links;
}
add_filter('wpseo_breadcrumb_links', 'custom_modify_breadcrumb_links');

add_filter( 'wpseo_breadcrumb_single_link', 'remove_breadcrumb_title' );
function remove_breadcrumb_title( $link_output ) {
	if ( ( is_product() || is_category() || is_single() ) && strpos( $link_output, 'breadcrumb_last' ) !== false ) {
		$link_output = '';
	}
	return $link_output;
}


function w3_create_separate_critical_css_of_category(){
   return array('product_cat');
}

function w3_create_separate_critical_css_of_post_type(){
    return array('page','post');
}


function custom_yoast_breadcrumb_output($output) {
    if (is_tax('pwb-brand')) {
        $brand_name = single_term_title('', false);
        $output = '<p id="breadcrumbs"><a href="' . esc_url(home_url('/')) . '">Home</a>  » <a href="/brands/">Brand</a>  » ' . $brand_name . '</p>';
    }
    return $output;
}
add_filter('wpseo_breadcrumb_output', 'custom_yoast_breadcrumb_output');

function recent_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 50 // Default limit is 10
    ), $atts, 'recent_products');

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $atts['limit'],
        'date_query' => array(
            array(
                'after' => '60 days ago',
                'inclusive' => true
            )
        )
    );

    $products = new WP_Query($args);

    ob_start();

    if ($products->have_posts()) {
       echo ' <div class="woocommerce columns-4 ">';
        echo '<ul class="products columns-4">';
        while ($products->have_posts()) {
            $products->the_post();
            wc_get_template_part('content', 'product');
        }
        echo '</ul>';
        echo '</div>';
    } else {
        echo __('No recent products found', 'your-text-domain');
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('recent_product', 'recent_products_shortcode');


/* Change Add to Cart text on shop page */
function custom_cart_button_Shop_Page( $text, $product ) {
    if( $product->is_type( 'variable' ) or $product->is_type( 'mix-and-match' ) ){
        $text = __('Choose Option', 'woocommerce');
    }
    return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'custom_cart_button_Shop_Page', 9, 2 );


add_filter( 'woocommerce_get_catalog_ordering_args', 'bbloomer_first_sort_by_stock_amount', 9999 );
function bbloomer_first_sort_by_stock_amount( $args ) {
    $args['orderby'] = 'meta_value';
    $args['meta_key'] = '_stock_status';
    $args['order'] = 'ASC';
    return $args;
}

function enqueue_montserrat_font() {
    wp_enqueue_style( 'montserrat-font', 'https://buymyweedonline.cc/wp-content/themes/GeneratePressChild/Fonts/static/Montserrat-ExtraBold.ttf', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_montserrat_font' );


// Add the following code to your theme's functions.php file

 add_shortcode('shortcode_reviews','example_shortcode');   
function example_shortcode( $atts ) {
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
    return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( $rating_count > 0 ) : 

             echo wc_get_rating_html($average, $rating_count); 
         if ( comments_open() ): ?><a href="<?php echo get_permalink() ?>#reviews-bottom" class="woocommerce-review-link extra-reviews-product" rel="nofollow">Based on <?php printf( _n( '%s',$review_count,'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?> reviews</a> <?php endif; 
    
 endif; 
}


// Remove the "Additional Information" tab
add_filter('woocommerce_product_tabs', 'remove_additional_information_tab', 98);
function remove_additional_information_tab($tabs) {
    unset($tabs['additional_information']);
    return $tabs;
}

// Remove the "Reviews" tab
add_filter('woocommerce_product_tabs', 'remove_reviews_tab', 98);
function remove_reviews_tab($tabs) {
    unset($tabs['reviews']);
    return $tabs;
}

function custom_product_description_heading($heading) {
    global $product;

    // Check if a product is being displayed
    if (is_product() && $product) {
        // Get the product name
        $product_name = $product->get_name();

        // Modify the heading to include "Description" before the product name
        $heading = sprintf(__('About %s', 'woocommerce'), $product_name);
    }

    return $heading;
}
add_filter('woocommerce_product_description_heading', 'custom_product_description_heading');



function custom_paginated_og_url($url) {
    if (is_paged()) {
        $page_number = get_query_var('paged');
        return trailingslashit($url) . 'page/' . $page_number . '/';
    }
    return $url;
}
add_filter('wpseo_opengraph_url', 'custom_paginated_og_url');



add_action( 'woocommerce_order_status_on-hold', 'bbloomer_cancel_on_hold_order_event' );

function bbloomer_cancel_on_hold_order_event( $order_id ) {
   if ( ! wp_next_scheduled( 'bbloomer_cancel_on_hold_order_after_one_hour', array( $order_id ) ) ) {
      wp_schedule_single_event( time() + 259200, 'bbloomer_cancel_on_hold_order_after_one_hour', array( $order_id ) );
   }
}

add_action( 'bbloomer_cancel_on_hold_order_after_one_hour', 'bbloomer_cancel_on_hold_order' );

function bbloomer_cancel_on_hold_order( $order_id ) {
   $order = wc_get_order( $order_id );
   wp_clear_scheduled_hook( 'bbloomer_cancel_on_hold_order_after_one_hour', array( $order_id ) );
   if ( $order->has_status( array( 'on-hold' ) ) ) { 
      $order->update_status( 'cancelled', 'On-hold order cancelled after 12 hours' );
   }
}



// Remove the anchor link from the cart icon
function remove_cart_icon_link() {
    remove_action('generate_navigation_before', 'generate_cart_link');
}
add_action('after_setup_theme', 'remove_cart_icon_link');



function wpse24661_filter_wp_title( $title, $separator ) {
    // Globalize $page
    global $paged;

    // Determine if current post is paginated
    // and if we're on a page other than Page 1
    if ( $paged >= 2 ) {
        // Append $separator Page #
        $title .= ' ' . $separator . ' ' . 'Page ' . $paged;
    }    
    // Return filtered $title
    // echo $title;die;
    return $title;
}
add_filter( 'wp_title', 'wpse24661_filter_wp_title', 101, 2 );



/**
* Sorting out of stock WooCommerce products - Order product collections by stock status, in-stock products first.
*/
class iWC_Orderby_Stock_Status
{
public function __construct()
{
// Check if WooCommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
add_filter('posts_clauses', array($this, 'order_by_stock_status'), 2000);
}
}
public function order_by_stock_status($posts_clauses)
{
global $wpdb;
// only change query on WooCommerce loops
if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag())) {
$posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
$posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
$posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
}
return $posts_clauses;
}
}
new iWC_Orderby_Stock_Status;
/**
* END - Order product collections by stock status, instock products first.
*/



// Add this code to your theme's functions.php file or a custom plugin

add_action('woocommerce_single_product_summary', 'bbloomer_echo_variation_info', 11);

function bbloomer_echo_variation_info() {
    global $product;

    // Check if the product is a variable product
    if ($product->is_type('variable')) {
        // Output an empty container for variation info
        echo '<div class="var_info"><span class="price">Price:  </span> </div>';
        
        // Enqueue JavaScript to handle variation change
        wc_enqueue_js("
            jQuery(document).on('found_variation', 'form.cart', function( event, variation ) { 
                jQuery('.var_info').html('Price: ' + variation.price_html); 
            });
        ");
    }
}