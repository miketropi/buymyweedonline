<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Automattic
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

?>
<div class="woocommerce-product-details__short-description"> 
    <?php //echo $short_description;  ?>
    
   
    
    
    
    
     <?php if( have_rows('quick_facts') ): ?>
         <?php while( have_rows('quick_facts') ): the_row(); ?>
 	<div class="unparalleled-experience">
       <?php if(get_sub_field('upload_image',get_the_ID()) != ''):?>       
  	 <div class="First-col">
   <?php $upload_image = get_sub_field('upload_image',get_the_ID());
     foreach ($upload_image as $upload_image1) {
        if (filter_var($upload_image1, FILTER_VALIDATE_URL)) {
        echo '<img src="' . esc_url($upload_image1) . '" />';
        $found_image = true;
        break; // Exit the loop after the first valid image is found
    }
           }?>
   
    </div>  
         <?php endif; ?>
     <?php  if(get_sub_field('enter_content',get_the_ID())  != ''): ?>
   <div class="First-col scnd-col">
      <div class="bmwo-progress-col-4 tabcontent" id="quick_facts">   
    <h2><?php echo get_sub_field('enter_heading',get_the_ID()); ?></h2>
     
    <p><?php echo get_sub_field('enter_content',get_the_ID()) ?></p>
      <?php echo do_shortcode('[shortcode_reviews]');?>
         
     </div>  
   </div> 
   <?php endif; ?>
   </div>
      <?php endwhile;
    endif; ?>
       
        
    <?php if( have_rows('Flavour') ): ?>
    <?php while( have_rows('Flavour') ): the_row(); ?>
        
 <div class="devoted"> 
        <?php  if(get_sub_field('enter_content',get_the_ID())  != ''): ?>
    <div class="First-col scnd-col">
       <div class="bmwo-progress-col-4 tabcontent" id="flavour">
   
    <h2><?php echo get_sub_field('enter_heading',get_the_ID()); ?></h2>
      
    <p><?php echo get_sub_field('enter_content',get_the_ID()) ?></p>
      <?php echo do_shortcode('[shortcode_reviews]');?>
         
     </div>  
     </div> 
            <?php endif; ?> 
  <?php if(get_sub_field('upload_image',get_the_ID()) != ''):?>    
    <div class="First-col">
   <?php $upload_image = get_sub_field('upload_image',get_the_ID());
     foreach ($upload_image as $upload_image1) {
        if (filter_var($upload_image1, FILTER_VALIDATE_URL)) {
        echo '<img src="' . esc_url($upload_image1) . '" />';
        $found_image = true;
        break; // Exit the loop after the first valid image is found
    }
           }?>
     
     </div> 
      <?php endif; ?> 
   </div>             
    <?php endwhile;
    endif; ?>            
                
 
        
<?php if( have_rows('strain_one') ): ?>
<?php while( have_rows('strain_one') ): the_row(); ?>
 
<div class="Commitment">
 
 <?php if(get_sub_field('1_attribute_value',get_the_ID()) != ''): ?>
  <div class="First-col">
	<div class="bmwo-progress-panel-container">
  	<div class="bmwo-progress-col-4 tabcontent" id="strain_one">
   
    
    
	<h4>General Effects</h4>
 	<?php   $value = get_sub_field('1_attribute_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('1_attribute_name',get_the_ID()); ?></span>
    <div class="bmwo-progress">
    <div class="bmwo-progress-bar bmwo-progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $value; ?>%"></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    

    <?php if(get_sub_field('2_attribute_name',get_the_ID()) != ''): 
    $value = get_sub_field('2_attribute_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('2_attribute_name',get_the_ID()); ?></span>
    <div class="bmwo-progress">
    <div class="bmwo-progress-bar bmwo-progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $value; ?>%"></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>

    <?php if(get_sub_field('3_attribute_name',get_the_ID()) != ''): 
    $value = get_sub_field('3_attribute_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('3_attribute_name',get_the_ID()); ?></span>
    <div class="bmwo-progress">
    <div class="bmwo-progress-bar bmwo-progress-bar-green" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $value; ?>%"></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>

    <?php if(get_sub_field('4_attribute_name',get_the_ID()) != ''):
    $value = get_sub_field('4_attribute_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('4_attribute_name',get_the_ID()); ?></span>
    <div class="bmwo-progress">
    <div class="bmwo-progress-bar bmwo-progress-bar-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $value; ?>%"></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>

    <?php if(get_sub_field('5_attribute_name',get_the_ID()) != ''):
    $value = get_sub_field('5_attribute_value',get_the_ID()); ?>
    <div class="bmwo-progress-bar-container">  
    <span><?php echo get_sub_field('5_attribute_name',get_the_ID()); ?></span>
    <div class="bmwo-progress">
    <div class="bmwo-progress-bar bmwo-progress-bar-green" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $value; ?>%"></div>
    </div>
    </div> <!-- bmwo-progress-bar-container -->
    <?php endif ?>

</div> <!-- bmwo-col-md-4 -->
</div>
</div><!-- bmwo-progress-panel-container -->
 <?php endif ?>
  
  <?php if( have_rows('effects_content') ): ?>
    <?php while( have_rows('effects_content') ): the_row(); ?>    
        <?php  if(get_sub_field('enter_content',get_the_ID())  != ''): ?>
   <div class="First-col scnd-col">
    <div class="bmwo-progress-col-4 tabcontent" id="effects_content">
   
    <h2><?php echo get_sub_field('enter_heading',get_the_ID()); ?></h2>
    
    <p><?php echo get_sub_field('enter_content',get_the_ID()) ?></p>
      <?php echo do_shortcode('[shortcode_reviews]');?>
         
       </div>  
     </div> 
     <?php endif; ?>
     <?php endwhile;
    endif; ?>
   </div>     
   <?php endwhile;
    endif; ?>
        
</div>