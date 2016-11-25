<?php
/**
 * Plugin Name: Ajax Form List
 * Plugin URI: https://mer.vin
 * Description: Allow users to change the list of Posts under a category. 
 * Version: 1.0.0
 * Author: Mervin Praison
 * Author URI: https://mer.vin
 * License: GPL2
 */

add_action( 'wp_enqueue_scripts', 'ajax_form_list_enqueue_scripts' );
function ajax_form_list_enqueue_scripts() {
	if( is_single() ) {
		wp_enqueue_style( 'formlist', plugins_url( '/form.css', __FILE__ ) );
	}

	wp_enqueue_script( 'formlist', plugins_url( '/form.js', __FILE__ ), array('jquery'), '1.0', true );

	wp_localize_script( 'formlist', 'catformlist', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
  		'ajax_nonce' => wp_create_nonce('name_of_nonce_field'),
	));

}

add_shortcode( 'form_list' , 'ajax_form_list_display' );
function ajax_form_list_display() {
	$value = '';

	if ( is_single() ) {
	
	// Start of Category Link List

	$terms = get_terms( array(
	    'taxonomy' => 'category',
	    'hide_empty' => true,
	) );

	$category_text .= '<ul>';
	foreach ($terms as $term) {
		$term_ids[] = $term->term_id;

		$category_text .= '<li class="cat-list-received"><a id="cat-list-button-id" class="cat-list-button" href="#" data-id-list="' . get_the_ID() .'" data-category-list="' . $term->term_id . '">'.$term->name.'</a></li>';
	}

	$category_text .= '</ul>';

	// End of Category Link List



	// Start of Category Form for the current post

	

		$prev_cat_id = get_post_meta( get_the_ID(), 'form_cat', true );
		$term = get_term($prev_cat_id);

		$args = array(
			'show_option_all'    => '',
			'show_option_none'   => '',
			'option_none_value'  => '-1',
			'orderby'            => 'ID',
			'order'              => 'ASC',
			'show_count'         => 0,
			'hide_empty'         => 1,
			'child_of'           => 0,
			'exclude'            => '',
			'include'            => '',
			'echo'               => 0,
			'selected'           => $prev_cat_id,
			'hierarchical'       => 0,
			'name'               => 'cat_name',
			'id'                 => 'cat_name',
			'class'              => 'cat_name',
			'depth'              => 0,
			'tab_index'          => 0,
			'taxonomy'           => 'category',
			'hide_if_empty'      => false,
			'value_field'	     => 'term_id',
		);

		$value ='
		<form class="form" method="post" id="ajax-form-list" action="/aah/wp-admin/admin-ajax.php">
		<input type="hidden" name="action" value="form_list">
		<input type="hidden" name="post_id" id="post_id" value="'.get_the_ID().'">';
		$value .= wp_dropdown_categories($args);
		//$value .= wp_nonce_field( 'contact_form_nonce_2', 'name_of_nonce_field' );
		$value .= '<button type="submit" class="btn">Submit</button></form>';




		$value .= '<br /><span id="cat-form-output">'.$term->name.'</span>';


	// End of Category Form for the current post




	} // End of Is single


		

	


	return $category_text.'<span id="cat-display"></span>'.$value;

}

add_action('wp_ajax_form_list', 'form_list');
add_action('wp_ajax_nopriv_form_list', 'form_list');

function form_list()
{

    if (
    	!wp_verify_nonce( $_REQUEST['security'], 'name_of_nonce_field')
    	) {

        exit('The form is not valid'); 
    }
 
    // ... Processing further

	$cat_name = $_REQUEST['cat_name']; 
	$post_id = $_REQUEST['post_id'];

	if($cat_name&&$post_id) {
		wp_set_post_categories( $post_id, $cat_name, false );
	}

	$term = get_term($cat_name);

	$category = $_REQUEST['cat_name'];
	$args = array( 'posts_per_page' => 1000, 'order'=> 'ASC', 'orderby' => 'title', 'category' => $category );
	$postslist = get_posts( $args );

	$response .= '<h2>'.get_the_category_by_ID($category[0]).'</h2><ul>';
	foreach ( $postslist as $post ) :
  	setup_postdata( $post ); 
		$response .= '<li>'.$post->post_title.'</li>';
	endforeach; 
	$response .= '</ul>';
	wp_reset_postdata();


	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
		echo $term->name. $response .' <span style="color:LightGreen;" >Updated</span>';
		die();
	}
	else {
		wp_redirect( get_permalink( $_REQUEST['post_id'] ) );
		exit();
	}
}