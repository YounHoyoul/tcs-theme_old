<?php
/**
Plugin Name: TCS Backend Customer Post Type For Portfolio
Plugin URI: 
Description: a plugin to create backend modules
Version: 1.0
Author: Luis Hoyoul Youn
Author URI: 
License: GPL2
*/
?>
<?php

//Brand Activation Custom Post Type
function tcs_hp_custom_post_brandactivation() {
	$labels = array(
		'name'               => _x( 'BrandActivations', 'post type general name' ),
		'singular_name'      => _x( 'BrandActivation', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'brandactivation' ),
		'add_new_item'       => __( 'Add New BrandActivation' ),
		'edit_item'          => __( 'Edit BrandActivation' ),
		'new_item'           => __( 'New BrandActivation' ),
		'all_items'          => __( 'All BrandActivation' ),
		'view_item'          => __( 'View BrandActivation' ),
		'search_items'       => __( 'Search BrandActivation' ),
		'not_found'          => __( 'No BrandActivation found' ),
		'not_found_in_trash' => __( 'No BrandActivation found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Brand'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our BrandActivations and BrandActivations specific data',
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array('slug' => 'brandactivations'),
		'menu_position' => 5,
		//'supports'      => array( 'title', 'editor', 'excerpt', 'custom-fields', 'comments', 'thumbnail', 'revision' ),
		//'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'thumbnail', 'revision' ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'revision' ),
		//'taxonomies'    => array( 'post_tag', 'category'),
		'taxonomies'    => array( 'post_tag'),
	);
	register_post_type( 'brandactivation', $args );
}
add_action( 'init', 'tcs_hp_custom_post_brandactivation' );

function tcs_hp_updated_messages_brandactivation( $messages ) {
	global $post, $post_ID;
	$messages['brandactivation'] = array(
		0 => '',
		1 => sprintf( __('BrandActivation updated. <a href="%s">View BrandActivation</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('BrandActivation updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('BrandActivation restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('BrandActivation published. <a href="%s">View BrandActivation</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Portfolio saved.'),
		8 => sprintf( __('BrandActivation submitted. <a target="_blank" href="%s">Preview BrandActivation</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('BrandActivation scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview BrandActivation</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('BrandActivation draft updated. <a target="_blank" href="%s">Preview BrandActivation</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'tcs_hp_updated_messages_brandactivation' );

function tcs_hp_contextual_help_brandactivation( $contextual_help, $screen_id, $screen ) {
	if ( 'brandactivation' == $screen->id ) {
		$contextual_help = '<h2>Portfolios</h2>
		<p>BrandActivation show the details of the items that we have done as the project so far. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p>
		<p>You can view/edit the details of each BrandActivation by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'edit-brandactivation' == $screen->id ) {
		$contextual_help = '<h2>Editing Portfolios</h2>
		<p>This page allows you to view/modify BrandActivation details. Please make sure to fill out the available boxes with the appropriate details.</p>';
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'tcs_hp_contextual_help_brandactivation', 10, 3 );

//Bespoke Solution Custom Post Type
function tcs_hp_custom_post_bespokesolution() {
	$labels = array(
		'name'               => _x( 'BespokeSolutions', 'post type general name' ),
		'singular_name'      => _x( 'BespokeSolution', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'bespokesolution' ),
		'add_new_item'       => __( 'Add New BespokeSolution' ),
		'edit_item'          => __( 'Edit BespokeSolution' ),
		'new_item'           => __( 'New BespokeSolution' ),
		'all_items'          => __( 'All BespokeSolution' ),
		'view_item'          => __( 'View BespokeSolution' ),
		'search_items'       => __( 'Search BespokeSolution' ),
		'not_found'          => __( 'No BespokeSolution found' ),
		'not_found_in_trash' => __( 'No BespokeSolution found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Bespoke'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our BespokeSolutions and BespokeSolutions specific data',
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array('slug' => 'bespokesolutions'),
		'menu_position' => 5,
		//'supports'      => array( 'title', 'editor', 'excerpt', 'custom-fields', 'comments', 'thumbnail', 'revision' ),
		//'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'thumbnail', 'revision' ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'revision' ),
		//'taxonomies'    => array( 'post_tag', 'category'),
		'taxonomies'    => array( 'post_tag'),
	);
	register_post_type( 'bespokesolution', $args );
}
add_action( 'init', 'tcs_hp_custom_post_bespokesolution' );

function tcs_hp_updated_messages_bespokesolution( $messages ) {
	global $post, $post_ID;
	$messages['bespokesolution'] = array(
		0 => '',
		1 => sprintf( __('BespokeSolution updated. <a href="%s">View BespokeSolution</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('BespokeSolution updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('BespokeSolution restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('BespokeSolution published. <a href="%s">View BespokeSolution</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Portfolio saved.'),
		8 => sprintf( __('BespokeSolution submitted. <a target="_blank" href="%s">Preview BespokeSolution</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('BespokeSolution scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview BespokeSolution</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('BespokeSolution draft updated. <a target="_blank" href="%s">Preview BespokeSolution</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'tcs_hp_updated_messages_bespokesolution' );

function tcs_hp_contextual_help_bespokesolution( $contextual_help, $screen_id, $screen ) {
	if ( 'bespokesolution' == $screen->id ) {
		$contextual_help = '<h2>Portfolios</h2>
		<p>BespokeSolution show the details of the items that we have done as the project so far. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p>
		<p>You can view/edit the details of each BespokeSolution by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'edit-bespokesolution' == $screen->id ) {
		$contextual_help = '<h2>Editing Portfolios</h2>
		<p>This page allows you to view/modify BespokeSolution details. Please make sure to fill out the available boxes with the appropriate details.</p>';
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'tcs_hp_contextual_help_bespokesolution', 10, 3 );

//Digital Platform Custom Post Type
function tcs_hp_custom_post_digitalplatform() {
	$labels = array(
		'name'               => _x( 'DigitalPlatforms', 'post type general name' ),
		'singular_name'      => _x( 'DigitalPlatform', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'digitalplatform' ),
		'add_new_item'       => __( 'Add New DigitalPlatform' ),
		'edit_item'          => __( 'Edit DigitalPlatform' ),
		'new_item'           => __( 'New DigitalPlatform' ),
		'all_items'          => __( 'All DigitalPlatform' ),
		'view_item'          => __( 'View DigitalPlatform' ),
		'search_items'       => __( 'Search DigitalPlatform' ),
		'not_found'          => __( 'No DigitalPlatform found' ),
		'not_found_in_trash' => __( 'No DigitalPlatform found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Digital'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our DigitalPlatforms and DigitalPlatforms specific data',
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array('slug' => 'digitalplatforms'),
		'menu_position' => 5,
		//'supports'      => array( 'title', 'editor', 'excerpt', 'custom-fields', 'comments', 'thumbnail', 'revision' ),
		//'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'thumbnail', 'revision' ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'revision' ),
		//'taxonomies'    => array( 'post_tag', 'category'),
		'taxonomies'    => array( 'post_tag'),
	);
	register_post_type( 'digitalplatform', $args );
}
add_action( 'init', 'tcs_hp_custom_post_digitalplatform' );

function tcs_hp_updated_messages_digitalplatform( $messages ) {
	global $post, $post_ID;
	$messages['digitalplatform'] = array(
		0 => '',
		1 => sprintf( __('DigitalPlatform updated. <a href="%s">View DigitalPlatform</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('DigitalPlatform updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('DigitalPlatform restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('DigitalPlatform published. <a href="%s">View DigitalPlatform</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Portfolio saved.'),
		8 => sprintf( __('DigitalPlatform submitted. <a target="_blank" href="%s">Preview DigitalPlatform</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('DigitalPlatform scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview DigitalPlatform</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('DigitalPlatform draft updated. <a target="_blank" href="%s">Preview DigitalPlatform</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'tcs_hp_updated_messages_digitalplatform' );

function tcs_hp_contextual_help_digitalplatform( $contextual_help, $screen_id, $screen ) {
	if ( 'digitalplatform' == $screen->id ) {
		$contextual_help = '<h2>Portfolios</h2>
		<p>DigitalPlatform show the details of the items that we have done as the project so far. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p>
		<p>You can view/edit the details of each DigitalPlatform by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'edit-digitalplatform' == $screen->id ) {
		$contextual_help = '<h2>Editing Portfolios</h2>
		<p>This page allows you to view/modify DigitalPlatform details. Please make sure to fill out the available boxes with the appropriate details.</p>';
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'tcs_hp_contextual_help_digitalplatform', 10, 3 );

//Sevice Taxonation
function tcs_hp_taxonomies_sevice() {
	$labels = array(
		'name'              => _x( 'Service Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Service Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Service Categories' ),
		'all_items'         => __( 'All Service Categories' ),
		'parent_item'       => __( 'Parent Service Category' ),
		'parent_item_colon' => __( 'Parent Service Category:' ),
		'edit_item'         => __( 'Edit Service Category' ),
		'update_item'       => __( 'Update Service Category' ),
		'add_new_item'      => __( 'Add New Service Category' ),
		'new_item_name'     => __( 'New Service Category' ),
		'menu_name'         => __( 'Service Categories' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'portfolio_category', array('brandactivation','bespokesolution','digitalplatform'), $args );
	//register_taxonomy_for_object_type('portfolio_category', 'portfolio');
}
add_action( 'init', 'tcs_hp_taxonomies_sevice', 0 );


//Post Meta Boxes For Brand Activation
add_action( 'add_meta_boxes', 'tcs_hp_brandactivation_additional_box' );
function tcs_hp_brandactivation_additional_box() {
	add_meta_box(
		'tcs_hp_brandactivation_additional_box',
		__( 'Additional Information', 'tcs_theme' ),
		'tcs_hp_brandactivation_additional_box_content',
		'brandactivation',
		'normal',
		'core'
	);
}

function tcs_hp_brandactivation_additional_box_content($post){
?>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
	<style> .media-upload h2 { font-weight: bold; } 
		.brandactivation_textarea {
			width:100%;
			height:80px;
		}
	</style>
	<script>
	( function( $ ) {
		$(document).ready(
			function()
			{
				$( "#brandactivation_date" ).datepicker();
				/*
				$('#upload_image_button').click(
					function()
					{
						tb_show('', 'media-upload.php?post_id=<?php  echo $post->ID; ?>&type=image&amp;TB_iframe=true');
						return false;
					}
				);
				*/
			}
		);
	})( jQuery );
	</script>

<?php
	wp_nonce_field( plugin_basename( __FILE__ ), 'tcs_hp_brandactivation_additional_box_content' );
	echo '<p><label for="brandactivation_date">Date :</label>';
	echo '<input type="text" id="brandactivation_date" name="brandactivation_date" placeholder="enter a date" value="'.get_post_meta($post->ID,'brandactivation_date',true).'"></p>';
	
	echo '<p><label for="brandactivation_task">Task :</label></p>';
	echo '<p><textarea id="brandactivation_task" name="brandactivation_task" class="brandactivation_textarea">'.get_post_meta($post->ID,'brandactivation_task',true).'</textarea></p>';
	
	echo '<p><label for="brandactivation_idea">Idea :</label></p>';
	echo '<p><textarea id="brandactivation_idea" name="brandactivation_idea" class="brandactivation_textarea">'.get_post_meta($post->ID,'brandactivation_idea',true).'</textarea></p>';
	
	echo '<p><label for="brandactivation_campaign">Campaign :</label></p>';
	echo '<p><textarea id="brandactivation_campaign" name="brandactivation_campaign" class="brandactivation_textarea">'.get_post_meta($post->ID,'brandactivation_campaign',true).'</textarea></p>';
	
	echo '<p><label for="brandactivation_success">Sucess :</label></p>';
	echo '<p><textarea id="brandactivation_success" name="brandactivation_success" class="brandactivation_textarea">'.get_post_meta($post->ID,'brandactivation_success',true).'</textarea></p>';
	
	echo '<p><label for="brandactivation_location">Location :</label></p>';
	echo '<p><textarea id="brandactivation_location" name="brandactivation_location" class="brandactivation_textarea">'.get_post_meta($post->ID,'brandactivation_location',true).'</textarea></p>';
	/*
?>
	<div class="media-upload">
		<h2>Upload Media</h2>
		<table>
			<tr valign="top">
				<td><input id="upload_image_button" type="button" value="Upload Media"></td>
			</tr>
		</table>
	</div>
<?php
	*/
}

function tcs_hp_admin_scripts()
{
	//wp_enqueue_script('media-upload');
	//wp_enqueue_script('thickbox');
	wp_enqueue_script('jquery-ui-datepicker');
}

function tcs_hp_admin_styles()
{
	//wp_enqueue_style('thickbox');
	wp_enqueue_style('jquery-ui');
}
add_action('admin_print_scripts', 'tcs_hp_admin_scripts');
add_action('admin_print_styles', 'tcs_hp_admin_styles');

add_action( 'save_post', 'tcs_hp_brandactivation_addition_box_save' );
function tcs_hp_brandactivation_addition_box_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	return;
	if ( !wp_verify_nonce( $_POST['tcs_hp_brandactivation_additional_box_content'], plugin_basename( __FILE__ ) ) )
	return;
	if ( 'brandactivation' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}
	
	//brandactivation_date
	$brandactivation_date = $_POST['brandactivation_date'];
	update_post_meta( $post_id, 'brandactivation_date', $brandactivation_date );
	
	//brandactivation_task
	update_post_meta( $post_id, 'brandactivation_task', $_POST['brandactivation_task'] );
	//brandactivation_idea
	update_post_meta( $post_id, 'brandactivation_idea', $_POST['brandactivation_idea'] );
	//brandactivation_campaign
	update_post_meta( $post_id, 'brandactivation_campaign', $_POST['brandactivation_campaign'] );
	//brandactivation_success
	update_post_meta( $post_id, 'brandactivation_success', $_POST['brandactivation_success'] );
	//brandactivation_location
	update_post_meta( $post_id, 'brandactivation_location', $_POST['brandactivation_location'] );
}

//Post Meta Boxes For Bespoke Solution
add_action( 'add_meta_boxes', 'tcs_hp_bespokesolution_additional_box' );
function tcs_hp_bespokesolution_additional_box() {
	add_meta_box(
		'tcs_hp_bespokesolution_additional_box',
		__( 'Additional Information', 'tcs_theme' ),
		'tcs_hp_bespokesolution_additional_box_content',
		'bespokesolution',
		'normal',
		'core'
	);
}

function tcs_hp_bespokesolution_additional_box_content($post){
?>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
	<style> .media-upload h2 { font-weight: bold; } 
		.bespokesolution_textarea {
			width:100%;
			height:80px;
		}
	</style>
	<script>
	( function( $ ) {
		$(document).ready(
			function()
			{
				$( "#bespokesolution_date" ).datepicker();
			}
		);
	})( jQuery );
	</script>

<?php
	wp_nonce_field( plugin_basename( __FILE__ ), 'tcs_hp_bespokesolution_additional_box_content' );
	echo '<p><label for="bespokesolution_date">Date :</label>';
	echo '<input type="text" id="bespokesolution_date" name="bespokesolution_date" placeholder="enter a date" value="'.get_post_meta($post->ID,'bespokesolution_date',true).'"></p>';
	
	echo '<p><label for="bespokesolution_challenge">Challenge :</label></p>';
	echo '<p><textarea id="bespokesolution_challenge" name="bespokesolution_challenge" class="bespokesolution_textarea">'.get_post_meta($post->ID,'bespokesolution_challenge',true).'</textarea></p>';
	
	echo '<p><label for="bespokesolution_solution">Solution :</label></p>';
	echo '<p><textarea id="bespokesolution_solution" name="bespokesolution_solution" class="bespokesolution_textarea">'.get_post_meta($post->ID,'bespokesolution_solution',true).'</textarea></p>';
	
	echo '<p><label for="bespokesolution_achieve">How did we achieve this :</label></p>';
	echo '<p><textarea id="bespokesolution_achieve" name="bespokesolution_achieve" class="bespokesolution_textarea">'.get_post_meta($post->ID,'bespokesolution_achieve',true).'</textarea></p>';
	
	echo '<p><label for="bespokesolution_result">Result :</label></p>';
	echo '<p><textarea id="bespokesolution_result" name="bespokesolution_result" class="bespokesolution_textarea">'.get_post_meta($post->ID,'bespokesolution_result',true).'</textarea></p>';
}

add_action( 'save_post', 'tcs_hp_bespokesolution_addition_box_save' );
function tcs_hp_bespokesolution_addition_box_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	return;
	if ( !wp_verify_nonce( $_POST['tcs_hp_bespokesolution_additional_box_content'], plugin_basename( __FILE__ ) ) )
	return;
	if ( 'bespokesolution' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}
	
	//bespokesolution_date
	$bespokesolution_date = $_POST['bespokesolution_date'];
	update_post_meta( $post_id, 'bespokesolution_date', $bespokesolution_date );
	
	//bespokesolution_challenge
	update_post_meta( $post_id, 'bespokesolution_challenge', $_POST['bespokesolution_challenge'] );
	//bespokesolution_solution
	update_post_meta( $post_id, 'bespokesolution_solution', $_POST['bespokesolution_solution'] );
	//bespokesolution_achieve
	update_post_meta( $post_id, 'bespokesolution_achieve', $_POST['bespokesolution_achieve'] );
	//bespokesolution_result
	update_post_meta( $post_id, 'bespokesolution_result', $_POST['bespokesolution_result'] );

}

?>