<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package TCS Themes
 * @subpackage TCS_Themes
 * @since TCS Theme 1.0
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">
			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				get_sidebar( 'footer' );
			?>
           <?php if ( has_nav_menu( 'footer', 'tcstheme' ) ) { ?>
                <nav id="access-footer" role="navigation">
                	<h3 class="assistive-text"><?php _e( 'Footer menu', 'tcstheme' ); ?></h3>
                    <?php wp_nav_menu( array( 'theme_location'  => 'footer', 'depth' => 1 ) );  ?>
                </nav>
            <?php } ?>
			<div id="site-generator" class="clearfix">
            	<?php do_action( 'tcs_hp_startgenerator_open' ); ?>
            	<div class="copyright">
                	<?php esc_attr_e('Copyright &copy;', 'tcstheme'); ?> <?php _e(date('Y')); ?>
                    <a href="<?php echo home_url('/') ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
						<?php bloginfo('name'); ?>
            		</a>
                    <?php esc_attr_e('. All Rights Reserved.', 'tcstheme'); ?>
                </div>
                <div class="powered">
                	<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'tcstheme' ) ); ?>" title="<?php esc_attr_e( 'Powered by WordPress', 'tcstheme' ); ?>" rel="generator"><?php printf( __( 'Powered by %s', 'tcstheme' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
                    <a href="<?php echo esc_url( __( 'http://catchthemes.com/', 'tcstheme' ) ); ?>" title="<?php esc_attr_e( 'Theme TCS Theme by Catch Internet', 'tcstheme' ); ?>" rel="designer"><?php printf( __( 'Theme: %s', 'tcstheme' ), 'TCS Theme' ); ?></a>
            	</div>
                <?php do_action( 'tcs_hp_startgenerator_close' ); ?>
          	</div> <!-- #site-generator -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>