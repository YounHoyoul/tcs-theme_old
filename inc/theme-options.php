<?php
/**
 * TCS Theme Theme Options
 *
 * @package TCS Themes
 * @subpackage TCS_Theme
 * @since TCS Theme 1.0
 */


/**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since TCS Theme 1.0
 *
 */
function tcs_hp_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'catchbox-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2011-04-28' );
	wp_enqueue_script( 'catchbox-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2011-06-10' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'tcs_hp_admin_enqueue_scripts' );
add_action( 'admin_print_styles-appearance_page_slider_options', 'tcs_hp_admin_enqueue_scripts' );
add_action( 'admin_print_styles-appearance_page_social_links', 'tcs_hp_admin_enqueue_scripts' );
add_action( 'admin_print_styles-appearance_page_webmaster_tools', 'tcs_hp_admin_enqueue_scripts' );


/**
 * Register the form setting for our tcs_hp_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, tcs_hp_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === tcs_hp_get_theme_options() )
		add_option( 'tcs_hp_theme_options', tcs_hp_get_default_theme_options() );

	register_setting(
		'tcs_hp_options',       // Options group, see settings_fields() call in tcs_hp_theme_options_render_page()
		'tcs_hp_theme_options', // Database option, see tcs_hp_get_theme_options()
		'tcs_hp_theme_options_validate' // The sanitization callback, see tcs_hp_theme_options_validate()
	);
	
	register_setting(
		'tcs_hp_options_slider',   // Options group, see settings_fields() call in tcs_hp_theme_options_render_page()
		'tcs_hp_options_slider',  // Database option, see tcs_hp_get_theme_options()			
		'tcs_hp_options_validation' // The sanitization callback, see tcs_hp_theme_options_validate()
	);
	
	register_setting(
		'tcs_hp_options_webmaster',   // Options group, see settings_fields() call in tcs_hp_theme_options_render_page()
		'tcs_hp_options_webmaster',  // Database option, see tcs_hp_get_theme_options()			
		'tcs_hp_options_webmaster_validation' // The sanitization callback, see tcs_hp_theme_options_validate()
	);
	
	register_setting(
		'tcs_hp_options_social_links',   // Options group, see settings_fields() call in tcs_hp_theme_options_render_page()
		'tcs_hp_options_social_links',  // Database option, see tcs_hp_get_theme_options()			
		'tcs_hp_options_social_links_validation' // The sanitization callback, see tcs_hp_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'theme_options' // Menu slug, used to uniquely identify the page; see tcs_hp_theme_options_add_page()
	);

	// Register our individual settings fields
	add_settings_field(
		'color_scheme', // Unique identifier for the field for this section
		__( 'Color Scheme', 'tcstheme' ), // Setting field label
		'tcs_hp_settings_field_color_scheme', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see tcs_hp_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);

	add_settings_field( 
		'link_color', // Unique identifier for the field for this section 
		__( 'Link Color', 'tcstheme' ), // Setting field label 
		'tcs_hp_settings_field_link_color', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see tcs_hp_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);
	
	add_settings_field( 
		'layout', // Unique identifier for the field for this section 
		__( 'Default Layout', 'tcstheme' ), // Setting field label 
		'tcs_hp_settings_field_layout', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see tcs_hp_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above 
	);

	add_settings_field(
		'content_layout', // Unique identifier for the settings section
		__( 'Content layout', 'tcstheme' ), // Setting field label
		'tcs_hp_settings_field_content_scheme', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see tcs_hp_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);
	
	add_settings_field(
		'excerpt_length', // Unique identifier for the settings section
		__( 'Excerpt Length in Words', 'tcstheme' ), // Setting field label
		'tcs_hp_settings_field_excerpt_length', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see tcs_hp_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);
	
	add_settings_field(
		'feed_redirect', // Unique identifier for the settings section
		__( 'Feed Redirect URL', 'tcstheme' ), // Setting field label
		'tcs_hp_settings_field_feed_redirect', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see tcs_hp_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);
	
	add_settings_field(
		'disable_header_search', // Unique identifier for the settings section
		__( 'Disable Search in Header', 'tcstheme' ), // Setting field label
		'tcs_hp_settings_field_disable_header_search', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see tcs_hp_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);	
	
	add_settings_field(
		'custom_css', // Unique identifier for the settings section
		__( 'Custom CSS Styles', 'tcstheme' ), // Setting field label
		'tcs_hp_settings_field_custom_css', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see tcs_hp_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);
}
add_action( 'admin_init', 'tcs_hp_theme_options_init' );

/**
 * Change the capability required to save the 'tcs_hp_options' options group.
 *
 * @see tcs_hp_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see tcs_hp_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * By default, the options groups for all registered settings require the manage_options capability.
 * This filter is required to change our theme options page to edit_theme_options instead.
 * By default, only administrators have either of these capabilities, but the desire here is
 * to allow for finer-grained control for roles and users.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function tcs_hp_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_tcs_hp_options', 'tcs_hp_option_page_capability' );


/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'tcstheme' ),   // Name of page
		__( 'Theme Options', 'tcstheme' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'tcs_hp_theme_options_render_page' // Function that renders the options page
	);

	$slider_options = add_theme_page( 
		__( 'Featured Slider', 'tcstheme' ),  // Name of page
		__( 'Featured Slider', 'tcstheme' ),  // Label in menu
		'edit_theme_options', 						// Capability required
		'slider_options', 							// Menu slug, used to uniquely identify the page
		'tcs_hp_options_slider_page'		// Function that renders the options page
	);
	
	$social_link_options = add_theme_page( 
		__( 'Social Links', 'tcstheme' ),  // Name of page
		__( 'Social Links', 'tcstheme' ),  // Label in menu
		'edit_theme_options', 						// Capability required
		'social_links', 							// Menu slug, used to uniquely identify the page
		'tcs_hp_options_social_links'		// Function that renders the options page
	);
	
	$webmaster_tool_options = add_theme_page( 
		__( 'Webmaster Tools', 'tcstheme' ),  // Name of page
		__( 'Webmaster Tools', 'tcstheme' ),  // Label in menu
		'edit_theme_options', 				  // Capability required
		'webmaster_tools', 					  // Menu slug, used to uniquely identify the page
		'tcs_hp_options_webmaster_tools'	  // Function that renders the options page
	);
	
	if ( ! $theme_page )
		return;

	add_action( "load-$theme_page", 'tcs_hp_theme_options_help' );
	add_action( "load-$slider_options", 'tcs_hp_slider_options_help' );
}
//add_action( 'admin_menu', 'tcs_hp_theme_options_add_page' );


function tcs_hp_theme_options_help() {

	$help = '<p>' . __( 'Some themes provide customization options that are grouped together on a Theme Options screen. If you change themes, options may change or disappear, as they are theme-specific. Your current theme, TCS Theme, provides the following Theme Options:', 'tcstheme' ) . '</p>' .
			'<ol>' .
				'<li>' . __( '<strong>Color Scheme</strong>: You can choose a color palette of "Light" (light background with dark text) or "Dark" (dark background with light text) for your site.', 'tcstheme' ) . '</li>' .
				'<li>' . __( '<strong>Link Color</strong>: You can choose the color used for text links on your site. You can enter the HTML color or hex code, or you can choose visually by clicking the "Select a Color" button to pick from a color wheel.', 'tcstheme' ) . '</li>' .
				'<li>' . __( '<strong>Default Layout</strong>: You can choose if you want your site&#8217;s default layout to have a sidebar on the left, the right, or not at all.', 'tcstheme' ) . '</li>' .
			'</ol>' .
			'<p>' . __( 'Remember to click "Save Changes" to save any changes you have made to the theme options.', 'tcstheme' ) . '</p>';

	$sidebar = '<p><strong>' . __( 'For more information:', 'tcstheme' ) . '</strong></p>' .
		'<p>' . __( '<a href="http://codex.wordpress.org/Appearance_Theme_Options_Screen" target="_blank">Documentation on Theme Options</a>', 'tcstheme' ) . '</p>' .
		'<p>' . __( '<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'tcstheme' ) . '</p>';

	$screen = get_current_screen();

	if ( method_exists( $screen, 'add_help_tab' ) ) {
		// WordPress 3.3
		$screen->add_help_tab( array(
			'title'		=> __( 'Overview', 'tcstheme' ),
			'id'		=> 'theme-options-help',
			'content'	=> $help,
			)
		);

		$screen->set_help_sidebar( $sidebar );
	} 
}


function tcs_hp_slider_options_help() {

	$help = '<p>' . __( 'Slider Some themes provide customization options that are grouped together on a Theme Options screen. If you change themes, options may change or disappear, as they are theme-specific. Your current theme, TCS Theme, provides the following Theme Options:', 'tcstheme' ) . '</p>' .
			'<ol>' .
				'<li>' . __( '<strong>Color Scheme</strong>: You can choose a color palette of "Light" (light background with dark text) or "Dark" (dark background with light text) for your site.', 'tcstheme' ) . '</li>' .
				'<li>' . __( '<strong>Link Color</strong>: You can choose the color used for text links on your site. You can enter the HTML color or hex code, or you can choose visually by clicking the "Select a Color" button to pick from a color wheel.', 'tcstheme' ) . '</li>' .
				'<li>' . __( '<strong>Default Layout</strong>: You can choose if you want your site&#8217;s default layout to have a sidebar on the left, the right, or not at all.', 'tcstheme' ) . '</li>' .
			'</ol>' .
			'<p>' . __( 'Remember to click "Save Changes" to save any changes you have made to the theme options.', 'tcstheme' ) . '</p>';

	$screen = get_current_screen();

	if ( method_exists( $screen, 'add_help_tab' ) ) {
		// WordPress 3.3
		$screen->add_help_tab( array(
			'title'		=> __( 'Overview', 'tcstheme' ),
			'id'		=> 'slider-options-help',
			'content'	=> $help,
			)
		);
	}
}


/**
 * Returns an array of color schemes registered for TCS Theme.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_color_schemes() {
	$color_scheme_options = array(
		'light' 					=> array(
			'value'					=> 'light',
			'label'					=> __( 'Light', 'tcstheme' ),
			'thumbnail'				=> get_template_directory_uri() . '/inc/images/light.png',
			'default_link_color'	=> '#1b8be0',
		),
		'dark' 						=> array(
			'value'					=> 'dark',
			'label'					=> __( 'Dark', 'tcstheme' ),
			'thumbnail'				=> get_template_directory_uri() . '/inc/images/dark.png',
			'default_link_color'	=> '#e4741f',
		),	
		'blue' 						=> array(
			'value'					=> 'blue',
			'label'					=> __( 'Blue', 'tcstheme' ),
			'thumbnail'				=> get_template_directory_uri() . '/inc/images/blue.png',
			'default_link_color'	=> '#326693',
		),			
	);

	return apply_filters( 'tcs_hp_color_schemes', $color_scheme_options );
}


/**
 * Returns an array of layout options registered for TCS Theme.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_layouts() {
	$layout_options = array(
		'content-sidebar' 	=> array(
			'value' 		=> 'content-sidebar',
			'label'			=> __( 'Content on left', 'tcstheme' ),
			'thumbnail'		=> get_template_directory_uri() . '/inc/images/content-sidebar.png',
		),
		'sidebar-content' 	=> array(
			'value'			=> 'sidebar-content',
			'label'			=> __( 'Content on right', 'tcstheme' ),
			'thumbnail'		=> get_template_directory_uri() . '/inc/images/sidebar-content.png',
		),
		'content-onecolumn'	=> array(
			'value'			=> 'content-onecolumn',
			'label'			=> __( 'One-column, no sidebar', 'tcstheme' ),
			'thumbnail'		=> get_template_directory_uri() . '/inc/images/content.png',
		),
	);

	return apply_filters( 'tcs_hp_layouts', $layout_options );
}


/**
 * Returns an array of content layout options registered for TCS Theme.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_content_layout() {
	$content_options = array(
		'excerpt'			=> array(
			'value'			=> 'excerpt',
			'label'			=> __( 'Show excerpt', 'tcstheme' ),
			'thumbnail'		=> get_template_directory_uri() . '/inc/images/excerpt.png',
		),	 
		'full-content'		=> array(
			'value'			=> 'full-content',
			'label'			=> __( 'Show full content', 'tcstheme' ),
			'thumbnail'		=> get_template_directory_uri() . '/inc/images/full-content.png',
		)
	);

	return apply_filters( 'tcs_hp_content_layouts', $content_options );
}


/**
 * Returns the default options for TCS Theme.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_get_default_theme_options() {
	$default_theme_options = array(
		'excerpt_length'		=> 40,
		'color_scheme'			=> 'light',
		'link_color'			=> tcs_hp_get_default_link_color( 'light' ),
		'theme_layout'			=> 'content-sidebar',
		'content_layout'		=> 'excerpt',
		'disable_header_search' => '0'
	);

	if ( is_rtl() )
 		$default_theme_options['theme_layout'] = 'sidebar-content';

	return apply_filters( 'tcs_hp_default_theme_options', $default_theme_options );
}


/**
 * Returns the default link color for TCS Theme, based on color scheme.
 *
 * @since TCS Theme 1.0
 *
 * @param $string $color_scheme Color scheme. Defaults to the active color scheme.
 * @return $string Color.
*/
function tcs_hp_get_default_link_color( $color_scheme = null ) {
	if ( null === $color_scheme ) {
		$options = tcs_hp_get_theme_options();
		$color_scheme = $options['color_scheme'];
	}

	$color_schemes = tcs_hp_color_schemes();
	if ( ! isset( $color_schemes[ $color_scheme ] ) )
		return false;

	return $color_schemes[ $color_scheme ]['default_link_color'];
}


/**
 * Returns the options array for TCS Theme.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_get_theme_options() {
	return get_option( 'tcs_hp_theme_options', tcs_hp_get_default_theme_options() );
}


/**
 * Renders the Color Scheme setting field.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_settings_field_color_scheme() {
	$options = tcs_hp_get_theme_options();

	foreach ( tcs_hp_color_schemes() as $scheme ) {
	?>
        <div class="layout image-radio-option color-scheme">
        <label class="description">
            <input type="radio" name="tcs_hp_theme_options[color_scheme]" value="<?php echo esc_attr( $scheme['value'] ); ?>" <?php checked( $options['color_scheme'], $scheme['value'] ); ?> />
            <input type="hidden" id="default-color-<?php echo esc_attr( $scheme['value'] ); ?>" value="<?php echo esc_attr( $scheme['default_link_color'] ); ?>" />
            <span>
                <img src="<?php echo esc_url( $scheme['thumbnail'] ); ?>" width="164" height="122" alt="" />
                <?php echo $scheme['label']; ?>
            </span>
        </label>
        </div>
	<?php
	}
}


/**
 * Renders the Link Color setting field.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_settings_field_link_color() {
	$options = tcs_hp_get_theme_options();
	?>
	<input type="text" name="tcs_hp_theme_options[link_color]" id="link-color" value="<?php echo esc_attr( $options['link_color'] ); ?>" />
	<a href="#" class="pickcolor hide-if-no-js" id="link-color-example"></a>
	<input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'tcstheme' ); ?>" />
	<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
	<br />
	<span><?php printf( __( 'Default color: %s', 'tcstheme' ), '<span id="default-color">' . tcs_hp_get_default_link_color( $options['color_scheme'] ) . '</span>' ); ?></span>
	<?php
}


/**
 * Renders the excerpt length setting field.
 *
 * @since TCS Theme 1.1.3
 */
function tcs_hp_settings_field_excerpt_length() {
	$options = tcs_hp_get_theme_options();
	if( empty( $options['excerpt_length'] ) )
		$options = tcs_hp_get_default_theme_options();
	?>
   
	<input type="text" name="tcs_hp_theme_options[excerpt_length]" id="excerpt-length" size="3" value="<?php if ( isset( $options[ 'excerpt_length' ] ) ) echo absint( $options[ 'excerpt_length'] ); ?>" /> 
	<?php
}


/**
 * Renders the feed redirect setting field.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_settings_field_feed_redirect() {
	$options = tcs_hp_get_theme_options();
	?>
	<input type="text" name="tcs_hp_theme_options[feed_url]" id="feed-url" size="65" value="<?php if ( isset( $options[ 'feed_url' ] ) ) echo esc_attr( $options[ 'feed_url'] ); ?>" />
	<?php
}


/**
 * Renders the feed redirect setting field.
 *
 * @since TCS Theme 1.3.1
 */
function tcs_hp_settings_field_disable_header_search() {
	$options = tcs_hp_get_theme_options();
	if( empty( $options['disable_header_search'] ) )
		$options = tcs_hp_get_default_theme_options();
	?>
    <input type="checkbox" id="disable-header-search" name="tcs_hp_theme_options[disable_header_search]" value="1" <?php checked( '1', $options['disable_header_search'] ); ?> />
	<?php
}


/**
 * Renders the Custom CSS styles setting fields
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_settings_field_custom_css() {
	$options = tcs_hp_get_theme_options();
	?>
     <textarea id="custom-css" cols="90" rows="12" name="tcs_hp_theme_options[custom_css]"><?php if (!empty($options['custom_css'] ) )echo esc_attr($options['custom_css']); ?></textarea> <br />
     <?php _e('CSS Tutorial from W3Schools.', 'tcstheme'); ?> <a class="button" href="<?php echo esc_url( __( 'http://www.w3schools.com/css/default.asp','tcstheme' ) ); ?>" title="<?php esc_attr_e( 'CSS Tutorial', 'tcstheme' ); ?>" target="_blank"><?php _e( 'Click Here to Read', 'tcstheme' );?></a>

	<?php
}


/**
 * Renders the Layout setting field.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_settings_field_layout() {
	$options = tcs_hp_get_theme_options();
	foreach ( tcs_hp_layouts() as $layout ) {
		?>
		<div class="layout image-radio-option theme-layout">
		<label class="description">
			<input type="radio" name="tcs_hp_theme_options[theme_layout]" value="<?php echo esc_attr( $layout['value'] ); ?>" <?php checked( $options['theme_layout'], $layout['value'] ); ?> />
			<span>
				<img src="<?php echo esc_url( $layout['thumbnail'] ); ?>" width="136" height="122" alt="" />
				<?php echo $layout['label']; ?>
			</span>
		</label>
		</div>
		<?php
	}
}


/**
 * Renders the Content layout setting fields.
 *
 * @since TCS Theme 1.0 
 */
function tcs_hp_settings_field_content_scheme() {
	$options = tcs_hp_get_theme_options();
	foreach ( tcs_hp_content_layout() as $content ) {
		?>
		<div class="layout image-radio-option theme-layout">
            <label class="description">
                <input type="radio" name="tcs_hp_theme_options[content_layout]" value="<?php echo esc_attr( $content['value'] ); ?>" <?php checked( $options['content_layout'], $content['value'] ); ?> />
                <span>
                	<img src="<?php echo esc_url( $content['thumbnail'] ); ?>" width="164" height="163" alt="" />
                	<?php echo $content['label']; ?>
            	</span>
			</label>
		</div>
		<?php
	}
}


/**
 * Returns the options array for TCS Theme.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
        
		<h2>
			<?php 
            if( function_exists( 'wp_get_theme' ) ) {
                printf( __( '%s Theme Options By', 'tcstheme' ), wp_get_theme() );
            } else {
                printf( __( '%s Theme Options By', 'tcstheme' ), get_current_theme() );
            }
			?> 
            <a href="<?php echo esc_url( __( 'http://catchthemes.com/', 'tcstheme' ) ); ?>" title="<?php echo esc_attr_e( 'TCS Themes', 'tcstheme' ); ?>" target="_blank"><?php _e( 'TCS Themes', 'tcstheme' ); ?></a>
        </h2>
        
		<div id="info-support">
                <a class="support button" href="<?php echo esc_url(__('http://catchthemes.com/support/','tcstheme')); ?>" title="<?php esc_attr_e('Theme Support', 'tcstheme'); ?>" target="_blank">
                <?php printf(__('Theme Support','tcstheme')); ?></a>
                
                <a class="themes button" href="<?php echo esc_url(__('http://catchthemes.com/themes/','tcstheme')); ?>" title="<?php esc_attr_e('More Themes', 'tcstheme'); ?>" target="_blank">
                <?php printf(__('More Themes','tcstheme')); ?></a>
                
                <a class="facebook button" href="<?php echo esc_url(__('http://facebook.com/catchthemes','tcstheme')); ?>" title="<?php esc_attr_e('Facebook', 'tcstheme'); ?>" target="_blank">
                <?php printf(__('Facebook','tcstheme')); ?></a>
                
                <a class="twitter button" href="<?php echo esc_url(__('http://twitter.com/#!/catchthemes','tcstheme')); ?>" title="<?php esc_attr_e('Twiiter', 'tcstheme'); ?>" target="_blank">
                <?php printf(__('Twitter','tcstheme')); ?></a>
                
                <a class="donate button" href="<?php echo esc_url(__('http://catchthemes.com/donate/','tcstheme')); ?>" title="<?php esc_attr_e('Donate Now', 'tcstheme'); ?>" target="_blank">
                <?php printf(__('Donate Now','tcstheme')); ?></a>
        </div>        
            
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'tcs_hp_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}


/**
 * Renders the slider options for TCS Theme.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_options_slider_page() {
	?>
	<div class="wrap">
    	<?php screen_icon(); ?>
		<h2>
			<?php 
            if( function_exists( 'wp_get_theme' ) ) {
                printf( __( '%s Theme Options By', 'tcstheme' ), wp_get_theme() );
            } else {
                printf( __( '%s Theme Options By', 'tcstheme' ), get_current_theme() );
            }
			?>
            <a href="<?php echo esc_url( __( 'http://catchthemes.com/', 'tcstheme' ) ); ?>" title="<?php echo esc_attr_e( 'TCS Themes', 'tcstheme' ); ?>" target="_blank"><?php _e( 'TCS Themes', 'tcstheme' ); ?></a></h2>
    	
        <form method="post" action="options.php">
			<?php
               	settings_fields( 'tcs_hp_options_slider' );
                $options = get_option( 'tcs_hp_options_slider' );
                
                if( is_array( $options ) && ( !array_key_exists( 'slider_qty', $options ) || !is_numeric( $options[ 'slider_qty' ] ) ) ) $options[ 'slider_qty' ] = 4;
                elseif( !is_array( $options ) ) $options = array( 'slider_qty' => 4);
				
            ?>   
            <?php if( isset( $_GET [ 'settings-updated' ] ) && $_GET[ 'settings-updated' ] == 'true' ): ?>
                <div class="updated" id="message">
                    <p><strong><?php _e( 'Settings saved.', 'tcstheme' );?></strong></p>
                </div>
            <?php endif; ?> 
           	<div class="option-container">
				<h3 class="option-toggle"><a href="#"><?php _e( 'Slider Options', 'tcstheme' ); ?></a></h3>
				<div class="option-content inside">
                    <table class="form-table">               
                        <tr>                            
                            <th scope="row"><?php _e( 'Exclude Slider post from Home page posts:', 'tcstheme' ); ?></th>
                            <input type='hidden' value='0' name='tcs_hp_options_slider[exclude_slider_post]'>
                            <td><input type="checkbox" id="headerlogo" name="tcs_hp_options_slider[exclude_slider_post]" value="1" <?php isset($options['exclude_slider_post']) ? checked( '1', $options['exclude_slider_post'] ) : checked('0', '1'); ?> /> <?php _e( 'Check to disable', 'tcstheme' ); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Number of Slides', 'tcstheme' ); ?></th>
                            <td><input type="text" name="tcs_hp_options_slider[slider_qty]" value="<?php if ( array_key_exists ( 'slider_qty', $options ) ) echo intval( $options[ 'slider_qty' ] ); ?>" /></td>
                        </tr>
                        <tbody class="sortable">
                            <?php for ( $i = 1; $i <= $options[ 'slider_qty' ]; $i++ ): ?>
                            <tr>
                                <th scope="row"><label class="handle"><?php _e( 'Featured Col #', 'tcstheme' ); ?><span class="count"><?php echo absint( $i ); ?></span></label></th>
                                <td><input type="text" name="tcs_hp_options_slider[featured_slider][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'featured_slider', $options ) && array_key_exists( $i, $options[ 'featured_slider' ] ) ) echo absint( $options[ 'featured_slider' ][ $i ] ); ?>" />
                                <a href="<?php bloginfo ( 'url' );?>/wp-admin/post.php?post=<?php if( array_key_exists ( 'featured_slider', $options ) && array_key_exists ( $i, $options[ 'featured_slider' ] ) ) echo absint( $options[ 'featured_slider' ][ $i ] ); ?>&action=edit" class="button" title="<?php esc_attr_e('Click Here To Edit'); ?>" target="_blank"><?php _e( 'Click Here To Edit', 'tcstheme' ); ?></a>
                                </td>
                            </tr> 							
                            <?php endfor; ?>
                        </tbody>
                    </table>
                	<p><?php _e( '<strong>Note</strong>: Here you add in Post IDs which displays on Homepage Featured Slider.', 'tcstheme' ); ?> </p>
                 	<p class="submit"><input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save', 'tcstheme' ); ?>" /></p> 
            	</div><!-- .option-content -->
			</div><!-- .option-container -->   
			<div class="option-container">
				<h3 class="option-toggle"><a href="#"><?php _e( 'Slider Effect Options', 'tcstheme' ); ?></a></h3>
				<div class="option-content inside">
					<table class="form-table">   
	                	<tr>
	                    	<th>
	                        <label for="tcs_hp_cycle_style"><?php _e( 'Transition Effect:', 'tcstheme' ); ?></label>
	                    	</th>
	                    	<?php if( empty( $options['transition_effect'] ) ) { $options['transition_effect'] = "fade"; } ?>
	                    	<td>
	                            <select id="tcs_hp_cycle_style" name="tcs_hp_options_slider[transition_effect]">
	                                <option value="fade" <?php selected('fade', $options['transition_effect']); ?>><?php _e( 'fade', 'tcstheme' ); ?></option>
	                                <option value="wipe" <?php selected('wipe', $options['transition_effect']); ?>><?php _e( 'wipe', 'tcstheme' ); ?></option>
	                                <option value="scrollUp" <?php selected('scrollUp', $options['transition_effect']); ?>><?php _e( 'scrollUp', 'tcstheme' ); ?></option>
	                                <option value="scrollDown" <?php selected('scrollDown', $options['transition_effect']); ?>><?php _e( 'scrollDown', 'tcstheme' ); ?></option>
	                                <option value="scrollLeft" <?php selected('scrollLeft', $options['transition_effect']); ?>><?php _e( 'scrollLeft', 'tcstheme' ); ?></option>
	                                <option value="scrollRight" <?php selected('scrollRight', $options['transition_effect']); ?>><?php _e( 'scrollRight', 'tcstheme' ); ?></option>
	                                <option value="blindX" <?php selected('blindX', $options['transition_effect']); ?>><?php _e( 'blindX', 'tcstheme' ); ?></option>
	                                <option value="blindY" <?php selected('blindY', $options['transition_effect']); ?>><?php _e( 'blindY', 'tcstheme' ); ?></option>
	                                <option value="blindZ" <?php selected('blindZ', $options['transition_effect']); ?>><?php _e( 'blindZ', 'tcstheme' ); ?></option>
	                                <option value="cover" <?php selected('cover', $options['transition_effect']); ?>><?php _e( 'cover', 'tcstheme' ); ?></option>
	                                <option value="shuffle" <?php selected('shuffle', $options['transition_effect']); ?>><?php _e( 'shuffle', 'tcstheme' ); ?></option>
	                            </select>
	                    	</td>
	                	</tr>
	                	<?php if( empty( $options['transition_delay'] ) ) { $options['transition_delay'] = 4; } ?>
	                	<tr>
	                    	<th scope="row"><?php _e( 'Transition Delay', 'tcstheme' ); ?></th>
	                    	<td>
	                       		<input type="text" name="tcs_hp_options_slider[transition_delay]" value="<?php if( isset( $options [ 'transition_delay' ] ) ) echo $options[ 'transition_delay' ]; ?>" size="4" />
	                       <span class="description"><?php _e( 'second(s)', 'tcstheme' ); ?></span>
	                    	</td>
	                	</tr>
	    
	                	<?php if( empty( $options['transition_duration'] ) ) { $options['transition_duration'] = 1; } ?>
	                	<tr>
	                    	<th scope="row"><?php _e( 'Transition Length', 'tcstheme' ); ?></th>
	                    	<td>
	                        	<input type="text" name="tcs_hp_options_slider[transition_duration]" value="<?php if( isset( $options [ 'transition_duration' ] ) ) echo $options[ 'transition_duration' ]; ?>" size="4" />
	                        <span class="description"><?php _e( 'second(s)', 'tcstheme' ); ?></span>
	                    	</td>
	                	</tr>                      
					</table> 
                    <p class="submit"><input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save', 'tcstheme' ); ?>" /></p> 
				</div><!-- .option-content -->
			</div><!-- .option-container -->       
		</form>
	</div><!-- .wrap -->
<?php
}


/**
 * Renders the social links options for TCS Theme.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_options_social_links() {
	?>
	<div class="wrap">
    	<?php screen_icon(); ?>
		<h2>
			<?php 
            if( function_exists( 'wp_get_theme' ) ) {
                printf( __( '%s Theme Options By', 'tcstheme' ), wp_get_theme() );
            } else {
                printf( __( '%s Theme Options By', 'tcstheme' ), get_current_theme() );
            }
			?> <a href="<?php echo esc_url( __( 'http://catchthemes.com/', 'tcstheme' ) ); ?>" title="<?php echo esc_attr_e( 'TCS Themes', 'tcstheme' ); ?>" target="_blank"><?php _e( 'TCS Themes', 'tcstheme' ); ?></a></h2>
        
		<form method="post" action="options.php">
			<?php
                settings_fields( 'tcs_hp_options_social_links' );
                $options = get_option( 'tcs_hp_options_social_links' );           
            ?>               
            <?php if( isset( $_GET [ 'settings-updated' ] ) && $_GET[ 'settings-updated' ] == 'true' ): ?>
                <div class="updated" id="message">
                    <p><strong><?php _e( 'Settings saved.', 'tcstheme' );?></strong></p>
                </div>
            <?php endif; ?>  
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label><?php _e( 'Facebook', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_facebook]" value="<?php if( isset( $options[ 'social_facebook' ] ) ) echo esc_url( $options[ 'social_facebook' ] ); ?>" />
                        </td>
                    </tr>
                    <tr> 
                        <th scope="row"><label><?php _e( 'Twitter', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_twitter]" value="<?php if ( isset( $options[ 'social_twitter' ] ) ) echo esc_url( $options[ 'social_twitter'] ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label><?php _e( 'Google +', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_google]" value="<?php if ( isset( $options[ 'social_google' ] ) ) echo esc_url( $options[ 'social_google' ] ); ?>" />
                        </td>
                    </tr>
                    
                     <tr>
                        <th scope="row"><label><?php _e( 'LinkedIn', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_linkedin]" value="<?php if ( isset( $options[ 'social_linkedin' ] ) ) echo esc_url( $options[ 'social_linkedin' ] ); ?>" />
                        </td>
                    </tr>
                    
                     <tr>
                        <th scope="row"><label><?php _e( 'Pinterest', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_pinterest]" value="<?php if ( isset( $options[ 'social_pinterest' ] ) ) echo esc_url( $options[ 'social_pinterest' ] ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label><?php _e( 'Youtube', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_youtube]" value="<?php if ( isset( $options[ 'social_youtube' ] ) ) echo esc_url( $options[ 'social_youtube' ] ); ?>" />
                        </td>
                    </tr>
                   
                    <tr>
                        <th scope="row"><label><?php _e( 'RSS Feed', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_rss]" value="<?php if ( isset( $options[ 'social_rss' ] ) ) echo esc_url( $options[ 'social_rss' ] ); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label><?php _e( 'Deviantart', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_deviantart]" value="<?php if ( isset( $options[ 'social_deviantart' ] ) ) echo esc_url( $options[ 'social_deviantart' ] ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label><?php _e( 'Tumblr', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_tumblr]" value="<?php if ( isset( $options[ 'social_tumblr' ] ) ) echo esc_url( $options[ 'social_tumblr' ] ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label><?php _e( 'Viemo', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_viemo]" value="<?php if ( isset( $options[ 'social_viemo' ] ) ) echo esc_url( $options[ 'social_viemo' ] ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label><?php _e( 'Dribbble', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_dribbble]" value="<?php if ( isset( $options[ 'social_dribbble' ] ) ) echo esc_url( $options[ 'social_dribbble' ] ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label><?php _e( 'MySpace', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_myspace]" value="<?php if ( isset( $options[ 'social_myspace' ] ) ) echo esc_url( $options[ 'social_myspace' ] ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label><?php _e( 'Aim', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_aim]" value="<?php if ( isset( $options[ 'social_aim' ] ) ) echo esc_url( $options[ 'social_aim' ] ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label><?php _e( 'Flicker', 'tcstheme' ); ?></label></th>
                        <td><input type="text" size="45" name="tcs_hp_options_social_links[social_flickr]" value="<?php if ( isset( $options[ 'social_flickr' ] ) ) echo esc_url( $options[ 'social_flickr' ] ); ?>" />
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <p><?php _e( '<strong>Note:</strong> Enter the url for correponding social networking website', 'tcstheme' ); ?></p>
            <p class="submit"><input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save', 'tcstheme' ); ?>" /></p> 
  		</form>
	</div><!-- .wrap -->
<?php
}


/**
* Returns the options array for TCS Theme.
*
* @since TCS Theme 1.0
*/
function tcs_hp_options_webmaster_tools() { 
	?>
    <div class="wrap">
    	<?php screen_icon(); ?>
		<h2>
			<?php 
            if( function_exists( 'wp_get_theme' ) ) {
                printf( __( '%s Theme Options By', 'tcstheme' ), wp_get_theme() );
            } else {
                printf( __( '%s Theme Options By', 'tcstheme' ), get_current_theme() );
            }
			?>
            <a href="<?php echo esc_url( __( 'http://catchthemes.com/', 'tcstheme' ) ); ?>" title="<?php echo esc_attr_e( 'TCS Themes', 'tcstheme' ); ?>" target="_blank"><?php _e( 'TCS Themes', 'tcstheme' ); ?></a></h2>

		<form method="post" action="options.php">
			<?php
                settings_fields( 'tcs_hp_options_webmaster' );
                $options = get_option( 'tcs_hp_options_webmaster' );
                        
            ?>   
            <?php if( isset( $_GET [ 'settings-updated' ] ) && $_GET[ 'settings-updated' ] == 'true' ): ?>
                <div class="updated" id="message">
                    <p><strong><?php _e( 'Settings saved.', 'tcstheme' );?></strong></p>
                </div>
            <?php endif; ?>  
    		<div class="option-container">
            	<h3 class="option-toggle"><a href="#"><?php _e( 'Webmaster Site Verification IDs', 'tcstheme' ); ?></a></h3>
                <div class="option-content inside">
           	 		<table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><label><?php _e( 'Google Site Verification ID', 'tcstheme' ); ?></label></th>
                                <td><input type="text" size="45" name="tcs_hp_options_webmaster[google_verification]" value="<?php if( isset( $options[ 'google_verification' ] ) ) echo esc_attr( $options[ 'google_verification' ] ); ?>" /> <?php _e('Enter your Google ID number only', 'tcstheme'); ?>
                                </td>
                            </tr>
                            
                            <tr> 
                                <th scope="row"><label><?php _e( 'Yahoo Site Verification ID', 'tcstheme' ); ?> </label></th>
                                <td><input type="text" size="45" name="tcs_hp_options_webmaster[yahoo_verification]" value="<?php if ( isset( $options[ 'yahoo_verification' ] ) ) echo esc_attr( $options[ 'yahoo_verification'] ); ?>" /> <?php _e('Enter your Yahoo ID number only', 'tcstheme'); ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label><?php _e( 'Bing Site Verification ID', 'tcstheme' ); ?></label></th>
                                <td><input type="text" size="45" name="tcs_hp_options_webmaster[bing_verification]" value="<?php if ( isset( $options[ 'bing_verification' ] ) ) echo esc_attr( $options[ 'bing_verification' ] ); ?>" /> <?php _e('Enter your Bing ID number only', 'tcstheme'); ?>
                                </td>
                            </tr>
                   		</tbody>
                  	</table>
                    <p class="submit"><input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save', 'tcstheme' ); ?>" /></p> 
              	</div> <!-- .option-content  -->
          	</div> <!-- .option-container  -->
            <div class="option-container">
            	<h3 class="option-toggle"><a href="#"><?php _e( 'Webmaster Site Verification Code', 'tcstheme' ); ?></a></h3>
               <div class="option-content inside">
           	 		<table class="form-table">
                    	<table class="form-table">
                            <tr>
                                <th scope="row"><label><?php _e('Analytics, site stats Header code', 'tcstheme' ); ?></label></th>
                                <td>
                                 <textarea name="tcs_hp_options_webmaster[tracker_header]" rows="7" cols="80" ><?php if ( isset( $options [ 'tracker_header' ] ) )  echo esc_attr( $options[ 'tracker_header' ] ); ?></textarea>
                     
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label><?php _e('Analytics, site stats footer code', 'tcstheme' ); ?></label></th>
                                <td>
                                 <textarea name="tcs_hp_options_webmaster[tracker_footer]" rows="7" cols="80" ><?php if ( isset( $options [ 'tracker_footer' ] ) )  echo esc_attr( $options[ 'tracker_footer' ] ); ?></textarea>
                     
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="submit"><input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save', 'tcstheme' ); ?>" /></p> 
            	</div> <!-- .option-content  -->
          	</div> <!-- .option-container  -->
    	</form>
  	</div><!-- .wrap -->
	<?php 
}


/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_options_validation($options) {
	$options_validated = array();
	//data validation for Featured Slider
	if ( isset( $options[ 'slider_qty' ] ) ) {
		$options_validated[ 'slider_qty' ] = absint( $options[ 'slider_qty' ] ) ? $options [ 'slider_qty' ] : 4;
	}
	if ( isset( $options[ 'featured_slider' ] ) ) {
		$options_validated[ 'featured_slider' ] = array();
	}
		
 	if( isset( $options[ 'slider_qty' ] ) )	
	for ( $i = 1; $i <= $options [ 'slider_qty' ]; $i++ ) {
		if ( absint( $options[ 'featured_slider' ][ $i ] ) ) 
			$options_validated[ 'featured_slider' ][ $i ] = absint($options[ 'featured_slider' ][ $i ] );
	}
	if ( isset( $options['exclude_slider_post'] ) ) {
        // Our checkbox value is either 0 or 1 
   		$options_validated[ 'exclude_slider_post' ] = $options[ 'exclude_slider_post' ];	
	
    }

    if( !empty( $options[ 'transition_effect' ] ) ) {
        $options_validated['transition_effect'] = wp_filter_nohtml_kses( $options['transition_effect'] );
    }

    // data validation for transition delay
    if ( !empty( $options[ 'transition_delay' ] ) && is_numeric( $options[ 'transition_delay' ] ) ) {
        $options_validated[ 'transition_delay' ] = $options[ 'transition_delay' ];
    }

    // data validation for transition length
    if ( !empty( $options[ 'transition_duration' ] ) && is_numeric( $options[ 'transition_duration' ] ) ) {
        $options_validated[ 'transition_duration' ] = $options[ 'transition_duration' ];
    }
	//Clearing the theme option cache
	if( function_exists( 'tcs_hp_themeoption_invalidate_caches' ) )  { tcs_hp_themeoption_invalidate_caches(); }
	
	return $options_validated;
}


/**
 * Sanitize and validate forms for webmaster tools options. Accepts an array, return a sanitized array.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_options_webmaster_validation( $options ) {
	$options_validated = array();
	
	// data validation for verification id
	if( isset( $options[ 'google_verification' ] ) ) {
		$options_validated[ 'google_verification' ] = wp_filter_post_kses( $options[ 'google_verification' ] );
	}
	if( isset( $options[ 'yahoo_verification' ] ) )
		$options_validated[ 'yahoo_verification' ] = wp_filter_post_kses( $options[ 'yahoo_verification' ] );
	if( isset( $options[ 'bing_verification' ] ) )
		$options_validated[ 'bing_verification' ] = wp_filter_post_kses( $options[ 'bing_verification' ] );
		
	// data validation for tracking code
	if( isset( $options[ 'tracker_header' ] ) )
		$options_validated[ 'tracker_header' ] = wp_kses_stripslashes( $options[ 'tracker_header' ] );
	if( isset( $options[ 'tracker_footer' ] ) )
		$options_validated[ 'tracker_footer' ] = wp_kses_stripslashes( $options[ 'tracker_footer' ] );
	
	return $options_validated;
}


/**
 * Sanitize and validate social links options form. Accepts an array, return a sanitized array.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_options_social_links_validation( $options ) {
	$options_validated = array();
	
	// data validation for Sociallinks
	//Facebook
	if( isset( $options[ 'social_facebook' ] ) )
		$options_validated[ 'social_facebook' ] = esc_url_raw( $options[ 'social_facebook' ] );
	//Twitter	
	if( isset( $options[ 'social_twitter' ] ) )
		$options_validated[ 'social_twitter' ] = esc_url_raw( $options[ 'social_twitter' ] );
	//Youtube	
	if( isset( $options[ 'social_youtube' ] ) )
		$options_validated[ 'social_youtube' ] = esc_url_raw( $options[ 'social_youtube' ] );
	//Google+
	if( isset( $options[ 'social_google' ] ) )
		$options_validated[ 'social_google' ] = esc_url_raw( $options[ 'social_google' ] );
	//RSS
	if( isset( $options[ 'social_rss' ] ) )
		$options_validated[ 'social_rss' ] = esc_url_raw( $options[ 'social_rss' ] );
	//Linkedin
	if( isset( $options[ 'social_linkedin' ] ) )
		$options_validated[ 'social_linkedin' ] = esc_url_raw( $options[ 'social_linkedin' ] );
	//Pinterest
	if( isset( $options[ 'social_pinterest' ] ) )
		$options_validated[ 'social_pinterest' ] = esc_url_raw( $options[ 'social_pinterest' ] );
	//Deviantart
	if( isset( $options[ 'social_deviantart' ] ) )
		$options_validated[ 'social_deviantart' ] = esc_url_raw( $options[ 'social_deviantart' ] );
	//Tumblr
	if( isset( $options[ 'social_tumblr' ] ) )
		$options_validated[ 'social_tumblr' ] = esc_url_raw( $options[ 'social_tumblr' ] );
	//Viemo
	if( isset( $options[ 'social_viemo' ] ) )
		$options_validated[ 'social_viemo' ] = esc_url_raw( $options[ 'social_viemo' ] );
	//Dribble
	if( isset( $options[ 'social_dribbble' ] ) )
		$options_validated[ 'social_dribbble' ] = esc_url_raw( $options[ 'social_dribbble' ] );
	//Myspace
	if( isset( $options[ 'social_myspace' ] ) )
		$options_validated[ 'social_myspace' ] = esc_url_raw( $options[ 'social_myspace' ] );
	//Aim
	if( isset( $options[ 'social_aim' ] ) )
		$options_validated[ 'social_aim' ] = esc_url_raw( $options[ 'social_aim' ] );
	//Flickr
	if( isset( $options[ 'social_flickr' ] ) )
		$options_validated[ 'social_flickr' ] = esc_url_raw( $options[ 'social_flickr' ] );
	
	//Clearing the theme option cache
	if( function_exists( 'tcs_hp_themeoption_invalidate_caches' ) )  { tcs_hp_themeoption_invalidate_caches(); }
	
	return $options_validated;
}


/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see tcs_hp_theme_options_init()
 * @todo set up Reset Options action
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_theme_options_validate( $input ) {
	$output = $defaults = tcs_hp_get_default_theme_options();

	// Color scheme must be in our array of color scheme options
	if ( isset( $input['color_scheme'] ) && array_key_exists( $input['color_scheme'], tcs_hp_color_schemes() ) )
		$output['color_scheme'] = $input['color_scheme'];

	// Our defaults for the link color may have changed, based on the color scheme.
	$output['link_color'] = $defaults['link_color'] = tcs_hp_get_default_link_color( $output['color_scheme'] );

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
		$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], tcs_hp_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['content_layout'] ) && array_key_exists( $input['content_layout'], tcs_hp_content_layout() ) )
		$output['content_layout'] = $input['content_layout'];
		
	if ( isset( $input['excerpt_length'] ) )	
		$output['excerpt_length'] = absint($input['excerpt_length']);
	
	if ( isset( $input['feed_url'] ) )	
		$output['feed_url'] = esc_url_raw($input['feed_url']);
		
	if ( isset( $input['disable_header_search'] ) )
		// Our checkbox value is either 0 or 1 
		$output[ 'disable_header_search' ] = $input[ 'disable_header_search' ];
	
		
	if ( isset( $input['custom_css'] ) )	
		$output['custom_css'] = wp_kses_stripslashes($input['custom_css']);
		
	if( function_exists( 'tcs_hp_themeoption_invalidate_caches' ) )  { tcs_hp_themeoption_invalidate_caches(); }
	return apply_filters( 'tcs_hp_theme_options_validate', $output, $input, $defaults );
}

/**
 * Enqueue the styles for the current color scheme.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_enqueue_color_scheme() {
	$options = tcs_hp_get_theme_options();
	$color_scheme = $options['color_scheme'];

	if ( 'dark' == $color_scheme )
		wp_enqueue_style( 'dark', get_template_directory_uri() . '/colors/dark.css', array(), null );
	elseif ( 'blue' == $color_scheme )
		wp_enqueue_style( 'blue', get_template_directory_uri() . '/colors/blue.css', array(), null );	

	do_action( 'tcs_hp_enqueue_color_scheme', $color_scheme );
}
add_action( 'wp_enqueue_scripts', 'tcs_hp_enqueue_color_scheme' );

/**
 * Hooks the css to head section
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_inline_css() {
    $options = tcs_hp_get_theme_options();
    if ($options['custom_css']) {
		echo '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
        echo '<style type="text/css" media="screen">' . "\n";
		echo $options['custom_css'] . "\n";
		echo '</style>' . "\n";
	}	
}
add_action('wp_head', 'tcs_hp_inline_css');

/**
 * Site Verification codes are hooked to wp_head if any value exists
 */
 
function tcs_hp_verification() {
    $options = get_option('tcs_hp_options_webmaster');
	//google
    if ($options['google_verification']) {
		echo '<meta name="google-site-verification" content="' . $options['google_verification'] . '" />' . "\n";
	}
	
	//bing
	if ($options['bing_verification']) {
        echo '<meta name="msvalidate.01" content="' . $options['bing_verification'] . '" />' . "\n";
	}
	
	//yahoo
	 if ($options['yahoo_verification']) {
        echo '<meta name="y_key" content="' . $options['yahoo_verification'] . '" />' . "\n";
	}
	
	//site stats, analytics code
	if ($options['tracker_header']) {
        echo $options['tracker_header'];
	}
}

add_action('wp_head', 'tcs_hp_verification');

/**
 * Analytic, site stat code hooked in footer
 * @uses wp_footer
 */
function tcs_hp_site_stats() {
    $options = get_option('tcs_hp_options_webmaster');
    if ($options['tracker_footer']) {
        echo $options['tracker_footer'];
	}
}

add_action('wp_footer', 'tcs_hp_site_stats');

/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_print_link_color_style() {
	$options = tcs_hp_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = tcs_hp_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
	<style>
		/* Link color */
		a,
		#site-title a:focus,
		#site-title a:hover,
		#site-title a:active,
		.entry-title a:hover,
		.entry-title a:focus,
		.entry-title a:active,
		.widget_tcs_hp_ephemera .comments-link a:hover,
		section.recent-posts .other-recent-posts a[rel="bookmark"]:hover,
		section.recent-posts .other-recent-posts .comments-link a:hover,
		.format-image footer.entry-meta a:hover,
		#site-generator a:hover {
			color: <?php echo $link_color; ?>;
		}
		section.recent-posts .other-recent-posts .comments-link a:hover {
			border-color: <?php echo $link_color; ?>;
		}
		article.feature-image.small .entry-summary p a:hover,
		.entry-header .comments-link a:hover,
		.entry-header .comments-link a:focus,
		.entry-header .comments-link a:active,
		.feature-slider a.active {
			background-color: <?php echo $link_color; ?>;
		}
	</style>
<?php
}
add_action( 'wp_head', 'tcs_hp_print_link_color_style' );


/**
 * Social Profles are hooked to tcs_hp_startgenerator_open if any value exists
 *
 * @since TCS Theme 1.0
 */
function tcs_hp_socialprofile() {

	//delete_transient( 'tcs_hp_socialprofile' );

    $options = get_option('tcs_hp_options_social_links');
	$flag = 0;	
	if( !empty( $options ) ) {
		foreach( $options as $option ) {
			if( $option ) {
				$flag = 1;
			}
			else { 
				$flag = 0;
			}
			if( $flag == 1) {
				break;
			}
		}
	}
			
	if( ( !$tcs_hp_socialprofile = get_transient( 'tcs_hp_socialprofile' ) ) && ($flag == 1) ) {
		echo '<!-- refreshing cache -->';
		
		$tcs_hp_socialprofile = '
			<div class="social-profile">
 		 		<ul>';
					//Facebook
					if ($options['social_facebook']) {
						$tcs_hp_socialprofile .= '<li class="facebook"><a href="'.$options['social_facebook'].'" title="Facebook" target="_blank">Facebook</a></li>';
					}
				
					//Twitter
					if ($options['social_twitter']) {
						$tcs_hp_socialprofile .= '<li class="twitter"><a href="'.$options['social_twitter'].'" title="Twitter" target="_blank">Twitter</a></li>';
					}
					
					//Google+
					if ($options['social_google']) {
						$tcs_hp_socialprofile .= '<li class="google-plus"><a href="'.$options['social_google'].'" title="Google Plus" target="_blank">Google Plus</a></li>';
					}
				
					//Linkedin
					if ($options['social_linkedin']) {
						$tcs_hp_socialprofile .= '<li class="linkedin"><a href="'.$options['social_linkedin'].'" title="Linkedin" target="_blank">Linkedin</a></li>';
					}
					
					//Pinterest
					if ($options['social_pinterest']) {
						$tcs_hp_socialprofile .= '<li class="pinterest"><a href="'.$options['social_pinterest'].'" title="Pinterest" target="_blank">Pinterest</a></li>';
					}
					
					//Youtube
					if ($options['social_youtube']) {
						$tcs_hp_socialprofile .= '<li class="you-tube"><a href="'.$options['social_youtube'].'" title="YouTube" target="_blank">YouTube</a></li>';
					}
					
					//RSS Feed
					if ($options['social_rss']) {
						$tcs_hp_socialprofile .= '<li class="rss"><a href="'.$options['social_rss'].'" title="RSS Feed" target="_blank">RSS Feed</a></li>';
					}
					
					//Deviantart
					if ($options['social_deviantart']) {
						$tcs_hp_socialprofile .= '<li class="deviantart"><a href="'.$options['social_deviantart'].'" title="Deviantart" target="_blank">Deviantart</a></li>';
					}		
					
					//Tumblr
					if ($options['social_tumblr']) {
						$tcs_hp_socialprofile .= '<li class="tumblr"><a href="'.$options['social_tumblr'].'" title="Tumblr" target="_blank">Tumblr</a></li>';
					}	
					
					//Viemo
					if ($options['social_viemo']) {
						$tcs_hp_socialprofile .= '<li class="viemo"><a href="'.$options['social_viemo'].'" title="Viemo" target="_blank">Viemo</a></li>';
					}	
					
					//Dribbble
					if ($options['social_dribbble']) {
						$tcs_hp_socialprofile .= '<li class="dribbble"><a href="'.$options['social_dribbble'].'" title="Dribbble" target="_blank">Dribbble</a></li>';
					}	
					
					//MySpace
					if ($options['social_myspace']) {
						$tcs_hp_socialprofile .= '<li class="my-space"><a href="'.$options['social_myspace'].'" title="MySpace" target="_blank">MySpace</a></li>';
					}	
					
					//Aim
					if ($options['social_aim']) {
						$tcs_hp_socialprofile .= '<li class="aim"><a href="'.$options['social_aim'].'" title="Aim" target="_blank">Aim</a></li>';
					}	
					
					//Flicker
					if ($options['social_flickr']) {
						$tcs_hp_socialprofile .= '<li class="flickr"><a href="'.$options['social_flickr'].'" title="Flicker" target="_blank">Flicker</a></li>';
					}	
					
					$tcs_hp_socialprofile .= '
				</ul>
			</div>';
		set_transient( 'tcs_hp_socialprofile', $tcs_hp_socialprofile, 604800 );		
	}
	echo $tcs_hp_socialprofile;	
} // tcs_hp_socialprofile	
add_action('tcs_hp_startgenerator_open', 'tcs_hp_socialprofile');


/**
 * Redirect WordPress Feeds To FeedBurner
 */
function tcs_hp_rss_redirect() {
	$options = tcs_hp_get_theme_options();
    if ($options['feed_url']) {
		$url = 'Location: '.$options['feed_url'];
		if ( is_feed() && !preg_match('/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT']))
		{
			header($url);
			header('HTTP/1.1 302 Temporary Redirect');
		}
	}
}
add_action('template_redirect', 'tcs_hp_rss_redirect');

/* Clearing Theme Option Cache 
 * @uses delete_transient
 */
function tcs_hp_themeoption_invalidate_caches() {
	delete_transient( 'tcs_hp_sliders' ); // Featured Slider
	delete_transient( 'tcs_hp_socialprofile' ); //Social Profile
}

/* Clearing Theme Option Cache 
 * @uses delete_transient and action publish_post
 */
function tcs_hp_posts_invalidate_caches() {
	delete_transient( 'tcs_hp_sliders' ); // Featured Slider
}
add_action( 'publish_post', 'tcs_hp_posts_invalidate_caches' ); // publish posts runs whenever posts are published or published posts are edited