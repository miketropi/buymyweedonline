<?php 

function project_pack_main_scripts() {
	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/project-pack/assets/custom-mini-cart.js?v='.time().'', array('jquery'), time(), true  );
    wp_enqueue_style( 'custom-styles', get_stylesheet_directory_uri() . '/project-pack/assets/custom-mini-cart.css?v='.time().'', false, time() );
    wp_enqueue_style( 'custom-main-style', get_stylesheet_directory_uri() . '/project-pack/css/main-custom-pj.css?v='.time().'', false, time() );
    wp_localize_script( 'custom-script', 'my_ajax_object', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'ic-mc-nc' ),
    ) 
);
}
add_action( 'wp_enqueue_scripts', 'project_pack_main_scripts' );


if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Header Settings',
        'menu_title'    => 'Header',
        'parent_slug'   => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'theme-general-settings',
    ));

}



add_action('init','show_button_mini_cart');
function show_button_mini_cart () {
    if(!is_cart()) {
      
    }
}

function ic_display_quantity_plus() {
    if(!is_cart() & !is_product()) {
        echo '<button type="button" class="ic-item-quantity-btn plus" data-type="plus"> +</button>';
    }
}
function ic_display_quantity_minus() {
    if(!is_cart() & !is_product()) {
        echo '<button type="button" class="ic-item-quantity-btn minus" data-type="minus">-</button>';
    }
} 

// add_action( 'woocommerce_after_quantity_input_field', 'ic_display_quantity_plus', 10, 2 );
// add_action( 'woocommerce_before_quantity_input_field', 'ic_display_quantity_minus' );

add_action( 'wp_ajax_ic_qty_update', 'ic_qty_update' );
add_action( 'wp_ajax_nopriv_ic_qty_update', 'ic_qty_update' );

function ic_qty_update() {
    $key    = sanitize_text_field( $_POST['key'] );
    $number = intval( sanitize_text_field( $_POST['number'] ) );

    $cart = [
        'count'      => 0,
        'total'      => 0,
        'item_price' => 0,
    ];

    if ( $key && $number > 0 && wp_verify_nonce( $_POST['security'], 'ic-mc-nc' ) ) {
        WC()->cart->set_quantity( $key, $number );
        $items              = WC()->cart->get_cart();
        $cart               = [];
        $cart['count']      = WC()->cart->cart_contents_count;
        $cart['total']      = WC()->cart->get_cart_total();
        $cart['item_price'] = wc_price( $items[$key]['line_total'] );
      
        // Get WooCommerce cart object
        
        $list_promo = get_field('list_product_promo','options');

        if(!empty($list_promo)) {
          $cart_new = WC()->cart;
          $subtotal_new = WC()->cart->get_cart_contents_total();
          foreach ($list_promo as $key => $pr_cart) {
            $spend_limit = get_field('limit_show_promo_gift',$pr_cart);
            if($subtotal_new<$spend_limit) {
              foreach( $cart_new->get_cart() as $cart_item_key => $cart_item ) {
                    if ( $cart_item['product_id'] == $pr_cart ) {
                        $cart_new->remove_cart_item( $cart_item_key );
                    }
              }
            }
          }
        }
    }

    echo json_encode( $cart );
    wp_die();
}

// Here I modify two more hooks for plus/minus button








function get_free_shipping_minimum($zone_name = 'England') {
    if ( ! isset( $zone_name ) ) return null;
  
    $result = null;
    $zone = null;
  
    $zones = WC_Shipping_Zones::get_zones();
    foreach ( $zones as $z ) {
      if ( $z['zone_name'] == $zone_name ) {
        $zone = $z;
      }
    }
  
    if ( $zone ) {
      $shipping_methods_nl = $zone['shipping_methods'];
      $free_shipping_method = null;
      foreach ( $shipping_methods_nl as $method ) {
        if ( $method->id == 'free_shipping' ) {
          $free_shipping_method = $method;
          break;
        }
      }
  
      if ( $free_shipping_method ) {
        $result = $free_shipping_method->min_amount;
      }
    }
  
    return $result;
}

add_action( 'woocommerce_before_mini_cart', 'action_woocommerce_before_mini_cart', 10, 0 );

function action_woocommerce_before_mini_cart () {
    global $woocommerce;
    $free_shipping_en = get_free_shipping_minimum( 'Free Shipping' );
    $count = intval($woocommerce->cart->get_cart_contents_count());
    $subtotal = $woocommerce->cart->get_cart_contents_total();
    if ( $free_shipping_en ) {
        $free_shipping_min = $free_shipping_en;
        
            if($count > 0) {
                ?>
                    <div class="show-free-shiping-wrapper">
                        <div class="title-amount-shipping">
                            <div class="title">
                                <?php 
                                    if($subtotal<$free_shipping_min) {
                                        ?>
                                            <span class="text">Free Shipping </span>
                                            <span class="price"><?php echo get_woocommerce_currency_symbol().$free_shipping_min.'+'?> </span>
                                        <?php
                                    }else{
                                        ?>
                                        <p class="congra">Congratulations! You have received Free Shipping!</p>
                                        <?php
                                    }
                                ?>   
                            </div>
                        </div>
                        <div class="inprogress-bar-free-shiping">
                            <?php 
                                $width = $subtotal/$free_shipping_min;
                                if($width<1) {
                                    $width_css = $width*100;
                                }else{
                                    $width_css = 100;
                                }
                            ?>
                            <div class="bar-prgress-all">
                                <span style="width:<?php echo $width_css.'%' ?>"></span>
                            </div>
                        
                        </div>
                        <?php 
                         if($subtotal<$free_shipping_min) {
                            $number_change = $free_shipping_min - $subtotal;
                            ?>
                             <div class="text-more-add-pr">
                                <span class="text">Add</span>
                                <span class="price"><?php echo get_woocommerce_currency_symbol().$number_change?> </span>
                                <span class="text">For Free Shipping!</span>
                             </div>
                            <?php
                         }
                        ?>
                    </div>
                <?php
            }
    }
}
 

// add_action( 'woocommerce_after_mini_cart', 'add_promo_product_gift', 10, 0 );

function add_promo_product_gift() {
  global $woocommerce;
  $list_promo = get_field('list_product_promo','options');
  $subtotal = $woocommerce->cart->get_cart_contents_total();
  $list_price_spend = [];
  $text_show_free_cart = '';
  $cart = WC()->cart;
  $key_promo_active;
  $pass_spend = false;
  foreach( $cart->get_cart() as $cart_item_key => $cart_item ) {
      foreach ($list_promo as $key_pr => $id_pr) {
          if($cart_item['product_id'] == $id_pr) {
              $key_promo_active = $key_pr;
          }
      }
  }
  if(!empty($list_promo)) {
    foreach ($list_promo as $key => $value) {
      array_push($list_price_spend, get_field('limit_show_promo_gift',$value));
    }
    if(!empty($list_price_spend)) {
      
      foreach ($list_price_spend as $key => $value) {
        if($key==0) {
          if($subtotal<$list_price_spend[0]) {
            $add_price = $list_price_spend[0] - $subtotal;
            $text_show_free_cart = '<p class="text-add-more">Add <span class="price_add">'.get_woocommerce_currency_symbol().$add_price.'</span> more to your cart for a FREE gift!</p><span class="text-only-atc">Only 1 gift per cart</span>';
            break;
          }else{
            $text_product_unlock = 'Congrats! You Qualified for ' .get_the_title($list_promo[$key]);
          }
        }else {
          if($subtotal<$list_price_spend[$key]) {
            $add_price = $list_price_spend[$key] - $subtotal;
            $text_show_free_cart = '<p class="text-add-more">Add <span class="price_add">'.get_woocommerce_currency_symbol().$add_price.'</span> more to unlock the next FREE gift!</p><span class="text-only-atc">Only 1 gift per cart</span>';
            break;
          }else{
            $text_product_unlock = 'Congrats! You Qualified for ' .get_the_title($list_promo[$key]);
            if($subtotal>$list_price_spend[count($list_price_spend) - 1]) {
              $text_product_unlock = 'Congrats! You Qualified all the gifts!';
              $text_show_free_cart = '<span class="text-only-atc">Only 1 gift per cart</span>';
            }
          }
        }
      }
    }
    ?>
      <div class="wrapper-list-product-promo">
          <div class="congra-product">
              <?php 
                echo $text_product_unlock;
              ?>
          </div>
          <div class="title-ss-promo">
              <?php echo $text_show_free_cart?>
          </div>


          <div class="list-product">
              <?php 
                foreach ($list_promo as $key_pr_in => $pr) {
                  $price_spend = get_field('limit_show_promo_gift',$pr);
                  $price_promo = get_field('price_promo_gift',$pr);
                    if($subtotal<$price_spend){
                      ?>
                      <div class="item-disable">
                        <div class="count-spend">
                          Spend <?php echo get_woocommerce_currency_symbol().$price_spend?>+

                        </div>
                        <div class="item-promo-gift">
                          <div class="infor-pr">
                            <div class="left-item">
                              <img src="<?php echo get_the_post_thumbnail_url($pr,'post-thumbnail')?>"/>
                              <div class="pro-name">
                                <h3 class="title-product">
                                  <?php 
                                    echo get_the_title($pr);
                                    
                                  ?>
                                </h3>
                                <div class="price-text">
                                  <?php 
                                    
                                  ?>
                                  <span class="promo-price"><?php echo get_woocommerce_currency_symbol().$price_promo?></span>
                                  <span>- FREE</span>
                                </div>
                              </div>
                            </div>
                            <div class="lock-icon">
                              <img src="/wp-content/uploads/2023/11/lock-icon.png"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php
                    }else{
                      ?>
                      <div class="item-enable">
                        <div class="count-spend">
                          Spend <?php echo get_woocommerce_currency_symbol().$price_spend?>+

                        </div>
                        <div class="item-promo-gift">
                          <div class="infor-pr">
                            <div class="left-item">
                                <img src="<?php echo get_the_post_thumbnail_url($pr,'post-thumbnail')?>"/>
                                <div class="pro-name">
                                  <h3 class="title-product">
                                    <?php 
                                      echo get_the_title($pr);
                                      
                                    ?>
                                  </h3>
                                  <div class="price-text">
                                    <?php 
                                      
                                    ?>
                                    <span class="promo-price"><?php echo get_woocommerce_currency_symbol().$price_promo?></span>
                                    <span>- FREE</span>
                                  </div>
                                </div>
                              </div>
                              <div class="unlock-add-to-cart">
                                <?php 
                                  
                                  if(!is_null($key_promo_active)  ) {
                                    if($key_promo_active == $key_pr_in) {
                                        
                                      ?>  
                                      <div class="active-add-to-cart-mini"></div>
                                      <?php
                                    }else{
                                    ?>
                                      <a href="?add-to-cart=<?php echo $pr?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $pr?>" data-product_sku="" aria-label="" aria-describedby="" rel="nofollow">Add to Cart</a>
                                    <?php
                                  }
                                  }else{
                                    ?>
                                      <a href="?add-to-cart=<?php echo $pr?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $pr?>" data-product_sku="" aria-label="" aria-describedby="" rel="nofollow">Add to Cart</a>
                                    <?php
                                  }
                                  
                                ?>
                              </div>
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                }
              ?>

          </div>

      </div>
    <?php
  }
}

// add_filter( 'woocommerce_cart_item_price', 'custom_disable_product_add_promo', 11, 3 );

// function custom_disable_product_add_promo($html, $cart_item, $cart_item_key) {
//     if($cart_item['product_id']==4010644 || $cart_item['product_id']==4010645 || $cart_item['product_id']==4010646 || $cart_item['product_id']==4010647) {
//       $product = wc_get_product( $cart_item['product_id'] );
//       $html = $product->get_price_html();;
//       return $html;
//     }else{
//       return $html;
//     }
// }


function check_cart_after_update() {

    $list_promo = get_field('list_product_promo','options');

    if(!empty($list_promo)) {
      $cart_new = WC()->cart;
      $subtotal_new = WC()->cart->get_cart_contents_total();
      foreach ($list_promo as $key => $pr_cart) {
        $spend_limit = get_field('limit_show_promo_gift',$pr_cart);
        if($subtotal_new<$spend_limit) {
          foreach( $cart_new->get_cart() as $cart_item_key => $cart_item ) {
                if ( $cart_item['product_id'] == $pr_cart ) {
                    $cart_new->remove_cart_item( $cart_item_key );
                }
          }
        }
      }
    }
}
  // Run the check_cart_after_update() function on the cart and checkout pages
  // add_action( 'woocommerce_before_cart', 'check_cart_after_update',10 );
  // add_action( 'woocommerce_before_checkout_form', 'check_cart_after_update',10 );
  
  
  // add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment',11);
  function woocommerce_header_add_to_cart_fragment( $fragments ) {
    $list_promo = get_field('list_product_promo','options');

    if(!empty($list_promo)) {
      $cart_new = WC()->cart;
      $subtotal_new = WC()->cart->get_cart_contents_total();
      foreach ($list_promo as $key => $pr_cart) {
        $spend_limit = get_field('limit_show_promo_gift',$pr_cart);
        if($subtotal_new<$spend_limit) {
          foreach( $cart_new->get_cart() as $cart_item_key => $cart_item ) {
                if ( $cart_item['product_id'] == $pr_cart ) {
                    $cart_new->remove_cart_item( $cart_item_key );
                }
          }
        }
      }
    }
    return $fragments;
  }
  
  // add_filter('woocommerce_add_to_cart_validation', 'remove_cart_item_before_add_to_cart_advi', 1, 3);
  function remove_cart_item_before_add_to_cart_advi($passed, $product_id, $quantity) {
      $category = 'gift-promo';
      if( $product_id == 4013562 || $product_id == 4013566 || $product_id == 4013567 || $product_id == 4013568) {
          if($quantity>1) {
              $passed = false;
          }
          
      }
      if( has_term( $category, 'product_cat', $product_id ) ) {
          foreach( WC()->cart->get_cart() as $item_key => $cart_item ){
              if( has_term( $category, 'product_cat', $cart_item['product_id'] ) ) {
                  WC()->cart->remove_cart_item( $item_key );
              }
          }
      }
      return $passed;
  }
  

// add_filter( 'wp_ajax_nopriv_ajax_update_mini_cart', 'ajax_update_mini_cart' );
// add_filter( 'wp_ajax_ajax_update_mini_cart', 'ajax_update_mini_cart' );

?>