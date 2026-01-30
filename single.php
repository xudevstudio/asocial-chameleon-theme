<?php
/**
 * The template for displaying all single posts
 *
 * @package Asocial_Chameleon
 */

get_header();
?>

<div class="container main-content-container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    <div class="entry-meta">
                        <?php
                        echo '<span class="posted-on">' . get_the_date() . '</span>';
                        echo '<span class="byline"> by ' . get_the_author() . '</span>';
                        ?>
                    </div>
				</header>

                <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail( 'full' ); ?>
                </div>
                <?php endif; ?>

				<div class="entry-content">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'asocial-chameleon' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>

				<footer class="entry-footer">
					<?php
                    // Translators: used between list items, there is a space after the comma.
                    $categories_list = get_the_category_list( esc_html__( ', ', 'asocial-chameleon' ) );
                    if ( $categories_list ) {
                        /* translators: 1: list of categories. */
                        printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'asocial-chameleon' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }

                    // Translators: used between list items, there is a space after the comma.
                    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'asocial-chameleon' ) );
                    if ( $tags_list ) {
                        /* translators: 1: list of tags. */
                        printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'asocial-chameleon' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
					?>
				</footer>
			</article>

			<?php
            // If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->

<?php
get_footer();
