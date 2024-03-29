<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package TCS Themes
 * @subpackage TCS_Themes
 * @since TCS Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 
            'before'		=> '<div class="page-link"><span class="pages">' . __( 'Pages:', 'tcstheme' ) . '</span>',
            'after'			=> '</div>',
            'link_before' 	=> '<span>',
            'link_after'   	=> '</span>',
        ) ); 
        ?>
	</div><!-- .entry-content -->
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'tcstheme' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
