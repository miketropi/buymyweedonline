<?php
/* Template Name: recipe content */

get_header();

$ridd = get_queried_object_id();
$rData = get_post_field('post_content', $ridd);
$sst = wp_strip_all_tags( $rData );
$rec_ids = substr($sst, 0, 7);
?>

<div id="main-content">
<a href="/recipe-contest/"><div class="banner-div">
</div> </a>
<?php if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
} ?>




	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area text1112">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="recipe-outer-container">
            <div class="recipe-inner-container" id="printableArea">              
            <?php
                $queried_post = get_post($rec_ids);
                $queries_postmeta = get_post_meta($rec_ids);
                //echo "<pre>";print_r($queries_postmeta);die;
                $original_ins = unserialize($queries_postmeta['wprm_instructions'][0]);
                $inst_array = $original_ins[0]['instructions'];
                
                $original_ings = unserialize($queries_postmeta['wprm_ingredients'][0]);
                $ings_array = $original_ings[0]['ingredients'];
                
                $original_img = $queries_postmeta;
                $original_serving = $queries_postmeta['wprm_servings'][0];
                $original_serving_unit = $queries_postmeta['wprm_servings_unit'][0];
                $original_time = $queries_postmeta['wprm_total_time'][0];
                $original_prep_time = $queries_postmeta['wprm_prep_time'][0];
				$total_time = $queries_postmeta['wprm_cook_time'][0]+$queries_postmeta['wprm_prep_time'][0]+$queries_postmeta['wprm_custom_time'][0];
				$round_time = round($total_time/60);
                //echo "<pre>";print_r($original_img);die;
                
                $args = array(
                    'post_parent' => $rec_ids,
                    'post_type'   => 'revision', 
                    'numberposts' => -1,
                    'post_status' => 'inherit' 
                );
                $children = get_children( $args );
                $key = key($children);
                $meta = get_post_meta($key);
                $unmeta = unserialize($meta['wprm_recipe'][0]);
               ?> 
                        <div class="recipe-data">
                            <h1 class="single-rec-title"><?php echo do_shortcode('[wprm-recipe-name]'); ?></h1>
            
                            <?php echo do_shortcode('[wprm-recipe-image]'); ?>
                            
                            <div class="rec-green-container">
                                <div class="rec-contain">
                                <div class="rec-white">
                                    <img src="/wp-content/uploads/2019/07/chef.png">
                                </div>
                            <div class="rec-green">
                                <?php echo do_shortcode('[wprm-recipe-servings-container label="Servings" style="inline" label_separator=": "]'); ?>
                            </div></div>
                            
                            <div class="rec-contain">
                                <div class="rec-white">
                                    <img src="/wp-content/uploads/2019/07/time.png">
                                </div>
                            <div class="rec-green">
                                <?php if($total_time<60){ echo "Time: ".$total_time." Mins"; } else { 
                                  if($round_time>1){  echo "Time: ".$round_time." hours"; }
                                  else { echo "Time: ".$round_time." hour"; }  } ?>
                            </div></div>
                                
                                <?php echo do_shortcode('[wprm-recipe-print icon="printer" style="wide-button" text_style="normal" border_color="#63b623" button_color="#63b623" icon_color="#ffffff" text_color="#ffffff"]'); ?>
                            </div> <!-- rec-green-container closed -->
                            
                            <div class="recipe_times">
                               <?php echo do_shortcode('[wprm-recipe-times-container shorthand="1" label_style="faded" style="table" label_separator="" table_border_color="#777777" table_border_style="solid"]'); ?>
                            </div> <!-- recipe_times div closed -->
                            
                            <div class="recipe_tags">
                                <?php echo do_shortcode('[wprm-recipe-tags-container label_style="faded" style="inline" label_separator=": "]'); ?>
                                <?php echo do_shortcode('[wprm-recipe-cost-container label="Cost" label_style="faded" style="inline" label_separator=": "]'); ?>
                            </div>
                            
                            <div class="recipe_author">
                                <?php echo do_shortcode('[wprm-recipe-author-container label="Author" label_style="faded" style="inline" label_separator=": "]'); ?>
                            </div>
                            
                                 

                            <p class="rec-content"><?php echo do_shortcode('[wprm-recipe-summary]'); ?></p>
                            
                            <?php if(do_shortcode('[wprm-recipe-ingredient]') != ''){ ?> 
                            <button id="recipe-button2" class="my-recipe-button2">Ingredients</button>
                            <?php echo do_shortcode('[wprm-recipe-ingredients notes_style="faded"]'); }?>
                            
                            <?php if(do_shortcode('[wprm-recipe-equipment]') != ''){ ?>   
                            <button id="recipe-button2" class="my-recipe-button2">Equipment</button>
                            <?php echo do_shortcode('[wprm-recipe-equipment]'); } ?>
                            
                          <?php if(do_shortcode('[wprm-recipe-instructions]') != ''){ ?>    
                          <button id="recipe-button2" class="my-recipe-button2">Instructions</button>
                          <?php echo do_shortcode('[wprm-recipe-instructions text_margin="5px" image_size="medium"]'); }?>
                          
                          <?php if(do_shortcode('[wprm-recipe-video]') != ''){ ?>
                          <button id="recipe-button2" class="my-recipe-button2">Video</button>
                          <?php echo do_shortcode('[wprm-recipe-video]'); } ?>
                           
                          <?php if(do_shortcode('[wprm-recipe-notes]') != ''){ ?>
                          <button id="recipe-button2" class="my-recipe-button2">Notes</button>
                           <?php echo do_shortcode('[wprm-recipe-notes]'); } ?>
                           
                          <?php if(do_shortcode('[wprm-nutrition-label]') != ''){ ?> 
                          <button id="recipe-button2" class="my-recipe-button2">Nutrition</button>
                           <?php echo do_shortcode('[wprm-nutrition-label style="simple"]'); } ?> 
                           
                            <div class="social-sharing"><?php echo do_shortcode('[Sassy_Social_Share title="Share The Love"]') ?></div>
                            
                        
                        
                        </div>  <!-- recipe-data closed -->
                  
               </div> <!-- recipe-inner-container cloased -->


<!--    RECIPE SIDEBAR START         -->          

<div class="recipe-sidebar">
    <button id="recipe-button3" class="my-recipe-button">Categories</button>
    
    <select name="recipe-categories" id="recipe-categories" onchange="location = this.value;">
        <option value="#">Select Category</option>
        <option value="/appetizers/">Appetizers</option>
        <option value="/beverages/">Beverages</option> 
        <option value="/bread/">Bread</option>
        <option value="/brunch">Brunch</option>
        <option value="/canna-butter/">Canna-Butter</option>
        <option value="/canna-oil/">Canna-Oil</option>
        <option value="/comfort-foods/">Comfort Foods</option>
        <option value="/desserts/">Dessert</option>
        <option value="/dressing-dip/">Dressing/Dip</option>
        <option value="/entrees/">Entrees</option>
        <option value="/everyday-meals/">Everyday Meals</option>
        <option value="/grilling/">Grilling</option>
        <option value="/infusions/">Infusions</option>
        <option value="/lunch/">Lunch</option>
        <option value="/salads/">Salads</option> 
        <option value="/snacks/">Snacks</option>
        <option value="/soups/">Soups</option>
        <option value="/vegetarian/">Vegetarian</option>
    </select>
    
   <div class="pinterest-widget">
      <a data-pin-do="embedBoard" data-pin-board-width="400" data-pin-scale-height="400" data-pin-scale-width="80" href="https://www.pinterest.com/BMWOCanada/cannabis-recipes/"></a>
    </div> 
    
    <button id="recipe-button3" class="my-recipe-button">Recent Recipes</button>
            <?php
            $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 3, // Number of recent posts thumbnails to display
                'post_status' => 'published', // Show only the published posts
                'post_type' => 'wprm_recipe'
            ));
            //echo '<pre>';print_r($recent_posts);
            $recentArray = array();
            foreach ($recent_posts as $posts){
                $recentArray[] = $posts['ID'];
            }

            foreach ($recentArray as $recipes){
                $queried_post = get_post($recipes);
                $queries_postmeta = get_post_meta($recipes);
                $parent_post = $queries_postmeta['wprm_parent_post_id'][0];
                $parent_post_data = get_post($parent_post);
                $parent_post_link = $parent_post_data->guid;
                $explode_link = explode("?", $parent_post_link);
				$new_parent_post_link = '/?'.$explode_link[1];
               //echo "<pre>";print_r($queries_postmeta);die;
                $url = wp_get_attachment_url( $queries_postmeta['_thumbnail_id'][0] );
                $total_time = $queries_postmeta['wprm_cook_time'][0]+$queries_postmeta['wprm_prep_time'][0]+$queries_postmeta['wprm_custom_time'][0];
                $round_time = round($total_time/60);
                $args = array(
                    'post_parent' => $recipes,
                    'post_type'   => 'revision', 
                    'numberposts' => -1,
                    'post_status' => 'inherit' 
                );
                $children = get_children( $args );
                $key = key($children);
                $meta = get_post_meta($key);
                $unmeta = unserialize($meta['wprm_recipe'][0]);
                $difname = $unmeta['tags']['keyword'][0]->name;
                $page_url = get_permalink( $queried_post );
                //echo "<pre>";print_r($unmeta);
                ?> 
                <div class="sidebar-recipe-group">
                <div class="sidebar-recipe-image">
                    <a href="<?php echo $page_url; ?>"> <img src="<?php echo $url ?>" width="300px"></a>
                </div> <!-- sidebar-recipe-image closed -->
                <div class="sidebar-recipe-data">
                  <a href="<?php echo $page_url; ?>">  <span class="sidebar-rec-title"><?php echo $queried_post->post_title; ?></span> </a>
                     <div class="sidebar-rec-group"><img src="/wp-content/uploads/2019/07/chef.png">&nbsp;&nbsp;&nbsp;&nbsp;<p>Serves: <?php echo $queries_postmeta['wprm_servings'][0].' '.$queries_postmeta['wprm_servings_unit'][0]; ?></p></div>
                    <div class="sidebar-rec-group"><img src="/wp-content/uploads/2019/07/time.png">&nbsp;&nbsp;&nbsp;&nbsp;<p><?php if($total_time<60){ echo "Time: ".$total_time." Mins"; } else {if($round_time>1){  echo "Time: ".$round_time." hours"; }else { echo "Time: ".$round_time." hour"; }} ?></p></div>                                                
        <!--      <div class="sidebar-rec-group"><img src="/wp-content/uploads/2019/07/icon.png" id="icon-img">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p>Difficulty: <?php if($difname != ''){
                        echo $difname;
                    } else {
                        echo 'easy';
                    } ?></p></div> -->      
                </div>  <!-- sidebar-recipe-data closed -->
                </div>  <!-- sidebar-recipe-group closed -->
                <?php } ?>                         
                </div> <!-- recipe-sidebar closed -->  
               </div> <!-- recipe-outer-container cloased -->     
				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

			</div> <!-- left-area -->

		</div> <!-- content-area -->
                <?php comments_template('/comments.php',true);  ?>
	</div> <!-- .container -->

</div> <!-- main-content -->

<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
</script>

<?php

get_footer();