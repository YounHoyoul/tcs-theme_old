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
function tcs_hp_custom_post_Portfolio() {
	$labels = array(
		'name'               => _x( 'Portfolios', 'post type general name' ),
		'singular_name'      => _x( 'Portfolio', 'post type singular name' ),
		'add_new'            => _x( 'Add New Portfolio', 'portfolio' ),
		'add_new_item'       => __( 'Add New Portfolio' ),
		'edit_item'          => __( 'Edit Portfolio' ),
		'new_item'           => __( 'New Portfolio' ),
		'all_items'          => __( 'All Portfolio' ),
		'view_item'          => __( 'View Portfolio' ),
		'search_items'       => __( 'Search Portfolio' ),
		'not_found'          => __( 'No Portfolio found' ),
		'not_found_in_trash' => __( 'No Portfolio found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Portfolios'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Portfolios and Portfolios specific data',
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array('slug' => 'portfolios'),
		'menu_position' => 5,
		//'supports'      => array( 'title', 'editor', 'excerpt', 'custom-fields', 'comments', 'thumbnail', 'revision' ),
		//'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'thumbnail', 'revision' ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'revision' ),
		'taxonomies'    => array( 'post_tag', 'category'),
		//'taxonomies'    => array( 'post_tag'),
	);
	register_post_type( 'portfolio', $args );
}
add_action( 'init', 'tcs_hp_custom_post_Portfolio' );

function tcs_hp_updated_messages_portfolio( $messages ) {
	global $post, $post_ID;
	$messages['portfolio'] = array(
		0 => '',
		1 => sprintf( __('Portfolio updated. <a href="%s">View portfolio</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Portfolio updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Portfolio restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Portfolio published. <a href="%s">View portfolio</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Portfolio saved.'),
		8 => sprintf( __('Portfolio submitted. <a target="_blank" href="%s">Preview portfolio</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Portfolio scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview portfolio</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Portfolio draft updated. <a target="_blank" href="%s">Preview portfolio</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'tcs_hp_updated_messages_portfolio' );

function tcs_hp_contextual_help_portfolio( $contextual_help, $screen_id, $screen ) {
	if ( 'portfolio' == $screen->id ) {
		$contextual_help = '<h2>Portfolios</h2>
		<p>Portfolios show the details of the items that we have done as the project so far. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p>
		<p>You can view/edit the details of each portfolio by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'edit-portfolio' == $screen->id ) {
		$contextual_help = '<h2>Editing Portfolios</h2>
		<p>This page allows you to view/modify portfolio details. Please make sure to fill out the available boxes with the appropriate details.</p>';
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'tcs_hp_contextual_help_portfolio', 10, 3 );

function tcs_hp_taxonomies_portfolio() {
	$labels = array(
		'name'              => _x( 'Portfolio Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Portfolio Categories' ),
		'all_items'         => __( 'All Portfolio Categories' ),
		'parent_item'       => __( 'Parent Portfolio Category' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:' ),
		'edit_item'         => __( 'Edit Portfolio Category' ),
		'update_item'       => __( 'Update Portfolio Category' ),
		'add_new_item'      => __( 'Add New Portfolio Category' ),
		'new_item_name'     => __( 'New Portfolio Category' ),
		'menu_name'         => __( 'Portfolio Categories' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'portfolio_category', 'portfolio', $args );
	//register_taxonomy_for_object_type('portfolio_category', 'portfolio');
}
add_action( 'init', 'tcs_hp_taxonomies_portfolio', 0 );


//Post Meta Boxes
add_action( 'add_meta_boxes', 'tcs_hp_portfolio_date_box' );
function tcs_hp_portfolio_date_box() {
	add_meta_box(
		'tcs_hp_portfolio_date_box',
		__( 'Portfolio Date', 'tcs_theme' ),
		'tcs_hp_portfolio_date_box_content',
		'portfolio',
		'side',
		'core'
	);
}

function tcs_hp_portfolio_date_box_content($post){
?>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
	<style> .media-upload h2 { font-weight: bold; } </style>
	<script>
	( function( $ ) {
		$(document).ready(
			function()
			{
				$( "#portfolio_date" ).datepicker();
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
	wp_nonce_field( plugin_basename( __FILE__ ), 'tcs_hp_portfolio_date_box_content_nonce' );
	echo '<label for="portfolio_date">Date :</label>';
	echo '<input type="text" id="portfolio_date" name="portfolio_date" placeholder="enter a date" value="'.get_post_meta($post->ID,'portfolio_date',true).'">';
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

add_action( 'save_post', 'tcs_hp_portfolio_date_box_save' );
function tcs_hp_portfolio_date_box_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	return;
	if ( !wp_verify_nonce( $_POST['tcs_hp_portfolio_date_box_content_nonce'], plugin_basename( __FILE__ ) ) )
	return;
	if ( 'portfolio' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}
	$portfolio_date = $_POST['portfolio_date'];
	update_post_meta( $post_id, 'portfolio_date', $portfolio_date );
}

?>