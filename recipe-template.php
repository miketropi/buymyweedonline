<?php
/* Template Name: recipe list */

get_header();
?>

<div id="main-content">
    
<a href="/recipe-contest/"><div class="banner-div">
</div> </a><!-- banner div closed -->

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area ttttt">
			<h1 class="recipes-heading"><?php echo the_title();?></h1>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="recipe-outer-container">
                    <div class="recipe-inner-container">
					<?php
					$rec_ids = get_post_field('post_content', $post->ID);
            		$rec_array = explode(',', $rec_ids);
            		//print_r($rec_array);

            		 foreach ($rec_array as $recipes){
		                $queried_post = get_post($recipes);
		                $queries_postmeta = get_post_meta($recipes);
		                $parent_post= $queries_postmeta['wprm_parent_post_id'][0];
                $parent_post_data = get_post($parent_post);
                $parent_post_link = $parent_post_data->guid;
                $explode_link = explode("?", $parent_post_link);
				$new_parent_post_link = '/?'.$explode_link[1];
                $url = wp_get_attachment_url( $queries_postmeta['_thumbnail_id'][0] );
                         $total_time = $queries_postmeta['wprm_cook_time'][0]+$queries_postmeta['wprm_prep_time'][0]+$queries_postmeta['wprm_custom_time'][0];
                         $round_time = round($total_time/60);
                //echo "<pre>";print_r($queries_postmeta);die;
				 $page_url = get_permalink( $queried_post );
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
		                //echo "<pre>";print_r($unmeta);
		                ?>
		               <div class="recipe-group">
                        <div class="recipe-image">
                           <a href="<?php echo $page_url; ?>"> <img src="<?php echo $url; ?>" width="320px"></a>
                        </div> <!-- recipe-image closed -->
                        <div class="recipe-data">
                           <a href="<?php echo $page_url; ?>"> <span class="rec-how">How to make </span><br>
                            <h2 class="rec-title"><?php echo $queried_post->post_title; ?></h2></a>
                            
                            <div class="rec-contain">
                                <div class="rec-white">
                                    <img src="/wp-content/uploads/2019/07/chef.png">
                                </div>
                            <div class="rec-green">
                                <span>Serves: </span>
                                <?php echo $queries_postmeta['wprm_servings'][0].' '.$queries_postmeta['wprm_servings_unit'][0]; ?>
                            </div></div>
                                
                                <div class="rec-contain">
                                <div class="rec-white">
                                    <img src="/wp-content/uploads/2019/07/time.png">
                                </div>
                            <div class="rec-green">
                                <?php if($total_time<60){ echo "Time: ".$total_time." Mins"; } else {    
                                if($round_time>1){  echo "Time: ".$round_time." hours"; }
                                  else { echo "Time: ".$round_time." hour"; }  } ?></div></div>
                                    
                        </div>  <!-- recipe-data closed -->
                    </div>  <!-- recipe-group closed -->
                    <hr class="recipe-hr">	               
		               <?php } ?>
		        </div> <!-- recipe-inner-container cloased -->
                    <!-------      RECIPE SIDEBAR START         ----------->          

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
                //echo "<pre>";print_r($queried_post);die;
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
                    <a href="<?php echo $page_url; ?>"> <img src="<?php echo $url; ?>" width="300px"></a>
                </div> <!-- sidebar-recipe-image closed -->
                <div class="sidebar-recipe-data">
                  <a href="<?php echo $page_url; ?>">  <span class="sidebar-rec-title"><?php echo $queried_post->post_title; ?></span> </a>
                    <div class="sidebar-rec-group"><img src="/wp-content/uploads/2019/07/chef.png">&nbsp;&nbsp;&nbsp;&nbsp;<p>Serves: <?php echo $queries_postmeta['wprm_servings'][0].' '.$queries_postmeta['wprm_servings_unit'][0]; ?></p></div>
                    <div class="sidebar-rec-group"><img src="/wp-content/uploads/2019/07/time.png">&nbsp;&nbsp;&nbsp;&nbsp;<p><?php if($total_time<60){ echo "Time: ".$total_time." Mins"; } else {if($round_time>1){  echo "Time: ".$round_time." hours"; }else { echo "Time: ".$round_time." hour"; }} ?></p></div>
                </div>  <!-- sidebar-recipe-data closed -->
                </div>  <!-- sidebar-recipe-group closed -->
                <?php } ?>                         
                </div> <!-- recipe-sidebar closed -->  
               </div> <!-- recipe-outer-container cloased -->      
				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

			</div> <!-- #left-area -->

		</div> <!-- #content-area -->
	</div> <!-- .container -->

</div> <!-- #main-content -->

<?php

get_footer();