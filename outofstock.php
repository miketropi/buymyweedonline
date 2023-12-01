<?php
/*
Template Name: Out of stock
*/
get_header();


function vpagination($pages = '', $range = 4)
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


	?>
	
<div id="main-content">
<article id="post-24050" class="post-24050 page type-page status-publish hentry">
<div class="entry-content">
<div id="outofstock" class="et_pb_section et_pb_section_0 et_pb_with_background et_section_regular">
<div class=" et_pb_row et_pb_row_0">
<div class="et_pb_column et_pb_column_4_4  et_pb_column_0 et_pb_column_empty et_pb_css_mix_blend_mode_passthrough et-last-child vpad">
</div> 
</div> 
</div>
  <h1 style="text-align:center;margin-top: 30px;">OUT OF STOCK</h1>
<?php 

if(isset($_POST['oosfilter'])){
	$item =  $_POST['oosfilter'];
	}
	else
	{
	$item =  $_SESSION["ved"];
	}
	
	
	$html='<form action="" method="POST" name="results" class="et_pb_row oos_filter" style="width: 85%;"><h4>Sort By</h4>
<select name="oosfilter" id="oosfilter" class="sortby"  onchange="this.form.submit()">
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
echo $html;
?>

 <div class="et_pb_section et_pb_section_1 et_section_regular margint_top out-of-stock-products-section">
<div class=" et_pb_row et_pb_row_1">
<div class="et_pb_column et_pb_column_4_4  et_pb_column_1 et_pb_css_mix_blend_mode_passthrough et-last-child">
 <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_2">
<div class="et_pb_text_inner">
<div class="woocommerce columns-">
    <ul class="products">
<?php
    	
if (isset($_SESSION["ved"])) { // if normal page load with cookie
     $count = $_SESSION["ved"];
  }
  else
  { $count='default'; }
  
  
  if (isset($_POST['oosfilter'])) { //if form submitted
    setcookie('ved',$_POST['oosfilter'] , time() + (86400 * 30), "/");
$_SESSION["ved"]=$_POST['oosfilter'];
	
   $count=$_POST['oosfilter'];
 
  }
  if (!isset($_POST['oosfilter'])) { 
  $_POST['oosfilter']=$_SESSION["ved"];
   $count=$_POST['oosfilter'];
 
  }
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
						'orderby' => 'date',
						'order' => 'desc',
						'post_type' => 'product',
						'posts_per_page' => 28,
						'paged' => $paged
						
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
						'paged' => $paged
						
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
						'orderby' => 'date',
						'order' => 'desc',
						'posts_per_page' => 28,
						'paged' => $paged
						
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
						'paged' => $paged
						
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
						'orderby' => 'date',
						'order' => 'desc',
						'post_type' => 'product',
						'posts_per_page' => 28,
						'paged' => $paged
						
						
					);
			/************************************************/
			}
				
				
    $loop = new WP_Query( $argss );
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();
            woocommerce_get_template_part( 'content', 'product' );
        endwhile;
    } else {
        echo __( 'No products found' );
    }
	 vpagination($loop->max_num_pages);
    wp_reset_postdata();
	//return '<div class="woocommerce columns-">' . ob_get_clean() . '</div>';
?>
</ul>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php




get_footer();