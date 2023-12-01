<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

global $wp;
$order = new WC_Order($wp->query_vars['order-received']);
?>
<div class="woocommerce-order thank-u-page">

	<?php if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>
	
		<?php else : ?>

<div class="big-txt">
            <p class="pay-intructions-red"><strong>PLEASE NOTE - NEW AUTOMATIC PAYMENT INSTRUCTIONS FOR ALL CUSTOMERS:</strong></p>

    <h1 class="title-thanks">Thank you!</h1>
    <h1 class="title-thanks-page">Order Received</h1>
   <div class="social-share-thank-page"> <?php echo do_shortcode('[automatewoo_referrals_share_widget]');?> </div>
<p class="order-p">Congratulations on your recent purchase! We are excited to process your order, but we need to confirm payment before we can do so. Please follow these specific steps when setting up your payment with your bank: </p>
</div>
    
    
    <div class="checkout-instructions">
		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
</div>
<!--div class="custom-timer">
<script>function startTimer(duration, display) {
    var timer = duration,hours, minutes, seconds;
    setInterval(function () {
    hours=parseInt(23, 10)
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);
 		hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.textContent = hours + "   :   " + minutes+ "   :   " + seconds;
        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}
window.onload = function () {
    var fiveMinutes = 60 * 60-1,
        display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
};</script>
<span id="time">24 : 00 : 00</span> 
<div class="timeword"><span>Hour(s)</span><span>Minutes</span><span>Seconds
</span></div>
</div  -->

<div class="custom-timer">
<script>function Timer(duration, display) 
{
    var timer = duration, hours, minutes, seconds;
    setInterval(function () {
        hours = parseInt((timer /3600)%24, 10)
        minutes = parseInt((timer / 60)%60, 10)
        seconds = parseInt(timer % 60, 10);

                hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.text(hours +":"+minutes + ":" + seconds);

                --timer;
    }, 1000);
}

jQuery(function ($) 
{
    var twentyFourHours = 24 * 60 * 60;
    var display = $('#time');
    Timer(twentyFourHours, display);
});</script>
 <span id="time">24:59:59</span>
<div class="timeword"><span>Hour(s)</span><span>Minutes</span><span>Seconds
</span></div>
</div>    
    
    
		<!--	<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p> -->

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

        <?php //--------Custom code  for google ecommerce tracking--------//?>
 
<div id="ecommerce-data" style="display:none;">
<?php

foreach($order->get_items() as $item) {
	$product_qty= $item['qty'];
    $product_name = $item['name'];
	 $product_id = $item['product_id'];
	echo "<span class='ved'>".$product_name."</span>";
	echo "<span class='qty-class'>".$product_qty."</span>";
	echo "<span class='productid'>".$product_id."</span>";
	echo "<span class='price-class'>".$item['subtotal']."</span>";
}
echo "</div><div id='order-total'>".$order->get_total()."</div>";
echo "<div id='shipping'>".$order->get_total_shipping()."</div>";

//--=-=-=-=-==-=-=-=-end custom code------=-=-====-=-=//
?>

<div class="checkout-instructions instructions-bottom">
		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
</div>
<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received teast"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
            
	<?php endif; ?>
</div>