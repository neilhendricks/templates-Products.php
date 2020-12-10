<?php
/**
 * Template Name: Products Template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
get_header();

$status = get_field('status');
//echo $status; this works :)


//custom query
$products = new WP_Query(array( //creating new WP_Query object
    'post_type' => 'Products',
    'meta_key' => 'status', //Custom field status
    'meta_compare' => '=', //compares Custom field, defined status above
    'meta_value' => 'active' // checks to see if custom field value is = to active   
));

while($products->have_posts() ) { //have_posts determines if there are posts to loop 
    $products->the_post(); //the_post() iterates the post index, getting all the posts

    //$products-get_post_type(); //Retrieves the post type of the current post or of a given post.
    //get_template_part( 'template-parts/content', get_post_type() );

    //testing links below, need to remove two lines of code below
    echo esc_url( get_permalink($post->ID));
    ?><a href=" <?php  esc_url( get_permalink($post->ID) ) ?> ">  <?php  the_field("title"); ?> </a><?php

//change header to div
    ?>
<header class="entry-header has-text-align-center<?php echo esc_attr( $entry_header_classes ); ?>">

	<div class="entry-header-inner section-inner medium">
    <ul class="blog-categories">
   <?php
    //get all the categories the post belongs to
    $categories = wp_get_post_categories( get_the_ID() );
    //loop through them
    foreach($categories as $c){
     $cat = get_category( $c );
      //get the name of the category
      $cat_id = get_cat_ID( $cat->name );
      //make a list item containing a link to the category
      echo '<li><a href="'.get_category_link($cat_id).'">'.$cat->name.'</a></li>';
    }
  ?> 
 </ul> 

	
		
		<?php
    if ( is_singular() ) { //Determines whether the query is for an existing single post of any post type. added esc_url to h1 right below, copied from h2 below
        the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h1>' );
        ?><h1 class="entry-title">   

            <a href=" <?php  esc_url( get_permalink($id) ) ?> ">
                <?php  the_field("product_title"); ?> </a>
            
            </h1>
         <!-- <a href='" . get_permalink() . "'>read more</a> --> <?php 
    } else {
        the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
    }
    echo "<br>";

    ?><a href=" <?php  esc_url( get_permalink($products->the_permalink()) ) ?> ">  <?php  the_field("title"); ?> </a><?php

	$terms = wp_get_post_terms($post->ID, 'products_category');// retrieve terms (categories)
	                   
    foreach($terms as $term_single) { // display terms with each post
        echo '<a href="'.get_term_link($term_single->slug, 'products_category').'">'. $term_single->slug .'</a>' . '   ';
	}
	
	echo "<img src='".get_field("image") ."'>";
	echo "<br>";
    //the_field("description");
    the_field('short_description');
    
    echo "<br>";
    echo "<br>";
    ?>
    }
