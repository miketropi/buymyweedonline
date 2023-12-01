<?php
/**
 * The template for displaying Archive pages.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<div <?php generate_do_attr( 'content' ); ?>>
        
 <?php
	$categories = get_categories( array (
    'taxonomy' => 'recipe-course',
    'orderby'  => 'name',
) );

if( empty( $categories ) ) {
    return;
}

?>
<div class="dr-archive-all-categories" style="display:none;">
    <div class="dr-title">
      <h2 class="Recipes-heading">Recipes</h2>
       <p>Welcome to the BMWO Cannabis Recipes section. Below you will find dozens of recipes across 18 different categories, prepared by our in-house culinary experts. BMWO has been serving the cannabis community in Canada for the past several years and with this new section, we hope to help our customers with preparing marijuana edibles and cooking with cannabis.</p>
    </div>
    <div class="dr-archive-cat-wrap">
        <ul class="recipe-category">
             <?php foreach( $categories as $category ) :
 			$category_images = get_field('course_image', $category);?>
            <li class="recipe-category-list">
                <a class="viewrecipes-all" href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>"
                    alt="<?php 
                        /* translators: %s: category name */
                        echo esc_attr( sprintf( __( 'View all recipes in %s', 'delicious-recipes' ), $category->name ) ); 
                    ?>">
                <?php
                     echo esc_html( $category->name ); ?>
 </a>
                      
                         <a class="view-recipes-scnd" href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>">
                         <?php
                        if ($category_images) {
            foreach ($category_images as $image) {
                 $first_image_url = reset($image);
 		if (filter_var($first_image_url, FILTER_VALIDATE_URL)) {?>
                    <img src=<?php echo esc_url($first_image_url);?> />
                        <?php
                }
            }
        }?>
         </a>       
        </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>

		<main <?php generate_do_attr( 'main' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			if ( generate_has_default_loop() ) {
				if ( have_posts() ) :

					/**
					 * generate_archive_title hook.
					 *
					 * @since 0.1
					 *
					 * @hooked generate_archive_title - 10
					 */
					do_action( 'generate_archive_title' );

					/**
					 * generate_before_loop hook.
					 *
					 * @since 3.1.0
					 */
					do_action( 'generate_before_loop', 'archive' );

					while ( have_posts() ) :

						the_post();

						generate_do_template_part( 'archive' );

					endwhile;

					/**
					 * generate_after_loop hook.
					 *
					 * @since 2.3
					 */
					do_action( 'generate_after_loop', 'archive' );

				else :

					generate_do_template_part( 'none' );

				endif;
			}

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

	get_footer();