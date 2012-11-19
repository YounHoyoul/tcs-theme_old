<?php
/**
Plugin Name: TCS Backend Customer Post Type For News
Plugin URI: 
Description: a plugin to create backend modules
Version: 1.0
Author: Luis Hoyoul Youn
Author URI: 
License: GPL2
*/
?>
<?php
function tcs_hp_custom_post_News() {
	$labels = array(
		'name'               => _x( 'Newses', 'post type general name' ),
		'singular_name'      => _x( 'News', 'post type singular name' ),
		'add_new'            => _x( 'Add New News', 'news' ),
		'add_new_item'       => __( 'Add New News' ),
		'edit_item'          => __( 'Edit News' ),
		'new_item'           => __( 'New News' ),
		'all_items'          => __( 'All News' ),
		'view_item'          => __( 'View News' ),
		'search_items'       => __( 'Search News' ),
		'not_found'          => __( 'No News found' ),
		'not_found_in_trash' => __( 'No News found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Newses'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Newses and Newses specific data',
		'public'        => true,
		'rewrite'       => array('slug' => 'news'),
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'excerpt', 'custom-fields', 'comments', 'thumbnail', 'revision' ),
		'has_archive'   => true,
		//'taxonomies'    => array( 'post_tag', 'category '),
	);
	register_post_type( 'news', $args );
}
add_action( 'init', 'tcs_hp_custom_post_News' );

function tcs_hp_updated_messages_news( $messages ) {
	global $post, $post_ID;
	$messages['news'] = array(
		0 => '',
		1 => sprintf( __('News updated. <a href="%s">View news</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('News updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('News restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('News published. <a href="%s">View news</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('News saved.'),
		8 => sprintf( __('News submitted. <a target="_blank" href="%s">Preview news</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('News scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview news</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('News draft updated. <a target="_blank" href="%s">Preview news</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'tcs_hp_updated_messages_news' );

function tcs_hp_contextual_help_news( $contextual_help, $screen_id, $screen ) {
	if ( 'news' == $screen->id ) {
		$contextual_help = '<h2>Newses</h2>
		<p>Newses show the details of the items that we have made so far. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p>
		<p>You can view/edit the details of each news by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'edit-news' == $screen->id ) {
		$contextual_help = '<h2>Editing Newses</h2>
		<p>This page allows you to view/modify news details. Please make sure to fill out the available boxes with the appropriate details.</p>';
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'tcs_hp_contextual_help_news', 10, 3 );

function tcs_hp_taxonomies_news() {
	$labels = array(
		'name'              => _x( 'News Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'News Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search News Categories' ),
		'all_items'         => __( 'All News Categories' ),
		'parent_item'       => __( 'Parent News Category' ),
		'parent_item_colon' => __( 'Parent News Category:' ),
		'edit_item'         => __( 'Edit News Category' ),
		'update_item'       => __( 'Update News Category' ),
		'add_new_item'      => __( 'Add New News Category' ),
		'new_item_name'     => __( 'New News Category' ),
		'menu_name'         => __( 'News Categories' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'news_category', 'news', $args );
}
add_action( 'init', 'tcs_hp_taxonomies_news', 0 );
?>