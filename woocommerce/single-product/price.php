<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

global $product;

?>
<p class="price"><?php echo $product->get_price_html(); ?></p>
<?php //woo_in_cart($product->id); ?>
<?php
$ImageUrl = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' )[0];
$ItemId = $product->id;
$Title = $product-> get_title();
$ProductUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$CurrencySymbol = get_woocommerce_currency_symbol();
$Currency = get_woocommerce_currency();
$Price = $product->get_price();
$RegularPrice = $product->get_regular_price();
if($RegularPrice != ''){
  $DiscountAmount = $RegularPrice - $Price;
}else{
  $DiscountAmount = 0;
}
$terms = get_terms( 'product_tag' );
$parts = parse_url("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$path_parts= explode('/', $parts['path']);
$prhandle = $path_parts[2];
?>
<script>
 var Title = "<?php echo $Title; ?>";
 var ItemId = "<?php echo $ItemId; ?>";
 var ImageUrl = "<?php echo $ImageUrl; ?>";
 var ProductUrl = "<?php echo $ProductUrl; ?>";
 var CurrencySymbol = "<?php echo $CurrencySymbol; ?>";
 var Currency = "<?php echo $Currency; ?>";
 var Price = "<?php echo $Price; ?>";
 var DiscountAmount = "<?php echo $DiscountAmount; ?>";
 var RegularPrice = "<?php echo $RegularPrice; ?>";
 var ProductHandle = "<?php echo $prhandle; ?>";
 var _learnq = _learnq || [];

    _learnq.push(['track', 'Viewed Product', {
      Title: Title,
      ItemId: ItemId,
      ImageUrl: ImageUrl,
      Url: ProductUrl,
	  Handle: ProductHandle,
      Metadata: {
        Currency: Currency,
        CurrencySymbol: CurrencySymbol,
        DiscountAmount: DiscountAmount,
        RegularPrice: RegularPrice,
		Price: Price
      }
 }]);
 </script>