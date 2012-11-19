<?php
/**
Plugin Name: TCS Backend Customer Post Type For Project
Plugin URI: 
Description: a plugin to create backend modules
Version: 1.0
Author: Luis Hoyoul Youn
Author URI: 
License: GPL2
*/
?>
<?php
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

function tcs_hp_custom_post_project() {
	$labels = array(
		'name'               => _x( 'Projects', 'post type general name' ),
		'singular_name'      => _x( 'Project', 'post type singular name' ),
		'add_new'            => _x( 'Add New Project', 'project' ),
		'add_new_item'       => __( 'Add New Project' ),
		'edit_item'          => __( 'Edit Project' ),
		'new_item'           => __( 'New Project' ),
		'all_items'          => __( 'All Project' ),
		'view_item'          => __( 'View Project' ),
		'search_items'       => __( 'Search Project' ),
		'not_found'          => __( 'No Project found' ),
		'not_found_in_trash' => __( 'No Project found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Projects'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Projects and Projects specific data',
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array('slug' => 'projects'),
		'menu_position' => 5,
		//'supports'      => array( 'title', 'editor', 'excerpt', 'custom-fields', 'comments', 'thumbnail', 'revision' ),
		//'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'thumbnail', 'revision' ),
		'supports'      => array( 'title', 'editor', 'excerpt', 'comments', 'revision' ),
		//'taxonomies'    => array( 'post_tag', 'category'),
		'taxonomies'    => array( 'post_tag'),
	);
	register_post_type( 'project', $args );
}
add_action( 'init', 'tcs_hp_custom_post_project' );

function tcs_hp_updated_messages_project( $messages ) {
	global $post, $post_ID;
	$messages['project'] = array(
		0 => '',
		1 => sprintf( __('Project updated. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Project updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Project published. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Project saved.'),
		8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'tcs_hp_updated_messages_project' );

function tcs_hp_contextual_help_project( $contextual_help, $screen_id, $screen ) {
	if ( 'project' == $screen->id ) {
		$contextual_help = '<h2>Projects</h2>
		<p>Projects show the details of the items that we have done as the project so far. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p>
		<p>You can view/edit the details of each project by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} elseif ( 'edit-project' == $screen->id ) {
		$contextual_help = '<h2>Editing Projects</h2>
		<p>This page allows you to view/modify project details. Please make sure to fill out the available boxes with the appropriate details.</p>';
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'tcs_hp_contextual_help_project', 10, 3 );

function tcs_hp_taxonomies_project() {
	$labels = array(
		'name'              => _x( 'Project Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Project Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Project Categories' ),
		'all_items'         => __( 'All Project Categories' ),
		'parent_item'       => __( 'Parent Project Category' ),
		'parent_item_colon' => __( 'Parent Project Category:' ),
		'edit_item'         => __( 'Edit Project Category' ),
		'update_item'       => __( 'Update Project Category' ),
		'add_new_item'      => __( 'Add New Project Category' ),
		'new_item_name'     => __( 'New Project Category' ),
		'menu_name'         => __( 'Project Categories' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'project_category', 'project', $args );
	//register_taxonomy_for_object_type('project_category', 'project');
}
add_action( 'init', 'tcs_hp_taxonomies_project', 0 );


//Post Meta Boxes
add_action( 'add_meta_boxes', 'tcs_hp_project_additional_box' );
function tcs_hp_project_additional_box() {
	add_meta_box(
		'tcs_hp_project_additional_box',
		__( 'Project Additional Information', 'tcs_theme' ),
		'tcs_hp_project_additional_box_content',
		'project',
		'normal',
		'high'
	);
}

function tcs_hp_project_additional_box_content($post){
?>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
	<style> .media-upload h2 { font-weight: bold; } 
		.tcs_hp_project_textarea {
			width:100%;
			height:80px;
		}
		.tcs_hp_additional{
			display:none;
		}
	</style>
	<script>
	( function( $ ) {
		$(document).ready(function(){
			$( "#project_date" ).datepicker();
			$('#<?php echo get_post_meta($post->ID,'project_type',true);?>_div').show('fast');
			
			$('#project_type').change(function(){
				$('.tcs_hp_additional').hide('fast');
				$('#'+$(this).val()+'_div').show('fast');
			});
		});
	})( jQuery );
	</script>
<?php
	wp_nonce_field( plugin_basename( __FILE__ ), 'tcs_hp_project_additional_box_content' );
	echo '<p><label for="project_type">Type :</label>';
	echo '<select id="project_type" name="project_type">
			<option value="brand" '.(get_post_meta($post->ID,'project_type',true)=="brand"?"selected":"").'>Brand Activation</option>
			<option value="bespoke" '.(get_post_meta($post->ID,'project_type',true)=="bespoke"?"selected":"").'>Bespoke Solution</option>
			<option value="digital" '.(get_post_meta($post->ID,'project_type',true)=="digital"?"selected":"").'>Digital Platform</option>
		</select></p>';
	
	echo '<p><label for="project_date">Date :</label>';
	echo '<input type="text" id="project_date" name="project_date" placeholder="enter a date" value="'.get_post_meta($post->ID,'project_date',true).'"></p>';
	
	echo '<div id="brand_div" class="tcs_hp_additional">';
	echo '<p><label for="project_task">Task :</label></p>';
	echo '<p><textarea id="project_task" name="project_task" class="tcs_hp_project_textarea">'.get_post_meta($post->ID,'project_task',true).'</textarea></p>';
	
	echo '<p><label for="project_idea">Idea :</label></p>';
	echo '<p><textarea id="project_idea" name="project_idea" class="tcs_hp_project_textarea">'.get_post_meta($post->ID,'project_idea',true).'</textarea></p>';
	
	echo '<p><label for="project_campaign">Campaign :</label></p>';
	echo '<p><textarea id="project_campaign" name="project_campaign" class="tcs_hp_project_textarea">'.get_post_meta($post->ID,'project_campaign',true).'</textarea></p>';
	
	echo '<p><label for="project_success">Sucess :</label></p>';
	echo '<p><textarea id="project_success" name="project_success" class="tcs_hp_project_textarea">'.get_post_meta($post->ID,'project_success',true).'</textarea></p>';
	
	echo '<p><label for="project_location">Location :</label></p>';
	echo '<p><textarea id="project_location" name="project_location" class="tcs_hp_project_textarea">'.get_post_meta($post->ID,'project_location',true).'</textarea></p>';
	echo '</div>';
	
	
	echo '<div id="bespoke_div" class="tcs_hp_additional">';
	echo '<p><label for="project_challenge">Challenge :</label></p>';
	echo '<p><textarea id="project_challenge" name="project_challenge" class="tcs_hp_project_textarea">'.get_post_meta($post->ID,'project_challenge',true).'</textarea></p>';
	
	echo '<p><label for="project_solution">Solution :</label></p>';
	echo '<p><textarea id="project_solution" name="project_solution" class="tcs_hp_project_textarea">'.get_post_meta($post->ID,'project_solution',true).'</textarea></p>';
	
	echo '<p><label for="project_achieve">How did we achieve this :</label></p>';
	echo '<p><textarea id="project_achieve" name="project_achieve" class="tcs_hp_project_textarea">'.get_post_meta($post->ID,'project_achieve',true).'</textarea></p>';
	
	echo '<p><label for="project_result">Result :</label></p>';
	echo '<p><textarea id="project_result" name="project_result" class="tcs_hp_project_textarea">'.get_post_meta($post->ID,'project_result',true).'</textarea></p>';
	echo '</div>';
}

add_action( 'save_post', 'tcs_hp_project_additional_box_save' );
function tcs_hp_project_additional_box_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	return;
	if ( !wp_verify_nonce( $_POST['tcs_hp_project_additional_box_content'], plugin_basename( __FILE__ ) ) )
	return;
	if ( 'project' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}
	
	//project_type
	update_post_meta( $post_id, 'project_type', $_POST['project_type'] );
	//project_date
	update_post_meta( $post_id, 'project_date', $_POST['project_date'] );
	
	//project_task
	if(!empty($_POST['project_task'])){
		update_post_meta( $post_id, 'project_task', $_POST['project_task'] );
	}
	//project_idea
	if(!empty($_POST['project_idea'])){
		update_post_meta( $post_id, 'project_idea', $_POST['project_idea'] );
	}
	//project_campaign
	if(!empty($_POST['project_campaign'])){
		update_post_meta( $post_id, 'project_campaign', $_POST['project_campaign'] );
	}
	//project_success
	if(!empty($_POST['project_success'])){
		update_post_meta( $post_id, 'project_success', $_POST['project_success'] );
	}
	//project_location
	if(!empty($_POST['project_location'])){
		update_post_meta( $post_id, 'project_location', $_POST['project_location'] );
	}
	
	//project_challenge
	if(!empty($_POST['project_challenge'])){
		update_post_meta( $post_id, 'project_challenge', $_POST['project_challenge'] );
	}
	//project_solution
	if(!empty($_POST['project_solution'])){
		update_post_meta( $post_id, 'project_solution', $_POST['project_solution'] );
	}
	//project_achieve
	if(!empty($_POST['project_achieve'])){
		update_post_meta( $post_id, 'project_achieve', $_POST['project_achieve'] );
	}
	//project_result
	if(!empty($_POST['project_result'])){
		update_post_meta( $post_id, 'project_result', $_POST['project_result'] );
	}
}

?>