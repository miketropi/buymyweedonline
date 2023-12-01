<?php
/**
 * The template for displaying the header.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
   
	<link rel="profile" href="https://gmpg.org/xfn/11">
     


	<!-- Anti-flicker snippet (recommended)  -->
	<style>.async-hide { opacity: 0 !important} </style>
	<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
	h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
	(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
	})(window,document.documentElement,'async-hide','dataLayer',1000,
	{'GTM-T6L9FFJ':true});</script>
	

	<meta name="google-site-verification" content="XHGLY1-Lv-vdDcoRgokuTAzi8M2vTWxzfAnxLc0mz40" />
  <LINK REL="STYLESHEET" HREF="HTTPS://CDNJS.CLOUDFLARE.COM/AJAX/LIBS/FONT-AWESOME/5.15.4/CSS/ALL.MIN.CSS" />
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- <link href="https://file.myfontastic.com/ybsLYh9yntbEjP2EQ9VAE5/icons.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet"> -->


	<?php if( is_checkout()){?>
	<script>
	window.onload = function(){
	var e = document.getElementById("billing_state");
	      var get = e.options[e.selectedIndex].value;
	if (get==='NU' || get==='QC'){
	ga('send', 'event', 'AM Tracking', 'Checkout Province Warning');
	$('#check').append('<div id="test"><p>Unfortunately we experience a higher percentage of losses when we ship here.</p><p class="ptag">We cannot offer any delivery guarantees if you live in Nunavut or Northern Quebec and you will be ordering at your own risk. If your order is stolen or lost, we reserve the right not to replace it.</p><span id="smalltxt"><abbr class="red_star">*** </abbr>Rest assured, if you\'re shipping to South Quebec your order is still insured<abbr class="red_star"> ***</abbr></span><p class="form-row input-checkbox validate-required" id="state_warn_field" data-priority=""><label class="checkbox "><input class="input-checkbox " name="state_warn" id="state_warn" value="1" type="checkbox"> Yes, I would like to continue anyways and take the risk.<abbr class="required" title="required">*</abbr></label></p></div>');
	     }else{
	 $('#test').remove();
	      $('#test2').remove();
	      $('#check').append('<div id="test2"><input class="input-checkbox " name="state_warn" id="state_warn" value="1" type="checkbox" checked>a</div>');
	}
	}

	$(document).ready(function(){
	var state = document.getElementById('billing_state');
	state.onchange = function(){
	var e = document.getElementById("billing_state");
	      var get = e.options[e.selectedIndex].value;
	      if (get==='NU' || get==='QC') {
	ga('send', 'event', 'AM Tracking', 'Checkout Province Warning');
	        $('#test').remove();
	        $('#test2').remove();
	    $('#check').append('<div id="test"><p>Unfortunately we experience a higher percentage of losses when we ship here.</p><p class="ptag">We cannot offer any delivery guarantees if you live in Nunavut or Northern Quebec and you will be ordering at your own risk. If your order is stolen or lost, we reserve the right not to replace it.</p><span id="smalltxt"><abbr class="red_star">*** </abbr>Rest assured, if you\'re shipping to South Quebec your order is still insured<abbr class="red_star"> ***</abbr></span><p class="form-row input-checkbox validate-required" id="state_warn_field" data-priority=""><label class="checkbox "><input class="input-checkbox " name="state_warn" id="state_warn" value="1" type="checkbox"> Yes, I would like to continue anyways and take the risk.<abbr class="required" title="required">*</abbr></label></p></div>');
	      }else{
	     $('#test').remove();
	      $('#test2').remove();
	      $('#check').append('<div id="test2"><input class="input-checkbox " name="state_warn" id="state_warn" value="1" type="checkbox" checked>a</div>');
	      } 
	      }
	  });

	</script>
	  <?php }?>

	<?php wp_head(); ?>
        
   <script type="text/javascript" src="https://onsite.optimonk.com/script.js?account=188220" async></script>

</head>
<body <?php body_class(); ?> <?php generate_do_microdata( 'body' ); ?>>
	
	<?php
	/**
	 * wp_body_open hook.
	 *
	 * @since 2.3
	 */
	do_action( 'wp_body_open' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core WP hook.

	/**
	 * generate_before_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_do_skip_to_content_link - 2
	 * @hooked generate_top_bar - 5
	 * @hooked generate_add_navigation_before_header - 5
	 */
	do_action( 'generate_before_header' );

	/**
	 * generate_custom_utility hook.
	 *
	 * @since 1.3.42
	 *
	 * custom hook to add an additional bar above header
	 */
	do_action( 'generate_custom_utility' );

	/**
	 * generate_header hook.
	 *
	 * @since 1.3.42
	 *
	 * @hooked generate_construct_header - 10
	 */
?>
 <?php
	do_action( 'generate_header' );

	/**
	 * generate_after_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_featured_page_header - 10
	 */
	 do_action( 'generate_after_header' );

	echo do_shortcode('[secure_payments_icons]');
	?>

	<div id="page" <?php generate_do_element_classes( 'page' ); ?>>
		<?php
		/**
		 * generate_inside_site_container hook.
		 *
		 * @since 2.4
		 */
		do_action( 'generate_inside_site_container' );
		?>
		<div id="content" class="site-content">
			<?php
			/**
			 * generate_inside_container hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_inside_container' );