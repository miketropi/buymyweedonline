<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) ) );

?>
<?php if ( $heading ) : ?>

<?php endif; ?>

  <?php if( have_rows('product_specs')): ?>
    
    <?php while( have_rows('product_specs')): the_row(); ?>
    
  
    <div class="bmwo-progress-col-specs tabcontent" id="product_specs" style="display:block;">
    <?php if ( $heading ) : ?>
	<h2><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>
     <?php the_content(); ?>
   
      <?php if(get_sub_field('1specs_name',get_the_ID()) != ''): 
    $value = get_sub_field('1specs_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('1specs_name',get_the_ID()); ?></span>
    <div class="bmwo-progress-specs">
    <div class="bmwo-progress-bar "><?php echo $value; ?></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>

    <?php if(get_sub_field('2specs_name',get_the_ID()) != ''): 
    $value = get_sub_field('2_specs_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('2specs_name',get_the_ID()); ?></span>
    <div class="bmwo-progress-specs">
    <div class="bmwo-progress-bar"><?php echo $value; ?></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>

    <?php if(get_sub_field('3_specs_name',get_the_ID()) != ''): 
    $value = get_sub_field('3_specs_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('3_specs_name',get_the_ID()); ?></span>
    <div class="bmwo-progress-specs">
    <div class="bmwo-progress-bar"><?php echo $value; ?></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>

    <?php if(get_sub_field('4_specs_name',get_the_ID()) != ''):
    $value = get_sub_field('4_specs_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('4_specs_name',get_the_ID()); ?></span>
    <div class="bmwo-progress-specs">
    <div class="bmwo-progress-bar"><?php echo $value; ?></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>

    <?php if(get_sub_field('5_specs_name',get_the_ID()) != ''):
    $value = get_sub_field('5_specs_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('5_specs_name',get_the_ID()); ?></span>
    <div class="bmwo-progress-specs">
    <div class="bmwo-progress-bar"><?php echo $value; ?></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>
        
    <?php if(get_sub_field('6_specs_name',get_the_ID()) != ''):
    $value = get_sub_field('6_specs_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('6_specs_name',get_the_ID()); ?></span>
    <div class="bmwo-progress-specs">
    <div class="bmwo-progress-bar"><?php echo $value; ?></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>  
     
     <?php if(get_sub_field('7_specs_name',get_the_ID()) != ''):
    $value = get_sub_field('7_specs_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('7_specs_name',get_the_ID()); ?></span>
    <div class="bmwo-progress-specs">
    <div class="bmwo-progress-bar"><?php echo $value; ?></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>
        
      <?php if(get_sub_field('8_specs_name',get_the_ID()) != ''):
    $value = get_sub_field('8_specs_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('8_specs_name',get_the_ID()); ?></span>
    <div class="bmwo-progress-specs">
    <div class="bmwo-progress-bar"><?php echo $value; ?></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>
        
  <?php if(get_sub_field('9_specs_name',get_the_ID()) != ''):
    $value = get_sub_field('9_specs_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('9_specs_name',get_the_ID()); ?></span>
    <div class="bmwo-progress-specs">
    <div class="bmwo-progress-bar"><?php echo $value; ?></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>
 </div>
    <?php endwhile;
    endif; ?>