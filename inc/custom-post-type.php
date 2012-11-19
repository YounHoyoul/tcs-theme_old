<?php
/**
Plugin Name: TCS Backend Plugin
Plugin URI: 
Description: a plugin to create backend modules
Version: 1.0
Author: Luis Hoyoul Youn
Author URI: 
License: GPL2
*/
?>
<?php

/*
add_action( 'init', 'tcs_hp_create_my_post_types' );

function tcs_hp_create_my_post_types() {
	register_post_type( 'super_duper', 
		array(
			'labels' => array(
				'name' => __( 'Super Dupers' ),
				'singular_name' => __( 'Super Duper' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Super Duper' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Super Duper' ),
				'new_item' => __( 'New Super Duper' ),
				'view' => __( 'View Super Duper' ),
				'view_item' => __( 'View Super Duper' ),
				'search_items' => __( 'Search Super Dupers' ),
				'not_found' => __( 'No super dupers found' ),
				'not_found_in_trash' => __( 'No super dupers found in Trash' ),
				'parent' => __( 'Parent Super Duper' ),
			),
			'description' => __( 'A super duper is a type of content that is the most wonderful content in the world. There are no alternatives that match how insanely creative and beautiful it is.' ),
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'menu_position' => 20,
			'query_var' => true,
			'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail', 'revision' ),
			'rewrite' => array( 'slug' => 'cool', 'with_front' => false ),
			'taxonomies' => array( 'post_tag', 'category '),
		)
	);
}
*/

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
		'supports'      => array( 'title', 'editor', 'excerpt', 'custom-fields', 'comments', 'thumbnail', 'revision' ),
		//'taxonomies'    => array( 'post_tag', 'category '),
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
}
add_action( 'init', 'tcs_hp_taxonomies_portfolio', 0 );

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
//script 
/*
function my_scripts_method() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script(
		'custom-script',
		get_template_directory_uri() . '/js/custom_script.js',
		array('jquery')
	);
}
add_action('wp_enqueue_scripts', 'my_scripts_method');
*/
?>